<?php
include __DIR__ . '/../includes/db.php';

// Kumuha ng rows gamit ang student number (prepared statement = safe sa SQL injection)
function fetch_rows($conn, $sql, $sn) {
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $sn);
    $stmt->execute();
    return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
}

// Gumawa ng SB Admin card na may table
function render_table($title, $headers, $rows, $columns, $emptyMsg) {
    echo '<div class="card shadow mb-4">';
    echo '<div class="card-header py-3"><h6 class="m-0 font-weight-bold text-primary">'
        . htmlspecialchars($title) . '</h6></div>';
    echo '<div class="card-body"><div class="table-responsive">';
    echo '<table class="table table-bordered"><thead><tr>';
    foreach ($headers as $h) {
        echo '<th>' . htmlspecialchars($h) . '</th>';
    }
    echo '</tr></thead><tbody>';
    if (count($rows) > 0) {
        foreach ($rows as $row) {
            echo '<tr>';
            foreach ($columns as $col) {
                echo '<td>' . htmlspecialchars((string)$row[$col]) . '</td>';
            }
            echo '</tr>';
        }
    } else {
        echo '<tr><td colspan="' . count($headers) . '" class="text-center">'
            . htmlspecialchars($emptyMsg) . '</td></tr>';
    }
    echo '</tbody></table></div></div></div>';
}

$search   = trim($_GET['search'] ?? '');   // tinype ng admin
$selected = trim($_GET['sn'] ?? '');       // student number na pinili sa list
$searched = ($search !== '' || $selected !== '');

$matches      = [];
$student      = null;
$reservations = [];
$borrows      = [];
$penalties    = [];

// Walang students table, kaya hinahanap ang student sa reservations, borrows at penalties
$lookup = "SELECT student_number, last_name, first_name FROM (
              SELECT student_number, last_name, first_name FROM reservations
              UNION
              SELECT student_number, last_name, first_name FROM borrows
              UNION
              SELECT student_number, last_name, first_name FROM penalties
           ) s ";

if ($selected !== '') {
    // Pinili na ang student mula sa list
    $rows = fetch_rows($conn, $lookup . "WHERE student_number = ? LIMIT 1", $selected);
    $student = $rows[0] ?? null;

} elseif ($search !== '') {
    // Last name (partial ok) O student number (exact)
    $stmt = $conn->prepare(
        $lookup . "WHERE last_name LIKE ? OR student_number = ? ORDER BY last_name, first_name"
    );
    $like = "%" . $search . "%";
    $stmt->bind_param("ss", $like, $search);
    $stmt->execute();
    $matches = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);

    if (count($matches) === 1) {   // isa lang ang match, diretso na sa records
        $student = $matches[0];
        $matches = [];
    }
}

if ($student) {
    $sn = $student['student_number'];

    $reservations = fetch_rows($conn,
        "SELECT book_title, reservation_date, status
         FROM reservations WHERE student_number = ?
         ORDER BY reservation_date DESC", $sn);

    $borrows = fetch_rows($conn,
        "SELECT book_title, borrow_date, due_date, return_date
         FROM borrows WHERE student_number = ?
         ORDER BY borrow_date DESC", $sn);
    foreach ($borrows as &$b) {
        $b['return_date'] = $b['return_date'] ?? 'Not yet returned';
    }
    unset($b);

    $penalties = fetch_rows($conn,
        "SELECT reason, amount, status
         FROM penalties WHERE student_number = ?", $sn);
    foreach ($penalties as &$p) {
        $p['amount'] = '₱' . number_format($p['amount'], 2);
    }
    unset($p);
}
?>

<h1 class="h3 mb-4 text-gray-800">Student Records</h1>

<!-- SEARCH -->
<div class="card shadow mb-4">
    <div class="card-header py-3">
        <h6 class="m-0 font-weight-bold text-primary">Search Student</h6>
    </div>
    <div class="card-body">
        <form method="GET" action="search_student.php">
            <div class="input-group">
                <input type="text" name="search" class="form-control"
                       placeholder="Enter last name or student number"
                       value="<?= htmlspecialchars($search) ?>" required>
                <div class="input-group-append">
                    <button class="btn btn-primary" type="submit">Search</button>
                </div>
            </div>
        </form>
    </div>
</div>

<?php if (count($matches) > 1): ?>
    <!-- Maraming match: mamili si admin -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">
                Multiple students found. Choose one:
            </h6>
        </div>
        <div class="list-group list-group-flush">
            <?php foreach ($matches as $m): ?>
                <a class="list-group-item list-group-item-action"
                   href="search_student.php?sn=<?= urlencode($m['student_number']) ?>">
                    <?= htmlspecialchars($m['last_name'] . ', ' . $m['first_name']) ?>
                    (<?= htmlspecialchars($m['student_number']) ?>)
                </a>
            <?php endforeach; ?>
        </div>
    </div>

<?php elseif ($student): ?>
    <!-- STUDENT INFO -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h6 class="m-0 font-weight-bold text-primary">Student Information</h6>
        </div>
        <div class="card-body">
            <p class="mb-1"><strong>Name:</strong>
                <?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']) ?></p>
            <p class="mb-0"><strong>Student Number:</strong>
                <?= htmlspecialchars($student['student_number']) ?></p>
        </div>
    </div>

    <?php
    render_table("Reservations",
        ["Book", "Date Reserved", "Status"],
        $reservations,
        ["book_title", "reservation_date", "status"],
        "No reservations.");

    render_table("Borrowed Books",
        ["Book", "Date Borrowed", "Due Date", "Date Returned"],
        $borrows,
        ["book_title", "borrow_date", "due_date", "return_date"],
        "No borrowed books.");

    render_table("Penalties",
        ["Reason", "Amount", "Status"],
        $penalties,
        ["reason", "amount", "status"],
        "No penalties.");
    ?>

<?php elseif ($searched): ?>
    <div class="alert alert-warning">No student found.</div>
<?php endif; ?>