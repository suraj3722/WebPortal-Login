# Web Portal Login

A simple PHP + MySQL web portal that allows users to register, log in, view their profile, and log out securely.

## Features
- Landing page
- User registration
- Duplicate email prevention
- Password hashing using PHP
- Login system with session management
- Protected profile page
- Logout functionality
- MySQL database connection using PDO
- Responsive styling with CSS

## Project Structure
- index.php
- register.php
- login.php
- profile.php
- logout.php
- db.php
- style.css
- database.sql
- .gitignore

## Technologies Used
- HTML
- CSS
- JavaScript
- PHP
- MySQL

## Setup Instructions
1. Start Apache and MySQL in XAMPP.
2. Create a database named `suraj` or update the database name in `db.php`.
3. Import `database.sql` into MySQL.
4. Place the project in `htdocs`.
5. Open the project in the browser:
   `http://localhost/suraj/`

## Notes
- Passwords are stored as hashed values using `password_hash()`.
- Sessions are used to protect the profile page.
- Prepared statements are used to prevent SQL injection.

## Authors
Suraj
