<?= $this->extend('template/master') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>

<!-- Start Content-->
<div class="container-fluid">

    <div class="row mt-2 mb-0">

        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row justify-content-between pl-2 pr-2 pb-2 pt-0">
                        <h4 class="header-title mb-2">List Users</h4>
                        <a href="/auth/register" class="btn btn-success btn-sm">add user</a>
                    </div>
                    <table id="table-status" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Username</th>
                                <th>User email</th>
                                <th>Level</th>
                                <th>Shipper</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody id="add_table_status">

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

    function get_data() {
        $.ajax({
            url: "<?php echo base_url() ?>dataSetup/get_data_setup_users",
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
                    data.push([index + 1, element.user_name, element.user_email, element.level, element.shipper, aksi]);
                });

                $('#table-status').DataTable().destroy();
                $('#table-status').DataTable({
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
                url: "<?php echo base_url() ?>dataSetup/delete_data_setup_users",
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