<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Register | <?php echo $title ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="<?= base_url() ?>/assets/document/logoProfile/<?php echo $logo ?>">

    <!-- App css -->
    <link href="<?= base_url() ?>/assets/css/bootstrap-creative.min.css" rel="stylesheet" type="text/css" id="bs-default-stylesheet" />
    <link href="<?= base_url() ?>/assets/css/app-creative.min.css" rel="stylesheet" type="text/css" id="app-default-stylesheet" />

    <link href="<?= base_url() ?>/assets/css/bootstrap-creative-dark.min.css" rel="stylesheet" type="text/css" id="bs-dark-stylesheet" />
    <link href="<?= base_url() ?>/assets/css/app-creative-dark.min.css" rel="stylesheet" type="text/css" id="app-dark-stylesheet" />

    <!-- icons -->
    <link href="<?= base_url() ?>/assets/css/icons.min.css" rel="stylesheet" type="text/css" />

</head>

<body class="loading authentication-bg authentication-bg-pattern bg-dark">

    <div class="account-pages mt-5 mb-4">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card bg-pattern">

                        <div class="card-body p-4">

                            <div class="text-center w-75 m-auto">
                                <div class="auth-logo">
                                    <a href="index.html" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="<?= base_url() ?>/assets/document/logoProfile/<?php echo $logo ?>" alt="" height="70">
                                        </span>
                                    </a>

                                    <a href="index.html" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="<?= base_url() ?>/assets/document/logoProfile/<?php echo $logo ?>" alt="" height="70">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Create your account to access admin panel.</p>
                            </div>

                            <?php if (isset($validation)) : ?>
                                <div class="alert alert-danger"><?= $validation->listErrors() ?></div>
                            <?php endif; ?>
                            <form action="/auth/add_register" method="post">
                                <div class="mb-2">
                                    <label for="InputForName" class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" id="InputForName" value="<?= set_value('name') ?>">
                                </div>
                                <div class="mb-2">
                                    <label for="InputForEmail" class="form-label">Email address</label>
                                    <input type="email" name="email" class="form-control" id="InputForEmail" value="<?= set_value('email') ?>">
                                </div>
                                <div class="mb-2">
                                    <label for="InputForPassword" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="InputForPassword">
                                </div>
                                <div class="mb-2">
                                    <label for="InputForConfPassword" class="form-label">Confirm Password</label>
                                    <input type="password" name="confpassword" class="form-control" id="InputForConfPassword">
                                </div>
                                <div class="mb-2">
                                    <label for="SelectForLevel" class="form-label">Level</label>
                                    <select name="level" class="form-control">
                                        <option value="user">User</option>
                                        <option value="admin">Admin</option>
                                    </select>
                                </div>
                                <div class="mb-2">
                                    <label for="SelectForLevel" class="form-label">Shipper</label>
                                    <select name="shipper" class="form-control" required>
                                        <option value="">--select shipper--</option>
                                        <?php 
                                            foreach ($data_shipper as $key => $d) {
                                                echo '<option value="'.$d['id'].'">'.$d['shipper_name'].'</option>';
                                            }
                                        ?>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary" style="margin-left: 150px;">Register</button>
                            </form>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p class="text-black-50">have an account? <a href="<?= base_url() ?>/auth" class="ml-1"><b>Sign In</b></href=>
                                    </p>
                                </div> <!-- end col -->
                            </div>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- end row -->

                </div> <!-- end col -->
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end page -->


    <footer class="footer footer-alt text-white-50">
        2022 - <script>
            document.write(new Date().getFullYear())
        </script> &copy; Application by <a href="" class="text-white-50">Scorptech</a>
    </footer>

    <!-- Vendor js -->
    <script src="<?= base_url() ?>/assets/js/vendor.min.js"></script>

    <!-- App js -->
    <script src="<?= base_url() ?>/assets/js/app.min.js"></script>

</body>

</html>