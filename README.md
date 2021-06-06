
Admin page URL: www.greplink.com/admin
Public page URL: www.greplink.com/

## **Installing Books Inventory via Ubuntu and apache server**

1. To install repository for Apache

    ```
    sudo apt install software-properties-common
    sudo add-apt-repository ppa:ondrej/php
    sudo apt update
    sudo apt install php7.4
    ```


2. To install apache and basic PHP tools

    ```
    sudo apt-get install apache2 php7.4 libapache2-mod-php7.4 php7.4-curl php-pear php7.4-gd php7.4-dev php7.4-zip php7.4-mbstring php7.4-mysql php7.4-xml curl -y
    ```


3. To install the MySQL server by using the Ubuntu operating system package manager

    ```
    sudo apt-get update
    sudo apt-get install mysql-server
    ```



* The installer installs MySQL and all dependencies.
* If the secure installation utility does not launch automatically after the installation completes, enter the following command:
    ```
    sudo mysql_secure_installation utility
    ```

    ```
    sudo mysql -u root
    CREATE DATABASE book_inventory;
    ```
* To create user and grant permission to the database
    ```
    CREATE USER 'inventory_user'@'localhost' IDENTIFIED BY 'user_password_1234';
    GRANT SELECT, INSERT, UPDATE, DELETE, CREATE, INDEX, DROP, ALTER, CREATE TEMPORARY TABLES, LOCK TABLES ON book_inventory.* TO 'inventory_user'@'localhost';
    ```

4. Clone the repository from git
    ```
    git clone https://github.com/arbindtechguy/book_inventory.git
    ```

5. Change basic permissions for laravel framework  

    ```
    sudo chown -R arbindtechguy:www-data book_inventory/
    cd book_inventory/
    sudo chmod -R 775 storage bootstrap/cache
    ```


6. Setting up virtual configuration on apache

    ```
    cd /etc/apache2/sites-available/
    ```

    ```
    sudo vim book_inventory.com.conf
    ```

* Basic configuration for for this project
    ```
    <VirtualHost *:80>
        ServerName greplink.com
        ServerAlias greplink.com *.greplink.com
        RedirectMatch permanent ^/(.*) https://www.greplink.com/$1
    </VirtualHost>
    
    <IfModule mod_ssl.c>
        <VirtualHost *:443>
            ServerAdmin arbindtechguy@gmail.com
                ServerName www.greplink.com
                ServerAlias www.greplink.com    
                DocumentRoot /var/www/book_inventory/public
            <Directory "/var/www/book_inventory/public">
                Options Indexes FollowSymLinks
                AllowOverride All
                Require all granted
                RewriteEngine On    
            </Directory>
            ErrorLog ${APACHE_LOG_DIR}/book_inventory_error.log
            CustomLog ${APACHE_LOG_DIR}/book_inventory_access.log combined
            # SSL CERTIFICATES PATH
        </VirtualHost>
    </IfModule>
    
    ```

*   To enable apache rewrite module

    ```
    sudo a2enmod rewrite
    ```


*   To reload the Apache configurations

    ```
    sudo service apache2 restart
    ```


7. To build the project 

    ```
    cd /var/www/book_inventory
    composer install
    ```




8. Update the basic environment configurations
    ```
    ...
    APP_NAME=book_inventory
    DB_DATABASE=book_inventory
    DB_USERNAME=inventory_user
    DB_PASSWORD=user_password_1234
    ...
    ```

9. To run database Migrations

    ```
    php artisan migrate
    ```


10. To generate Vendor files of laravel-admin
    ```
    sudo php artisan vendor:publish --provider="Encore\Admin\AdminServiceProvider"
    ```


*  [Optionals]

* To create an Admin Credentials Through Artisan command
    ```
    php artisan admin:create-user
    ```
    
- Add a book to the list.
![ADMIN: Add a book to the list step 1. 1](https://www.greplink.com/screenshots/admin_add_book_1.png)
![ADMIN: Add a book to the list step 2. 2](https://www.greplink.com/screenshots/admin_add_book.png)

- Delete a book from the list.
![ADMIN: Delete a book from the list 1](https://www.greplink.com/screenshots/admin_delete_book.png)

- Change an authors name
 ![ADMIN: Change an authors details step 1 1](https://www.greplink.com/screenshots/admin_edit_book_1.png)
 ![ADMIN: Change an authors details step 2 1](https://www.greplink.com/screenshots/admin_edit_book_2.png)

- Sort by title or author
 ![ADMIN: Sort by title descending order 1](https://www.greplink.com/screenshots/admin_sort_title_desc.png)
 ![ADMIN: Sort by title ascending order 1](https://www.greplink.com/screenshots/admin_sort_title_asc.png)
 ![ADMIN: Sort by author 1](https://www.greplink.com/screenshots/admin_sort_author_sort.png)

- Search for a book by title or author
 ![ADMIN: Search for a book by title or author 1](https://www.greplink.com/screenshots/admin_search_books.png)

- Export the the following in CSV and XML
  ![ADMIN: Export the the following in CSV and XML step 1 1](https://www.greplink.com/screenshots/admin_export_books.png)
  ![ADMIN: Export the the following in CSV and XML step 2 1](https://www.greplink.com/screenshots/admin_export_books_modal.png)