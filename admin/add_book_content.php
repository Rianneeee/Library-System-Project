<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "book_management";

// Connect to database
$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"];
    $author = $_POST["author"];
    $publisher = $_POST["publisher"];
    $year = $_POST["year"];
    $category = $_POST["category"];
    $copies = $_POST["copies"];

    $sql = "INSERT INTO books
            (title, author, publisher, year, category, copies)
            VALUES
            ('$title', '$author', '$publisher', '$year', '$category', '$copies')";

    if (mysqli_query($conn, $sql)) {
        $message = "Book added successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}

?>

<!DOCTYPE html>
<html>
<head>

    <title>Add Book</title>

    <style>

        body {
            font-family: Arial, sans-serif;
            background-color: white;
            margin: 0;
        }

        .form-container {
            width: 590px;
            margin: 60px auto;
            border: 1px solid #ddd;
            background-color: white;
        }

        .form-title {
            padding: 20px;
            color: #15549b;
            font-size: 18px;
            font-weight: bold;
            border-bottom: 1px solid #ddd;
        }

        .form-body {
            padding: 25px 20px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            font-size: 16px;
            color: #333;
        }

        input {
            width: 100%;
            height: 42px;
            padding: 10px;
            margin-bottom: 22px;
            border: 1px solid #ccc;
            box-sizing: border-box;
            font-size: 15px;
        }

        button {
            width: 100%;
            height: 42px;
            background-color: #1769d1;
            color: white;
            border: none;
            font-size: 16px;
            cursor: pointer;
        }

        button:hover {
            background-color: #1258b0;
        }

        .success {
            background-color: #dff0d8;
            color: #3c763d;
            padding: 12px;
            margin-bottom: 20px;
        }

        .error {
            background-color: #f2dede;
            color: #a94442;
            padding: 12px;
            margin-bottom: 20px;
        }

    </style>

</head>

<body>

<div class="form-container">

    <div class="form-title">
        Add Book Form
    </div>

    <div class="form-body">

        <?php if ($message != "") { ?>

            <?php if (strpos($message, "successfully") !== false) { ?>

                <div class="success">
                    <?php echo $message; ?>
                </div>

            <?php } else { ?>

                <div class="error">
                    <?php echo $message; ?>
                </div>

            <?php } ?>

        <?php } ?>

        <form method="POST" action="">

            <label>Book Title</label>
            <input
                type="text"
                name="title"
                required
            >

            <label>Author</label>
            <input
                type="text"
                name="author"
                required
            >

            <label>Publisher</label>
            <input
                type="text"
                name="publisher"
                required
            >

            <label>Year</label>
            <input
                type="number"
                name="year"
                required
            >

            <label>Category</label>
            <input
                type="text"
                name="category"
                required
            >

            <label>Copies</label>
            <input
                type="number"
                name="copies"
                min="1"
                required
            >

            <button type="submit">
                Add Book
            </button>

        </form>

    </div>

</div>

</body>
</html>