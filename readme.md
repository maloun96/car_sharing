### Car Sharing APP
### [Laravel Boilerplate link for documentation](http://laravel-boilerplate.com/ "Laravel Boilerplate link for documentation")

### Install Instruction
### 1) Composer
Laravel project dependencies are managed through the PHP Composer tool. The first step is to install the depencencies by navigating into your project in terminal and typing this command:

`$ composer install`

### 2) NPM/Yarn
In order to install the Javascript packages for frontend development, you will need the Node Package Manager, and optionally the Yarn Package Manager by Facebook (Recommended)

If you only have NPM installed you have to run this command from the root of the project:

`$ npm install`

### 3) Create Database
You must create your database on your server and on your .env file update the following lines:
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=homestead
DB_USERNAME=homestead
DB_PASSWORD=secret
```
### 4) Artisan Commands
The first thing we are going to so is set the key that Laravel will use when doing encryption. Run code below one by one.

`$ php artisan key:generate`

`$ php artisan migrate`

`$ php artisan db:seed`


### 5) Storage link
After your project is installed you must run this command to link your public storage folder for user avatar uploads:

`$ php artisan storage:link`

### 5) Login
After your project is installed and you can access it in a browser, click the login button on the right of the navigation bar.
The administrator credentials are:

**Username**: admin@admin.com

**Password**: secret
