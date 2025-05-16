# docs/Developer Guide

## Installation & Local Setup

***

### 1. Prerequisites

You will need the following tools installed on your system. The steps below will guide you through installing Composer and other necessary software.

| Tool                                       | How to Get (Windows)                                                                              | How to Get (macOS)                                                     |
| ------------------------------------------ | ------------------------------------------------------------------------------------------------- | ---------------------------------------------------------------------- |
| **PHP 8.2**                                | Included with XAMPP installation                                                                  | `brew install php` or native PHP 8 binary                              |
| **Composer**                               | Use the Windows Installer: [https://getcomposer.org/download/](https://getcomposer.org/download/) | Use Homebrew: `brew install composer`                                  |
| **Git**                                    | Download Installer: [https://git-scm.com/](https://git-scm.com/)                                  | Use Homebrew: `brew install git`                                       |
| **MySQL 8**                                | Included with XAMPP installation                                                                  | Use Homebrew: `brew install mysql@8`; then `brew services start mysql` |
| **MySQL Workbench**                        | Optional GUI: Download from MySQL.com                                                             | Optional GUI: Download from MySQL.com                                  |
| **Node 18+** (optional for frontend build) | Download Installer: [https://nodejs.org/](https://nodejs.org/)                                    | Use Homebrew: `brew install node`                                      |

***

### 1.1 Install Composer

Composer is a dependency manager for PHP. It's required to install Laravel and its packages.

#### Windows

1. Go to the Composer download page: [https://getcomposer.org/download/](https://getcomposer.org/download/)
2. Download the **`Composer-Setup.exe`** file.
3. Run the installer.
4. During the installation, when asked about the PHP path, **make sure it points to your PHP executable**. If you installed XAMPP, this will be something like `C:\xampp\php\php.exe`. The installer usually detects it, but confirm it's correct.
5. Complete the installation. The installer should automatically add Composer to your system's PATH.

#### macOS

1. Open your terminal.
2. If you don't have Homebrew installed, follow the instructions on [https://brew.sh/](https://brew.sh/).
3.  Run the following command:

    ```bash
    brew install composer
    ```

    Homebrew will download and install Composer, making it available in your terminal.

***

### 1.2 Install Other Prerequisites

Now, install the remaining tools listed in the Prerequisites table (Step 0).

* **Windows Users:**
  * Download and run the **XAMPP** installer from [https://www.apachefriends.org/index.html](https://www.apachefriends.org/index.html). This will install Apache, PHP, and MySQL.
  * Download and run the **Git** installer from [https://git-scm.com/](https://git-scm.com/). You can generally accept the default options.
  * (Optional) Download and run the **Node.js** installer from [https://nodejs.org/](https://nodejs.org/) if you plan to build frontend assets.
  * Download and run the **MySQL Workbench** installer from [MYSQL ](https://dev.mysql.com/downloads/workbench/)
* **macOS Users:**
  *   Use **Homebrew** for most installations:

      ```bash
      brew install git
      brew install mysql@8
      brew install node # Optional
      ```
  *   After installing MySQL, start the service:

      ```bash
      brew services start mysql
      ```
  * (Optional) Download the **MySQL Workbench** DMG file from MySQL.com and install it by dragging the application to your Applications folder.

***

### 1.3 Configure Windows Environment Variables (only once)

This step is essential for Windows users to ensure your terminal can find the `php`, `composer`, and `artisan` commands regardless of your current directory. Skip this step if you are on macOS or Linux, as Homebrew usually handles this. This should be done **after** installing XAMPP and Composer (Steps 1.1 and 1.2).

1. **Open Environment Variables**
   1. Press `Win + S` and type **“Edit the system environment variables.”**
   2. Click the result. The System Properties dialog opens.
   3. In the **Advanced** tab, click **Environment Variables…**.
2. **Add PHP to&#x20;**_**User**_**&#x20;Path**
   1. In the top pane **User variables for \<YOU>**, select **Path** → **Edit…**.
   2.  Click **New** and paste the path to your XAMPP PHP directory:

       ```
       C:\xampp\php
       ```
   3. Click **OK**.
3. **Add Composer to&#x20;**_**User**_**&#x20;Path**
   1. Still in **User variables**, select **Path** again → **Edit…**.
   2.  Click **New** and paste the path where the Composer installer placed its executable. This is commonly:

       ```
       C:\ProgramData\ComposerSetup\bin
       ```

       _(If you used a different Composer installation method or location, you might need to add `C:\Users\<YOUR-USERNAME>\AppData\Roaming\Composer\vendor\bin` instead - replace `<YOUR-USERNAME>` with your Windows user folder name.)_
   3. Click **OK** three times to close all dialogs.

***

### 1.4 Verify Installations & Path

Open a **new** terminal window (Command Prompt or PowerShell on Windows, Terminal on macOS). Run the following commands to confirm that the necessary tools are installed and accessible from your PATH:

```bash
php -v       # Should show PHP version 8.x
composer -V  # Should show Composer version
git --version # Should show Git version
```

If any command is not recognized, revisit the installation steps (1.1, 1.2) and the Windows PATH configuration (1.3). Make sure you opened a _new_ terminal window after making changes to environment variables.

***

### 2. Start Web Server & Database (Windows with XAMPP)

This step is for Windows users who installed XAMPP. macOS users typically manage MySQL via Homebrew services and will use PHP's built-in server later.

1. Launch the **XAMPP Control Panel**.
2. Click the **Start** button next to **Apache** (your web server) and **MySQL** (your database server).
3. Wait until the status indicators for both Apache and MySQL turn **green**, indicating they are running.

***

### 3. Clone Code into Webroot

Navigate in your terminal to the directory where web server files are served from. For XAMPP on Windows, this is typically `C:\xampp\htdocs`. On macOS, a common location is `~/Sites`. Then, clone the project repository:

#### Windows

PowerShell

```
cd C:\xampp\htdocs
git clone [https://github.com/Amr2001-lab/Graduation-Project.git](https://github.com/Amr2001-lab/Graduation-Project.git)
cd Graduation-Project
```

#### macOS

Bash

```
mkdir -p ~/Sites # Create the directory if it doesn't exist
cd ~/Sites
git clone [https://github.com/Amr2001-lab/Graduation-Project.git](https://github.com/Amr2001-lab/Graduation-Project.git)
cd Graduation-Project
```

The main Laravel project code is located within the `src/` subdirectory of the cloned repository. The `exe/` directory contains supplementary files, including the SQL database dump.

***

### 4. Install PHP Dependencies

Move into the `src` directory (which contains the project's `composer.json` file) and use Composer to download and install all the required PHP libraries and frameworks, including Laravel itself.

Bash

```
cd src
composer install
```

This command reads `src/composer.json` and downloads dependencies into the `src/vendor/` directory.

***

### 4 Environment Configuration

Navigate back up to the project root directory (`Graduation-Project`). Copy the example environment file to create your local configuration file.

Bash

```
# From the project root directory (Graduation-Project)

# Windows
copy src\.env.example src\.env

# macOS / Linux
cp src/.env.example src/.env
```

Now, open the newly created `src/.env` file in a text editor. Find the section starting with `DB_` and configure your database connection details to match your MySQL setup.

Code snippet

```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=real_estate # Use this name or update it to match your database
DB_USERNAME=root
DB_PASSWORD= # Leave blank if your root user has no password, or enter it here
```

Make sure the `DB_DATABASE` name matches the database you will set up in the next step (Step 5).

Next, generate a unique application key for your Laravel installation. This key is used for encryption and security. Run this command from the project root directory:

Bash

```
php src/artisan key:generate
```

This command adds or updates the `APP_KEY` variable in your `src/.env` file.

***

### 4. Database Setup

You can prepare the database by either running Laravel's built-in migrations and seeders or by importing a provided SQL dump file. Choose **Option A** or **Option B**:

#### Option A – Run Laravel Migrations (+Seeders)

From the project root directory, execute the `migrate` command. Including the `--seed` flag will also run the database seeders, populating the database with initial data.

Bash

```
php src/artisan migrate --seed
```

This option requires that the database name specified in `src/.env` (`DB_DATABASE=real_estate`) already exists and that the `DB_USERNAME` has permissions to create tables within it.

To import:

1. Open **MySQL Workbench** and connect to your local MySQL server (host: `127.0.0.1`, user: `root`, password: _blank or as configured_).
2. Right-click the **Schemas** panel → **Create Schema...**
   * Name it exactly `real_estate` (or match `DB_DATABASE` in your `.env` file).
3. Go to **File → Open SQL Script...**
   * Navigate to your cloned repository folder → `exe/real_estate.sql`
4. Ensure `real_estate` is selected as the active schema.
5. Click **Execute** (lightning icon).

This will create all necessary tables and populate initial data.

***

### 5. Build Front-end Assets (optional)

This step is only necessary if you installed Node.js/npm (Step 1.2) and plan to modify the project's front-end source files (like those in `resources/js` or `resources/css`) that use tools like Tailwind CSS. If you don't need to modify the frontend, you can skip this as pre-built assets are committed.

Navigate into the `src` directory:

Bash

```
cd src
```

Install the Node.js dependencies:

Bash

```
npm install
```

Then, run the build command:

Bash

```
npm run build   # Builds optimized assets for production
# Or, for development with hot-reloading/watching:
# npm run dev -- --watch # Runs a development build and watches for file changes
```

The output assets will be placed in the `src/public/build/` directory.

***

### 6. Serve the Application

The method to access the running application depends on your setup.

#### Windows (Apache via XAMPP)

If you started the Apache web server in XAMPP (Step 1), the application should be accessible through its `public` directory. Open your web browser and navigate to:

Bash

```
http://localhost/Graduation-Project/src/public
```

This URL points to the project's `public` directory relative to the XAMPP `htdocs` folder.

#### macOS / Linux (Laravel development server)

From the project root directory (`Graduation-Project`), use Laravel's built-in development server. This is often more convenient for development than setting up Apache/Nginx separately on macOS/Linux.

Bash

```
php src/artisan serve --host=127.0.0.1 --port=8000
```

Then open your web browser and go to:

```
[http://127.0.0.1:8000](http://127.0.0.1:8000)
```

The terminal running the command will display server logs. Press `Ctrl + C` to stop the server.

***

### 8 Troubleshooting

| Issue                                                      | Resolution                                                                                                                                                                                                                                                                            |
| ---------------------------------------------------------- | ------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------- |
| “`php` not recognized” (Windows)                           | Ensure XAMPP/PHP is installed (Step 0.2) and its path `C:\xampp\php` is added to your User or System PATH environment variables (Step 0.3). Open a **new** terminal window.                                                                                                           |
| “`composer` not recognized” (Windows)                      | Ensure Composer is installed (Step 0.1) and its bin path (`C:\ProgramData\ComposerSetup\bin` or similar) is added to your User or System PATH (Step 0.3). Open a **new** terminal window.                                                                                             |
| “`git` not recognized”                                     | Ensure Git is installed (Step 0.2) and its executable path is in your system's PATH environment variable. Open a **new** terminal.                                                                                                                                                    |
| Port 80 busy in XAMPP                                      | Another application (like Skype, IIS, etc.) is using port 80. Stop the conflicting application or change Apache's listening port in `C:\xampp\apache\conf\httpd.conf` (edit the `Listen 80` line to `Listen 8080`, for example).                                                      |
| `PDOException: could not connect` or other database errors | Confirm MySQL is running (Step 1 for Windows, `brew services list` for macOS). Verify credentials (`DB_DATABASE`, `DB_USERNAME`, `DB_PASSWORD`) in `src/.env` exactly match your MySQL setup. Ensure the database specified in `DB_DATABASE` exists and is correctly set up (Step 5). |
| `APP_KEY` missing error                                    | Navigate to the project root (`Graduation-Project`) and run `php src/artisan key:generate` again (Step 4). Ensure the `src/.env` file exists and the user running the command has write permissions.                                                                                  |
| Massive folders in repo (`vendor`, `node_modules`)         | These directories should be excluded by the `.gitignore` file. If they were accidentally committed, remove them from Git's tracking (`git rm -r --cached vendor node_modules`) and then regenerate them by running `composer install` and `npm install` from the `src` directory.     |
| Site shows directory listing or errors (Windows Apache)    | Ensure you are accessing the application via the correct public directory path in the URL: `http://localhost/Graduation-Project/src/public`.                                                                                                                                          |
| Site shows 404 Not Found / Routing errors                  | Ensure the `.htaccess` file in `src/public` is present and enabled by your web server (Apache needs `mod_rewrite` enabled). For the Laravel dev server (macOS/Linux), ensure `php artisan serve` is run from the project root.                                                        |
