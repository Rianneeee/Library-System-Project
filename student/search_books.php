<?php
include('../includes/db.php');
?>
<!DOCTYPE html>
<html>
<head>
    <title>Student Search Books</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
        #suggestions {
            border: 1px solid #ccc;
            max-height: 150px;
            overflow-y: auto;
            position: absolute;
            background: #fff;
            width: 300px;
            display: none;
        }
        #suggestions div {
            padding: 8px;
            cursor: pointer;
        }
        #suggestions div:hover {
            background: #f2f2f2;
        }
        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 10px;
        }
        table th {
            background-color: #f8f9fc;
        }
        table tr:nth-child(even) {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>

<h2>Search Books</h2>
<form method="GET">
    <input type="text" id="searchInput" name="title" placeholder="Search by title..." autocomplete="off">
    <div id="suggestions"></div>
    <button type="submit">Search</button>
</form>

<?php
if (!empty($_GET['title'])) {
    $title = $_GET['title'];
    $sql = "SELECT * FROM books WHERE title LIKE ?";
    $stmt = $conn->prepare($sql);
    $like = "%$title%";
    $stmt->bind_param("s", $like);
    $stmt->execute();
    $result = $stmt->get_result();

    echo "<table>";
    echo "<tr><th>Title</th><th>Author</th><th>Publisher</th><th>Year</th><th>Category</th><th>Copies</th><th>Action</th></tr>";

    if ($result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['title']}</td>
                    <td>{$row['author']}</td>
                    <td>{$row['publisher']}</td>
                    <td>{$row['year']}</td>
                    <td>{$row['category']}</td>
                    <td>{$row['copies']}</td>
                    <td><a href='borrow.php?book_id={$row['book_id']}'>Borrow Book</a></td>
                  </tr>";
        }
    } else {
        echo "<tr><td colspan='7'>No books found</td></tr>";
    }
    echo "</table>";
}
?>

<script>
$(document).ready(function(){
    $("#searchInput").keyup(function(){
        var query = $(this).val();
        if(query != ""){
            $.ajax({
                url: "search_suggestions.php",
                method: "POST",
                data: {query:query},
                success:function(data){
                    $("#suggestions").fadeIn().html(data);
                }
            });
        } else {
            $("#suggestions").fadeOut();
        }
    });

    $(document).on('click', '#suggestions div', function(){
        $('#searchInput').val($(this).text());
        $('#suggestions').fadeOut();
    });
});
</script>

</body>
</html>
