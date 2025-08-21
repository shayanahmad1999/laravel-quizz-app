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

# LaraDumps – Installation & Quick Usage

LaraDumps is a developer-friendly debugging tool for Laravel that lets you send clean, structured debug output to a desktop app — so your browser stays clutter-free.

---

## 📦 Prerequisites

-   PHP & Composer installed
-   A Laravel project (for package installation)
-   Internet access to download the **LaraDumps Desktop App**

---

## 🚀 1) Install the Desktop App

1. Open **https://laradumps.dev/**
2. Click **Get Started** → **Installation** (right-side menu).
3. Download the latest **Desktop App** for your OS.
4. Install it and open the application.

> Keep the app running while you debug to receive dumps.

---

## 🧩 2) Install in Your Laravel Project

Run these in your project root:

```bash
# Install the package (dev only)
composer require laradumps/laradumps ^4.0 --dev -W

# Initialize LaraDumps in this project
php artisan ds:init $(pwd)
```

> **Note (Windows/PowerShell):** If `$(pwd)` doesn't resolve, replace it with your project path, e.g.:
>
> ```powershell
> php artisan ds:init "C:\path\to\your\project"
> ```

---

## 🌐 3) (Optional) Install Globally

Use this if you want to send dumps from anywhere (CLI scripts, etc.) or quickly set up multiple projects.

```bash
# Install the global CLI
composer global require laradumps/global-laradumps

# Run the installer
global-laradumps install

# Uninstall if needed
global-laradumps uninstall
```

---

## 🛠 Usage (Laravel)

### Basic dump

```php
// routes/web.php
use Illuminate\Support\Facades\Route;

Route::get('/demo', function () {
    ds('Hello LaraDumps!');
    return 'Check the LaraDumps desktop app.';
});
```

### Dump variables / arrays / objects

```php
$user = [
    'id' => 1,
    'name' => 'Zeshan',
    'roles' => ['admin', 'editor'],
];

ds($user);               // Pretty structured dump
ds($user['roles']);      // Dump specific part
```

### In a controller

```php
// app/Http/Controllers/UserController.php
namespace App\Http\Controllers;

use App\Models\User;

class UserController extends Controller
{
    public function show(int $id)
    {
        $user = User::with('roles')->find($id);

        ds('Loaded user', $user);  // Multiple arguments supported
        return view('users.show', compact('user'));
    }
}
```

### Compare with dd() / dump()

```php
// Instead of dd($foo) or dump($foo)
ds($foo);  // Non-blocking; output goes to the desktop app
```

> Tip: You can sprinkle `ds()` anywhere (routes, controllers, jobs, events, tests) and keep your HTTP responses clean.

---

## 🔧 Configuration

Running `php artisan ds:init $(pwd)` creates configuration files and sets up your project. If you need to change options later, re-run the command or visit the docs.

---

## ❓ Troubleshooting

-   **Nothing shows up?** Make sure the **LaraDumps Desktop App** is open.
-   **Firewall/Network issues?** Ensure the app is allowed through your firewall.
-   **Wrong project path?** Re-run `php artisan ds:init` with the correct path.

---

## 📚 Official Docs

-   Installation: https://laradumps.dev/get-started/installation.html
-   Laravel usage: https://laradumps.dev/debug/laravel.html

---

Happy debugging! 🎉
