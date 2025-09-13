<?php
// includes/config.php
session_start(); // Start a session to track user login

// Your Database Details (You made these up, Itumeleng)
$host = "localhost";       // Host is almost always 'localhost'
$dbname = "Itumeleng_db";  // The name you invented for the database
$username = "Itumeleng";   // The username you invented
$password = "winny@MOM";   // The password you invented

// Try to connect to the database
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    // Set the PDO error mode to exception
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
} catch(PDOException $e) {
    // If connection fails, show a clear error message
    die("Connection failed. Please check your database details. Error: " . $e->getMessage());
}
?>