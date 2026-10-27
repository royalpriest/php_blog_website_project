# Programmer Hub: PHP Blog CMS

A community blog for developers, built from scratch in PHP and MySQL with no framework or CMS. Members sign up, log in, and publish, edit and delete their own posts, and the site includes a user management area.

## Features

- **Accounts:** registration with a profile picture, login and logout, with sessions keeping members signed in
- **Posts:** create, edit and delete blog posts with a title, body and optional image
- **Community feed:** all members' posts on one page, each showing its author
- **User management:** list, create, update and delete users
- **Validation:** required fields, username format, email format and minimum password length, with clear error messages
- **Responsive design:** custom CSS layout with a landing page, features section and testimonials

## Built with

- PHP (object-oriented, with `Database`, `User`, `Content` and `ValidateInfo` classes)
- MySQL through PDO with prepared statements
- HTML and CSS

## How it handles security

- All database queries use **PDO prepared statements**, which protects against SQL injection.
- User-supplied content is escaped with `htmlspecialchars()` before display, which protects against cross-site scripting (XSS).
- Pages that change data require a logged-in session.
- Each post is linked to its author through a foreign key.

## Project structure

```text
classes/     Database connection, User, Content and validation classes
inc/         Shared header and footer
sql/         Table definitions (usersInfo, content)
css/         Styles
images/      Logos and card images
*.php        Pages: home, login, register, posts, users
```

## Run it locally

1. Create a MySQL database and run `sql/userInformation.sql` to create the tables.
2. Set your own host, database name, username and password in `classes/database.php`.
3. Serve the folder with PHP, for example `php -S localhost:8000`, and open `http://localhost:8000`.

## What I'd improve next

- Switch password hashing to PHP's built-in `password_hash()` and `password_verify()`, which add a salt automatically.
- Move database settings into environment variables instead of code.
- Add CSRF tokens to forms and pagination to the post feed.
