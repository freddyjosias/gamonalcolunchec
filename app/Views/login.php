<?php

    $user_session = session();
    /*
    if ($user_session != null) 
    {
        redirect() -> to(base_url());
    }
    */
?>

<!DOCTYPE html>
<html lang="es">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />

        <title><?= $nombreTienda ?></title>

        <link rel="shortcut icon" href="<?= base_url() . '/public/img/' . $logoTienda ?>" type="image/x-icon">

        <!-- Custom fonts for this template -->
        <link href="<?= base_url() ?>/public/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

        <!-- Custom styles for this template -->
        <link href="<?= base_url() ?>/public/css/sb-admin-2.min.css" rel="stylesheet">

        <!-- Custom styles for this page -->
        <link href="<?= base_url() ?>/public/vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">

        <?php foreach ($css as $key => $value) { ?>
                <link href="<?= base_url() ?>/public/css/<?= $value ?>.css" rel="stylesheet">
        <?php } ?>

    </head>
    <body class="bg-primary">
        <div id="layoutAuthentication">
            <div id="layoutAuthentication_content">
                <main>
                    <div class="container">
                        <div class="row justify-content-center">
                            <div class="col-lg-5">
                                <div class="card shadow-lg border-0 rounded-lg mt-5">

                                    <div class="card-header text-center pt-5">

                                        <img src="<?= base_url() . '/public/img/' . $logoTienda ?>" alt="" class='login_logotienda'>
                                        <h3 class="text-center font-weight-light mt-4 mb-3">Iniciar Sesión</h3>
                                    
                                    </div>

                                    <div class="card-body">
                                        <form method='POST' action='<?= base_url() ?>/usuarios/valida'>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputEmailAddress">Usuario</label>
                                                <input class="form-control py-4" id="usuario" name='usuario' type="text" placeholder="Ingresa tu usuario" />
                                            </div>
                                            <div class="form-group">
                                                <label class="small mb-1" for="inputPassword">Contraseña</label>
                                                <input class="form-control py-4" id="password" id="password" type="password" placeholder="Ingresa tu contraseña" name='password' />
                                            </div>
                                            <div class="form-group mt-4 mb-0 text-right">
                                                <button type='submit' class="btn btn-primary">Iniciar Sesión</button>
                                            </div>

                                            <?php if (isset($validation)) { ?>
                                                <div class="alert alert-danger mt-3">
                                                <?= $validation -> listErrors() ?>
                                                </div>
                                            <?php } ?>

                                            <?php if (isset($error)) { ?>
                                                <div class="alert alert-danger mt-3">
                                                <?= $error ?>
                                                </div>
                                            <?php } ?>

                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
            <div id="layoutAuthentication_footer mt-5">
                <footer class="sticky-footer bg-white mt-5 login_footer">
                    <div class="container my-auto">
                        <div class="copyright text-center my-auto">
                            <span>Copyright &copy; <?= $nombreTienda . ' ' . date('Y') ?></span>
                        </div>
                    </div>
                </footer>
            </div>
        </div>
        <!-- Bootstrap core JavaScript-->
        <script src="<?= base_url() ?>/public/vendor/jquery/jquery.min.js"></script>
        <script src="<?= base_url() ?>/public/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

        <!-- Core plugin JavaScript-->
        <script src="<?= base_url() ?>/public/vendor/jquery-easing/jquery.easing.min.js"></script>

        <!-- Custom scripts for all pages-->
        <script src="<?= base_url() ?>/public/js/sb-admin-2.min.js"></script>

        <!-- Page level plugins -->
        <script src="<?= base_url() ?>/public/vendor/datatables/jquery.dataTables.min.js"></script>
        <script src="<?= base_url() ?>/public/vendor/datatables/dataTables.bootstrap4.min.js"></script>

        <!-- Page level custom scripts -->
        <script src="<?= base_url() ?>/public/js/demo/datatables-demo.js"></script>

        <?php

            foreach ($js as $key => $value) 
            { ?>
                <script src="<?= base_url() ?>/public/js/<?= $value ?>.js"></script>
            <?php
            }

        ?>

    </body>
</html>
