<?= $this->extend('template/master') ?>

<?= $this->section('css') ?>
<?= $this->endSection() ?>

<?= $this->section('content') ?>
<link href="<?= base_url() ?>/assets/modules/tracking/styleTracking.css" rel="stylesheet" type="text/css">

<!-- Start Content-->
<div class="container-fluid">

    <div class="row">
        <div class="col-12 col-lg-1">
            <div class="text-center mt-1">
                <div class="text-left p-0">
                    <table>
                        <tr>
                            <td><a href="javascript:void(0);" onclick="call_container()"><span id="span_call_container"></span>(<span id="count_containers"></span>)</a></td>
                        </tr>
                        <tr>
                            <td><a href="javascript:void(0);" onclick="call_document()"><span id="span_call_document"></span>(<span id="count_document"></span>)</a></td>
                        </tr>
                    </table>
                </div>
            </div> <!-- end card-box -->
        </div> <!-- end col-->

        <div class="col-12 col-lg-11">
            <div class="card-box">
                <div class="row align-items-center">
                    <div class="col-sm-4">
                        <div class="media">
                            <span id="logo_ship_head"></span>
                            <div class="media-body ml-lg-4">
                                <table>
                                    <tr>
                                        <td><b>Internal#</b></td>
                                        <input type="hidden" id="noref_track_shipment">
                                        <input type="hidden" id="ship_number">
                                        <td class="pl-2"><span id="internal_number_head"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>BL#</b></td>
                                        <td class="pl-2"><span id="bl_number_head"></span></td>
                                    </tr>
                                    <tr>
                                        <td><b>NPE-PEB#</b></td>
                                        <td class="pl-2"><span id="npe_peb_number_head"></span></td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 align-content-center">
                        <div class="text-center mt-0 mt-sm-0">
                            <div class="badge font-14 p-1" id="badge_status_head"><span id="status_head"></span></div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="steps mt-4 d-flex flex-wrap flex-sm-nowrap justify-content-between">
                            <div class="step track-order-list-left" id="line_completed_left">
                                <div class="step-icon-wrap bullet-active">
                                    <div class="step-icon"><span id="ship_position_left"></span></div>
                                </div>
                                <p class="text-left"> </p>
                            </div>
                            <span id="ship_position_center"></span>
                            <div class="step track-order-list-right" id="line_completed_right">
                                <div class="step-icon-wrap bullet-active">
                                    <div class="step-icon text-right"><span id="ship_position_right"></span></div>
                                </div>
                                <p class="text-right"> </p>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-3">
                        <div class="media-body ml-2">
                            <table>
                                <tr>
                                    <td><b>Shipping Line </b></td>
                                    <td class="pl-2"><span id="shipping_line_head"></span></td>
                                </tr>
                                <tr>
                                    <td><b>CI-PL# </b></td>
                                    <td class="pl-2"><span id="ci_pl_number_head"></span></td>
                                </tr>
                                <tr>
                                    <td><b>Incoterm </b></td>
                                    <td class="pl-2"><span id="incoterm_head"></span></td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div> <!-- end row -->
            </div> <!-- end card-box-->

            <div class="row" id="div_tracking">
                <div class="col-12 col-lg-8">
                    <div class="row justify-content-between">
                        <div class="p-2"></div>
                        <div class="text-bottom p-2">
                            <?php if ($_SESSION['level'] == 'admin') { ?>
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#add-container-modal">Add Container</button>
                            <?php } ?>
                        </div>
                    </div>
                    <div id="data_container"></div>
                </div>
                <div class="col-12 col-lg-4">
                    <div class="row justify-content-between">
                        <div class="p-2"></div>
                        <div class="text-bottom p-2">
                            <?php if ($_SESSION['level'] == 'admin') { ?>
                                <button class="btn btn-sm btn-info" data-toggle="modal" data-target="#add-tracking-modal">Add Tracking</button>
                            <?php } ?>
                        </div>
                    </div>
                    <div class="card-box">
                        <div class="pt-1 pb-1">
                            <div class="dropdown float-right" id="action_track">
                                <a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">
                                    <i class="mdi mdi-dots-horizontal m-0 text-muted h3"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item btn" data-toggle="modal" data-target="#edit-tracking-modal" onClick="table_edit_activity()">Edit</a>
                                </div>
                            </div> <!-- end dropdown -->
                            <h5 class="text-center">BL# : <span id="bl_number_side"></span></h5>
                        </div>
                        <div class="track-order-list pb-3">
                            <ul class="list-unstyled" id="side_tracking"></ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row" id="div_document">
                <div class="col-12">
                    <div class="row justify-content-between">
                        <div class="p-2"></div>
                        <div class="text-bottom p-2">
                            <button class="btn btn-sm btn-secondary" data-toggle="modal" data-target="#add-document-modal">Add Document</button>
                        </div>
                    </div>
                    <div class="card-box">
                        <div class="pt-1 pb-1">
                            <h5 class="text-left">Files Document</h5>
                        </div>
                        <form class="form-horizontal">
                            <table id="table_document" class="table dt-responsive nowrap w-100">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Files Name</th>
                                        <th>#</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                            </table>
                        </form>
                    </div>
                </div>

            </div> <!-- end col -->
        </div>
        <!-- end row-->

    </div> <!-- container -->

    <div id="add-document-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h4 class="modal-title">Add Document</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body pl-2 pr-2 pt-2">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form class="form-horizontal">
                                <div class="form-group row mb-2">
                                    <label class="col-2 col-form-label">Document*</label>
                                    <div class="col-10">
                                        <input type="file" class="form-control ml-0 border-gray" id="file_document" multiple>
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="validation_add_document()">Save data</button>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->

    <div id="add-container-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h4 class="modal-title">Add Container</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <div class="modal-body pl-2 pr-2 pt-2">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form class="form-horizontal">
                                <div class="form-group row mb-2">
                                    <label class="col-2 col-form-label">Container*</label>
                                    <div class="col-10">
                                        <input type="text" class="form-control" id="container_number_new" placeholder="container number">
                                    </div>
                                </div>
                            </form>
                        </div>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary waves-effect" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-info waves-effect waves-light" onclick="validation_add_container()">Save data</button>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->

    <div id="edit-tracking-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h4 class="modal-title">Edit Tracking Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <h5 class="pl-2"><small>Edit tracking event details for </small> <span id="bl_number_edit_event"></span></h5>
                <div class="modal-body pl-2 pr-2 pt-0">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form class="form-horizontal">
                                <table id="table_edit_activity" class="table dt-responsive nowrap w-100">
                                    <thead>
                                        <tr>
                                            <th>No</th>
                                            <th>Activity Name</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
                            </form>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div><!-- /.modal -->

    <div id="add-tracking-modal" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" style="display: none;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header border-bottom">
                    <h4 class="modal-title">Add Tracking Event</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                </div>
                <h5 class="pl-2"><small>Adding tracking event details for </small> <span id="bl_number_add_event"></span></h5>
                <div class="modal-body pl-2 pr-2 pt-1">
                    <div class="row">
                        <div class="col-12 col-lg-12">
                            <form class="form-horizontal">
                                <div class="form-group row mb-2">
                                    <label class="col-2 col-form-label">Activity*</label>
                                    <div class="col-10">
                                        <select id="activity" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-2 col-form-label">Location*</label>
                                    <div class="col-4">
                                        <select id="port_type" class="form-control" onChange="change_port_type()">
                                            <option value="">--select port--</option>
                                            <option value="origin">Origin Port</option>
                                            <option value="direct">Direct</option>
                                            <option value="transshipment">Transshipment</option>
                                            <option value="pod">POD</option>
                                        </select>
                                    </div>
                                    <div class="col-6">
                                        <select id="port_name" class="form-control">
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-2 col-form-label">Date*</label>
                                    <div class="col-10">
                                        <input type="datetime-local" class="form-control" id="date" placeholder="date">
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-2 col-form-label">Vehicle</label>
                                    <div class="col-10">
                                        <select id="vehicle" class="form-control">
                                            <option value="">--select vehicle--</option>
                                            <option value="Truck">Truck</option>
                                            <option value="Vessel">Vessel</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row mb-2">
                                    <label class="col-2 col-form-label">Voyage Details</label>
                                    <div class="col-6">
                                        <input type="text" class="form-control" id="voyage" placeholder="voyage">
                                    </div>
                                    <div class="col-4">
                                        <input type="text" class="form-control" id="voyage_number" placeholder="voyage Number">
                                    </div>
                                </div>

                            </form>
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
</div>

<?= $this->endSection() ?>

<?= $this->section('js') ?>
<script>
    var id = '<?php echo $id ?>';
    var base_url = '<?php echo base_url() ?>';
    localStorage.removeItem("level");
    sessionStorage.setItem("level", '<?php echo $_SESSION['level'] ?>');
</script>
<script src="<?= base_url() ?>/assets/modules/tracking/tracking.js"></script>
<?= $this->endSection() ?>