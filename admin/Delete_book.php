<?php
$conn = new mysqli("localhost", "root", "", "cpe_tb1");

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

$message = "";
$messageType = "";

if ($_SERVER["REQUEST_METHOD"] === "POST"
    && isset($_POST["delete_id"])) {

    $book_id = intval($_POST["delete_id"]);

    if ($book_id > 0) {
        $stmt = $conn->prepare(
            "DELETE FROM books WHERE book_id = ?"
        );

        $stmt->bind_param("i", $book_id);

        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                $message = "Deleted successfully!";
                $messageType = "success";
            } else {
                $message = "Book not found or already deleted.";
                $messageType = "error";
            }
        } else {
            $message = "Failed to delete the book.";
            $messageType = "error";
        }

        $stmt->close();
    }
}

$result = $conn->query(
    "SELECT book_id, title, author, publisher,
            year, category, copies
     FROM books
     ORDER BY book_id ASC"
);
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<title>Delete Book | Library System</title>

<style>
* {
    box-sizing: border-box;
}

body {
    margin: 0;
    font-family: Arial, sans-serif;
    background: #f4f6f9;
    color: #333;
}

/* Sidebar */
.sidebar {
    width: 200px;
    height: 100vh;
    position: fixed;
    top: 0;
    left: 0;
    background: #1749c5;
    padding: 20px 10px;
    color: white;
}

.sidebar h2 {
    font-size: 20px;
    line-height: 1.5;
    margin: 5px 8px 28px;
}

.sidebar a {
    display: block;
    padding: 13px 5px;
    color: white;
    text-decoration: none;
    font-size: 14px;
    border-bottom: 1px solid white;
}
Compose

}

.sidebar a:hover,
.sidebar a.active {
    background: #10389e;
}

/* Main content */
.main-content {
    margin-left: 200px;
    padding: 30px;
}

.container {
    background: white;
    padding: 25px;
    border-radius: 8px;
    min-height: 75vh;
}

h2 {
    margin-top: 0;
    color: #222;
}

h4 {
    color: #1749c5;
    margin-top: 25px;
}

.message {
    padding: 12px 15px;
    border-radius: 5px;
    margin: 15px 0;
}

.success {
    background: #d4edda;
    color: #155724;
}

.error {
    background: #f8d7da;
    color: #721c24;
}

.deleting {
    background: #fff3cd;
    color: #856404;
}

/* Table */
.table-wrapper {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    margin-top: 15px;
}

th {
    background: #1749c5;
    color: white;
    text-align: left;
}

th, td {
    padding: 12px 10px;
    border-bottom: 1px solid #ddd;
    font-size: 14px;
}

.delete-btn {
    background: #dc3545;
    color: white;
    padding: 9px 13px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.delete-btn:hover {
    background: #b02a37;
}

.delete-btn:disabled {
    opacity: 0.6;
    cursor: wait;
}

footer {
    text-align: center;
    margin-top: 35px;
    color: #777;
    font-size: 12px;
}

/* Smaller screens */
@media (max-width: 700px) {
    .sidebar {
        width: 150px;
    }

    .main-content {
        margin-left: 150px;
        padding: 12px;
    }

    .container {
        padding: 15px;
    }

    .sidebar h2 {
        font-size: 16px;
    }
}
</style>
</head>

<body>

<!-- Sidebar -->
<div class="sidebar">
    <h2>📚 LIBRARY<br>SYSTEM</h2>

    <a href="Book_management.php">Book Management</a>
    <a href="Records.php">Records</a>
    <a href="Search.php">Search</a>
    <a href="Student_history.php">Student History</a>
</div>

<!-- Main content -->
<div class="main-content">
    <div class="container">

        <h2>Delete Book</h2>

        <?php if ($message !== ""): ?>
            <div class="message <?= htmlspecialchars($messageType) ?>">
                <?= htmlspecialchars($message) ?>
            </div>
        <?php endif; ?>

        <h4>Select a Book to Delete</h4>

        <div class="table-wrapper">

        <?php if ($result && $result->num_rows > 0): ?>

            <table>
                <thead>
                    <tr>
                        <th>Book ID</th>
                        <th>Title</th>
                        <th>Author</th>
                        <th>Publisher</th>
                        <th>Year</th>
                        <th>Category</th>
                        <th>Copies</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>
                <?php while ($book = $result->fetch_assoc()): ?>
                    <tr>
                        <td>
                            <?= htmlspecialchars($book["book_id"]) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($book["title"]) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($book["author"]) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($book["publisher"]) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($book["year"]) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($book["category"]) ?>
                        </td>
                        <td>
                            <?= htmlspecialchars($book["copies"]) ?>
                        </td>
                        <td>
                            <form method="POST"
                                  onsubmit="return confirmDelete(this);">

                                <input type="hidden"
                                       name="delete_id"
                                       value="<?= htmlspecialchars($book["book_id"]) ?>">

                                <button type="submit"
                                        class="delete-btn">
                                    Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>

        <?php else: ?>

            <p>No books found.</p>

        <?php endif; ?>

        </div>

        <footer>Library System Project</footer>
    </div>
</div>

<script>
function confirmDelete(form) {
    if (!confirm("Are you sure you want to delete this book?")) {
        return false;
    }

    const button = form.querySelector(".delete-btn");

    button.disabled = true;
    button.textContent = "Deleting...";

    const message = document.createElement("div");
    message.className = "message deleting";
    message.textContent = "Deleting...";

    const container = document.querySelector(".container");
    const heading = container.querySelector("h2");

    heading.insertAdjacentElement("afterend", message);

    return true;
}
</script>

</body>
</html>

<?php
$conn->close();
?>

