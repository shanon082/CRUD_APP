Student Management System (CRUD)

A simple Student Management System built using PHP, JavaScript, MySQL, and XAMPP that performs full CRUD (Create, Read, Update, Delete) operations for managing student records. This project is designed for learning purposes and demonstrates how to build a database-driven web application using core web technologies.

============================================================================================================================
Features
✔ Add new students
✔ View all students in a table
✔ Update student information
✔ Delete student records
✔ Form validation using JavaScript
✔ Backend processing using PHP
✔ Data storage using MySQL database

=============================================================================================================================
Technologies Used
Frontend: HTML, CSS, JavaScript
Backend: PHP
Database: MySQL
Server Environment: XAMPP

===============================================================================================================================
Open XAMPP Control Panel
Start:
Apache
MySQL

Open your browser and go to:
http://localhost/phpmyadmin

Create a new database:
student_managementn(Or any name)

Create a table called students and then import database in the config(folder):

===========================================================================================================================
Installation Guide
Follow these steps to run the project on your local machine:

Install XAMPP
1. Download and install XAMPP from:
https://www.apachefriends.org

2. Clone the Repository
git clone https://github.com/shanon082/CRUD_APP.git

3. Move Project Folder
Place the project inside the XAMPP htdocs folder: "C:\xampp\htdocs\CRUD_Project"

4. Configure Database
Open the database connection file (e.g., db.php) and ensure:
$host = "localhost";
$user = "root";
$password = "";
$database = "your database name";

5. Run the Application
Start Apache & MySQL in XAMPP, then open: "http://localhost/CRUD_Project"


=================================================================================================================
How It Works
-User fills in student details in a form
-JavaScript validates input
-PHP receives the data and stores it in MySQL
-Students are displayed in a dynamic table
-Each row has:
        Edit button → Updates record
        Delete button → Removes record

===============================================================================================================
Future Improvements
-Authentication system (Admin login)
-Pagination
-UI enhancement with frameworks (Bootstrap/Tailwind)

================================================================================================================
Author
Shanon Simon
Passionate developer focused on building practical web systems.

📜 License

This project is open-source and free to use for learning purposes.
