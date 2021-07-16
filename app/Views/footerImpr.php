    <!-- Bootstrap core JavaScript-->
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

    <script>
        $('#modal-confirma').on('show.bs.modal', function (e) {
            $(this).find('.btn-ok').attr('href', $(e.relatedTarget).data('href'));
        });
    </script>

    <?php if (isset($anyChart)) { ?>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-base.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-ui.min.js"></script>
        <script src="https://cdn.anychart.com/releases/v8/js/anychart-exports.min.js"></script>
    <?php } 
    
    if (isset($js)) {
        foreach ($js as $key => $value) { ?>
            <script src="<?= base_url() ?>/public/js/<?= $value ?>.js"></script>
    <?php } 
    }  ?>

</body>

</html>