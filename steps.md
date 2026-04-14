
  Before installing Laravel, make sure you have:
 - PHP (>= 8.1)
-  Composer
- A web server (like XAMPP or Laragon)
then run this command at termianl 
- php -v
- composer -V

=> Install Laravel via Composer
 option one :composer create-project laravel/laravel NameOfProject
 option two :composer global require laravel/installer

 => run the project 
   - cd NameOFProject 
   -start server :php artisan serve
    then will open http://127.0.0.1:8000

=>Configure Environment
  Copy .env file (already exists)
    Set database info:
    DB_DATABASE=your_db
    DB_USERNAME=root
    DB_PASSWORD=