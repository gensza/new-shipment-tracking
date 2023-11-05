$(document).ready(function () {

    loading_processing()
    get_data_trackshipment()
    get_data_dropdown()
    call_container()
});

function call_container() {

    $('#div_document').hide();
    $('#div_tracking').show();
    $('#span_call_container').html('<u>Container</u>');
    $('#span_call_document').html('Document');
}

function call_document() {

    $('#div_tracking').hide();
    $('#div_document').show();
    $('#span_call_container').html('Container');
    $('#span_call_document').html('<u>Document</u>');
}

function get_data_trackshipment() {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/tracking/get_data_track_shipment",
        data: {
            id: id,
        },
        beforeSend: function () {
            loadingPannel.show();
        },
        success: function (response) {

            if (!$.trim(response)) {
                alert("What follows is blank: " + response);
                console.log('error!' + response);
                // location.reload();
            } else {

                $("#internal_number_head").text(response.internal_number)
                $("#bl_number_head").text(response.bl_number)
                $("#npe_peb_number_head").text(response.npe_peb_number)
                $("#status_head").text(response.status)
                $("#shipping_line_head").text(response.shipping_line)
                $("#ci_pl_number_head").text(response.ci_pl_number)
                $("#incoterm_head").text(response.incoterm)

                $("#bl_number_add_event").text(response.bl_number)
                $("#bl_number_edit_event").text(response.bl_number)

                $("#noref_track_shipment").val(response.noref)
                $("#ship_number").val(response.ship_number)

                $("#bl_number_side").text(response.bl_number)

                if (!response.logo || response.logo == null) {
                    var logo_ship = base_url + '/assets/images/default-shipping.jpg';
                } else {
                    var logo_ship = base_url + '/assets/document/logoShipping/' + response.logo;
                }

                var logo_img = '<img class="d-flex align-self-center mr-0" src="' + logo_ship + '" alt="Generic placeholder image" width="74" height="64" style="border-radius:5px;">'

                $("#logo_ship_head").html(logo_img)


                get_data_containers(response)
                get_data_port_name(response.port_loading, response.port_discharge, response.noref, response.trans_loading, response.status, response.noref_vessel_schedules)
                table_document(response.noref)

                if (response.status == 'At Origin') {
                    document.getElementById("ship_position_left").innerHTML +=
                        '<span class="active-dot dot"></span>' +
                        '<i class="mdi mdi-circle-medium text-muted"></i>'

                    document.getElementById("ship_position_right").innerHTML +=
                        '<i class="mdi mdi-circle-medium text-muted"></i>'

                    $("#line_completed_left").removeClass("completed");
                    $("#line_completed_right").removeClass("completed");

                    $("#badge_status_head").addClass("bg-danger text-white");

                } else if (response.status == 'In Transit') {
                    document.getElementById("ship_position_left").innerHTML +=
                        '<i class="mdi mdi-circle-medium text-muted"></i>'

                    document.getElementById("ship_position_center").innerHTML +=
                        '<div class="step track-order-list-right" id="line_completed_right' + '">' +
                        '<div class="step-icon-wrap bullet-active">' +
                        '<div class="step-icon text-right">' +
                        '<span class="active-dot dot"></span>' +
                        '<i class="mdi mdi-circle-medium text-muted"></i>' +
                        '</div>' +
                        '</div>' +
                        '</div>'

                    document.getElementById("ship_position_right").innerHTML +=
                        '<i class="mdi mdi-circle-medium text-muted"></i>'

                    $("#line_completed_left").addClass("completed");
                    $("#line_completed_right").removeClass("completed");

                    $("#badge_status_head").addClass("bg-warning text-white");

                } else if (response.status == 'Reached POD') {
                    document.getElementById("ship_position_left").innerHTML +=
                        '<i class="mdi mdi-circle-medium text-muted"></i>'

                    document.getElementById("ship_position_right").innerHTML +=
                        // '<i class="mdi mdi-anchor step-icon"></i>'
                        '<span class="active-dot dot"></span>' +
                        '<i class="mdi mdi-circle-medium text-muted"></i>'

                    $("#line_completed_left").addClass("completed");
                    $("#line_completed_right").addClass("completed");

                    $("#badge_status_head").addClass("bg-success text-white");
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

function validation() {
    if ($("#port_type option:selected").text() == 'Direct') {
        id_to_validation = ['activity', 'port_type', 'date']
        $("#port_name").removeClass("is-invalid");
    } else {
        id_to_validation = ['activity', 'port_type', 'port_name', 'date']
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

    if (data_input_array.length == id_to_validation.length) {
        add_data_tracking_event()
    }
}

function add_data_tracking_event() {

    // jika vessel departed change status to cast off
    if ($("#activity option:selected").text() == 'Vessel Departed' || $("#activity option:selected").text() == 'Vessel In Transit') {
        var type_status = 'start'
        change_status_track($("#noref_track_shipment").val(), type_status)
    } else if ($("#activity option:selected").text() == 'Vessel Arrived') {
        var type_status = 'end'
        change_status_track($("#noref_track_shipment").val(), type_status)
    }

    if (!$("#port_name option:selected").val()) {
        var port_name = ""
    } else {
        var port_name = $("#port_name option:selected").text()
    }

    let formData = new FormData();

    formData.append('noref_track_shipment', $("#noref_track_shipment").val());
    formData.append('ship_number', $("#ship_number").val());
    formData.append('bl_number', $("#bl_number_head").text());
    formData.append('activity', $("#activity option:selected").text());
    formData.append('port_type', $("#port_type option:selected").text());
    formData.append('port_name', port_name);
    formData.append('date', $("#date").val());
    formData.append('vehicle', $("#vehicle option:selected").val());
    formData.append('voyage', $("#voyage").val());
    formData.append('voyage_number', $("#voyage_number").val());

    // for(var pair of formData.entries()) {
    //     console.log(pair[1]); 
    //  }

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/tracking/add_data_tracking_event",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            loadingPannel.show();
        },
        success: function (response) {
            $("#add-tracking-modal").modal("hide");
            location.reload();

            // get_data_trackshipment()
        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function change_status_track(noref_track_shipment, type_status) {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/tracking/change_status_track",
        data: {
            noref_track_shipment: noref_track_shipment,
            type_status: type_status,
        },
        beforeSend: function () {
        },
        success: function (response) {
            console.log(response);

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function add_side_tracking(noref_track_shipment, all_port, trans_loading, status) {
    for (let i = 0; i < all_port.length; i++) {

        (function (i) {
            setTimeout(function () {

                $.ajax({
                    method: "POST",
                    dataType: "JSON",
                    url: base_url + "/tracking/get_side_tracking",
                    data: {
                        noref_track_shipment: noref_track_shipment,
                        port_name: all_port[i],
                    },
                    beforeSend: function () {
                        // loadingPannel.show();
                    },
                    success: function (response) {

                        var res_tot = response.length - 1
                        var res_real = response.length
                        var i_tot = i + 1
                        var i_min = i - 1

                        if (i_tot == all_port.length) {
                            if (!response[0]) {

                                var html = '<li>'
                                html += '<h5 class="mt-0 mb-1">' + all_port[i] + '</h5>'
                                html += '</li>'
                                $(".class_li_" + i_min).removeClass("completed");
                                $(".class_dot_" + i_min).addClass("dot");
                            } else {

                                var html = '<li>'
                                html += '<span class="active-dot dot"></span>'
                                html += '<h5 class="mt-0 mb-1">' + all_port[i] + ' <span class="badge badge-danger badge-outline-success">' + response[0].port + '</span></h5>'
                                for (let j = 0; j < response.length; j++) {
                                    html += '<span class="text-muted">' + formatDate(response[j].date) + '<small class="text-muted"> ' + response[j].activity + '</small> </span></br>'
                                }
                                html += '</li>'
                            }
                        } else {
                            if (!response[0]) {
                                var html = '<li>'
                                html += '<h5 class="mt-0 mb-1">' + all_port[i] + '</h5>'
                                html += '</li>'

                                $(".class_li_" + i_min).removeClass("completed");
                                $(".class_dot_" + i_min).addClass("dot");

                            } else {

                                var html = '<li class="completed class_li_' + i + '">'
                                html += '<span class="active-dot class_dot_' + i + '"></span>'
                                html += '<h5 class="mt-0 mb-1">' + all_port[i] + ' <span class="badge badge-danger badge-outline-success">' + response[0].port + '</span></h5>'
                                for (let j = 0; j < response.length; j++) {
                                    html += '<span class="text-muted">' + formatDate(response[j].date) + '<small class="text-muted"> ' + response[j].activity + '</small> </span></br>'
                                }
                                html += '</li>'

                                if (trans_loading == 'Direct' && i == 0 && status == 'In Transit') {

                                    html += '<li>'
                                    html += '<span class="active-dot dot"></span>'
                                    html += '<h5 class="mt-0 mb-1">' + all_port[0] + ' - ' + all_port[1] + ' <span class="badge badge-danger badge-outline-success" id="span_status_direct"></span></h5>'
                                    html += '<span class="text-muted">' + formatDate(response[res_tot].date) + ' - <span id="span_until_end"> </span></span></br>'
                                    html += '</li>'
                                    get_status_direct(noref_track_shipment)

                                } else if (trans_loading == 'Direct' && i_tot == 1 && status == 'Reached POD') {
                                    html += '<li class="completed">'
                                    html += '<span class="active-dot"></span>'
                                    html += '<h5 class="mt-0 mb-1">' + all_port[0] + ' - ' + all_port[1] + ' <span class="badge badge-danger badge-outline-success" id="span_status_direct"></span></h5>'
                                    html += '<span class="text-muted">' + formatDate(response[res_tot].date) + ' - <span id="span_until_end"> </span></span></br>'
                                    html += '</li>'
                                    get_status_direct(noref_track_shipment)
                                }
                            }

                        }
                        $('#side_tracking').append(html);

                        if (trans_loading == 'Direct' && status == 'In Transit') {

                            $(".class_li_0").addClass("completed");
                            $(".class_dot_0").removeClass("dot");
                        }

                        if ((i + 1) == all_port.length && trans_loading == 'Direct' && status == 'Reached POD') {
                            $("#span_until_end").text(formatDate(response[0].date));
                        } else {
                            $("#span_until_end").text("");
                        }
                    },
                }).done(function (data) {
                    // setTimeout(function() {
                    //     loadingPannel.hide();
                    // }, 500);
                }).fail(function (jqXHR, textStatus, errorThrown) {
                    alert("Unable to save new list order: " + errorThrown);
                });

            }, 1000 * i);
        }(i));
    }
}

function formatDate(value) {
    let date = new Date(value);
    const day = date.toLocaleString('default', { day: '2-digit' });
    const month = date.toLocaleString('default', { month: 'numeric' });
    const year = date.toLocaleString('default', { year: 'numeric' });
    return day + '-' + month + '-' + year;
}

function get_status_direct(noref_track_shipment) {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/tracking/get_status_direct",
        data: {
            noref_track_shipment: noref_track_shipment,
        },
        beforeSend: function () {
        },
        success: function (response) {

            if (response) {
                $("#span_status_direct").text(response.port);
            } else {
                $("#span_status_direct").text("");
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

function get_data_port_name(port_loading, port_discharge, noref, trans_loading, status, noref_vessel_schedules) {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/tracking/get_data_port_name",
        data: {
            noref_vessel_schedules: noref_vessel_schedules,
        },
        beforeSend: function () {
        },
        success: function (response) {

            var i
            var all_port = []
            all_port.push(port_loading)

            var html = '<option value="">--select port name--</option>';
            html += '<option value=' + port_loading + '>' + port_loading + '</option>';

            for (i = 0; i < response.length; i++) {
                html += '<option value=' + response[i].port_name + '>' + response[i].port_name + '</option>';
                all_port.push(response[i].port_name)
            }

            all_port.push(port_discharge)
            html += '<option value=' + port_discharge + '>' + port_discharge + '</option>';
            $('#port_name').html(html);

            add_side_tracking(noref, all_port, trans_loading, status)
        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function get_data_dropdown() {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/tracking/get_data_dropdown",
        beforeSend: function () {
        },
        success: function (response) {

            var i
            var html = '<option value="">--select activity--</option>';
            for (i = 0; i < response.activity.length; i++) {
                html += '<option value=' + response.activity[i].activity_name + '>' + response.activity[i].activity_name + '</option>';
            }
            $('#activity').html(html);

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function get_data_containers(response_track) {

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/tracking/get_data_containers",
        beforeSend: function () {
            loadingPannel.show();
        },
        data: {
            noref_track_shipment: response_track.noref,
        },
        success: function (response) {

            if (!$.trim(response)) {
                alert("What follows is blank: " + response);
                console.log('error!' + response);
                // location.reload();
            } else {

                $('#count_containers').text(response.length);

                for (let i = 0; i < response.length; i++) {

                    document.getElementById("data_container").innerHTML +=
                        '<div class="card-box mb-1 pb-3 pt-1">' +
                        '<div class="row">' +
                        '<div class="col-lg-3 col-12">' +
                        '<table>' +
                        '<tr>' +
                        '<h5><b><span id="container_number_car">' + response[i].container_number + '</span></b></h5>' +
                        '</tr>' +
                        '</table>' +
                        '</div>' +
                        '<div class="col-lg-8 col-12">' +
                        '<table>' +
                        '<tr>' +
                        '<td><b>BL#</b></td>' +
                        '<td class="pl-2"> ' + response_track.bl_number + ' </td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td><b>Booking#</b></td>' +
                        '<td class="pl-2"> ' + response[i].container_number + ' </td>' +
                        '</tr>' +
                        '<tr>' +
                        '<td><b>Status</b></td>' +
                        '<td class="pl-2"> ' + response_track.status + ' </td>' +
                        '</tr>' +
                        '</table>' +
                        '</div>' +
                        '<div class="col-1">' +
                        '<div class="text-sm-right mt-lg-3">' +
                        '<a href="javascript:void(0);" class="action-icon" onClick="delete_container(' + response[i].id + ')" id="action_' + [i] + '"> <i class="mdi mdi-delete"></i></a>' +
                        '</div>' +
                        '</div> <!-- end col-->' +
                        '</div> <!-- end row -->' +
                        '</div> <!-- end card-box-->'

                    if (sessionStorage.getItem("level") != 'admin') {
                        $('#action_track').hide();
                        $('#action_' + [i]).hide();
                    }
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

function delete_container(id) {
    let text = "Press a button for delete!\nOK or Cancel.";
    if (confirm(text) == true) {
        $.ajax({
            method: "POST",
            dataType: "JSON",
            url: base_url + "/tracking/delete_container",
            data: {
                id_container: id,
            },
            beforeSend: function () {
                loadingPannel.show();
            },
            success: function (response) {
                console.log(response);
                location.reload()
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

function change_port_type() {

    if ($("#port_type").val() == 'direct') {
        $("#port_name").attr('disabled', ''); //disable.
        $("#port_name").addClass('bg-light'); //disable.
    } else {
        $("#port_name").removeAttr('disabled', ''); //disable.
        $("#port_name").removeClass('bg-light', ''); //disable.
    }
}

function table_edit_activity() {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        data: {
            noref_track_shipment: $("#noref_track_shipment").val(),
        },
        url: base_url + "/tracking/table_edit_activity",
        beforeSend: function () {
            loadingPannel.show();
        },
        success: function (response) {

            var data = []
            for (let i = 0; i < response.length; i++) {
                data.push([i + 1, response[i].activity, '<a href="javascript:void(0);" class="action-icon" onClick="delete_activity_event(' + response[i].id + ')"> <i class="mdi mdi-delete"></i></a>']);
            }

            $('#table_edit_activity').DataTable().destroy();
            $('#table_edit_activity').DataTable({
                searching: false,
                data: data,
                pageLength: 10,
                lengthChange: false
            });
        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Error!: " + errorThrown);
    });
}

function delete_activity_event(id) {
    let text = "Press a button for delete!\nOK or Cancel.";
    if (confirm(text) == true) {
        $.ajax({
            method: "POST",
            dataType: "JSON",
            url: base_url + "/tracking/delete_activity_event",
            data: {
                id_tracking_event: id,
            },
            beforeSend: function () {
                loadingPannel.show();
            },
            success: function (response) {
                console.log(response);
                location.reload()
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

function validation_add_document() {
    id_to_validation = ['file_document']

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

    if (data_input_array.length == id_to_validation.length) {
        add_data_document()
    }
}

function add_data_document() {

    let formData = new FormData();
    formData.append('noref_track_shipment', $("#noref_track_shipment").val());

    var fileupload = $('#file_document')[0];
    $.each(fileupload.files, function (k, file) {
        formData.append('fileupload[]', file);
    });

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/tracking/add_data_document",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            loadingPannel.show();
        },
        success: function (response) {
            $("#add-document-modal").modal("hide");
            table_document($("#noref_track_shipment").val())

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function validation_add_container() {
    id_to_validation = ['container_number_new']

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

    if (data_input_array.length == id_to_validation.length) {
        add_data_container()
    }
}

function add_data_container() {

    let formData = new FormData();
    formData.append('noref_track_shipment', $("#noref_track_shipment").val());
    formData.append('bl_number', $("#bl_number_head").text());
    formData.append('container_number', $("#container_number_new").val());

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "/tracking/add_data_container",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            loadingPannel.show();
        },
        success: function (response) {
            $("#add-container-modal").modal("hide");
            location.reload();

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function table_document(noref) {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        data: {
            noref_track_shipment: noref,
        },
        url: base_url + "/tracking/table_document",
        beforeSend: function () {
            loadingPannel.show();
        },
        success: function (response) {

            $('#count_document').text(response.length);

            var data = []
            for (let i = 0; i < response.length; i++) {
                data.push([i + 1, response[i].file_name, '<a href="' + base_url + '/assets/document/trackingShipment/' + response[i].file_name + '" class="action-icon" target="_blank"> <i class="mdi mdi-square-edit-outline"></i></a> <a href="javascript:void(0);" class="action-icon" onClick="delete_file_document(' + response[i].id + ')"> <i class="mdi mdi-delete"></i></a>']);
            }

            $('#table_document').DataTable().destroy();
            $('#table_document').DataTable({
                searching: false,
                data: data,
                pageLength: 10,
                lengthChange: false
            });
        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Error!: " + errorThrown);
    });
}

function delete_file_document(id) {
    let text = "Press a button for delete!\nOK or Cancel.";
    if (confirm(text) == true) {
        $.ajax({
            method: "POST",
            dataType: "JSON",
            url: base_url + "/tracking/delete_file_document",
            data: {
                id_document: id,
            },
            beforeSend: function () {
                loadingPannel.show();
            },
            success: function (response) {
                table_document($("#noref_track_shipment").val())

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