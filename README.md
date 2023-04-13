# Stock Data Project
This project allows users to search for historical stock data for a given company, specified by its symbol, and a date range. The historical data is displayed in a table and chart format. Users can also request to receive the data via email.

### Requirements
* PHP >= 7.4
* Composer
* Node.js and NPM
* Laravel >= 8.x
* MySQL or compatible database

### Setup

* Clone the repository:

    `git clone https://github.com/Lando-Ke/stock-data.git`

* Navigate to the project directory:

    `cd stock-data-project`

* Install PHP dependencies using Composer:

    `composer install`

* Install JavaScript dependencies using NPM:

    `npm install`

* Compile the frontend assets:

    `npm run dev`

* Create a copy of the .env.example file and name it .env
* Update the DB_DATABASE DB_USERNAME DB_PASSWORD
* Update the RAPID_API_KEY

    `cp .env.example .env`

* Update the .env file with your database configuration and any other necessary settings (API keys, email configuration, etc.).

* Generate a new application key:

    `php artisan key:generate`

* Run the migrations to create the necessary database tables:

    `php artisan migrate`

* Fetch and store Nasdaq Company Listings from API
    
    `php artisan fetch:company-data`

### Running the Project Locally

* Start the Laravel development server:

    `php artisan serve`

* Open a web browser and navigate to the displayed URL (usually http://127.0.0.1:8000).

* You should now be able to use the application and search for historical stock data.
<img width="774" alt="Screenshot 2023-04-13 at 11 42 28" src="https://user-images.githubusercontent.com/6400931/231705658-71051d35-47e6-4c79-8d8b-27b281d5b18c.png">

<img width="1339" alt="Screenshot 2023-04-13 at 11 42 43" src="https://user-images.githubusercontent.com/6400931/231705748-614ccacb-7dd8-47e0-a077-32a862699298.png">

<img width="1379" alt="Screenshot 2023-04-13 at 11 42 55" src="https://user-images.githubusercontent.com/6400931/231705843-b28fbf44-1151-4082-a036-ef56822a88d0.png">

