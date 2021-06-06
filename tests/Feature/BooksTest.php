<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\File;
use Tests\TestCase;
use DB;

class UserTest extends TestCase
{
    /**
     * Testing of Homepage Http Response
     *
     * @return void
     */
    public function testHomePageResponse() {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /**
     * Testing of Admin Page Http Response
     *
     * @return void
     */
    public function testAdminPageResponse() {
        $response = $this->get('/admin/auth/login');
        $response->assertStatus(200);
    }

    /**
     * Testing on Heading Books 
     *
     * @return void
     */
    public function testHomePageBookHeading() {
        $response = $this->get('/')
            ->assertSee('Title')
            ->assertSee('Author')
            ->assertSee('Genre')
            ->assertSee('Publisher');
    }

    /**
     * Testing Searching
     *
     * @return void
     */
    public function testSearch() {
        $response = $this->get('/search?k=data')
            ->assertSee('Data Structures Using C & C++')
            ->assertSee('Data Analysis with Open Source Tools');
    }

    // admin login function
    public function adminLogin() {
        $response = $this->post('/admin/auth/login', [
            'username' => 'techguy',
            'password' => 'techguy'          
        ]);
        return $response;
    }

    /**
     * Testing Admin Login
     *
     * @return void
     */
    public function testAdminLogin() {
        $this->adminLogin()->assertRedirect('/admin');
    }

    /**
     * Testing Admin Search
     *
     * @return void
     */
    public function testAdminSearch() {
        $response = $this->adminLogin();
        $response = $this->get('/admin/search?k=data')
            ->assertSee('Data Structures Using C & C++')
            ->assertSee('Data Analysis with Open Source Tools');
    }

    /**
     * Testing Register a book
     *
     * @return void
     */
    public function testRegisterBook() {
        $response = $this->adminLogin();
        $book = [
            'title'     => 'bookTitle',
            'author'    => 'author',
            'genre'     => 'genre',
            'publisher' => 'publisher', 
        ];
        $this->post('/admin/store_book', $book)
            ->assertRedirect('/admin');

        $this->assertDatabaseHas('books', $book);
        DB::table('books')->where('title', 'bookTitle')->delete();
    }

}
