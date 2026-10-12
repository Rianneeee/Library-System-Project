<?php
include __DIR__ . '/../includes/db.php';

$message = "";
$messageType = "";
$book = null;
$books = [];

// book_id galing sa link (?id=) o sa hidden field ng form
$id = (int)($_GET['id'] ?? $_POST['book_id'] ?? 0);

// 1. UPDATE: tumatakbo lang kapag na-submit ang form
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $id > 0) {
    $title     = trim($_POST['title']);
    $author    = trim($_POST['author']);
    $publisher = trim($_POST['publisher']);
    $year      = (int)$_POST['year'];
    $category  = trim($_POST['category']);
    $copies    = (int)$_POST['copies'];

    $stmt = $conn->prepare(
        "UPDATE books
         SET title = ?, author = ?, publisher = ?, year = ?, category = ?, copies = ?
         WHERE book_id = ?"
    );
    // s = string, i = integer (sunod-sunod sa ? sa taas)
    $stmt->bind_param("sssisii", $title, $author, $publisher, $year, $category, $copies, $id);

    if ($stmt->execute()) {
        $message = "Book updated successfully!";
        $messageType = "success";
        $id = 0; 
    } else {
        $message = "Error: " . $stmt->error;
        $messageType = "danger";
    }
}

// 2. Kunin ang libro para ma-prefill ang form (kasama na ang bagong values pagkatapos ng update)
if ($id > 0) {
    $stmt = $conn->prepare("SELECT * FROM books WHERE book_id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $book = $stmt->get_result()->fetch_assoc();

    if (!$book) {
        $message = "Book not found.";
        $messageType = "danger";
    }
}

// 3. Walang napiling libro: kunin lahat para sa listahan
if (!$book) {
    $result = $conn->query(
        "SELECT book_id, title, author, category, copies FROM books ORDER BY title"
    );
    $books = $result->fetch_all(MYSQLI_ASSOC);
}
?>

<h1 class="h3 mb-4 text-gray-800">Edit Book</h1>

<?php if ($message !== ""): ?>
    <div class="alert alert-<?= $messageType ?>">
        <?= htmlspecialchars($message) ?>
    </div>
<?php endif; ?>

<?php if ($book): ?>

    <!-- EDIT FORM -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Edit Book Form</h6>
        </div>
        <div class="card-body">
            <form method="POST" action="edit_book.php?id=<?= (int)$book['book_id'] ?>">
                <input type="hidden" name="book_id" value="<?= (int)$book['book_id'] ?>">

                <div class="form-group">
                    <label>Book Title</label>
                    <input type="text" name="title" class="form-control" required
                           value="<?= htmlspecialchars($book['title']) ?>">
                </div>

                <div class="form-group">
                    <label>Author</label>
                    <input type="text" name="author" class="form-control" required
                           value="<?= htmlspecialchars($book['author']) ?>">
                </div>

                <div class="form-group">
                    <label>Publisher</label>
                    <input type="text" name="publisher" class="form-control" required
                           value="<?= htmlspecialchars($book['publisher']) ?>">
                </div>

                <div class="form-group">
                    <label>Year</label>
                    <input type="number" name="year" class="form-control" required
                           value="<?= (int)$book['year'] ?>">
                </div>

                <div class="form-group">
                    <label>Category</label>
                    <input type="text" name="category" class="form-control" required
                           value="<?= htmlspecialchars($book['category']) ?>">
                </div>

                <div class="form-group">
                    <label>Copies</label>
                    <input type="number" name="copies" class="form-control" min="0" required
                           value="<?= (int)$book['copies'] ?>">
                </div>

                <button type="submit" class="btn btn-primary">Update Book</button>
                <a href="edit_book.php" class="btn btn-secondary">Back to list</a>
            </form>
        </div>
    </div>

<?php else: ?>

    <!-- LISTAHAN NG BOOKS -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Select a Book to Edit</h6>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Category</th>
                            <th>Copies</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (count($books) > 0): ?>
                        <?php foreach ($books as $b): ?>
                            <tr>
                                <td><?= htmlspecialchars($b['title']) ?></td>
                                <td><?= htmlspecialchars($b['author']) ?></td>
                                <td><?= htmlspecialchars($b['category']) ?></td>
                                <td><?= (int)$b['copies'] ?></td>
                                <td>
                                    <a href="edit_book.php?id=<?= (int)$b['book_id'] ?>"
                                       class="btn btn-sm btn-primary">Edit</a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="5" class="text-center">No books found.</td></tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

<?php endif; ?>