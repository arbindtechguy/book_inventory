<?php

namespace App\Admin\Controllers;
use Illuminate\Http\Request;
use App\Models\Contact;
use App\Http\Controllers\Controller;
use Encore\Admin\Layout\Content;
use DB;
use Log;

class BookFormController extends Controller {

    // Create Contact Form
    public function createForm(Request $request, Content $content) {
        return $content
        ->title('Register a book')
        ->description('Add a new book')
        ->breadcrumb(['text' => "Register Book"])
        ->body(view('admin.register_book'));
    }
    
    public function editForm(Request $request, Content $content, $id) {
        $bookInfo = DB::table('books')->where('id',$id)->first();
        return $content
        ->title('Edit a book details')
        ->description('Modify book information.')
        ->breadcrumb(['text' => "Edit Book"])
        ->body(view('admin.register_book', 
            [
                'bookInfo' => $bookInfo
            ]
        ));
    }

    // Store Book Form data
    public function save_book(Request $request) {

        // Form validation
        $this->validate($request, [
            'title'     => 'required',
            'author'    => 'required',
            'genre'     => '',
            'publisher' =>'',
        ]);

        // Book information from post data
        $bookInfo = [
            'title'         => $request->post('title'),
            'author'        => $request->post('author'),
            'genre'         => $request->post('genre'),
            'publisher'     => $request->post('publisher'),
            'updated_at'    => date('Y-m-d H:i:s'),
            'created_at'    => date('Y-m-d H:i:s'),
        ];

        // The the request is to update the book information
        if ($request->post('update')) {
            unset($bookInfo['created_at']);
            if (DB::table('books')->where('id', $request->post('book_id'))->update($bookInfo)) {
                return redirect()->route('admin.index')
                    ->with('flash_message', __('admin.success_update', [
                        'title' => $request->post('title')
                    ]));
            }

            // error while saving book
            Log::error("BookFormController.php save_book(): " . __('admin.error_update', [
                'title' => $request->post('title')
            ]));
            return redirect()->route('admin.index')
                ->with('flash_message_error', __('admin.error_update', [
                    'title' => $request->post('title')
                ]));

        }

        // check if successfully stored book information in database
        else if (DB::table('books')->insert($bookInfo)) {
            return redirect()->route('admin.index')
                ->with('flash_message', __('admin.success_insert', [
                    'title' => $request->post('title')
                ]));
        }

        // error while registering book
        Log::error("BookFormController.php save_book(): " . __('admin.error_insert', [
            'title' => $request->post('title')
        ]));

        // redirect with message
        return redirect()->route('admin.index')
            ->with('flash_message_error',  __('admin.error_insert', [
                'title' => $request->post('title')
        ]));
        
    }

    // Delete Book data
    public function delete_book(Request $request, $id, $title) {
        // Book id validation and check if deletes
        if ($id && is_numeric($id) && DB::table('books')->where('id', $id)->delete()) {
            return redirect()->route('admin.index')
                ->with('flash_message', __('admin.success_delete', [
                    'title' => $title
            ]));
        }

        // error while deleting book
        Log::error("BookFormController.php delete_book(): " . __('admin.error_delete', [
            'title' => $title
        ]));

        // redirect with message
        return redirect()->route('admin.index')
            ->with('flash_message_error', __('admin.error_delete', [
                'title' => $title
        ]));
        
    }
    
    // Delete multiple books
    public function delete_books(Request $request) {

        // get books id from delete request
        $ids = explode(",", $request->post('books_id'));

        // validate book id  and check if deletes
        if ($ids && DB::table('books')->whereIn('id', $ids)->delete()) {
            return redirect()->route('admin.index')
                ->with('flash_message', __('admin.multiple_success_delete', [
                    'count' => count($ids)
            ]));
        }

        // error while deleting book
        Log::error("BookFormController.php delete_books(): " . __('admin.multiple_error_delete'));

        // redirect with message
        return redirect()->route('admin.index')
                ->with('flash_message_error', __('admin.multiple_error_delete'));
        
    }

}