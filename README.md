# ChallengeHub - PHP OOP MVC Project

ChallengeHub is a web application built using PHP (OOP) and following the MVC architecture.

## Prerequisites

Before starting, ensure you have the following installed:
- PHP 8.0 or higher
- MySQL / MariaDB
- Composer (optional, for dependency management)

## Setup Instructions

### 1. Database Configuration
1. Open your database management tool (e.g., phpMyAdmin).
2. Create a new database named `web`.
3. Import the SQL file located at `config/webbd.sql` into the `web` database.

> [!NOTE]
> If you want to use a different database name, update the `BASE` constant in `config/configuration.php`.

### 2. Configure Database Connection
Edit the `config/configuration.php` file if your database credentials differ from the defaults:
```php
define('USER', "root");
define('PASSWD', "");
define('SERVER', "localhost");
define('BASE', "web");
```

### 3. Install Dependencies (Optional)
If you have Composer installed, run:
```bash
composer install
```
This will install `vlucas/phpdotenv` and `guzzlehttp/guzzle` as defined in `composer.json`.

### 4. Run the Application

#### Using PHP's Built-in Server
Open your terminal in the project root and run:
```bash
php -S localhost:8000
```
Then, visit `http://localhost:8000` in your browser.

#### Using XAMPP / WAMP
1. Move the project folder to your server's root directory (`htdocs` for XAMPP, `www` for WAMP).
2. Start Apache and MySQL from the control panel.
3. Visit `http://localhost/ChallengeHub` (adjust the path based on your folder name).

## Testing Accounts

You can use the following default accounts from the database:
- **Email:** `sofien@gmail.com` | **Password:** `123456` (Example password, check `config/webbd.sql`)
- **Email:** `menifaicha@gmail.com`
- **Email:** `imen@gmail.com`

---
Happy Coding!
