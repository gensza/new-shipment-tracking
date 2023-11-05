$(document).ready(function () {

    loading_processing()
    get_data_dropdown()
    add_row_container()

    var page = 1
    var filter_track = "";
    load_data(page, filter_track)

});

function change_limit() {
    var page = 1
    var filter_track = "";
    load_data(page, filter_track)
}

function btn_search_filter() {
    var page = 1
    var filter_track = "";
    load_data(page, filter_track)
}

function get_track_shipment(filter_track) {
    var page = 1

    if (filter_track == "At Origin") {
        $("#nav_all").removeClass("card");
        $("#link_all").removeClass("active");
        $("#nav_transit").removeClass("card");
        $("#link_transit").removeClass("active");
        $("#nav_destination").removeClass("card");
        $("#link_destination").removeClass("active");

        $("#nav_delayed").addClass("card");
        $("#link_delayed").addClass("active");

        $("#filter_track").val("At Origin");

    } else if (filter_track == "In Transit") {
        $("#nav_all").removeClass("card");
        $("#link_all").removeClass("active");
        $("#nav_delayed").removeClass("card");
        $("#link_delayed").removeClass("active");
        $("#nav_destination").removeClass("card");
        $("#link_destination").removeClass("active");

        $("#nav_transit").addClass("card");
        $("#link_transit").addClass("active");

        $("#filter_track").val("In Transit");

    } else if (filter_track == "Reached POD") {
        $("#nav_all").removeClass("card");
        $("#link_all").removeClass("active");
        $("#nav_delayed").removeClass("card");
        $("#link_delayed").removeClass("active");
        $("#nav_transit").removeClass("card");
        $("#link_transit").removeClass("active");

        $("#nav_destination").addClass("card");
        $("#link_destination").addClass("active");

        $("#filter_track").val("Reached POD");
    } else {
        $("#nav_delayed").removeClass("card");
        $("#link_delayed").removeClass("active");
        $("#nav_transit").removeClass("card");
        $("#link_transit").removeClass("active");
        $("#nav_destination").removeClass("card");
        $("#link_destination").removeClass("active");

        $("#nav_all").addClass("card");
        $("#link_all").addClass("active");

        $("#filter_track").val("all");
        var filter_track = "";
    }

    load_data(page, filter_track)
}

function load_data(page, filter) {
    var limit_page = $("#limit_select").val()
    var search_filter = $("#search_filter").val()

    $.ajax({
        url: base_url + "/home/get_data_track_shipment",
        method: "POST",
        dataType: "JSON",
        beforeSend: function () {
            loadingPannel.show();
        },
        data: {
            page: page,
            limit: limit_page,
            filter: filter,
            search_filter: search_filter
        },
        success: function (response) {
            if (!$.trim(response)) {
                // alert("What follows is blank: " + response);
                console.log('error!' + response);
            } else {

                var data = response.data
                var data_count = response.data_count_all

                $("#span_total_shipment").text(data_count.total_id['total_id']);
                $("#span_total_shipment_delayed").text(data_count.total_delayed['total_delayed']);
                $("#span_total_shipment_in_transit").text(data_count.total_in_transit['total_in_transit']);
                $("#span_total_shipment_in_destination").text(data_count.total_in_destination['total_in_destination']);

                if (filter == "At Origin") {
                    var tot_rec = data_count.total_delayed['total_delayed']
                } else if (filter == "In Transit") {
                    var tot_rec = data_count.total_in_transit['total_in_transit']
                } else if (filter == "Reached POD") {
                    var tot_rec = data_count.total_in_destination['total_in_destination']
                } else {
                    var tot_rec = data_count.total_id['total_id']
                }

                $("div#data_track_shipments").remove();
                $("div#pagination").remove();
                $("#span_data_track_shipments").append('<div id="data_track_shipments"></div>');
                $("#span_pagination").append('<div id="pagination"></div>');


                for (let i = 0; i < data.length; i++) {

                    if (data[i].status == 'At Origin') {
                        var status_color = 'bg-danger text-white'
                    } else if (data[i].status == 'In Transit') {
                        var status_color = 'bg-warning text-white'
                    } else if (data[i].status == 'Reached POD') {
                        var status_color = 'bg-success text-white'
                    }

                    if (!data[i].logo || data[i].logo == null) {
                        var logo_ship = base_url + '/assets/images/default-shipping.jpg';
                    } else {
                        var logo_ship = base_url + '/assets/document/logoShipping/' + data[i].logo;
                    }

                    var datetime1 = new Date(data[i].update_at);
                    var datetime2 = new Date();
                    var seconds = datetimeDiff(datetime1, datetime2);
                    var hourse = convertToHours(seconds);
                    const days = Math.floor(hourse / 24);
                    const hours = hourse % 24;
                    var date_difference = days + 'd ' + hours + ' h'


                    document.getElementById("data_track_shipments").innerHTML +=
                        '<div class="card-box mb-1">' +
                        '<div class="row align-items-center">' +
                        '<div class="col-sm-4">' +
                        '<div class="media">' +
                        '<img class="d-flex align-self-center mr-0" src="' + logo_ship + '" alt="Generic placeholder image" width="74" height="64" style="border-radius:5px;">' +
                        '<div class="media-body ml-5">' +
                        '<table>' +
                        '<tr>' +
                        '<td><b>Internal#</b></td>' +
                        '<td class="pl-2">' + data[i].internal_number + '</td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td><b>BL#</b></td>' +
                        '<td class="pl-2">' + data[i].bl_number + '</td>' +
                        '</tr>' +
                        '</table>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-sm-4">' +
                        '<div class="steps mt-3 d-flex flex-wrap flex-sm-nowrap justify-content-between">' +
                        '<div class="step track-order-list-left" id="line_completed_left_' + i + '">' +
                        '<div class="step-icon-wrap bullet-active">' +
                        '<div class="step-icon"><span id="ship_position_left_' + i + '"></span></div>' +
                        '</div>' +
                        '<p class="text-left">' + data[i].port_loading + '</p>' +
                        '</div>' +
                        '<span id="ship_position_center_' + i + '"></span>' +
                        '<div class="step track-order-list-right" id="line_completed_right_' + i + '">' +
                        '<div class="step-icon-wrap bullet-active">' +
                        '<div class="step-icon text-right"><span id="ship_position_right_' + i + '"></span></div>' +
                        '</div>' +
                        '<p class="text-right">' + data[i].port_discharge + '</p>' +
                        '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-sm-2 align-content-center">' +
                        '<div class="text-center mt-sm-0">' +
                        '<div class="badge font-14 ' + status_color + ' p-1">' + data[i].status + '</div>' +
                        '</div>' +
                        '</div>' +
                        '<div class="col-sm-2">' +
                        '<div class="text-sm-right">' +
                        '<a href="' + base_url + '/tracking/container/' + data[i].id + '" class="action-icon"> <i class="mdi mdi-square-edit-outline"></i></a>' +
                        '<a href="javascript:void(0);" class="action-icon" onClick="delete_tracking(' + data[i].id + ')" id="action_' + [i] + '"> <i class="mdi mdi-delete"></i></a>' +
                        '</div>' +
                        '</div> <!-- end col-->' +
                        '</div> <!-- end row -->' +
                        '<div class="text-small text-right">Shipper: ' + data[i].shipper + ' | <small>Updated: ' + date_difference + ' ago</small></div>' +
                        '</div> <!-- end card-box-->'

                    if (data[i].status == 'At Origin') {
                        document.getElementById("ship_position_left_" + i).innerHTML +=
                            '<span class="active-dot dot"></span>' +
                            '<i class="mdi mdi-circle-medium text-muted"></i>'

                        document.getElementById("ship_position_right_" + i).innerHTML +=
                            '<i class="mdi mdi-circle-medium text-muted"></i>'

                        $("#line_completed_left_" + i).removeClass("completed");
                        $("#line_completed_right_" + i).removeClass("completed");

                    } else if (data[i].status == 'In Transit') {
                        document.getElementById("ship_position_left_" + i).innerHTML +=
                            '<i class="mdi mdi-circle-medium text-muted"></i>'

                        document.getElementById("ship_position_center_" + i).innerHTML +=
                            '<div class="step track-order-list-right" id="line_completed_right_' + i + '">' +
                            '<div class="step-icon-wrap bullet-active">' +
                            '<div class="step-icon text-right">' +
                            '<span class="active-dot dot"></span>' +
                            '<i class="mdi mdi-circle-medium text-muted"></i>' +
                            '</div>' +
                            '</div>' +
                            '</div>'

                        document.getElementById("ship_position_right_" + i).innerHTML +=
                            '<i class="mdi mdi-circle-medium text-muted"></i>'

                        $("#line_completed_left_" + i).addClass("completed");
                        $("#line_completed_right_" + i).removeClass("completed");

                    } else if (data[i].status == 'Reached POD') {
                        document.getElementById("ship_position_left_" + i).innerHTML +=
                            '<i class="mdi mdi-circle-medium text-muted"></i>'

                        document.getElementById("ship_position_right_" + i).innerHTML +=
                            // '<i class="mdi mdi-anchor step-icon"></i>'
                            '<span class="active-dot dot"></span>' +
                            '<i class="mdi mdi-circle-medium text-muted"></i>'

                        $("#line_completed_left_" + i).addClass("completed");
                        $("#line_completed_right_" + i).addClass("completed");
                    }

                    if (sessionStorage.getItem("level") != 'admin') {
                        $('#action_' + [i]).hide();
                    }
                }

                var total_records = tot_rec
                var limit = limit_page

                jumlah_page = Math.ceil(total_records / limit);
                jumlah_number = 1; //jumlah halaman ke kanan dan kiri dari halaman yang aktif
                start_number = (page > jumlah_number) ? Number(page) - Number(jumlah_number) : 1;
                end_number = (page < (jumlah_page - jumlah_number)) ? Number(page) + Number(jumlah_number) : jumlah_page;
                link_prev = (page > 1) ? Number(page) - 1 : 1;
                link_next = (page < jumlah_page) ? Number(page) + 1 : jumlah_page;

                document.getElementById("pagination").innerHTML +=
                    '<nav class="mb-5">' +
                    '<ul class="pagination justify-content-end">' +
                    '<li class="page-item halaman" id="1"><a class="btn page-link">First</a></li>' +
                    '<li class="page-item halaman" id="' + link_prev + '"><a class="btn page-link"><span aria-hidden="true">&laquo;</span></a></li>' +
                    '<li id="add_halaman" class="row"></li>' +
                    '<li class="page-item halaman" id="' + link_next + '"><a class="btn page-link"><span aria-hidden="true">&raquo;</span></a></li>' +
                    '<li class="page-item halaman" id="' + jumlah_page + '"><a class="btn page-link">Last</a></li>' +
                    '</ul>' +
                    '</nav>'

                for (p = start_number; p <= end_number; p++) {
                    link_active = (page == p) ? ' active' : '';
                    document.getElementById("add_halaman").innerHTML +=
                        '<li class="page-item halaman ' + link_active + '" id="' + p + '"><a class="btn page-link">' + p + '</a></li>'
                }
            }
        }
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function convertToHours(seconds) {
    // Menghitung jumlah jam dari sejumlah detik dan mengambil bilangan bulat terkecil
    var hours = Math.floor(seconds / (60 * 60));

    return hours;
}

function datetimeDiff(datetime1, datetime2) {
    // Menghitung selisih antara dua tanggal dan waktu dalam milidetik
    var diff = Math.abs(datetime1.getTime() - datetime2.getTime());

    // Mengonversi milidetik ke detik
    var diffInSeconds = diff / 1000;

    return diffInSeconds;
}

$(document).on('click', '.halaman', function () {
    var page = $(this).attr("id");
    var filter = $("#filter_track").val();

    if (filter == "all") {
        var filter = "";
    }

    load_data(page, filter);
});

function get_data_dropdown() {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/home/get_data_dropdown",
        beforeSend: function () {
        },
        success: function (response) {

            var i, j, k;
            var html = '<option value="">--select shipper--</option>';
            for (i = 0; i < response.shipper.length; i++) {
                html += '<option value=' + response.shipper[i].id + '>' + response.shipper[i].shipper_name + '</option>';
            }
            $('#shipper').html(html);

            var html2 = '<option value="">--select shipping line--</option>';
            for (j = 0; j < response.shippingline.length; j++) {
                html2 += '<option value=' + response.shippingline[j].shipping_name + '>' + response.shippingline[j].shipping_name + '</option>';
            }
            $('#shipping_line').html(html2);

            var html3 = '<option value="">--select incoterm--</option>';
            for (k = 0; k < response.incoterm.length; k++) {
                html3 += '<option value=' + response.incoterm[k].incoterm + '>' + response.incoterm[k].incoterm + '</option>';
            }
            $('#incoterm').html(html3);
        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function get_vessel_number() {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        data: {
            shipping_line: $('#shipping_line option:selected').text()
        },
        url: base_url + "/home/get_vessel_number",
        beforeSend: function () {
        },
        success: function (response) {

            var html3 = '<option value="">--select vessel number--</option>';
            for (k = 0; k < response.length; k++) {
                html3 += '<option value=' + response[k].ship_number + '_' + response[k].noref + '>' + response[k].ship_name + ' - ' + response[k].ship_number + '</option>';
            }
            $('#vessel_number').html(html3);

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

$(".export, .import").click(function () {

    if (!$('.import:checked').val()) {
        region = 'indonesia'
    } else {
        region = 'international'
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        data: {
            region: region
        },
        url: base_url + "/home/get_data_portline",
        beforeSend: function () {
        },
        success: function (response) {

            var j, k;

            var html4 = '<option value="">--select POL--</option>';
            for (j = 0; j < response.pol.length; j++) {
                html4 += '<option value=' + response.pol[j].port_name + '>' + response.pol[j].port_name + '</option>';
            }
            $('#pol').html(html4);

            var html5 = '<option value="">--select POD--</option>';
            for (k = 0; k < response.pod.length; k++) {
                html5 += '<option value=' + response.pod[k].port_name + '>' + response.pod[k].port_name + '</option>';
            }
            $('#pod').html(html5);
        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
});

function validation() {
    id_to_validation = ['container_number_1', 'shipper', 'shipment_owner', 'shipping_line', 'vessel_number', 'incoterm', 'pol', 'pod']

    data_input_array = [];
    for (let i = 0; i < id_to_validation.length; i++) {
        var data_input = $("#" + id_to_validation[i]).val();

        if (!data_input || !data_input[0]) { // !data_input[0] = jika data kosong untuk select2
            $("#" + id_to_validation[i]).addClass("is-invalid");
        } else {
            $("#" + id_to_validation[i]).removeClass("is-invalid");
            // array push
            data_input_array.push(true);
        }
    }

    if (!$('#export_import:checked').val()) {
        $("#span-ex-im-required").append('<div id="ex-im-required" class="text-danger align-text-bottom pt-lg-2">is required!</div>');
    } else {
        $("div#ex-im-required").remove();
    }

    if (data_input_array.length == id_to_validation.length) {
        add_data_shipment()
    } else {
        console.log('Failed Validation!');
    }
}

function add_data_shipment() {

    let formData = new FormData();

    var container_number_array = []
    for (let i = 1; i <= $("#row_container").val(); i++) {
        container_number_array.push($("#container_number_" + i).val())
    }

    var fileupload = $('#file_document')[0];
    $.each(fileupload.files, function (k, file) {
        formData.append('fileupload[]', file);
    });

    formData.append('internal_number', $("#internal_number").val());
    formData.append('bl_number', $("#bl_number").val());
    formData.append('container_number', container_number_array);
    formData.append('movement_type', $('#export_import:checked').val());
    formData.append('shipper', $('#shipper').val());
    formData.append('shipment_owner', $('#shipment_owner').val());
    formData.append('shipping_line', $('#shipping_line option:selected').text());
    formData.append('ship_number', $('#vessel_number').val());
    formData.append('ci_pl_number', $('#ci_pl_number').val());
    formData.append('npe_peb_number', $('#npe_peb_number').val());
    formData.append('incoterm', $('#incoterm').val());
    formData.append('pol', $('#pol option:selected').text());
    formData.append('pod', $('#pod option:selected').text());

    // for(var pair of formData.entries()) {
    //     console.log(pair[1]); 
    //  }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/home/add_data_shipment",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            loadingPannel.show();
        },
        success: function (response) {
            $("#insert-shipment-modal").modal("hide");
            loadingPannel.hide();

            var filter_track = "";
            get_track_shipment(filter_track)

            $("#internal_number").val("");
            $("#bl_number").val("");
            $("#container_number").val("");
            $('.export').prop('checked', false);
            $('.import').prop('checked', false);
            $('#shipper').val("");
            $('#shipment_owner').val("");
            $('#shipping_line').val("");
            $('#vessel_number').val("");
            $('#vessel_number').text("");
            $('#ci_pl_number').val("");
            $('#npe_peb_number').val("");
            $('#incoterm').val("");
            $('#pol').val("");
            $('#pol').text("");
            $('#pod').val("");
            $('#pod').text("");
            $('#file_document').val("");
            $("input.input_row_container").remove();

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function add_row_container() {
    var row = $('#row_container').val()

    $("input.input_row_container").remove();

    for (let i = 1; i <= row; i++) {

        document.getElementById("div_row_container").innerHTML +=
            '<input type="text" class="form-control mb-1 input_row_container" id="container_number_' + i + '" placeholder="Container Number">'
    }
}

function delete_tracking(id) {
    let text = "Press a button for delete!\nOK or Cancel.";
    if (confirm(text) == true) {
        $.ajax({
            method: "POST",
            dataType: "JSON",
            url: base_url + "/home/delete_tracking",
            data: {
                id_tracking: id,
            },
            beforeSend: function () {
                loadingPannel.show();
            },
            success: function (response) {
                console.log(response);
                // location.reload()
                var page = 1
                var filter_track = "";
                load_data(page, filter_track)

            }
        }).done(function (data) {
            setTimeout(function () {
                loadingPannel.hide();
            }, 500);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alert("Unable to save new list order: " + errorThrown);
        });
    }
}