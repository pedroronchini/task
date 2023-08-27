# Task Management Web Application

This repository contains a web-based task management application developed using Laravel framework and Docker for containerization.

## Prerequisites

To run this project, make sure you have the following installed:

- [Docker](https://www.docker.com/get-started)
- [Docker Compose](https://docs.docker.com/compose/install/)
- [Composer](https://getcomposer.org/)

## Getting Started

Follow the steps below to set up and run the project locally:

1. Clone the repository:
   ```bash
   git clone <repository_url>
   cd <repository_directory>
   ```

2. Create a `.env` file:
   ```bash
   cp .env.example .env
   ```

3. Update the `.env` file with your database and other configuration settings.

4. Install project dependencies using Composer:
   ```bash
   composer install
   ```

5. Build and start the Docker containers:
   ```bash
   docker-compose up -d
   ```

6. Generate an application key:
   ```bash
   docker-compose exec app php artisan key:generate
   ```

7. Run database migrations:
   ```bash
   docker-compose exec app php artisan migrate
   ```

8. Access the application in your browser:
   ```
   http://localhost:8989
   ```

## Usage

The web application provides the following features:

- Create, edit, and delete tasks.
- Assign tasks to users.
- Mark tasks as completed or pending.
- Attach files to tasks.
- View a list of tasks.

## Additional Notes

- This project uses Docker for containerization, making it easier to set up and run the application across different environments.
- Laravel is used as the backend framework, providing powerful tools for building web applications.
- The application utilizes JavaScript and AJAX to provide a responsive user interface for task management.
- Bootstrap is used for styling and UI components, resulting in a modern and user-friendly interface.

