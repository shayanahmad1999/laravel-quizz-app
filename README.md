# Laravel Project Setup

This README will guide you through setting up and running the Laravel project locally.

## Prerequisites

Ensure the following tools are installed on your system:
🔧 Tech Stack:

-   PHP >= 8.4
-   Laravel = 12
-   Composer
-   Node.js >= 24.x
-   NPM >= 8.x
-   MySQL or any supported database

## Installation & Setup

Follow the steps below to get started:

```bash
# Clone the repository
git clone https://github.com/shayanahmad1999/laravel-quizz-app.git
cd laravel-quizz-app

# Install PHP dependencies
composer install

# Initialize and install Node.js dependencies
npm install

# Build frontend assets
npm run build

# Run the development server (optional during setup)
npm run dev

# Copy and set up the environment configuration
cp .env.example .env

# Generate application key
php artisan key:generate

# Run database migrations
php artisan migrate --seed

# Run the development server again
php artisan serve
npm run dev

```

## Installation of LaraDumps

Follow the steps below to Installed:

```bash

# Visit the site
https://laradumps.dev/
click on Get Started

# Right side menu click on installation
Desktop App
Download latest version here
Once downloaded, open it and proceed with the installer.

# After Installation Open Termianl of you Project
PHP Packages
1․ Install LaraDumps Package in your Laravel project using Composer.
Run the command:
composer require laradumps/laradumps ^4.0 --dev -W

2․ Now, configure LaraDumps. Run the command below:
php artisan ds:init $(pwd)

# Globally Installed
Global LaraDumps
1․ You can install the global LaraDumps via Composer.
composer global require laradumps/global-laradumps

How to install
global-laradumps install

How to uninstall
global-laradumps uninstall

# For more info please visit below link
https://laradumps.dev/get-started/installation.html


# Usage with Laravel Please visit below link
https://laradumps.dev/debug/laravel.html

```
