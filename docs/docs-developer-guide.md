# docs/Developer Guide

1.  ### Installation & Local Setup

    > These instructions assume you are running on Windows with XAMPP.    > \
    > Replace `root` / empty password with your own MySQL credentials if you changed them.

    #### 1. Start the Web Server and Database

    Before proceeding, ensure your local server environment is running.

    Open the **XAMPP Control Panel** and click "Start" for the following services:

    | Service | Action    | Why                                                                                  |
    | ------- | --------- | ------------------------------------------------------------------------------------ |
    | Apache  | **Start** | Hosts PHP files, allowing you to access the Laravel app in a browser (ports 80/443). |
    | MySQL   | **Start** | Runs the database server that the application will connect to (port 3306).           |

    Wait until both rows turn green in the XAMPP Control Panel, indicating that Apache and MySQL are running correctly.

    #### 2. Project Setup: Database, Code, and Configuration

    This section covers creating the database, cloning the project, installing dependencies, and configuring the environment.

    Open **Command Prompt** (or PowerShell) and follow these steps:

    1.  **Create a blank MySQL database:**        \
        This command connects to MySQL as the `root` user and creates a new database named `real_estate`.

        ```bash
        mysql -u root -e "CREATE DATABASE real_estate;"
        ```
    2.  **Clone the project repository:**        \
        Navigate to your desired projects directory (e.g., `C:\xampp\htdocs`) and clone the repository. Replace `https://github.com/YourOrg/Graduation-Project.git` with your actual project URL.

        ```bash
        git clone [https://github.com/YourOrg/Graduation-Project.git](https://github.com/YourOrg/Graduation-Project.git)
        ```
    3.  **Navigate into the project directory:**

        ```bash
        cd Graduation-Project
        ```
    4.  **Install project dependencies using Composer:**        \
        This will download and install all the libraries the project needs.

        ```bash
        composer install
        ```
    5.  **Set up the environment file:**        \
        Copy the example environment file. On Windows:

        ```bash
        copy .env.example .env
        ```

        (On macOS/Linux, use `cp .env.example .env`)
    6.  **Generate an application key:**        \
        This key is used for encrypting sessions and other sensitive data.

        ```bash
        php artisan key:generate
        ```
    7.  **Configure database connection in the `.env` file:**        \
        Open the `.env` file in your project's root directory with a text editor. Locate the database section and update it as follows. These settings tell Laravel how to connect to the `real_estate` database you created.

        ```ini
        DB_CONNECTION=mysql
        DB_HOST=127.0.0.1
        DB_PORT=3306
        DB_DATABASE=real_estate
        DB_USERNAME=root
        DB_PASSWORD=
        ```

        * `DB_PASSWORD`: Leave this empty if you haven't set a password for the `root` MySQL user in XAMPP. Otherwise, enter your `root` user's password.
    8.  **Run database migrations and seed initial data:**        \
        Migrations create the database tables, and seeders can populate them with initial/test data.

        ```bash
        php artisan migrate --seed
        ```
    9.  **Serve the application:**        \
        This command starts Laravel's local development server.

        ```bash
        php artisan serve
        ```

        Once the server is running (it will typically say `Laravel development server started: http://127.0.0.1:8000`), you can access your application by navigating to the following URL in your web browser:

        **http://127.0.0.1:8000**

    This completes the local setup for your Laravel project.
