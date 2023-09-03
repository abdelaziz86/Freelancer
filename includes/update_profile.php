<?php
include 'connect.php';  // Include your database connection code
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Get form data
        $first_name = $_POST['first_name'];
        $last_name = $_POST['last_name'];
        $location = $_POST['location'];
        $job = $_POST['job'];
        $gender = $_POST['gender'];
        $bio = $_POST['bio'];
        $hourly_pay = $_POST['hourly_pay'] ; 
        $id = $_POST['id'];


        // You may want to add validation and sanitation of input data here

        // Update the user's profile in the database
        $query = "UPDATE user SET 
            first_name = :first_name, 
            last_name = :last_name, 
            location = :location, 
            job = :job, 
            gender = :gender, 
            bio = :bio,
            hourly_pay = :hourly_pay
            WHERE id = :id";

        $stmt = $db->prepare($query);
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':location', $location);
        $stmt->bindParam(':job', $job);
        $stmt->bindParam(':gender', $gender);
        $stmt->bindParam(':hourly_pay', $hourly_pay);
        $stmt->bindParam(':bio', $bio);
        $stmt->bindParam(':id', $id); // You should have the user's ID in the session

        $stmt->execute();

        echo "success"; // Send a success message back to the AJAX request
    } catch (PDOException $e) {
        echo "error"; // Send an error message back to the AJAX request
    }
}
?>
