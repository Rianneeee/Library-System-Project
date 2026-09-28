<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Library System - Student</title>
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="sbadmin/css/custom.css" rel="stylesheet">
</head>
<body id="page-top">

<div id="wrapper">

    <!-- Sidebar -->
    <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

        <!-- Brand -->
        <a class="sidebar-brand d-flex align-items-center justify-content-center" href="student_dashboard.php">
            <div class="sidebar-brand-icon">
                <i class="fas fa-user-graduate"></i>
            </div>
            <div class="sidebar-brand-text mx-3">Student Portal</div>
        </a>

        <hr class="sidebar-divider">

        <!-- Reservation -->
        <li class="nav-item">
          <a class="nav-link" href="reserve.php">Reserve Book</a>
        </li>

        <!-- Borrow -->
        <li class="nav-item">
            <a class="nav-link" href="student/borrow.php">
                <span>Borrow Book</span>
            </a>
        </li>

        <!-- Return -->
        <li class="nav-item">
            <a class="nav-link" href="student/return.php">
                <span>Return Book</span>
            </a>
        </li>

        <!-- Penalties -->
        <li class="nav-item">
            <a class="nav-link" href="student/penalties.php">
                <span>View Penalties</span>
            </a>
        </li>

        <!-- Search -->
        <li class="nav-item">
            <a class="nav-link" href="student/search.php">
                <span>Search Books</span>
            </a>
        </li>

    </ul>
    <!-- End of Sidebar -->

    <!-- Content Wrapper -->
    <div id="content-wrapper" class="d-flex flex-column">
        <div id="content">
            <div class="container-fluid">
                <?php
                if (isset($content)) {
                    include($content);
                }
                ?>
            </div>
        </div>
    </div>

</div>
</body>
</html>
