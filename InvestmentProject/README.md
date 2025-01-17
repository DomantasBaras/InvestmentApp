# Investment Management Application

## Overview

This application is a web-based platform for managing investments. It allows users to create investments and calculate interest rates based on predefined ranges. The system ensures user authentication and provides a hybrid setup for handling interest rates, leveraging both database and configuration-based defaults.

---

## Features

### Core Functionality

- **User Authentication:** Secure user login and registration with token-based authentication.
- **Investment Creation:** Users can create investments with specified amounts.
- **Interest Calculation:** Automatically applies interest rates based on configured ranges.

### Interest Rate Management

- **Dynamic Rates:** Rates can be managed dynamically through a database.

### Error Handling

- Pre-checks ensure investments cannot be created with invalid values (e.g., negative amounts).
- Provides clear error messages for invalid operations, such as missing interest rates.

### Frontend

- Built with Vue.js for a responsive and interactive user interface.
- Axios is used for API communication.

---

## Setup Instructions

### Prerequisites

- PHP >= 8.1
- Laravel >= 11
- Node.js & npm
- MySQL or any other database supported by Laravel

### Installation

1. Clone the repository:

   ```bash
   git clone <repository-url>
   cd <project-folder>
   ```

2. Install dependencies:

   ```bash
   composer install
   npm install
   ```

3. Configure environment variables:

   - Copy `.env.example` to `.env`
     ```bash
     cp .env.example .env
     ```
   - Update `.env` with your database, mail, and other configurations.

4. Generate application key:

   ```bash
   php artisan key:generate
   ```

5. Run migrations and seeders:

   ```bash
   php artisan migrate --seed
   ```

6. Start the development server:

   ```bash
   php artisan serve
   npm run dev
   ```