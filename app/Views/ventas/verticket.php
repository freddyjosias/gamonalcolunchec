    <!-- Begin Page Content -->
    <div class="container-fluid">

        <h1 class="h2 mb-2 text-gray-800 mx-3"><?= $title ?></h1>

        <div class="ml-3">
            <p class="">
                <a href="<?= base_url() ?>/ventas" class='btn btn-warning'>Ventas</a>
            </p>
        </div>

        <div class="col-12">

            <div class="panel">
            
                <div class="embed-responsive embed-responsive-4by3 ">

                    <iframe src="<?= base_url() . '/ventas/generaticket/' . $idventa ?>" frameborder="0" class='embed-responsive-item'>
                    
                    </iframe>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->