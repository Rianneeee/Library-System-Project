<?php
require "../includes/db.php";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $student_number   = $_POST['student_number'];
    $last_name        = $_POST['last_name'];
    $first_name       = $_POST['first_name'];
    $middle_initial   = $_POST['middle_initial'];
    $book_title       = $_POST['book_title'];
    $reservation_date = $_POST['reservation_date'];

    $sql = "INSERT INTO reservations 
            (student_number, last_name, first_name, middle_initial, book_title, reservation_date)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssssss", $student_number, $last_name, $first_name, $middle_initial, $book_title, $reservation_date);

    if ($stmt->execute()) {
        header("Location: reserve.php?status=success");
    } else {
        die("Execute failed: " . $stmt->error);
    }

    $stmt->close();
    $conn->close();
}
?>
