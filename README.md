# To-Do App

A simple To-Do application that allows users to register, log in, and manage their tasks. Built with PHP, MySQL, and a bit of encryption for secure handling of user data.

## Features

- User registration and login
- Task management: create, read, update, and delete tasks
- Simple and intuitive UI

## Table of Contents

- [Features](#features)
- [Installation](#installation)
- [Usage](#usage)
- [Configuration](#configuration)
- [License](#license)

## Installation

### Prerequisites

- PHP 7.4 or higher
- MySQL
- Web server (e.g., Apache, Nginx)
- Composer (for dependency management, if applicable)

### Setup

1. **Clone the repository:**

    ```bash
    git clone https://github.com/strnadaljaz/TODO-Online-App.git
    cd TODO-Online-App
    ```

2. **Set up the database:**

    - Import the `database.sql` file located in the `database/` directory into your MySQL server.

    ```sql
    -- Example SQL script (replace with your actual script)
    CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) UNIQUE NOT NULL,
        user_password VARCHAR(255) NOT NULL
    );

    CREATE TABLE tasks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        user_id INT NOT NULL,
        task VARCHAR(255) NOT NULL,
        status TINYINT DEFAULT 0, -- 0 = incomplete, 1 = complete
        FOREIGN KEY (user_id) REFERENCES users(id)
    );
    ```

3. **Configure database connection:**

    - Open `connection.php` and set your database credentials:

    ```php
    <?php
    $servername = "localhost";
    $username = "your-db-username";
    $password = "your-db-password";
    $dbname = "your-db-name";

    $con = new mysqli($servername, $username, $password, $dbname);

    if ($con->connect_error) {
        die("Connection failed: " . $con->connect_error);
    }
    ?>
    ```

4. **Install dependencies (if any):**

    If you have any PHP dependencies, install them using Composer:

    ```bash
    composer install
    ```

## Usage

1. **Start your web server** and navigate to the application URL.

2. **Register a new user** by visiting the registration page (`sign_up.php`).

3. **Log in** using the credentials you registered.

4. **Manage your tasks** by adding, updating, and deleting tasks.

## Configuration

- **Database Schema:** Make sure that the database schema matches what is expected by your application.

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

### Attribution

When using this software, please include the following attribution:

"This software was developed by Aljaž Strnad."
