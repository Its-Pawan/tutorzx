<?php
function dbConnect()
{
    $host = "localhost";
    $user = "root";
    $password = "";
    $dbname = "tutorxz";
    $conn = mysqli_connect($host, $user, $password, $dbname);
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }
    return $conn;
}

function createTable($conn)
{
    $checkTable = "SHOW TABLES LIKE 'users'";
    $result = mysqli_query($conn, $checkTable);

    if (mysqli_num_rows($result) > 0) {
        // Table exists
        echo "Table already exists.";
    } else {
        // Create table
        $sql = "CREATE TABLE users (
            id INT AUTO_INCREMENT PRIMARY KEY,
            full_name VARCHAR(100) NOT NULL,
            email VARCHAR(100) NOT NULL UNIQUE,
            phone VARCHAR(15),
            password VARCHAR(255) NOT NULL,
            role ENUM('student', 'teacher', 'admin') DEFAULT 'student',
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            status TINYINT(1) DEFAULT 1
        )";

        if (mysqli_query($conn, $sql)) {
            echo "Table created successfully.";
        } else {
            echo "Error creating table: " . mysqli_error($conn);
        }
    }
}

function isTableExist($conn, $tableName, $fn)
{
    $checkTable = "SHOW TABLES LIKE '$tableName'";
    $result = mysqli_query($conn, $checkTable);
    if (mysqli_num_rows($result) > 0) {
        // Table exists
        // echo "Table '$tableName' already exists.";
        return false;

    } else {
        // Create table
        $fn($conn);
        return true;
    }

}

$conn = dbConnect();

isTableExist($conn, "users", "createTable");