<?= $this->extend('template/master') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<link href="<?= base_url() ?>/assets/modules/vessel/styleVessel.css" rel="stylesheet" type="text/css">

<!-- Start Content-->
<div class="container-fluid">

    <div class="bg-soft-warning pl-3 pt-2 pb-2 mt-2">
        <div class="row float-center">
            <div class="col-1"></div>
            <div class="card col-3 border-0 rounded-0 shadow-none mb-0"><small>Origin</small>
                <select style="border: none;" class="w-75" id="select_filter_origin">
                </select>
            </div>
            <div class="card col-3 border-0 rounded-0 shadow-none mb-0"><small>Destination</small>
                <select style="border: none;" class="w-75" id="select_filter_destination">
                </select>
            </div>
            <div class="card col-3 border-0 rounded-0 shadow-none mb-0"><small>Month</small>
                <select style="border: none;" class="w-75" id="select_filter_month">
                </select>
            </div>
            <div class="col-2">
                <button type="button" class="btn waves-light btn-blue mb-0" onclick="search_filter()"><i class="fa fa-search"></i> Search</button>
            </div>
        </div>
    </div>
    <!-- start page title -->
    <div class="row">
        <div class="col-12 mt-2 mb-2">
            <div class="row">
                <div class="col-12 col-lg-2">
                    <a>Filters</a>
                    <!-- <a href="" class="text-danger ml-2"><small>Clear All</small></a> -->
                </div>
                <div class="col-6 col-lg-6">
                    <a href="#" class="text-dark"><small><b><span id="count_data"></span></b> Search Result(s) <b>for <span id="span_origin"></span> - <span id="span_destination"></span> | <span id="span_month"></span> </b></small></a>
                </div>
                <div class="col-4 text-right">
                    <?php if ($_SESSION['level'] == 'admin') { ?>
                        <button type="button" class="btn btn-primary waves-effect waves-light btn-sm" data-toggle="modal" data-target="#insert-vessel-modal"><i class="mdi mdi-plus-circle mr-1"></i>New vessel</button>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
    <!-- end page title -->

    <div class="row">
        <div class="col-lg-2 col-xl-2">
            <div class="card text-center">

                <div class="text-left pl-2 pt-0 pb-2">
                    <h4 class="font-13 text-uppercase">Routes</h4>
                    <div class="radio radio-info form-check-inline pl-2">
                        <input type="radio" id="direct_trans" class="export" value="" name="radioInline">
                        <label for="inlineRadio1"> All </label>
                    </div><br>
                    <div class="radio radio-info form-check-inline pl-2">
                        <input type="radio" id="direct_trans" class="export" value="Direct" name="radioInline">
                        <label for="inlineRadio1"> Direct </label>
                    </div><br>
                    <div class="radio radio-info form-check-inline pl-2">
                        <input type="radio" id="direct_trans" class="import" value="Transshipment" name="radioInline">
                        <label for="inlineRadio2"> Transshipment </label>
                    </div>
                    <span id="span-ex-im-required"></span>
                </div>
            </div> <!-- end card-box -->

            <!-- <div class="card-box">
                <h4 class="header-title mb-3">Inbox</h4>
            </div>  -->
            <!-- end card-box-->

        </div> <!-- end col-->

        <div class="col-lg-10 col-xl-10">

            <div id="data_vessel"></div>
            <div class="table" id="data_vessel"></div>
            <span class="table" id="span_data_vessel"></span>
            <div class="table" id="pagination"></div>
            <span class="table" id="span_pagination"></span>

        </div> <!-- end col -->
    </div>
    <!-- end row-->

</div> <!-- container -->

<!-- Full width modal content -->
<div id="insert-vessel-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">Input New Vessel Schedules</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <div class="modal-body p-3">
                <div class="row">
                    <div class="col-12 col-lg-6">
                        <form class="form-horizontal">
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
                                    <select id="trans_loading" class="form-control" onchange="change_trans_loading()">
                                        <option value="">--select trans loading--</option>
                                        <option value="direct">Direct</option>
                                        <option value="transshipment">Transshipment</option>
                                    </select>
                                </div>
                            </div>
                            <div id="div_transshipment">
                                <div class="form-group row mb-2 pt-0">
                                    <label class="col-3 col-form-label pt-0"></label>
                                    <div class="col-3">
                                        <select id="row_transshipment" class="form-control" onchange="add_row_transshipment()">
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
                                    <div class="col-6">
                                        <div class="form-group row mb-2" id="div_row_transshipment">
                                        </div>
                                    </div>
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
<script src="<?= base_url() ?>/assets/modules/vessel/vesselSchedules.js"></script>
<?= $this->endSection() ?>