<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Reserve a Book</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-gradient-primary">

<div class="container">
    <div class="row justify-content-center">
        <div class="col-xl-6 col-lg-8 col-md-9 mt-5">

            <div class="card shadow mb-4">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Book Reservation Form</h6>
                </div>
                <div class="card-body">

                    <?php
                    if (isset($_GET['status']) && $_GET['status'] === 'success') {
                        echo "<p style='color:green;'>Reservation successful!</p>";
                        echo "<script>
                            if (window.history.replaceState) {
                                window.history.replaceState(null, null, window.location.pathname);
                            }
                            </script>";
                            } 
                    elseif (isset($_GET['status']) && $_GET['status'] === 'error') {
                        echo "<p style='color:red;'>Something went wrong. Please try again.</p>";
                    }
                    ?>

                    <form action="process_reservation.php" method="POST">

                        <div class="form-group">
                            <label>Student Number</label>
                            <input type="text" class="form-control" name="student_number" required>
                        </div>

                        <div class="form-group">
                            <label>Last Name</label>
                            <input type="text" class="form-control" name="last_name" required>
                        </div>

                        <div class="form-group">
                            <label>First Name</label>
                            <input type="text" class="form-control" name="first_name" required>
                        </div>

                        <div class="form-group">
                            <label>Middle Initial</label>
                            <input type="text" class="form-control" name="middle_initial" maxlength="5">
                        </div>

                        <div class="form-group">
                            <label>Book Title</label>
                            <input type="text" class="form-control" name="book_title" required>
                        </div>

                        <div class="form-group">
                            <label>Reservation Date</label>
                            <input type="date" class="form-control" name="reservation_date" required>
                        </div>

                        <button type="submit" class="btn btn-primary btn-block">Reserve Book</button>

                    </form>

                </div>
            </div>

        </div>
    </div>
</div>

<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>