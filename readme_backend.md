# Ridhi Sidhi Security Services - Backend Setup

This project has been upgraded to a PHP backend with a full authentication system and an admin panel.

## Features Added
1.  **User Authentication**:
    *   **Register**: Signup page with Admin/Client roles.
    *   **Login**: Secure login with role-based redirection.
    *   **Forgot Password**: Mock implementation for password reset tokens.
2.  **Contact Form (Dynamic)**:
    *   Contact form submissions are saved to the database.
    *   AJAX-based form handling for smooth UX.
3.  **Admin Panel**:
    *   **Dashboard**: Overview of total users and enquiries.
    *   **Enquiry Management**: View details of all contact submissions, mark as read, delete, and direct reply links.
    *   **User Management**: View and delete registered users.
4.  **PHP Inclusions**: Shared `header.php` and `footer.php` for easier maintenance.

## Installation / Setup

1.  **Database**:
    *   Create a MySQL database named `ridhi_sidhi_db`.
    *   Import/Run the provided `setup_db.sql` file in your MySQL environment (phpMyAdmin or CLI).
    *   Configure your connection in `config/db.php`.

2.  **Folder Structure**:
    *   Ensure the `config/` directory exists with `db.php` and `config.php`.
    *   Ensure the `includes/` directory exists with `header.php` and `footer.php`.
    *   Ensure the `admin/` directory exists with its associated view files.

3.  **Admin Login**:
    *   Default Admin Credentials:
        *   **Email**: `admin@ridhisidhi.com`
        *   **Password**: `admin123`
    *   Access the admin panel at `/admin/dashboard.php`.

## How to use
*   Start using the `.php` files instead of `.html` (e.g., `index.php`, `login.php`).
*   All forms now point to PHP processing scripts and use AJAX for a premium feel.

## Recommended Changes
*   Consider renaming all existing `.html` files in the root to `.php` and wrap them with:
    ```php
    <?php include 'includes/header.php'; ?>
    <!-- Page Content -->
    <?php include 'includes/footer.php'; ?>
    ```
