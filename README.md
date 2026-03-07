# Inactive User Reminder System

A Laravel-based automation system that detects inactive users (no login for 7 days) and queues a reminder notification.

## Features
- **Automated Detection**: Custom Artisan command to find inactive users.
- **Queue Processing**: Background jobs to handle notifications without slowing down the server.
- **Frequency Control**: Ensures users are only processed once per day.
- **Database Tracking**: Records reminder history in a dedicated `reminders` table.

## Tech Stack
- PHP 8.2+ / Laravel 12
- MySQL
- Bootstrap 5 (via Laravel Breeze)

## Setup Instructions

### 1. Clone the repository

```bash
git clone https://github.com/rajesh-mondal/inactive-user-reminder.git
cd inactive-user-reminder
```

### 2. Install Dependencies
Install the backend dependencies using Composer:
```bash
composer install
```

### 3. Environment Configuration
* Copy `.env.example` to `.env`
* Set your database credentials (`DB_DATABASE`, `DB_USERNAME`, etc.)
* Set `QUEUE_CONNECTION=database`
* (Optional) Set `INACTIVITY_DAYS=7`

### 4. Database Setup
```bash
php artisan migrate
```

## Running the Application

### 1. The Scheduler
To simulate the daily check:
```bash
php artisan schedule:work
```
Or run the command manually:
```bash
php artisan users:detect-inactive
```

### 2. The Queue Worker
To process the reminder jobs:
```bash
php artisan queue:work
```

## Testing
* Register a new user from the Home page using Breeze authentication
* Manually update the `last_login_at` in the `users` table to a date older than 7 days
* Run the detection command
* Check `storage/logs/laravel.log` for the reminder log
