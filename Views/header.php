<?php
if (!isset($_SESSION['IS_LOGIN']) && $_SESSION(['IS_LOGIN'] !== 'yes')) {
    header('location:login');
    die();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Admin</title>
    <!-- Custom fonts for this template-->
    <link href="./public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <!-- Page level plugin CSS-->
    <link href="./public/vendor/datatables/dataTables.bootstrap4.css" rel="stylesheet">
    <!-- Custom styles for this template-->
    <link href="./public/css/sb-admin.css" rel="stylesheet">
</head>

<body id="page-top">
    <nav class="navbar navbar-expand navbar-dark bg-dark static-top">
        <a class="navbar-brand mr-1" href="dashboard.php">Project Management System</a>
        <div class="d-none d-md-inline-block ml-auto"></div>
        <!-- Navbar -->>
        <?php if ($_SESSION['ROLE']) { ?>
            <button class="rounded"> <a class="dropdown-item" href="profile">My Profile</a></button>
        <?php } ?>
        <button class="rounded"><a class="dropdown-item" href="logout">Logout</a></button>

    </nav>
    <div id="wrapper">
        <!-- Sidebar -->
        <ul class="sidebar navbar-nav">
            <?php if ($_SESSION['ROLE'] == 1) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="admin_dashboard">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="project">
                        <i class="fa fa-fw fa-columns"></i>
                        <span>Manage Project</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users">
                        <i class="fa fa-fw fa-user"></i>
                        <span>Manage Users</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="team">
                        <i class="fa fa-fw fa-users"></i>
                        <span>Manage Team</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="task">
                        <i class="fas fa-fw fa-check-circle"></i>
                        <span>Manage Task</span></a>
                </li>
            <?php } elseif ($_SESSION['ROLE'] == 2) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="project">
                        <i class="fa fa-fw fa-columns"></i>
                        <span>Manage Project</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="team">
                        <i class="fa fa-fw fa-user"></i>
                        <span>Manage Team</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users">
                        <i class="fa fa-fw fa-user"></i>
                        <span>Manage Users</span></a>
                </li>
            <?php } elseif ($_SESSION['ROLE'] == 3) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="task">
                        <i class="fas fa-fw fa-check-circle"></i>
                        <span>Manage Task</span></a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="users">
                        <i class="fa fa-fw fa-user"></i>
                        <span>Manage Users</span></a>
                </li>
            <?php } elseif ($_SESSION['ROLE'] == 4) { ?>
                <li class="nav-item">
                    <a class="nav-link" href="usercalander">
                        <i class="fas fa-fw fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="usertask">
                        <i class="fa fa-fw fa-newspaper"></i>
                        <span>Task</span></a>
                </li>

                <!-- <li class="nav-item">
                    <a class="nav-link" href="mycalander.php">
                        <i class="fa fa-fw fa-newspaper"></i>
                        <span>Calander</span></a>
                </li> -->
            <?php } ?>
        </ul>
        <div id="content-wrapper">