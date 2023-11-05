<?= $this->extend('template/master') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Start Content-->
<div class="container-fluid">

    <div class="row mt-2 mb-0">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-body">
                    <h4 class="header-title mb-2">Add Shippingline</h4>
                    <form>
                        <div class="form-group mb-2">
                            <input type="text" id="set_shippingline" name="" class="form-control" placeholder="shippingline" required>
                        </div>
                        <button type="button" class="btn btn-primary waves-effect waves-light float-right" onclick="add_data()">Submit</button>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title mb-2">List Shippingline</h4>
                    <table id="table-shippingline" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Shipping Line</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="add_table_shippingline">

                        </tbody>
                    </table>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->
    </div>
    <!-- end row -->

</div>
<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    $(document).ready(function() {
        loading_processing();
        get_data();
    });

    function add_data() {
        $.ajax({
            url: "<?php echo base_url() ?>/dataSetup/add_data_setup_shippingline",
            method: "POST",
            dataType: "JSON",
            beforeSend: function() {
                loadingPannel.show();
            },
            data: {
                shippingline: $("#set_shippingline").val()
            },
            success: function(data) {

                loadingPannel.hide();
                get_data()
                $("#set_shippingline").val("")
            }
        }).done(function(data) {
            setTimeout(function() {
                loadingPannel.hide();
            }, 500);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("Unable to save new list order: " + errorThrown);
        });
    }

    function get_data() {
        $.ajax({
            url: "<?php echo base_url() ?>/dataSetup/get_data_setup_shippingline",
            method: "POST",
            dataType: "JSON",
            beforeSend: function() {
                loadingPannel.show();
            },
            success: function(response) {
                loadingPannel.hide();

                var data = []
                response.forEach((element, index) => {

                    aksi = '<button id="delete_data" class="btn btn-danger btn-sm" onClick="delete_data(' + element.id + ')">delete</button>'
                    data.push([index + 1, element.shipping_name, aksi]);
                });

                $('#table-shippingline').DataTable().destroy();
                $('#table-shippingline').DataTable({
                    searching: true,
                    data: data,
                });
            }
        }).done(function(data) {
            setTimeout(function() {
                loadingPannel.hide();
            }, 500);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("Unable to save new list order: " + errorThrown);
        });
    }

    function delete_data(id) {
        let text = "Press a button for delete!\nOK or Cancel.";
        if (confirm(text) == true) {
            $.ajax({
                url: "<?php echo base_url() ?>/dataSetup/delete_data_setup_shippingline",
                method: "POST",
                dataType: "JSON",
                data: {
                    id: id
                },
                beforeSend: function() {
                    loadingPannel.show();
                },
                success: function(response) {
                    loadingPannel.hide();
                    get_data()
                }
            }).done(function(data) {
                setTimeout(function() {
                    loadingPannel.hide();
                }, 500);
            }).fail(function(jqXHR, textStatus, errorThrown) {
                alert("Unable to save new list order: " + errorThrown);
            });
        }

    }
</script>

<?= $this->endSection() ?>