<?php
include('../includes/db.php');

if(isset($_POST['query'])){
    $query = $_POST['query'];
    $sql = "SELECT title FROM books WHERE title LIKE ? LIMIT 5";
    $stmt = $conn->prepare($sql);
    $like = "%$query%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    while($row = $result->fetch_assoc()){
        echo "<div>".$row['title']."</div>";
    }
}
?>