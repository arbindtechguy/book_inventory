<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;

class BookListController extends Controller {
    private $book_meta = [
        "title"         => "Title", 
        "author"        => "Author",
        "genre"         => "Genre",
        "publisher"     => "Publisher",
    ];
    
    // home page request
    public function index(Request $req) {
        // To homepage view
        return view('homepage', [
                'books'         => $this->filter_books($req),
                'sort_by'       => $this->sort_params($req),
                'public_page'   => true,
                'title'         => 'Top Selling Books',
                'query'    => '',
            ]);
    }

    public function search_books(Request $req) {
        // To search public books with query
        return view('homepage', [
            'books'         => $this->filter_books($req),
            'query'         => $req->get('k'),
            'sort_by'       => $this->sort_params($req),
            'public_page'   => true,
            'title'         => 'Displaying search results for "' . $req->get('k') . '"',
        ]);
    }

    // dashboard of books export 
    public function export_books(Content $content) {
        return $content->title('Export books')
            ->description('Download the books information')
            ->breadcrumb(['text' => "Export Books"])
            ->body(view('common.export', [
                'books' => $this->filter_books(),
            ]));
    }

    // function to download book requests
    public function download_books(Content $content, Request $req) {

        // get export information from post data
        $export_fields = $req->post('export_field');
        $export_type = $req->post('export_type');

        // validate export requests
        $valid_export_fields = !array_diff($export_fields, config('app.valid_export_fields'));
        $valid_export_type = in_array($export_type, config('app.valid_export_type'));
        
        if (
            $export_fields &&
            $export_type &&
            $valid_export_fields &&
            $valid_export_type
        ) {
            switch($export_type) {
                case 'csv':
                    $a = FileExport::download_csv_file($export_fields);
                    break;
                case 'xml':
                    FileExport::download_xml_file($export_fields);
                    break;
                default:
                    break;
            }
        }

        return redirect()->route('admin.index')
                ->with('flash_message_error', 'Error while expoting file, try again');

    }

    // get book row information data for requested parameters
    private function sort_params($req) {
        $sort_params = [];
        foreach ($this->book_meta as $key => $name) {
            if ($req->get('sort') == $key && $req->get('order')) {
                $sort_params[$key] = [
                    'active'    => true,
                    'order'     => $req->get('order') == 'desc' ? 'asc' : 'desc',
                    'name'      => $name
                ];
            }
            else {
                $sort_params[$key] = [
                    'active'    => false,
                    'order'     => 'desc',
                    'name'      => $name,
                ];
            }
        }
        return $sort_params;
    }


    // get books with multiple filters
    private function filter_books($filters = null) {
        $query = DB::table('books');
        if ($filters) {

            // Search for a book by title or author
            if ($keyword = $filters->get('k')) {

                // updating query to match author or title of books
                $query->orWhere('title', 'like', '%' . $keyword . '%')
                    ->orWhere('author', 'like', '%' . $keyword . '%');

            }
            
            if ($sort_info = $this->get_sort_params($filters)) {

                // updating query to match sort options
                $query->orderBy($sort_info['sort_by'], $sort_info['order']);
            }
        }

        return $query->paginate(config('app.book_pagination_count'));
    }

    // check and get if valid request sort options
    function get_sort_params($filters) {

        // valid sort option
        if (isset($this->book_meta[$filters->get('sort')])) {

            // check if valid order option if invalid default by ascending order
            $order = $filters->get('order') == 'desc' ? 'desc' : 'asc';
            
            return [
                'sort_by' => $filters->get('sort'),
                'order'   => $order,
            ];
        }

        // if invalid sort attribute
        return null;

    }


}
