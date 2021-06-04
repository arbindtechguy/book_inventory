<?php
namespace Lib;
use Log;
use DB;

/**
 * export books library
 * export books details to csv or xml format
 */

class FileExport {

    const DEFAULT_FILE_NAME_CSV = 'books.csv';
    const DEFAULT_FILE_NAME_XML = 'books.xml';

    // File export: with csv file type
    public static function download_csv_file($export_fields, $filename = 'books.csv') {
        $books = DB::table('books')->select($export_fields)->get();
        $books = json_decode(json_encode($books), 1);
        $delimiter = ',';
        header("Content-Type: text/csv");
        header("Content-Disposition: attachment; filename=\"$filename\"");	
        $fh = fopen( 'php://output', 'w' );
        $is_coloumn = true;
        if(!empty($books)) {
          foreach($books as $record) {
            if($is_coloumn) {
              fputcsv($fh, array_keys($record));
              $is_coloumn = false;
            }		
            fputcsv($fh, array_values($record));
          }
           fclose($fh);
        }
        exit;  
    }

    // File export: with xml file type
    public static function download_xml_file($export_fields, $filename = 'books.xml') {
        $books = DB::table('books')->select($export_fields)->get();
        $books = json_decode(json_encode($books), 1);
        $delimiter = ',';
        $is_coloumn = true;

        $xml = new \SimpleXMLElement('<xml/>');

        foreach ($books as $book) {
            $book_obj = $xml->addChild('book');
            foreach ($book as $key => $val) {
                $book_obj->addChild($key, htmlspecialchars($val));
            }
        }
        Header("Content-type: text/xml");
        header("Content-Disposition: attachment; filename=$filename");
        echo ($xml->asXML());
        exit;
    }


    // generate test books from public sites
    public static function generate_books() {
        $books_url = 'https://gist.githubusercontent.com/jaidevd/23aef12e9bf56c618c41/raw/c05e98672b8d52fa0cb94aad80f75eb78342e5d4/books.csv';
        $data = file_get_contents($books_url);
        $rows = explode("\n",$data);
        foreach($rows as $row) {
            $s = str_getcsv($row);
            $bookInfo = [
                'title'         => $s[0],
                'author'        => $s[1],
                'genre'         => $s[2],
                'publisher'     => $s[4],
                'created_at'    => date('Y-m-d H:i:s'),
                'updated_at'    => date('Y-m-d H:i:s'),
            ];
            DB::table('books')->insert($bookInfo);
        }
    }

}