
# Tale Trail

**Tale Trail** is an interactive storytelling platform where users can log in, register, and navigate through stories. It uses PHP, MySQL, and JavaScript, with FastRoute handling routing. This project is designed to showcase user authentication and a dynamic story platform.

## Technologies Used
- **PHP** for backend logic
- **MySQL** for database management
- **JavaScript** for form validation
- **FastRoute** for routing
- **Composer** for dependency management

## Requirements
- PHP 7.4 or higher
- MySQL
- Composer (for dependencies)

## Installation

1. **Clone the Repository**
   ```bash
   git clone https://github.com/Ta1al/Tale-Trail.git
   ```

2. **Navigate to the Project Directory**
   ```bash
   cd tale-trail
   ```

3. **Install Dependencies**
   - Run the following command to install all necessary PHP dependencies using Composer:
   ```bash
   composer install
   ```

4. **Set Up Database**
   - Create a new MySQL database.
   - Import the provided SQL schema (if available) to create the necessary tables.

5. **Configure `.env`**
   - Rename `.env.example` to `.env` and update the database connection details.
   
   Example:
   ```env
    DB_HOST=localhost
    DB_NAME=db
    DB_USER=root
    DB_PASS=
   ```

6. **Start XAMPP**
   - Ensure Apache and MySQL are running.

7. **Access the App**
   - Navigate to `http://localhost` to see the app in action.

## Development

### Directory Structure

- `config/`: Holds configuration files (e.g., database, environment settings)
- `src/`: Application logic
  - `controllers/`: PHP classes that handle requests
  - `models/`: Database models
  - `views/`: HTML views for the frontend
- `public/`: Publicly accessible directory containing `index.php` and other assets
- `vendor/`: Composer dependencies

### Routes
- **GET `/register`**: Shows the registration page.
- **GET `/login`**: Shows the login page.
- **GET `/logout`**: Logs the user out.
- **POST `/register`**: Handles the registration form submission.
- **POST `/login`**: Handles the login form submission.

## Contributing

1. Fork the repository.
2. Create a new branch (`git checkout -b feature-name`).
3. Commit your changes (`git commit -am 'Add new feature'`).
4. Push to the branch (`git push origin feature-name`).
5. Create a new Pull Request.
