
# NOS_Webapplication

This project is a web-based application that requires a local server environment to run. It uses PHP and MySQL, so you'll need a tool like AppServ to set up the local environment and test the project.

## Prerequisites

Before you begin, make sure you have the following installed on your machine:

- **AppServ** (or any equivalent tool that includes Apache, PHP, and MySQL)
  - You can download AppServ from [here](https://www.appserv.org/th/).

## Setup Instructions

### Step 1: Clone the Repository

First, you'll need to clone the project repository from GitHub to your local machine. Open a terminal and run the following command:

```bash
git clone https://github.com/NonthawatKRT/NOS_Webapplication.git
```

### Step 2: Install and Set Up AppServ

1. **Download and Install AppServ**:  
   Download AppServ and follow the installation steps. Make sure to install the following components:
   - Apache (Web Server)
   - PHP (Scripting Language)
   - MySQL (Database)

2. **Locate the `www` Directory**:  
   After installation, navigate to the `www` directory inside the AppServ folder. The default path is:

   ```bash
   C:\AppServ\www
   ```

   This directory is where you will place your project files.

### Step 3: Move Project Files to the `www` Directory

1. **After cloning the project, move the entire project folder into the `www` directory.**  
   For example, if you cloned the project to your Desktop:

   - Navigate to the cloned project folder.
   - Move the entire folder to:

   ```bash
   C:\AppServ\www
   ```

2. Once the project folder is inside the `www` directory, it should look something like this:

   ```bash
   C:\AppServ\www\your-repository
   ```

### Step 4: Set Up the Database

1. **Start AppServ**:  
   Make sure both Apache and MySQL services are running. You can do this by using the AppServ control panel.

2. **Access phpMyAdmin**:  
   Open a browser and type the following URL:

   ```bash
   http://localhost/phpMyAdmin
   ```

3. **Create the Database**:
   - Log in to phpMyAdmin using your MySQL credentials (default username: `root`, password: the one you set during AppServ installation).
   - Create a new database.
   - Import the SQL file (if provided) located in your cloned project folder to set up the necessary tables. (File name is `nos_db.sql`)

### Step 5: Run the Project

1. **Open a Web Browser**:  
   In your browser (Google Chrome, Firefox, etc.), type the following URL:

   ```bash
   http://localhost/your-repository/index.php
   ```

   Replace `your-repository` with the name of your project folder inside the `www` directory.

2. **Test the Application**:  
   The project should now load, and you can start interacting with the web application.

## Troubleshooting

- If you encounter issues with the database:
  - Make sure the MySQL service is running in AppServ.
  - Double-check that you imported the correct database schema.
  - Ensure that the database credentials in your project (likely in a `db_connection.php` file) match the ones you set up in phpMyAdmin.

- If Apache isn't running:
  - Check if another service is using port 80 (the default for Apache). You can change the port in the AppServ configuration or stop the conflicting service.
