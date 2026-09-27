<?php
include('../includes/db.php');
?>

<!DOCTYPE html>
<html>
<head>
    <title>Search Books</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
</head>
<body class="p-4">

<div class="container">
    <h2>Search Books</h2>

    <!-- Search Form -->
    <form method="GET" class="mb-4">
        <div class="form-row">
            <div class="col">
                <label>Title</label>
                <input type="text" name="title" class="form-control">
            </div>
            <div class="col">
                <label>Author</label>
                <input type="text" name="author" class="form-control">
            </div>
            <div class="col">
                <label>Publisher</label>
                <input type="text" name="publisher" class="form-control">
            </div>
            <div class="col">
                <label>Year</label>
                <input type="text" name="year" class="form-control">
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Search</button>
    </form>

    <?php
    // Validation for Year: only allow numbers
    if(!empty($_GET['year']) && !ctype_digit($_GET['year'])){
        echo "<div class='alert alert-danger'>Year must be in number.</div>";
        exit; // stop the search if year is invalid
    }

    $where = [];

    if(!empty($_GET['title'])){
        $title = $_GET['title'];
        $where[] = "title LIKE '%$title%'";
    }

    if(!empty($_GET['author'])){
        $author = $_GET['author'];
        $where[] = "author LIKE '%$author%'";
    }

    if(!empty($_GET['publisher'])){
        $publisher = $_GET['publisher'];
        $where[] = "publisher LIKE '%$publisher%'";
    }

    if(!empty($_GET['year'])){
        $year = $_GET['year'];
        $where[] = "year = '$year'";
    }

    if(count($where) > 0){
        $sql = "SELECT * FROM books WHERE " . implode(" OR ", $where);
        $result = mysqli_query($conn, $sql);

        echo "<h4>Results</h4>";

        if(mysqli_num_rows($result) > 0){
            echo "<table class='table table-bordered'>";
            echo "<thead><tr>
                    <th>Title</th>
                    <th>Author</th>
                    <th>Publisher</th>
                    <th>Year</th>
                    <th>Category</th>
                    <th>Copies</th>
                  </tr></thead><tbody>";

            while($row = mysqli_fetch_assoc($result)){
                echo "<tr>";
                echo "<td>".$row['title']."</td>";
                echo "<td>".$row['author']."</td>";
                echo "<td>".$row['publisher']."</td>";
                echo "<td>".$row['year']."</td>";
                echo "<td>".$row['category']."</td>";
                echo "<td>".$row['copies']."</td>";
                echo "</tr>";
            }

            echo "</tbody></table>";
        } else {
            echo "<div class='alert alert-warning'>No books found.</div>";
        }
    }
    ?>
</div>
</body>
</html>
