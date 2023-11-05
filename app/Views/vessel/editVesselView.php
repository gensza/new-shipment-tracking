<?= $this->extend('template/master') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<link href="<?= base_url() ?>/assets/modules/vessel/editVessel.css" rel="stylesheet" type="text/css">

<div class="col-lg-12 mt-2">
    <div class="card">
        <div class="card-body">

            <h4 class="mb-3 header-title">Edit Vessel</h4>

            <div class="row">
                <div class="col-12 col-lg-6">
                    <form class="form-horizontal">
                        <input type="hidden" id="noref">
                        <input type="hidden" id="id_vessel">
                        <div class="form-group row mb-2">
                            <label class="col-3 col-form-label pt-0">Shipping*</label>
                            <div class="col-9">
                                <select id="shipping_line" class="form-control">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0">
                            <label class="col-3 col-form-label pt-0">Trans Loading*</label>
                            <div class="col-9">
                                <select id="trans_loading" class="form-control" onchange="get_trans_loading()">
                                </select>
                            </div>
                        </div>
                        <div class="form-group row mb-0 div_table_transit">
                            <label class="col-3 col-form-label pt-0"></label>
                            <div class="col-5">
                                <table id="table_transshipment" class="table table-sm dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th class="p-1 text-center">Port Name</th>
                                            <th class="p-1">#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </div>
                            <div class="col-4">
                                <button type="button" class="btn btn-primary btn-sm mt-1" data-toggle="modal" data-target="#add-transshipment-modal"><i class="mdi mdi-plus-circle"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="col-12 col-lg-6">
                    <form class="form-horizontal">
                        <div class="form-group row mb-2">
                            <label class="col-3 col-form-label">Ship&nbsp;Name*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="ship_name" placeholder="Ship Name">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-3 col-form-label">Ship&nbsp;Number*</label>
                            <div class="col-9">
                                <input type="text" class="form-control" id="ship_number" placeholder="Ship Number">
                            </div>
                        </div>
                        <div class="form-group row mb-2">
                            <label class="col-3 col-form-label">Transit&nbsp;Day</label>
                            <div class="col-9">
                                <input type="number" class="form-control" id="transit_day" placeholder="Transit Day">
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="border-top">
                <div class="row mt-2">
                    <div class="col-12 col-lg-6">
                        <form class="form-horizontal">
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label text-right">ETD*</label>
                                <div class="col-7">
                                    <input type="date" class="form-control" id="date_etd" placeholder="date">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label text-right">Origin*</label>
                                <div class="col-4">
                                    <select id="origin" class="form-control">
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-lg-6">
                        <form class="form-horizontal">
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label text-right">ETA*</label>
                                <div class="col-7">
                                    <input type="date" class="form-control" id="date_eta" placeholder="date">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label text-right">Destination*</label>
                                <div class="col-4">
                                    <select id="destination" class="form-control">
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="border-top">
                <div class="row mt-2">
                    <div class="col-12 col-lg-6">
                        <form class="form-horizontal">
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">Logo</label>
                                <div class="col-9">
                                    <input type="file" class="form-control ml-0 border-gray" id="file_logo">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label"></label>
                                <div class="col-9">
                                    <span id="logo_ship_head"></span>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info waves-effect waves-light" onclick="validation_edit()">Save data</button>
            </div>

        </div> <!-- end card-body -->
    </div> <!-- end card -->
</div> <!-- end col -->

<div id="add-transshipment-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header border-bottom">
                <h4 class="modal-title">Add Transshipment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body pl-2 pr-2 pt-2">
                <div class="row">
                    <div class="col-12 col-lg-12">
                        <form class="form-horizontal">
                            <div class="form-group row mb-2">
                                <label class="col-2 col-form-label">Port Name*</label>
                                <div class="col-10">
                                    <select id="port_name_new" class="form-control">
                                    </select>
                                </div>
                            </div>
                        </form>
                    </div>

                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info waves-effect waves-light" onclick="validation_add_transshipment()">Save data</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    var id_vessel = '<?php echo $id_vessel ?>';
    var base_url = '<?php echo base_url() ?>';
</script>
<script src="<?= base_url() ?>/assets/modules/vessel/editVessel.js"></script>
<?= $this->endSection() ?>