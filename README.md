# VidHire: One-Way Video Interview Platform

**Built for Horizon Sphere Equity’s 24-Hour Developer Challenge**

VidHire is a Laravel-based web app for running simple one-way video interviews.
Admins create interviews with questions, candidates submit answers as video links, and reviewers score them — all in a browser, no extra apps required.

I normally work with Django, Flask, FastAPI, and Express.js. Laravel was less familiar, but I learned what I needed and shipped this in under 24 hours.

👉 [View Live Demo](http://139.59.89.144)
👉 [GitHub Repo](https://github.com/Sadja18/vidhire-laravel.git)

---

## Features

* Role-based login: **Admin**, **Reviewer**, **Candidate**
* Admin can create interviews and set questions
* Candidate submits a video link (e.g., YouTube unlisted, Cloudinary, etc.)
* Reviewer watches the video, scores (1–5), and leaves comments
* Built-in PDF guides for each role
* Responsive UI with Bootstrap 5 and Blade templates

**Note:** Videos are not uploaded directly. Candidates paste a public video link. This kept the project lightweight and achievable within the challenge timeframe.

---

## Tech Stack

| Component  | Choice                           |
| ---------- | -------------------------------- |
| Framework  | Laravel 12                       |
| Language   | PHP 8.2                          |
| Database   | MariaDB 10.11 (MySQL-compatible) |
| Server     | Apache2 on Ubuntu 24.04          |
| Auth       | Session-based (no Sanctum)       |
| Frontend   | Bootstrap 5 + Blade              |
| Deployment | DigitalOcean droplet             |

---

## Setup (Linux / Ubuntu)

### Local Development

1. **Install PHP 8.2 + extensions**

   ```bash
   sudo apt update
   sudo apt install software-properties-common -y
   sudo add-apt-repository ppa:ondrej/php -y
   sudo apt update
   sudo apt install php8.2 php8.2-mysql php8.2-curl php8.2-xml php8.2-mbstring php8.2-zip php8.2-gd php8.2-cli -y
   ```

2. **Install Composer**

   ```bash
   curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
   ```

3. **Clone the repo**

   ```bash
   git clone https://github.com/Sadja18/vidhire-laravel.git
   cd vidhire
   ```

4. **Install dependencies**

   ```bash
   composer install --optimize-autoloader --no-dev
   cp .env.example .env
   php artisan key:generate
   ```

5. **Install MariaDB & create database**

   ```bash
   sudo apt install mariadb-server -y
   sudo mysql_secure_installation
   ```

   Then log in and create a database + user:

   ```sql
   CREATE DATABASE vidhire_db CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   CREATE USER 'vidhire_user'@'localhost' IDENTIFIED BY 'yourpassword';
   GRANT ALL PRIVILEGES ON vidhire_db.* TO 'vidhire_user'@'localhost';
   FLUSH PRIVILEGES;
   EXIT;
   ```

6. **Update `.env`**

   Edit `.env` to match your DB credentials:

   ```env
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=vidhire_db
   DB_USERNAME=vidhire_user
   DB_PASSWORD=yourpassword
   ```

7. **Run migrations**

   ```bash
   php artisan migrate --seed
   ```

8. **Start dev server**

   ```bash
   php artisan serve --host=0.0.0.0 --port=8000
   ```

   Visit: `http://localhost:8000`

   Default test users (if seeded):

   * `admin@vidhire.com / password123`
   * `candidate@vidhire.com / password123`
   * `reviewer@vidhire.com / password123`

---

### Production Deployment

* Follow steps above for PHP, Composer, and DB setup

* Copy project to `/var/www/vidhire`

* Set correct permissions:

  ```bash
  sudo chown -R www-data:www-data /var/www/vidhire
  sudo chmod -R 775 /var/www/vidhire/storage /var/www/vidhire/bootstrap/cache
  ```

* Configure Apache virtual host pointing to `/public`

* Run:

  ```bash
  php artisan config:cache
  php artisan view:cache
  ```

---

## Project Structure

```
vidhire/
├── app/Models/
├── database/migrations/
├── public/guides/
├── resources/views/
├── routes/web.php
├── .env
└── composer.json
```

---

## Security Notes

* `.env` is ignored by Git
* Passwords hashed with Laravel’s `Hash::make()`
* Role-based middleware protects routes
* Guides are stored locally in `/public/guides/` and linked from the app

---

## License

This project is licensed under the **GNU General Public License v3.0 (GPLv3)**.
See the [LICENSE](LICENSE) file for details.

---

## Final Notes

This was built in 24 hours under time pressure.
It isn’t over-engineered, but it works: you can log in, create interviews, record answers, and review them.

I’m stronger in Python frameworks, but I adapted to Laravel quickly and delivered.
That’s what this project shows — the ability to learn fast, make trade-offs, and ship something usable.