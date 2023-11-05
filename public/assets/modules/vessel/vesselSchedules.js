$(document).ready(function () {

    loading_processing()

    var page = 1
    get_data_vessel(page)
    get_shipping_line()
    get_port_line()
    add_row_transshipment()
    change_trans_loading()
    console.log(sessionStorage.getItem("level"));
});

function search_filter() {

    var page = 1
    get_data_vessel(page)
}

function get_data_vessel(page) {
    var limit_page = 10

    const dt = new Date();
    let year_dt = dt.getFullYear();
    let month_dt = dt.getMonth();

    var monthNames = ["", "Jan", "Feb", "Mar", "Apr", "May", "Jun",
        "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"];

    $("#span_origin").text($('#select_filter_origin option:selected').text());
    $("#span_destination").text($('#select_filter_destination option:selected').text());
    var month_span = parseInt($('#select_filter_month').val())
    if (month_span) {
        $("#span_month").text(monthNames[month_span] + ' ' + year_dt);
    } else {
        $("#span_month").text(monthNames[month_dt] + ' ' + year_dt);
    }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/get_data_vessel",
        beforeSend: function () {
            loadingPannel.show();
        },
        data: {
            page: page,
            limit: limit_page,
            origin: $('#select_filter_origin option:selected').text(),
            destination: $('#select_filter_destination option:selected').text(),
            month: $('#select_filter_month').val(),
            routes: $('#direct_trans:checked').val()
        },
        success: function (response) {

            if (!$.trim(response)) {
                alert("What follows is blank: " + response);
                console.log('error!' + response);
                // location.reload();
            } else {

                console.log(response);
                var data = response.data

                $("#count_data").text(data.length);

                $("div#data_vessel").remove();
                $("div#pagination").remove();
                $("#span_data_vessel").append('<div id="data_vessel"></div>');
                $("#span_pagination").append('<div id="pagination"></div>');

                for (let i = 0; i < data.length; i++) {

                    var date_eta = data[i].eta;
                    var date_etd = data[i].etd;

                    var split_date_eta = date_eta.split('-');
                    var split_date_etd = date_etd.split('-');

                    // console.log('date: ', split_date[1]);
                    // console.log('month: ', arr1[1]);
                    // console.log('yeae: ', arr1[0]);

                    var date_view_eta = split_date_eta[2]
                    var month_view_eta = monthNames[parseInt(split_date_eta[1])]
                    var year_view_eta = split_date_eta[0]

                    var date_view_etd = split_date_etd[2]
                    var month_view_etd = monthNames[parseInt(split_date_etd[1])]
                    var year_view_etd = split_date_etd[0]

                    if (!data[i].logo || data[i].logo == null) {
                        var logo_ship = base_url + '/assets/images/default-shipping.jpg';
                    } else {
                        var logo_ship = base_url + '/assets/document/logoShipping/' + data[i].logo;
                    }

                    var count_transit = data[i].total_transit - 1
                    if (data[i].total_transit == 1) {
                        var trans_name = data[i].port_name
                    } else {
                        var trans_name = data[i].port_name + ', +' + count_transit

                    }
                    var noref = "'" + data[i].noref + "'";
                    if (data[i].trans_loading == 'Transshipment') {

                        document.getElementById("data_vessel").innerHTML +=
                            '<div class="card-box mb-1">' +
                            '<div class="dropdown float-right" id="action_' + [i] + '">' +
                            '<a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="mdi mdi-dots-horizontal m-0 text-muted h3"></i>' +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="' + base_url + '/vessel/edit_vessel/' + data[i].id + '" class="dropdown-item btn">edit</a>' +
                            '<a class="dropdown-item btn" onClick="cek_before_delete(' + noref + ')">Delete</a>' +
                            '</div>' +
                            '</div> <!-- end dropdown -->' +
                            '<div class="row">' +
                            '<div class="col-sm-2 mt-1">' +
                            '<div class="media">' +
                            '<img class="d-flex align-self-center mr-3" src="' + logo_ship + '" alt="Generic placeholder image" width="64" height="64" style="border-radius:5px;">' +
                            '<div class="media-body">' +
                            '<h5 class="mt-3">' + data[i].shipping_line + '</h5>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-sm-2 mt-1">' +
                            '<div class="media">' +
                            '<div class="media-body ml-3">' +
                            '<h4 class="mb-0">' + date_view_eta + ' ' + month_view_eta + ' <small>' + year_view_eta + '</small></h4>' +
                            '<p class="mb-0"><small>' + data[i].origin + '</small></p>' +
                            // '<i class="mb-0"><small>Cut off : Not Available</small></i>'+
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class=" col-sm-4 mt-1">' +
                            '<div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between">' +
                            '<div class="step completed">' +
                            '<h6 class="text-center mt-2 mb-0"><small class="text-white">Direct</small></h6>' +
                            '<div class="step-icon-wrap">' +
                            '<div class="step-icon text-left"><i class="mdi mdi-circle-medium"></i></div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="step completed">' +
                            '<h6 class="text-center mt-2 mb-0"><small>' + data[i].total_transit + '&nbsp;Transshipment</small></h6>' +
                            '<div class="step-icon-wrap">' +
                            '<div class="step-icon text-center"><i class="mdi mdi-circle-medium"></i></div>' +
                            '</div>' +
                            '<h6 class="text-center mt-0"><small>' + trans_name + '</small></h6>' +
                            '</div>' +

                            '<div class="step completed">' +
                            '<h6 class="text-center mt-2 mb-0"><small class="text-white">Direct</small></h6>' +
                            '<div class="step-icon-wrap">' +
                            '<div class="step-icon text-right"><i class="mdi mdi-circle-medium"></i></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-sm-2 mt-1">' +
                            '<div class="media">' +
                            '<div class="media-body">' +
                            '<h4 class="mb-0">' + date_view_etd + ' ' + month_view_etd + ' <small>' + year_view_etd + '</small></h4>' +
                            '<p class="mb-0"><small>' + data[i].destination + '</small></p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-sm-2 mt-1">' +
                            '<div class="text-sm-center">' +
                            '<h3 class="mb-0">' + data[i].transit_day + '</h3>' +
                            '<h6 class="mb-0">Transit Days</h6>' +
                            '</div>' +
                            '</div> <!-- end col-->' +
                            '</div> <!-- end row -->' +
                            '<div class="row mt-0" style="margin-top: -45px!important;">' +
                            '<h6 class="col-4">Vessel : ' + data[i].ship_name + ' | ' + data[i].ship_number + '</h6>' +
                            // '<h6 class="col-4">Service : CIX</h6>'+
                            // '<h6 class="col-4 text-right">View Detail</h6>'+
                            '</div>' +
                            '</div> <!-- end card-box-->'
                    } else {
                        document.getElementById("data_vessel").innerHTML +=
                            '<div class="card-box mb-1">' +
                            '<div class="dropdown float-right" id="action_' + [i] + '">' +
                            '<a href="#" class="dropdown-toggle card-drop arrow-none" data-toggle="dropdown" aria-expanded="false">' +
                            '<i class="mdi mdi-dots-horizontal m-0 text-muted h3"></i>' +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="' + base_url + '/vessel/edit_vessel/' + data[i].id + '" class="dropdown-item btn">Edit</a>' +
                            '<a class="dropdown-item btn" onClick="cek_before_delete(' + noref + ')">Delete</a>' +
                            '</div>' +
                            '</div> <!-- end dropdown -->' +
                            '<div class="row">' +
                            '<div class="col-sm-2 mt-1">' +
                            '<div class="media">' +
                            '<img class="d-flex align-self-center mr-3" src="' + logo_ship + '" alt="Generic placeholder image" width="64" height="64" style="border-radius:5px;">' +
                            '<div class="media-body">' +
                            '<h5 class="mt-3">' + data[i].shipping_line + '</h5>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-sm-2 mt-1">' +
                            '<div class="media">' +
                            '<div class="media-body ml-3">' +
                            '<h4 class="mb-0">' + date_view_etd + ' ' + month_view_etd + ' <small>' + year_view_etd + '</small></h4>' +
                            '<p class="mb-0"><small>' + data[i].origin + '</small></p>' +
                            // '<i class="mb-0"><small>Cut off : Not Available</small></i>'+
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class=" col-sm-4 mt-1">' +
                            '<div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between">' +
                            '<div class="step completed">' +
                            '<h6 class="text-center mt-2 mb-0"><small class="text-white">Direct</small></h6>' +
                            '<div class="step-icon-wrap">' +
                            '<div class="step-icon text-left"><i class="mdi mdi-circle-medium"></i></div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="step completed">' +
                            '<h6 class="text-center mt-2 mb-0"><small>Direct</small></h6>' +
                            '<div class="step-icon-wrap">' +
                            '<div class="step-icon text-center"><i class="mdi mdi-circle-medium text-white"></i></div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="step completed">' +
                            '<h6 class="text-center mt-2 mb-0"><small class="text-white">Direct</small></h6>' +
                            '<div class="step-icon-wrap">' +
                            '<div class="step-icon text-right"><i class="mdi mdi-circle-medium"></i></div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-sm-2 mt-1">' +
                            '<div class="media">' +
                            '<div class="media-body">' +
                            '<h4 class="mb-0">' + date_view_eta + ' ' + month_view_eta + ' <small>' + year_view_eta + '</small></h4>' +
                            '<p class="mb-0"><small>' + data[i].destination + '</small></p>' +
                            '</div>' +
                            '</div>' +
                            '</div>' +
                            '<div class="col-sm-2 mt-1">' +
                            '<div class="text-sm-center">' +
                            '<h3 class="mb-0">' + data[i].transit_day + '</h3>' +
                            '<h6 class="mb-0">Transit Days</h6>' +
                            '</div>' +
                            '</div> <!-- end col-->' +
                            '</div> <!-- end row -->' +
                            '<div class="row mt-0" style="margin-top: -20px!important;">' +
                            '<h6 class="col-4">Vessel : ' + data[i].ship_name + ' | ' + data[i].ship_number + '</h6>' +
                            // '<h6 class="col-4">Service : CIX</h6>'+
                            // '<h6 class="col-4 text-right">View Detail</h6>'+
                            '</div>' +
                            '</div> <!-- end card-box-->'

                        // get_data_transshipmnent()
                    }

                    if (sessionStorage.getItem("level") != 'admin') {
                        $('#action_' + [i]).hide();
                    }
                }

                var total_records = response.data_count_all['total_id']
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
        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

$(document).on('click', '.halaman', function () {
    var page = $(this).attr("id");
    get_data_vessel(page);
});

function cek_before_delete(noref) {
    let text = "Press a button for delete!\nOK or Cancel.";
    if (confirm(text) == true) {
        $.ajax({
            method: "POST",
            dataType: "JSON",
            url: base_url + "vessel/cek_before_delete",
            data: {
                noref: noref,
            },
            beforeSend: function () {
            },
            success: function (response) {
                console.log(response);
                if (response > 0) {
                    alert("Vessel In Shipment! can't be deleted")
                } else {
                    delete_vessel(noref)
                }
            },
        }).done(function (data) {
            setTimeout(function () {
                loadingPannel.hide();
            }, 500);
        }).fail(function (jqXHR, textStatus, errorThrown) {
            alert("Unable to save new list order: " + errorThrown);
        });
    }
}

function delete_vessel(noref) {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/delete_vessel",
        data: {
            noref: noref,
        },
        beforeSend: function () {
            loadingPannel.show()
        },
        success: function (response) {
            console.log(response);
            get_data_vessel(1)
        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function get_shipping_line() {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/get_shipping_line",
        beforeSend: function () {
        },
        success: function (response) {

            var html3 = '<option value="">--select shipping line--</option>';
            for (k = 0; k < response.length; k++) {
                html3 += '<option value=' + response[k].shipping_name + '>' + response[k].shipping_name + '</option>';
            }
            $('#shipping_line').html(html3);

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function get_port_line() {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/get_port_line",
        beforeSend: function () {
        },
        success: function (response) {

            var html2 = '<option value="">--select port line--</option>';
            for (k = 0; k < response.length; k++) {
                html2 += '<option value=' + response[k].port_name + '>' + response[k].port_name + '</option>';
            }
            $('#origin').html(html2);

            var html3 = '<option value="">--select port line--</option>';
            for (l = 0; l < response.length; l++) {
                html3 += '<option value=' + response[l].port_name + '>' + response[l].port_name + '</option>';
            }
            $('#destination').html(html3);

            // for filter
            var html4 = '<option value=""></option>';
            for (l = 0; l < response.length; l++) {
                html4 += '<option value=' + response[l].port_name + '>' + response[l].port_name + '</option>';
            }
            $('#select_filter_origin').html(html4);

            var html5 = '<option value=""></option>';
            for (var l = response.length - 1; l >= 0; l--) {
                html5 += '<option value=' + response[l].port_name + '>' + response[l].port_name + '</option>';
            }
            $('#select_filter_destination').html(html5);

            var html6 = '<option value=""></option>';
            html6 += '<option value="01">January</option>';
            html6 += '<option value="02">February</option>';
            html6 += '<option value="03">March</option>';
            html6 += '<option value="04">April</option>';
            html6 += '<option value="05">May</option>';
            html6 += '<option value="06">June</option>';
            html6 += '<option value="07">July</option>';
            html6 += '<option value="08">August</option>';
            html6 += '<option value="09">September</option>';
            html6 += '<option value="10">October</option>';
            html6 += '<option value="11">November</option>';
            html6 += '<option value="12">December</option>';
            $('#select_filter_month').html(html6);

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function validation() {
    if ($('#trans_loading').val() == 'transshipment') {
        id_to_validation = ['transshipment_1', 'shipping_line', 'trans_loading', 'ship_name', 'ship_number', 'date_etd', 'origin', 'date_eta', 'destination']
    } else {
        id_to_validation = ['shipping_line', 'trans_loading', 'ship_name', 'ship_number', 'date_etd', 'origin', 'date_eta', 'destination']
    }


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

    var transshipment_array = []
    for (let i = 1; i <= $("#row_transshipment").val(); i++) {
        transshipment_array.push($("#transshipment_" + i + " option:selected").text())
    }

    var fileupload = $('#file_logo')[0];
    $.each(fileupload.files, function (k, file) {
        formData.append('fileupload[]', file);
    });

    formData.append('shipping_line', $('#shipping_line option:selected').text());
    formData.append('trans_loading', $('#trans_loading option:selected').text());
    formData.append('transshipment', transshipment_array);
    formData.append('ship_name', $("#ship_name").val());
    formData.append('ship_number', $("#ship_number").val());
    formData.append('transit_day', $("#transit_day").val());
    formData.append('date_etd', $("#date_etd").val());
    formData.append('date_eta', $("#date_eta").val());
    formData.append('origin', $("#origin option:selected").text());
    formData.append('destination', $("#destination option:selected").text());

    // for(var pair of formData.entries()) {
    //     console.log(pair[1]); 
    //  }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/add_data_vessel",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            loadingPannel.show();
        },
        success: function (response) {
            $("#insert-vessel-modal").modal("hide");
            loadingPannel.hide();
            get_data_vessel(1)

            $("#shipping_line").val("");
            $("#trans_loading").val("");
            $("#ship_name").val("");
            $("#ship_number").val("");
            $("#transit_day").val("");
            $("#date_etd").val("");
            $("#date_eta").val("");
            $("#origin").val("");
            $("#destination").val("");

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function change_trans_loading() {
    if ($('#trans_loading').val() == 'transshipment') {
        $('#div_transshipment').css('display', 'block')
    } else {
        $('#div_transshipment').css('display', 'none')

    }
}

function add_row_transshipment() {
    var row = $('#row_transshipment').val()

    $("select.input_row_transshipment").remove();

    for (let i = 1; i <= row; i++) {

        document.getElementById("div_row_transshipment").innerHTML +=
            '<select id="transshipment_' + [i] + '" class="form-control input_row_transshipment mb-1">'

        get_port_line_transshipment(i)
    }
}

function get_port_line_transshipment(no) {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/get_port_line",
        beforeSend: function () {
        },
        success: function (response) {

            var html2 = '<option value="">--select port line--</option>';
            for (k = 0; k < response.length; k++) {
                html2 += '<option value=' + response[k].port_name + '>' + response[k].port_name + '</option>';
            }
            $('#transshipment_' + no).html(html2);

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}