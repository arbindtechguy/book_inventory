<?php

use Illuminate\Routing\Router;

Admin::routes();

Route::group([
    'prefix'        => config('admin.route.prefix'),
    'namespace'     => config('admin.route.namespace'),
    'middleware'    => config('admin.route.middleware'),
    'as'            => config('admin.route.prefix') . '.',
], function (Router $router) {

    // dasboard for book management
    $router->get('/', 'AdminController@index')->name('index');

    // route for handing query on books
    $router->get('/search', 'AdminController@search_books')->name('search_books');
    
    // route for registering new books
    $router->get('/register_book', 'BookFormController@createForm')->name('form_register_book');

    // route for storing new books
    $router->post('/store_book', 'BookFormController@save_book')->name('store_book');

    // route for updating existing books
    $router->get('/edit_book/{id}', 'BookFormController@editForm')->name('form_edit_book');

    // route for deleting existing books
    $router->get('/delete_book/{id}/{title}', 'BookFormController@delete_book')->name('delete_book');

    // route for deleting multiple books 
    $router->post('/delete_books', 'BookFormController@delete_books')->name('delete_books');

    // Export books to csv or xml
    $router->get('/export_books', 'AdminController@export_books')->name('export_books');
    $router->post('/download_books', 'AdminController@download_books')->name('download_books');

});
