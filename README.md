# 🔧 TahoServis — Tachograph Service Management System

A full-stack web application for managing tachograph servicing workflows, built with **Laravel**, **Laravel Breeze** and **Laravel Blueprint**.

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-777BB4?style=for-the-badge&logo=php&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-005C84?style=for-the-badge&logo=mysql&logoColor=white)
![Blade](https://img.shields.io/badge/Blade-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)

---

## 📋 Overview

TahoServis is a role-based web platform that streamlines the entire tachograph servicing process — from client appointment booking to diagnostics, repairs, and automated certificate generation.

---

## ✨ Features

### 👤 Client
- Register and log in securely
- Book a tachograph service appointment (vehicle, tachograph type, desired date)
- Track service status in real time: *Scheduled → Diagnostics → Repair → Completed*
- View full service history

### 🛠️ Technician (Serviser)
- View and manage incoming service requests
- Run diagnostics and log results
- Record completed repairs and parts used
- Automatically generate a **PDF sealing certificate** upon repair completion

### 🔑 Administrator
- Full user management
- Inventory/spare parts management (add, edit, delete)
- Reports dashboard: total services, completed repairs, most-used parts, average processing time
- Export reports as PDF

---

## 🧱 Tech Stack

| Layer | Technology |
|---|---|
| Backend | PHP 8.x, Laravel 10 |
| Authentication | Laravel Breeze |
| Database | MySQL (via XAMPP / phpMyAdmin) |
| Frontend | Blade Templates, HTML, CSS |
| PDF Generation | Laravel PDF (DomPDF) |
| Dev Environment | XAMPP, Visual Studio Code |

---

## 🗄️ Database

Managed via **phpMyAdmin (XAMPP)**. Key tables:

- `users` — clients, technicians, admins (role-based)
- `appointments` — service bookings
- `diagnostics` — diagnostic records per appointment
- `repairs` — repair logs with parts used
- `parts` (zalihe) — spare parts inventory
- `certificates` — sealing certificate records

---

## 🖥️ Screens

The application includes **14 screens**:

1. Login
2. Registration (Client)
3. Client Dashboard
4. Technician Dashboard
5. Admin Dashboard
6. Book a Service (Client)
7. My Services / History (Client)
8. Service Requests (Technician)
9. Diagnostics Screen (Technician)
10. Repair Log Screen (Technician)
11. Inventory Management (Admin/Technician)
12. Add Inventory Item
13. Edit Inventory Item
14. Reports & Analytics (Admin)

---

## 🚀 Getting Started

### Prerequisites
- PHP >= 8.1
- Composer
- XAMPP (MySQL + Apache)
- Node.js & npm

### Installation

```bash
# 1. Clone the repository
git clone https://github.com/vukasinriznic/tahoservis.git
cd tahoservis

# 2. Install PHP dependencies
composer install

# 3. Install Node dependencies
npm install && npm run dev

# 4. Set up environment
cp .env.example .env
php artisan key:generate

# 5. Configure your .env database connection
DB_DATABASE=tahoservis
DB_USERNAME=root
DB_PASSWORD=

# 6. Run migrations
php artisan migrate

# 7. Seed the database (optional)
php artisan db:seed

# 8. Start the development server
php artisan serve
```

Then open [http://localhost:8000](http://localhost:8000) in your browser.

---

## 📁 Project Structure

```
tahoservis/
├── app/
│   ├── Http/Controllers/
│   └── Models/
├── database/
│   ├── migrations/
│   └── seeders/
├── resources/
│   └── views/          # Blade templates (14 screens)
├── routes/
│   └── web.php
└── .env.example
```

## 🔗 Live Site

👉 [View Live Site](https://tealfather.webflow.io)

---

## ❗ Note
If you want to test app you can register as a client and then login. To login as servicer you shoud enter email: serviser@tahoservis.com and password: password123 and to login as admin you should enter email: admin@tahoservis.com and password123.

## 👤 Author

**Vukašin Riznić**
[github.com/vukasinriznic](https://github.com/vukasinriznic)
