<?php

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Validate and sanitize the email address
    $email = filter_input(INPUT_POST, "email", FILTER_SANITIZE_EMAIL);

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Database connection parameters
        $host = "127.0.0.1";
        $user = "root";
        $password = "";
        $database = "next-dev";

        // Create a PDO connection
        try {
            $pdo = new PDO("mysql:host=$host;dbname=$database", $user, $password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Insert the email into the database
            $stmt = $pdo->prepare("INSERT INTO newsletter_subscribers (email) VALUES (:email)");
            $stmt->bindParam(":email", $email);
            $stmt->execute();

            echo "Thank you for subscribing to our newsletter!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        } finally {
            $pdo = null;
        }
    } else {
        echo "Invalid email address.";
    }
} else {
    header("Location: index.html");
    exit();
}
