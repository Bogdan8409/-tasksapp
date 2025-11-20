# Mini MVC Tasks

## Overview
This project is a simple MVC (Model-View-Controller) application for managing tasks. It allows users to create, edit, and view tasks through a web interface.

## Project Structure
```
mini-mvc-tasks
├── app
│   ├── Controllers
│   │   └── TaskController.php
│   ├── Models
│   │   └── Task.php
│   ├── Views
│   │   └── tasks
│   │       ├── edit.php
│   │       └── list.php
│   └── Core
│       ├── Controller.php
│       └── Model.php
├── config
│   └── db.php
├── public
│   ├── index.php
│   ├── edit.php
│   └── .htaccess
├── tests
│   └── TaskControllerTest.php
├── composer.json
└── README.md
```

## Requirements
- PHP 7.4 or higher
- MySQL database

## Setup Instructions
1. Clone the repository to your local machine.
2. Navigate to the project directory.
3. Create a MySQL database named `2webtasks`.
4. Import the SQL schema (if provided) to set up the necessary tables.
5. Update the `config/db.php` file with your database connection details.
6. Install dependencies using Composer:
   ```
   composer install
   ```
7. Start a local server (e.g., using Laragon, XAMPP, or built-in PHP server).

## Usage
- Access the application through your web browser at `http://localhost/mini-mvc-tasks/public/index.php`.
- You can view the list of tasks, edit existing tasks, and manage task details.

## Testing
- Unit tests for the `TaskController` can be found in the `tests/TaskControllerTest.php` file.
- Run tests using PHPUnit to ensure the application functions as expected.

## Contributing
Feel free to submit issues or pull requests for improvements and bug fixes.