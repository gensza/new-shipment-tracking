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
                    <h4 class="header-title mb-2">Company Profile</h4>
                    <form>
                        <div class="border-top">
                            <div class="row mt-2">
                                <div class="col-12">
                                    <form class="form-horizontal">
                                        <div class="form-group mb-2">
                                            <label for="" class="mb-0">Title</label>
                                            <input type="text" id="title" name="" class="form-control title" required>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="" class="mb-0">Logo</label>
                                            <input type="file" class="form-control ml-0 border-gray" id="file_logo">
                                        </div>
                                        <div class="form-group row mb-2">
                                            <div class="col-9">
                                                <span id="logo_profile_head"></span>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-primary waves-effect waves-light float-right" onclick="add_data()">Submit</button>
                    </form>
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

        let formData = new FormData();

        var fileupload = $('#file_logo')[0];
        $.each(fileupload.files, function(k, file) {
            formData.append('fileupload[]', file);
        });

        formData.append('title', $('#title').val());

        $.ajax({
            method: "POST",
            dataType: "JSON",
            url: "<?php echo base_url() ?>dataSetup/add_data_setup_profile",
            data: formData,
            processData: false,
            contentType: false,
            cache: false,
            beforeSend: function() {
                loadingPannel.show();
            },
            success: function(response) {
                loadingPannel.hide();
                alert('Please Re-login for refresh Logo and Title Application!')
            },
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
            url: "<?php echo base_url() ?>dataSetup/get_data_setup_profile",
            method: "POST",
            dataType: "JSON",
            beforeSend: function() {
                loadingPannel.show();
            },
            success: function(response) {

                console.log(response);
                $(".title").val(response[0].title)

                if (!response[0].logo || response[0].logo == null) {
                    var logo_profile = '<?php echo base_url() ?>assets/images/docker-logo.jpg';
                } else {
                    var logo_profile = '<?php echo base_url() ?>assets/document/logoProfile/' + response[0].logo;
                }

                var logo_img = '<img class="d-flex align-self-center mr-0" src="' + logo_profile + '" alt="Generic placeholder image" width="74" height="64" style="border-radius:5px;">'

                $("#logo_profile_head").html(logo_img)

            }
        }).done(function(data) {
            setTimeout(function() {
                loadingPannel.hide();
            }, 500);
        }).fail(function(jqXHR, textStatus, errorThrown) {
            alert("Unable to save new list order: " + errorThrown);
        });
    }
</script>

<?= $this->endSection() ?>