InvestmentApp

InvestmentApp is a web application for managing investments. Built with Laravel on the backend and Vue.js on the frontend, it allows users to create, view, and manage their investments while dynamically calculating interest rates based on predefined ranges.
Features
Backend

    Laravel Framework: A robust and scalable backend for handling API requests and investment logic.
    Interest Ranges:
        Managed through a dedicated class for flexibility and scalability.
        Automatically seeded during application boot using a database seeder.
    Investments:
        Validation to prevent invalid investments (e.g., negative values).
        Secure user authentication to ensure only logged-in users can create or view investments.
    Payment Schedule: Automatically generates a payment schedule for each investment.

Frontend

    Vue.js: Dynamic and interactive user interface.
    Flexible View Options: Users can toggle between table view and card view to visualize investment and cryptocurrency data.
    Live Search and Sorting: Allows users to search and sort data dynamically.
    Responsive Design: Optimized for both desktop and mobile devices.

Installation and Setup
Prerequisites

    Backend Requirements:
        PHP 8.x or higher
        Composer
        MySQL or compatible database
    Frontend Requirements:
        Node.js 16.x or higher
        npm or yarn

Steps

    Clone the repository:

git clone https://github.com/DomantasBaras/InvestmentApp.git
cd InvestmentApp

Install backend dependencies:

composer install

Set up the .env file:

cp .env.example .env

Configure your database credentials and other environment variables in the .env file.

Run migrations and seeders:

php artisan migrate --seed

Install frontend dependencies:

npm install

Build frontend assets:

npm run dev

Start the development server:

php artisan serve

Open the application in your browser:

    http://localhost:8000

Usage
Investment Creation

    Users must log in to create investments.
    Investments are validated to ensure positive values only.
    Interest is calculated dynamically based on the predefined ranges:
        $0 – $100: 5%
        $100 – $1000: 6%
        $1000 – $5000: 7%

View Options

    Toggle between table view and card view for a customizable visualization of data.
    Use the search bar to find investments or cryptocurrencies quickly.
    Sort data by rank, name, or financial attributes.

Interest Ranges

Interest ranges are managed via a dedicated PHP class, providing centralized control over rate definitions. A seeder is executed during the boot process to ensure these ranges are preconfigured for every environment.

If adjustments are needed, you can update the seeder or class logic to reflect the new rates.
Contributing

    Fork the repository.
    Create a new branch:

git checkout -b feature/your-feature

Commit your changes:

git commit -m "Add your feature"

Push to the branch:

    git push origin feature/your-feature

    Open a pull request.

License

This project is licensed under the MIT License. See the LICENSE file for more information.