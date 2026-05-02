# URL Shortener

A simple URL shortener application built with Laravel. Users can create shortened URLs, and the app supports role-based access (Super Admin, Admin, Member) with company-based organization.

## Features

- User authentication and registration
- Role-based access control (Super Admin, Admin, Member)
- Company management
- URL shortening with custom short codes
- Invitation system for adding users to companies

## Prerequisites

- PHP 8.1 or higher
- Composer
- Node.js and npm
- MySQL or another supported database

## Installation

1. **Clone the repository** (if not already done):
   ```bash
   git clone <repository-url>
   cd url-shortener
   ```

2. **Install PHP dependencies**:
   ```bash
   composer install
   ```

3. **Install Node.js dependencies**:
   ```bash
   npm install
   ```

4. **Set up environment**:
   - Copy the example environment file:
     ```bash
     cp .env.example .env
     ```
   - Edit `.env` to configure your database and other settings:
     ```
     DB_CONNECTION=mysql
     DB_HOST=127.0.0.1
     DB_PORT=3306
     DB_DATABASE=url_shortener
     DB_USERNAME=your_username
     DB_PASSWORD=your_password
     ```

5. **Generate application key**:
   ```bash
   php artisan key:generate
   ```

6. **Run database migrations**:
   ```bash
   php artisan migrate
   ```

7. **Seed the database** (optional, for initial data):
   ```bash
   php artisan db:seed
   ```

8. **Build assets**:
   ```bash
   npm run build
   ```
   Or for development:
   ```bash
   npm run dev
   ```

## Running the Application

Start the Laravel development server:
```bash
php artisan serve
```

The application will be available at `http://localhost:8000`.

## Usage

- Register as a new user or log in.
- Create shortened URLs.
- Admins can invite users to their company.
- Super Admins can manage all URLs and companies.

## Testing

Run the test suite:
```bash
php artisan test
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
