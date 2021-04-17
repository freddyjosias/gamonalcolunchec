    <!-- Begin Page Content -->
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h1 mb-2 text-gray-800"><?= $title ?></h1>

        <form method='POST' action='<?= base_url() ?>/marcas/actualizar' autocomplete='off'>

            <div class="form-group">
                <div class="row">
                    <div class="col-12 col-sm-6">

                        <label for="">Nombre</label>
                        <input type="text" class='form-control' value='<?= $datos['marca_nombre'] ?>' id='nombre' name='nombre' autofocus require>

                    </div>

                </div>
            </div>

            <input type="hidden" value='<?= $datos['marca_id'] ?>' name='id'>

            <div class=''>
                <a href="<?= base_url() ?>/marcas" class='btn btn-leght'>Regresar</a>
                <button type="submit" class="btn btn-success">Guardar</button>
            </div>
            

        </form>

    </div>
    <!-- /.container-fluid -->

</div>
<!-- End of Main Content -->