# Ridhi Sidhi Security Services - PHP Backend Setup

This project is a premium security services website built with PHP and MySQL. It features a complete user authentication system, a dynamic contact form, and a dedicated Admin Panel.

## Features Included 🚀
- **User Authentication**: Secure Login, Registration (Admin/Client), and Forgot Password.
- **Dynamic Contact Form**: AJAX-based form handling with database storage.
- **Admin Panel**: Dashboard for managing enquiries and viewing/deleting users.
- **Responsive Design**: Fast and mobile-friendly interface.

---

## 🛠️ Prerequisites
- **XAMPP** (includes Apache & MySQL) - [Download XAMPP](https://www.apachefriends.org/index.html)

---

## 💻 Installation & Setup (Using XAMPP)

Follow these steps to run the project locally on your machine:

### 1. Project Placement
- Download or clone this repository.
- Move the entire `Ridhi-Sidhi` folder into your XAMPP's `htdocs` directory:
  - **Windows:** `C:\xampp\htdocs\Ridhi-Sidhi`
  - **macOS:** `/Applications/XAMPP/htdocs/Ridhi-Sidhi`

### 2. Start XAMPP Services
- Open the **XAMPP Control Panel**.
- Start both **Apache** and **MySQL** modules.

### 3. Database Setup (Import)
- Open your browser and go to: `http://localhost/phpmyadmin/`
- Click on **"New"** in the sidebar to create a database.
- Name the database: `ridhi_sidhi_db`
- Select the `ridhi_sidhi_db` in the sidebar and click the **"Import"** tab at the top.
- Choose the [setup_db.sql](setup_db.sql) file from your project folder and click **"Go"** or **"Import"**.

---

## 🚀 Running the Project
Once the setup is done, you can access the website in your browser:
- **Main Home Page:** `http://localhost/Ridhi-Sidhi/index.php`
- **Admin Panel:** `http://localhost/Ridhi-Sidhi/admin/dashboard.php`

---

## 🔐 Admin Login Details
You can log in to the admin panel using these default credentials:
- **Email:** `admin@ridhisidhi.com`
- **Password:** `admin123`

---

## 📂 Project Structure Highlights
- `/config/db.php`: Database connection settings.
- `/includes/`: Reusable header and footer files.
- `/admin/`: All files and logic for the admin dashboard.
- `*_process.php`: Backend logic for handling form submissions safely.

---

© 2025 Ridhi Sidhi Security Services. Developed for premium protection solutions.
