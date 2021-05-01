    <!-- Begin Page Content -->
    <div class="container-fluid">

        <h1 class="h2 mb-2 text-gray-800 mx-3"><?= $title ?></h1>

        <div class="col-12">

            <div class="panel">
            
                <div class="embed-responsive embed-responsive-4by3">

                    <iframe src="<?= base_url() . '/compras/generacomprapdf/' . $idcompra ?>" frameborder="0" class='embed-responsive-item'>
                    
                    </iframe>

                </div>

            </div>

        </div>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->