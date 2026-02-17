# Academic Journal Management System

<p align="center">
  <img src="https://img.shields.io/badge/Laravel-12.x-red" alt="Laravel 12.x">
  <img src="https://img.shields.io/badge/PHP-8.2+-blue" alt="PHP 8.2+">
  <img src="https://img.shields.io/badge/MySQL-8.0+-orange" alt="MySQL 8.0+">
  <img src="https://img.shields.io/badge/TailwindCSS-3.x-38B2AC" alt="TailwindCSS 3.x">
  <img src="https://img.shields.io/badge/License-Proprietary-lightgrey" alt="Proprietary License">
</p>

## Overview

A comprehensive Academic Journal Management System built with Laravel 12
that facilitates the submission, review, and publication of academic
journals.\
The platform supports two primary user roles (Authors and Admins) with
distinct functionalities, ensuring a streamlined workflow from
manuscript submission to final publication.

> ⚠️ **Note:** This project is **not open source**. All rights are
> reserved by the author/owner.

------------------------------------------------------------------------

## Key Features

### User Roles

-   **Authors:** Submit journals, manage submissions, track publication
    status\
-   **Admins:** Manage users, journals, tags, announcements; oversee the
    entire workflow

### Journal Management

-   Rich text editor (Quill) for content creation\
-   File uploads (manuscripts, cover images, supplementary files)\
-   Co-author management with ORCID integration\
-   Tag-based categorization\
-   Status tracking (draft, submitted, under review, revision required,
    published, rejected)\
-   Version control for revisions

### Notification System

-   Database notifications\
-   Email notifications for important events\
-   Customizable announcement system\
-   Read/unread tracking\
-   Mark all as read functionality

### Admin Dashboard

-   Comprehensive statistics and analytics\
-   User activity monitoring\
-   Journal submission trends\
-   Popular tags and categories\
-   Recent activities feed\
-   User management (CRUD operations)

### Author Features

-   Personal dashboard\
-   Journal submission wizard\
-   Track submission status\
-   Receive feedback from reviewers\
-   Co-author management\
-   Profile management

### Tag Management

-   Create, edit, delete tags\
-   Merge tags functionality\
-   Bulk delete operations\
-   Tag usage statistics\
-   Popular tags display

### Security & Authentication

-   Email verification\
-   Password reset functionality\
-   Remember me feature\
-   Role-based access control (Author/Admin)\
-   Session management

### Additional Features

-   Newsletter subscription with email verification\
-   Contact form with email notifications\
-   Social media integration\
-   SEO-friendly URLs with slugs\
-   Responsive design (TailwindCSS)\
-   Toast notifications\
-   PDF preview in browser\
-   Citation tools (APA, MLA, Chicago formats)

------------------------------------------------------------------------

## System Architecture

### Database Schema

    ├── users
    ├── profiles
    ├── countries
    ├── journals
    ├── co_authors
    ├── tags
    ├── journal_tag (pivot)
    ├── journal_files
    ├── notifications
    ├── announcements
    ├── newsletter_subscriptions

### Key Relationships

-   User ↔ Profile (One-to-One)\
-   User ↔ Journals (One-to-Many)\
-   Journal ↔ CoAuthors (One-to-Many)\
-   Journal ↔ Tags (Many-to-Many)\
-   Journal ↔ Files (One-to-Many)

------------------------------------------------------------------------

## 🚀 Installation Guide

### Prerequisites

-   PHP \>= 8.4\
-   Composer\
-   MySQL \>= 8.0 / MariaDB \>= 10.3\
-   Node.js & NPM\
-   Git

### Step-by-Step Installation

#### 1. Clone the repository

``` bash
git clone https://github.com/yourusername/academic-journal.git
cd academic-journal
```

#### 2. Install PHP dependencies

``` bash
composer install
```

#### 3. Install JavaScript dependencies

``` bash
npm install
```

#### 4. Environment Configuration

``` bash
cp .env.example .env
php artisan key:generate
```

#### 5. Configure Database in `.env`

``` env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=academic_journal
DB_USERNAME=root
DB_PASSWORD=
```

#### 6. Configure Mail in `.env`

``` env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=your-email@gmail.com
MAIL_PASSWORD=your-app-password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=your-email@gmail.com
MAIL_FROM_NAME="${APP_NAME}"

MAIL_ADMIN_ADDRESS=admin@academicjournal.edu
```

#### 7. Run migrations and seeders

``` bash
php artisan migrate --seed
```

#### 8. Create storage link

``` bash
php artisan storage:link
```

#### 9. Build assets

``` bash
npm run build
```

#### 10. Start the development server

``` bash
php artisan serve
```

------------------------------------------------------------------------

## 🔧 Configuration

### Default Admin Credentials

After seeding, you can login with:

-   **Email:** admin@academicjournal.edu\
-   **Password:** password

### Environment Variables

  -------------------------------------------------------------------------------
  Variable               Description                  Default
  ---------------------- ---------------------------- ---------------------------
  APP_NAME               Application name             Academic Journal

  APP_URL                Application URL              http://localhost

  MAIL_ADMIN_ADDRESS     Admin email for              admin@academicjournal.edu
                         notifications                

  MAIL_FROM_ADDRESS      Sender email address         hello@example.com
  -------------------------------------------------------------------------------

------------------------------------------------------------------------

## Project Structure

    ├── app/
    │   ├── Http/
    │   │   ├── Controllers/
    │   │   │   ├── Admin/
    │   │   │   ├── Auth/
    │   │   │   └── Author/
    │   ├── Models/
    │   └── Notifications/
    ├── database/
    │   ├── migrations/
    │   └── seeders/
    ├── resources/
    │   ├── views/
    │   │   ├── admin/
    │   │   ├── author/
    │   │   ├── auth/
    │   │   └── partials/
    ├── routes/
    │   ├── web.php
    │   ├── auth.php
    │   ├── admin.php
    │   └── author.php
    └── public/
        └── storage/

------------------------------------------------------------------------

## Core Features in Detail

### Authentication System

-   User registration with email verification\
-   Login with remember me functionality\
-   Password reset via email\
-   Role-based redirection (Author/Admin)

### Journal Workflow

Draft → Submitted → Under Review → Revision Required → Published →
Rejected

### File Management

-   Manuscript upload (PDF)\
-   Cover image upload (JPG, PNG)\
-   Supplementary files (any format)\
-   File size validation\
-   Secure file storage

### Notification Types

-   Journal submitted\
-   Journal under review\
-   Revision required\
-   Journal approved\
-   Announcements

------------------------------------------------------------------------

## 🧪 Testing

Run tests with:

``` bash
php artisan test
```

------------------------------------------------------------------------

## Frontend Assets

-   CSS Framework: TailwindCSS\
-   Icons: Font Awesome 6\
-   Rich Text Editor: Quill\
-   JavaScript: Vanilla JS with Vite

------------------------------------------------------------------------

## License

This software is **proprietary** and **not open source**.\
Unauthorized copying, modification, distribution, or use is prohibited
without explicit permission from the owner.

------------------------------------------------------------------------

## 👏 Acknowledgments

-   Laravel community\
-   TailwindCSS\
-   Font Awesome\
-   All contributors and testers
