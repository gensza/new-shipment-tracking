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
                    <h4 class="header-title mb-2">Add Shipper</h4>
                    <form>
                        <div class="form-group">
                            <label for="" class="mb-0">Shipper</label>
                            <input type="text" id="set_shipper" name="" class="form-control mt-0" placeholder="shipper">
                        </div>
                        <div class="form-group">
                            <label for="" class="mb-0">Admin Name</label>
                            <input type="text" id="set_admin_name" name="" class="form-control" placeholder="Admin Name">
                        </div>
                        <div class="form-group">
                            <label for="" class="mb-0">Admin Email</label>
                            <input type="text" id="set_admin_email" name="" class="form-control" placeholder="Admin Email">
                        </div>
                        <button type="button" class="btn btn-primary waves-effect waves-light float-right" onclick="add_data()">Submit</button>
                    </form>
                </div> <!-- end card-body -->
            </div> <!-- end card -->
        </div> <!-- end col -->

        <div class="col-lg-8">
            <div class="card">
                <div class="card-body">

                    <h4 class="header-title mb-2">List Shipper</h4>
                    <table id="table-shipper" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Shipper</th>
                                <th>Admin Name</th>
                                <th>Admin Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="add_table_shipper">

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
            url: "<?php echo base_url() ?>/dataSetup/add_data_setup_shipper",
            method: "POST",
            dataType: "JSON",
            beforeSend: function() {
                loadingPannel.show();
            },
            data: {
                shipper: $("#set_shipper").val(),
                admin_name: $("#set_admin_name").val(),
                admin_email: $("#set_admin_email").val()
            },
            success: function(data) {

                loadingPannel.hide();
                get_data()
                $("#set_shipper").val("")
                $("#set_admin_name").val("")
                $("#set_admin_email").val("")
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
            url: "<?php echo base_url() ?>/dataSetup/get_data_setup_shipper",
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
                    data.push([index + 1, element.shipper_name, element.admin_name, element.admin_email, aksi]);
                });

                $('#table-shipper').DataTable().destroy();
                $('#table-shipper').DataTable({
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
                url: "<?php echo base_url() ?>/dataSetup/delete_data_setup_shipper",
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