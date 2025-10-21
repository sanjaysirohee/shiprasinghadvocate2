<?php

session_start();

include_once ('database/connectdb.php');
if (!isset($_SESSION['isloginur'])) {

    header('location:login.php');
}
include ('config.php');
?>

<style>
    .skin-megna .topbar .top-navbar .navbar-header .navbar-brand .light-logo {
        width: 86%;
    }

    .topbar .top-navbar .navbar-header .navbar-brand {
        background: #fff;
        padding-left: 10px;
    }

    .topbar .top-navbar .navbar-header {
        padding-left: 0 !important;
    }
</style>



<!DOCTYPE html>

<html lang="en">

<head>

    <meta charset="utf-8">

    <meta http-equiv="X-UA-Compatible" content="IE=edge">

    <meta name="viewport" content="width=device-width, initial-scale=1">

    <meta name="description" content="">

    <meta name="author" content="">

    <link rel="icon" type="image/png" sizes="16x16" href="	https://shiprasinghadvocate.com/img/innerlogo2.png">

    <title>Shipra Singh Advocate</title>

    <link href="assets/node_modules/morrisjs/morris.css" rel="stylesheet">

    <link href="assets/node_modules/toast-master/css/jquery.toast.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="assets/node_modules/datatables.net-bs4/css/dataTables.bootstrap4.css">

    <link href="dist/css/style.min.css" rel="stylesheet">

    <link href="dist/css/pages/dashboard1.css" rel="stylesheet">

    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.6.3/css/all.css">

    <link href="assets/node_modules/bootstrap-datepicker/bootstrap-datepicker.min.css" rel="stylesheet"
        type="text/css" />

    <link rel="stylesheet" type="text/css" href="assets/node_modules/summernote/dist/summernote-bs4.css">





</head>



<body class="skin-megna fixed-layout">



    <div id="main-wrapper">

        <header class="topbar">

            <nav class="navbar top-navbar navbar-expand-md navbar-dark">

                <div class="navbar-header">

                    <a class="navbar-brand" href="#">

                        <img src="<?php echo BASE_URL; ?>img/og-image.png" alt="homepage"
                            class="dark-logo" />

                        <img src="<?php echo BASE_URL; ?>img/og-image.png" alt="homepage"
                            class="light-logo" />

                        </b>

                        <span class="hidden-xs"><span class="font-bold"></span></span></a>
                </div>



                <div class="navbar-collapse">

                    <ul class="navbar-nav mr-auto">

                        <li class="nav-item"><a class="nav-link nav-toggler d-block d-md-none waves-effect waves-dark"
                                href="javascript:void(0)"><i class="ti-menu"></i></a></li>

                        <li class="nav-item"><a
                                class="nav-link sidebartoggler d-none d-lg-block d-md-block waves-effect waves-dark"
                                href="javascript:void(0)">

                                <i class="icon-menu"></i></a> </li>
                    </ul>



                    <ul class="navbar-nav my-lg-0">



                        <li class="nav-item dropdown u-pro">

                            <a class="nav-link dropdown-toggle waves-effect waves-dark profile-pic" href="#"
                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img
                                    src="images/users/1.png" alt="user" class=""> <span class="hidden-md-down">Admin
                                    &nbsp;<i class="fa fa-angle-down"></i></span> </a>

                            <div class="dropdown-menu dropdown-menu-right animated flipInY">

                                <a href="logout.php" class="dropdown-item"><i class="fa fa-power-off"></i> Logout</a>

                            </div>
                        </li>

                    </ul>
                </div>
            </nav>

        </header>





        <aside class="left-sidebar">

            <div class="scroll-sidebar">

                <nav class="sidebar-nav">

                    <ul id="sidebarnav">
					<!--
                        <li> <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false"><i class="fas fa-blog"></i>

                                <span class="hide-menu">Blog</span></a>

                            <ul aria-expanded="false" class="collapse">

                                <li><a href="add-blog.php">Add Blog</a></li>

                                <li><a href="manage-blog.php">Manage Blog</a></li>

                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false"><i class="fas fa-blog"></i>
                                <span class="hide-menu">Cities</span></a>

                            <ul aria-expanded="false" class="collapse">


                                <li><a href="manage-cities.php">Manage Cities</a></li>


                            </ul>
                        </li>

                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false"><i class="fas fa-blog"></i>
                                <span class="hide-menu">Location</span></a>

                            <ul aria-expanded="false" class="collapse">

                                <li><a href="manage-locations.php">Manage Location</a></li>

                            </ul>
                        </li>
						-->


                        <li>
                            <a class="has-arrow waves-effect waves-dark" href="javascript:void(0)"
                                aria-expanded="false"><i class="fas fa-blog"></i>
                                <span class="hide-menu">Queries</span></a>

                            <ul aria-expanded="false" class="collapse">

                                <li><a href="manage-queries.php">List Queries</a></li>
								<li><a href="junk-queries.php">Junk Queries</a></li>

                            </ul>
                        </li>


                    </ul>
                </nav>
            </div>

        </aside>

        <script>
            $("#success_alert").fadeTo(2000, 1000).slideUp(1000, function () {

                $("#success_alert").slideUp(1000);

            });
        </script>

        <script type="text/javascript">
            function warning(x, y) {

                if (confirm(y)) {

                    window.location.href = x

                }

            }
        </script>