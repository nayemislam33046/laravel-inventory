# 🚀 Inventory Project - Installation & Setup Guide

Thank you for using this Laravel-based project! This guide will help you get the application up and running on your local machine from the ZIP file you received.

---

## 📦 Requirements

Before you begin, make sure the following are installed on your system:

- PHP 8.x or later
- Composer
- Laravel CLI
- Node.js and npm
- XAMPP or LAMPP (for Apache and MySQL)
- MySQL Database

---

## 📁 Step-by-Step Setup

### 1. Extract the ZIP File
Unzip the project file into your desired directory:

# unzip your-project.zip
# cd your-project-folder

### 2. Install PHP Dependencies

composer install

### 3. Install Frontend Dependencies

# npm install

Then Compile The Asset 

# composer run dev

and start apache and mysql server with xampp or command line

# cd /opt/lampp
# sudo ./lampp startapache
# sudo ./lampp startmysql

### 4. Run Database Migrations

# php artisan migrate

### 5. Link Storage

# php artisan storage:link

### 6. Seed Admin User

# php artisan db:seed --class=AdminUserSeeder

you can customize database 
database/seeders/AdminUserSeeder.php



app/                  → Application logic
bootstrap/            → Framework bootstrap files
database/             → Migrations & seeders
public/               → Publicly accessible folder
resources/views/      → Blade templates (UI)
routes/web.php        → Web routes
.env                  → Environment configuration


```bash