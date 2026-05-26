# Learning Platform

A comprehensive learning platform built with Laravel 12. This application features course management, user enrollment, forums, and uses MongoDB for flexible data storage.

## Features

- **Course Management:** Create and manage courses.
- **User Enrollment:** Students can enroll in courses.
- **Forums:** Dedicated spaces for discussion and collaborative learning.
- **Modern Stack:** Built on Laravel 12, utilizing Laravel Breeze for authentication and MongoDB as the database.

## Prerequisites

Before setting up the project, make sure you have the following installed on your system:
- PHP 8.2 or higher
- Composer
- Node.js & npm
- MongoDB

## Setup Instructions

Setting up the project is straightforward thanks to the provided setup script.

1. **Clone the repository:**
   ```bash
   git clone <repository-url>
   cd learning-platform
   ```

2. **Configure Environment:**
   The setup script will automatically copy `.env.example` to `.env`, but make sure to update your `.env` file with your specific MongoDB connection details and other configurations.
   ```env
   DB_CONNECTION=mongodb
   DB_HOST=127.0.0.1
   DB_PORT=27017
   DB_DATABASE=learning_platform
   ```

3. **Run the Setup Script:**
   You can run all necessary setup steps (installing PHP dependencies, generating application key, running migrations, installing NPM packages, and building frontend assets) with a single Composer command:
   ```bash
   composer run setup
   ```

4. **Start the Development Server:**
   To run the local development server, Vite for frontend assets, and queue workers concurrently, use:
   ```bash
   composer run dev
   ```

5. **Access the Application:**
   Open your browser and navigate to `http://localhost:8000`.

## Testing

To run the test suite, you can use the following Composer script:
```bash
composer run test
```

## License

This project is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).
