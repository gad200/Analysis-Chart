# Analysis-Chart
# Production Monitoring Dashboard

## Overview
This project aims to create a dashboard for monitoring and optimizing the sugar production process using IoT technology. Real-time data from sensors measuring temperature and pH levels are collected, stored in a MySQL database, and visualized using Chart.js.

## Features
- **Dashboard**: Provides an intuitive interface to monitor sugar production metrics.
- **Real-time Data**: Collects data from IoT sensors (temperature, pH) and updates the dashboard.
- **Database**: Stores sensor data in a MySQL database.
- **Visualization**: Utilizes Chart.js to create interactive charts for data visualization.

## Technologies Used
- Laravel 11
- MySQL
- Chart.js 
- Vue
- Vuetify
- Axios

## Installation
```bash
# Clone this repository
git clone <repository-url>

# Set up your Laravel environment
cp .env.example .env
php artisan key:generate

# Configure the MySQL database connection in the .env file
# DB_CONNECTION=mysql
# DB_HOST=127.0.0.1
# DB_PORT=3306
# DB_DATABASE=your_database
# DB_USERNAME=your_username
# DB_PASSWORD=your_password

# Install dependencies using Composer and npm
composer install
npm install

# Run migrations to create the necessary tables
php artisan migrate

# Start the Laravel development server
php artisan serve
