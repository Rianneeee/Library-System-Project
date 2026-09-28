<?php
// layout.php
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Library System Admin">
    <meta name="author" content="">

    <title>Library System - Admin</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

    <!-- SB Admin 2 core CSS -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Your custom theme -->
    <link href="sbadmin/css/custom.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.php">
                <div class="sidebar-brand-icon">
                    <i class="fas fa-book"></i>
                </div>
                <div class="sidebar-brand-text mx-3">Library System</div>
            </a>

            <hr class="sidebar-divider">

            <!-- Book Management -->
            <li class="nav-item">
                <a class="nav-link" href="book_management_dashboard.php">
                    <span>Book Management</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Records -->
            <li class="nav-item">
                <a class="nav-link" href="records_dashboard.php">
                    <span>Records</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Search -->
            <li class="nav-item">
                <a class="nav-link" href="search_books.php">
                    <span>Search</span>
                </a>
            </li>

            <hr class="sidebar-divider">

            <!-- Student History -->
            <li class="nav-item">
                <a class="nav-link" href="student_history_dashboard.php">
                    <span>Student History</span>
                </a>
            </li>

        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">
                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <?php
                    if (isset($content)) {
                        include($content);
                    }
                    ?>
                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Library System Project Sir Gil © CPE4101</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- SB Admin 2 JavaScript-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
