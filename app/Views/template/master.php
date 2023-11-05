<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $_SESSION['title'] ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>assets/document/logoProfile/<?php echo $_SESSION['logo'] ?>">

    <!-- App css -->
    <link href="<?= base_url() ?>assets/css/bootstrap-creative.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?= base_url() ?>assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="<?= base_url() ?>assets/css/bootstrap-creative-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="<?= base_url() ?>assets/css/app-creative-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="<?= base_url() ?>assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <link href="<?= base_url() ?>assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
    <link href="<?= base_url() ?>assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

    <?= $this->renderSection('css') ?>

</head>

<body class="loading" data-layout-mode="horizontal" data-layout='{"mode": "light", "width": "fluid", "menuPosition": "fixed", "topbar": {"color": "dark"}, "showRightSidebarOnPageLoad": true}'>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <div class="navbar-custom">
            <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-right mb-0">

                    <li class="dropdown d-inline-block d-lg-none">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <i class="fe-search noti-icon"></i>
                        </a>
                        <div class="dropdown-menu dropdown-lg dropdown-menu-right p-0">
                            <form class="p-3">
                                <input type="text" class="form-control" placeholder="Search <?= base_url() ?>." aria-label="Recipient's username">
                            </form>
                        </div>
                    </li>

                    <!-- <li class="dropdown d-none d-lg-inline-block">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                            <i class="fe-maximize noti-icon"></i>
                        </a>
                    </li> -->

                    <li class="dropdown notification-list topbar-dropdown">
                        <a class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                            <!-- <img src="<?= base_url() ?>/assets/images/users/user-5.jpg" alt="user-image" class="rounded-circle"> -->
                            <span class="pro-user-name ml-1">
                                <?php echo $_SESSION['user_name'] ?> <i class="mdi mdi-chevron-down"></i>
                            </span>
                        </a>
                        <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                            <!-- item-->
                            <div class="dropdown-header noti-title">
                                <h6 class="text-overflow m-0">Welcome ! <?php echo $_SESSION['user_name'] ?></h6>
                            </div>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-user"></i>
                                <span>My Account</span>
                            </a>

                            <!-- item-->
                            <a href="javascript:void(0);" class="dropdown-item notify-item">
                                <i class="fe-settings"></i>
                                <span>Settings</span>
                            </a>

                            <div class="dropdown-divider"></div>

                            <!-- item-->
                            <a href="<?= base_url() ?>auth/logout" class="dropdown-item notify-item">
                                <i class="fe-log-out"></i>
                                <span>Logout</span>
                            </a>

                        </div>
                    </li>

                    <!-- <li class="dropdown notification-list">
                        <a href="javascript:void(0);" class="nav-link right-bar-toggle waves-effect waves-light">
                            <i class="fe-settings noti-icon"></i>
                        </a>
                    </li> -->

                </ul>

                <!-- LOGO -->
                <div class="logo-box">
                    <a href="/" class="logo logo-dark text-center">
                        <span class="logo-sm">
                            <img src="<?= base_url() ?>assets/images/logo-sm.png" alt="" height="50">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                        </span>
                        <span class="logo-lg">
                            <img src="<?= base_url() ?>assets/images/logo-dark.png" alt="" height="45">
                            <!-- <span class="logo-lg-text-light">U</span> -->
                        </span>
                    </a>

                    <a href="/" class="logo logo-light text-center">
                        <span class="logo-sm">
                            <img src="<?= base_url() ?>assets/document/logoProfile/<?php echo $_SESSION['logo'] ?>" alt="" height="50">
                        </span>
                        <span class="logo-lg">
                            <img src="<?= base_url() ?>assets/document/logoProfile/<?php echo $_SESSION['logo'] ?>" alt="" height="45">
                        </span>
                    </a>
                </div>

                <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                    <li>
                        <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu"></i>
                        </button>
                    </li>

                    <li>
                        <!-- Mobile menu toggle (Horizontal Layout)-->
                        <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                            <div class="lines">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </a>
                        <!-- End mobile menu toggle-->
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
        </div>
        <!-- end Topbar -->

        <div class="topnav shadow-lg">
            <div class="container-fluid">
                <nav class="navbar navbar-light navbar-expand-lg topnav-menu">

                    <div class="collapse navbar-collapse" id="topnav-menu-content">
                        <ul class="navbar-nav">
                            <?php if ($_SESSION['level'] == 'admin') { ?>
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle arrow-none" href="#" id="topnav-dashboard" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fe-grid mr-1"></i> Setup <div class="arrow-down"></div>
                                    </a>
                                    <div class="dropdown-menu" aria-labelledby="topnav-dashboard">
                                        <!-- <a href="<?= base_url() ?>setup/status" class="dropdown-item">Status</a> -->
                                        <a href="<?= base_url() ?>setup/shippingline" class="dropdown-item">Shipping Line</a>
                                        <a href="<?= base_url() ?>setup/shipper" class="dropdown-item">Shipper</a>
                                        <a href="<?= base_url() ?>setup/portline" class="dropdown-item">Port Line</a>
                                        <a href="<?= base_url() ?>setup/incoterm" class="dropdown-item">Incoterm</a>
                                        <a href="<?= base_url() ?>setup/profile" class="dropdown-item">Company Profile</a>
                                        <a href="<?= base_url() ?>setup/users" class="dropdown-item">Users</a>
                                    </div>
                                </li>
                            <?php } ?>

                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="<?= base_url() ?>" id="topnav-dashboard" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="fe-airplay mr-1"></i> Track Shipments
                                </a>
                            </li>

                            <li class="nav-item">
                                <a class="nav-link arrow-none" href="<?= base_url() ?>vessel_schedules" id="topnav-dashboard" role="button" aria-haspopup="true" aria-expanded="false">
                                    <i class="fe-calendar mr-1"></i> Vessel Schedules
                                </a>
                            </li>

                        </ul> <!-- end navbar-->
                    </div> <!-- end .collapsed-->
                </nav>
            </div> <!-- end container-fluid -->
        </div> <!-- end topnav-->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->
        <script src="<?= base_url() ?>/assets/js/jquery.min.js"></script>

        <div class="content-page">
            <div class="content">

                <?= $this->renderSection('content') ?>

            </div> <!-- content -->

            <!-- Footer Start -->
            <footer class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-6">
                            2022 - <script>
                                document.write(new Date().getFullYear())
                            </script> &copy; Application by <a href="" class="text-dark">Scorptech</a>
                        </div>
                        <div class="col-md-6">
                            <div class="text-md-right footer-links d-none d-sm-block">
                            </div>
                        </div>
                    </div>
                </div>
            </footer>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right bar overlay-->
    <div class="rightbar-overlay"></div>

    <?= $this->renderSection('js') ?>

    <!-- Vendor js -->
    <script src="<?= base_url() ?>/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>/assets/js/app.min.js"></script>

    <script src="<?= base_url() ?>/assets/libs/datatables.net/js/jquery.dataTables.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
    <script src="<?= base_url() ?>/assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js"></script>

    <!-- Datatables init -->
    <!-- <script src="<?= base_url() ?>/assets/js/pages/datatables.init.js"></script> -->

    <script type="text/javascript">
        function loading_processing() {
            loadingPannel = (function() {
                var lpDialog = $("" +
                    "<div class='modal fade' id='lpDialog' data-backdrop='static' data-keyboard='false' style='width: 150px;height: 150px;margin:0 auto;display:table;left: 0;right:0;top: 50%;-webkit-transform:translateY(-50%);-moz-transform:translateY(-50%);-ms-transform:translateY(-50%);-o-transform:translateY(-50%);'>" +
                    "<div class='modal-dialog' >" +
                    "<div class='modal-content'>" +
                    // "<div class='modal-header'><b>Loading...</b></div>" + //Processing
                    "<div class='modal-body'>" +
                    "<div style='text-align:center'><i class='mdi mdi-spin mdi-loading mr-1'></i> <br> Processing...</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>" +
                    "</div>");
                return {
                    show: function() {
                        lpDialog.modal('show');
                    },
                    hide: function() {
                        lpDialog.modal('hide');
                    }
                };
            })();
        }
    </script>

</body>

</html>