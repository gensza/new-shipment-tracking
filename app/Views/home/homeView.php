<?= $this->extend('template/master') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<link href="<?= base_url() ?>/assets/modules/home/style.css" rel="stylesheet" type="text/css">
<!-- Start Content-->
<div class="container-fluid">
    <!-- custom css global -->

    <div class="row mt-2 mb-0">

        <div class="col-12">
            <div class="card-box">

                <input type="hidden" id="filter_track">
                <ul class="nav nav-tabs nav-bordered">
                    <li class="nav-item card" id="nav_all">
                        <a href="javascript:void(0);" class="nav-link active" id="link_all" onclick="get_track_shipment('all')">
                            <span class="badge badge-danger rounded-circle noti-icon-badge"><span id="span_total_shipment"></span></span>
                            Total shipment
                        </a>
                    </li>
                    <li class="nav-item" id="nav_delayed">
                        <a href="#javascript:void(0);" class="nav-link" id="link_delayed" onclick="get_track_shipment('At Origin')">
                            <span class="badge badge-danger rounded-circle noti-icon-badge"><span id="span_total_shipment_delayed"></span></span>
                            At Origin
                        </a>
                    </li>
                    <li class="nav-item" id="nav_transit">
                        <a href="#javascript:void(0);" class="nav-link" id="link_transit" onclick="get_track_shipment('In Transit')">
                            <span class="badge badge-danger rounded-circle noti-icon-badge"><span id="span_total_shipment_in_transit"></span></span>
                            In transit
                        </a>
                    </li>
                    <li class="nav-item" id="nav_destination">
                        <a href="#javascript:void(0);" class="nav-link" id="link_destination" onclick="get_track_shipment('Reached POD')">
                            <span class="badge badge-danger rounded-circle noti-icon-badge"><span id="span_total_shipment_in_destination"></span></span>
                            Reachead&nbsp;Destination
                        </a>
                    </li>
                </ul>

                <div class="row mt-1">
                    <div class="col-lg-8">
                        <div class="form-inline">
                            <div class="form-group-sm mx-sm-3 mb-1">
                                <select class="form-control form-control-sm" id="limit_select" onchange="change_limit()">
                                    <option selected="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    <option value="100">100</option>
                                </select>
                                <input class="form-control form-control-sm" id="search_filter" type="text" placeholder="bl number">
                                <button class="btn btn-info btn-sm" onclick="btn_search_filter()"><span class="mdi mdi-filter"></span>Filters</button>
                                <!-- <button class="btn">Sort By<span class="mdi mdi-sort"></span></button> -->
                            </div>
                            <!-- <div class="form-group-sm mx-sm-3">
                                </div> -->
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="text-right">
                            <?php if ($_SESSION['level'] == 'admin') { ?>
                                <button type="button" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="modal" data-target="#insert-shipment-modal"><i class="mdi mdi-plus-circle mr-1"></i>New Shipment</button>
                            <?php } ?>
                        </div>
                    </div><!-- end col-->
                </div> <!-- end row -->
            </div> <!-- end card-box-->
        </div> <!-- end col -->
    </div> <!-- end row -->

    <div class="row">
        <div class="col-12">

            <div class="table-responsive" id="data_track_shipments"></div>
            <span class="table-responsive" id="span_data_track_shipments"></span>
            <div class="table-responsive" id="pagination"></div>
            <span class="table-responsive" id="span_pagination"></span>

        </div> <!-- end col -->
    </div>
    <!-- end row -->
    <!-- end page title -->

</div> <!-- container -->

<!-- Full width modal content -->
<div id="insert-shipment-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-full-width">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Input New Shipment</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-3">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <form class="form-horizontal">
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">Internal Number</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="internal_number" placeholder="Internal Number">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">BL Number</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="bl_number" placeholder="BL Number">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">Movement Type*</label>
                                <div class="row col-9 ml-2">
                                    <div class="radio radio-info form-check-inline">
                                        <input type="radio" id="export_import" class="export" value="export" name="radioInline">
                                        <label for="inlineRadio1"> Export </label>
                                    </div>
                                    <div class="radio form-check-inline">
                                        <input type="radio" id="export_import" class="import" value="import" name="radioInline">
                                        <label for="inlineRadio2"> Import </label>
                                    </div>
                                    <span id="span-ex-im-required"></span>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">Shipper*</label>
                                <div class="col-7">
                                    <select id="shipper" class="form-control">
                                    </select>
                                </div>
                                <div class="col-2">
                                    <a class="btn btn-success btn-sm" target="_blank" href="<?= base_url() ?>/setup/shipper"><i class="mdi mdi-plus-circle mr-1"></i> add</a>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">Shipment Owner*</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="shipment_owner" placeholder="Shipment Owner">
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-12 col-lg-6">
                        <form class="form-horizontal">
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">Shipping Line*</label>
                                <div class="col-9">
                                    <select id="shipping_line" class="form-control" onchange="get_vessel_number()">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">Ship Number*</label>
                                <div class="col-9">
                                    <select id="vessel_number" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">CI-PL Number</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="ci_pl_number" placeholder="CI-PL Number">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">NPE-PEB Number</label>
                                <div class="col-9">
                                    <input type="text" class="form-control" id="npe_peb_number" placeholder="NPE-PEB Number">
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">Intocerm*</label>
                                <div class="col-9">
                                    <select id="incoterm" class="form-control">
                                    </select>
                                </div>
                            </div>
                            <div class="form-group row mb-2">
                                <label class="col-3 col-form-label">Row Container*</label>
                                <div class="col-2">
                                    <select id="row_container" class="form-control" onchange="add_row_container()">
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                    </select>
                                </div>
                                <div class="col-7">
                                    <div class="form-group row mb-2" id="div_row_container">
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- <hr> -->
                <div class="border-top">
                    <div class="row mt-3">
                        <div class="col-12 col-lg-6">
                            <form class="form-horizontal">
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label text-right">POL*</label>
                                    <div class="col-4">
                                        <select id="pol" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label">Document</label>
                                    <div class="col-9">
                                        <input type="file" class="form-control ml-0 border-gray" id="file_document" multiple>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <div class="col-12 col-lg-6">
                            <form class="form-horizontal">
                                <div class="form-group row mb-2">
                                    <label class="col-3 col-form-label text-right">POD*</label>
                                    <div class="col-4">
                                        <select id="pod" class="form-control">
                                        </select>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-info waves-effect waves-light" onclick="validation()">Save data</button>
            </div>
        </div>
    </div>
</div><!-- /.modal -->

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    var base_url = '<?php echo base_url() ?>';
    localStorage.removeItem("level");
    sessionStorage.setItem("level", '<?php echo $_SESSION['level'] ?>');
</script>
<script src="<?= base_url() ?>/assets/modules/home/home.js"></script>
<?= $this->endSection() ?>