<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title>Log In | <?php echo $title ?></title>
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
                                    <a href="/" class="logo logo-dark text-center">
                                        <span class="logo-lg">
                                            <img src="<?= base_url() ?>/assets/document/logoProfile/<?php echo $logo ?>" alt="" height="70">
                                        </span>
                                    </a>

                                    <a href="/" class="logo logo-light text-center">
                                        <span class="logo-lg">
                                            <img src="<?= base_url() ?>/assets/document/logoProfile/<?php echo $logo ?>" alt="" height="70">
                                        </span>
                                    </a>
                                </div>
                                <p class="text-muted mb-4 mt-3">Enter your email address and password to access admin panel.</p>
                            </div>

                            <?php if (session()->getFlashdata('msg')) : ?>
                                <div class="alert alert-danger"><?= session()->getFlashdata('msg') ?></div>
                            <?php endif; ?>
                            <form action="/auth/login" method="post">
                                <div class="mb-3">
                                    <label for="InputForEmail" class="form-label">Email address</label>
                                    <input type="email" name="email" class="form-control" id="InputForEmail" value="<?= set_value('email') ?>">
                                </div>
                                <div class="mb-3">
                                    <label for="InputForPassword" class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" id="InputForPassword">
                                </div>
                                <button type="submit" class="btn btn-primary" style="margin-left: 150px;">Login</button>
                            </form>

                            <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <!-- <p> <a href="auth-recoverpw.html" class="ml-1">Forgot your password?</a></p> -->
                                    <!-- <p class="text-black-50">Don't have an account? <a href="<?= base_url() ?>/auth/register" class="ml-1"><b>Sign Up</b></a></p> -->
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