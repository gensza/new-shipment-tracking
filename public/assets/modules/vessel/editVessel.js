$(document).ready(function () {

    loading_processing()
    get_data_vessel()

});

function get_data_vessel() {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/get_data_vessel_by_id",
        data: {
            id_vessel: id_vessel
        },
        beforeSend: function () {
            loadingPannel.show()
        },
        success: function (response) {

            console.log(response);

            get_shipping_line(response.shipping_line)
            get_port_line(response.origin, response.destination)

            if (response.trans_loading == 'Transshipment') {

                var html = '<option value="Transshipment" selected>Transshipment</option>';
                html += '<option value="Direct">Direct</option>';

                $('.div_table_transit').show();
                table_transshipment(response.noref)

            } else {

                var html = '<option value="Transshipment">Transshipment</option>';
                html += '<option value="Direct" selected>Direct</option>';
                $('.div_table_transit').hide();

            }
            $('#trans_loading').html(html);

            $('#noref').val(response.noref);
            $('#id_vessel').val(response.id);
            $('#ship_name').val(response.ship_name);
            $('#ship_number').val(response.ship_number);
            $('#transit_day').val(response.transit_day);
            $('#date_etd').val(response.etd);
            $('#date_eta').val(response.eta);

            if (!response.logo || response.logo == null) {
                var logo_ship = base_url + '/assets/images/default-shipping.jpg';
            } else {
                var logo_ship = base_url + '/assets/document/logoShipping/' + response.logo;
            }

            var logo_img = '<img class="d-flex align-self-center mr-0" src="' + logo_ship + '" alt="Generic placeholder image" width="74" height="64" style="border-radius:5px;">'

            $("#logo_ship_head").html(logo_img)

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function validation_edit() {

    id_to_validation = ['shipping_line', 'trans_loading', 'ship_name', 'ship_number', 'date_etd', 'date_eta', 'origin', 'destination']

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
        edit_data_vessel()
    } else {
        console.log('Failed Validation!');
    }
}

function edit_data_vessel() {

    let formData = new FormData();

    var fileupload = $('#file_logo')[0];
    $.each(fileupload.files, function (k, file) {
        formData.append('fileupload[]', file);
    });

    formData.append('id', $('#id_vessel').val());
    formData.append('shipping_line', $('#shipping_line option:selected').text());
    formData.append('trans_loading', $('#trans_loading option:selected').text());
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
        url: base_url + "vessel/edit_data_vessel",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            loadingPannel.show();
        },
        success: function (response) {
            console.log(response);
            location.reload()
        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function get_trans_loading() {
    console.log($('#trans_loading').val());
    if ($('#trans_loading').val() == "Transshipment") {
        $('.div_table_transit').show();
    } else {
        $('.div_table_transit').hide();
    }
}

function validation_add_transshipment() {
    id_to_validation = ['port_name_new']

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
        add_data_transshipment()
    }
}

function add_data_transshipment() {

    let formData = new FormData();
    formData.append('noref', $("#noref").val());
    formData.append('port_name', $("#port_name_new option:selected").text());

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/add_data_transshipment",
        data: formData,
        processData: false,
        contentType: false,
        cache: false,
        beforeSend: function () {
            loadingPannel.show();
        },
        success: function (response) {
            $("#add-transshipment-modal").modal("hide");
            table_transshipment($('#noref').val())

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function get_shipping_line(shipping_line) {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/get_shipping_line",
        beforeSend: function () {
        },
        success: function (response) {

            var html3 = '<option value="">--select shipping line--</option>';
            for (k = 0; k < response.length; k++) {
                if (shipping_line == response[k].shipping_name) {
                    html3 += '<option value=' + response[k].shipping_name + ' selected>' + response[k].shipping_name + '</option>';
                } else {
                    html3 += '<option value=' + response[k].shipping_name + '>' + response[k].shipping_name + '</option>';
                }
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

function get_port_line(origin, destination) {
    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/get_port_line",
        beforeSend: function () {
        },
        success: function (response) {

            var html2 = '<option value="">--select port line--</option>';
            for (k = 0; k < response.length; k++) {
                if (origin == response[k].port_name) {
                    html2 += '<option value=' + response[k].port_name + ' selected>' + response[k].port_name + '</option>';
                } else {
                    html2 += '<option value=' + response[k].port_name + '>' + response[k].port_name + '</option>';
                }
            }
            $('#origin').html(html2);

            var html3 = '<option value="">--select port line--</option>';
            for (l = 0; l < response.length; l++) {
                if (destination == response[l].port_name) {
                    html3 += '<option value=' + response[l].port_name + ' selected>' + response[l].port_name + '</option>';
                } else {
                    html3 += '<option value=' + response[l].port_name + '>' + response[l].port_name + '</option>';
                }
            }
            $('#destination').html(html3);

            var html4 = '<option value="">--select port line--</option>';
            for (l = 0; l < response.length; l++) {
                html4 += '<option value=' + response[l].port_name + '>' + response[l].port_name + '</option>';
            }
            $('#port_name_new').html(html4);

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function table_transshipment(noref) {

    $.ajax({
        method: "POST",
        dataType: "JSON",
        url: base_url + "vessel/get_data_transshipment",
        data: {
            noref: noref
        },
        beforeSend: function () {
        },
        success: function (response) {

            console.log(response);

            var data = []
            response.forEach((element, index) => {

                port_name = '<p style="margin:-5px!important;text-align:center">' + element.port_name + '</p>'
                aksi = '<a style="margin:-5px!important;text-align:center" href="javascript:void(0);" class="action-icon" onClick="delete_transshipment(' + element.id + ')"> <i class="mdi mdi-delete"></i></a>'
                data.push([port_name, aksi])
            });

            $('#table_transshipment').DataTable().destroy()
            $('#table_transshipment').DataTable({
                "bPaginate": false,
                "bLengthChange": false,
                "bFilter": true,
                "bInfo": false,
                "searching": false,
                data: data,
            });

        },
    }).done(function (data) {
        setTimeout(function () {
            loadingPannel.hide();
        }, 500);
    }).fail(function (jqXHR, textStatus, errorThrown) {
        alert("Unable to save new list order: " + errorThrown);
    });
}

function delete_transshipment(id) {
    let text = "Press a button for delete!\nOK or Cancel.";
    if (confirm(text) == true) {
        $.ajax({
            method: "POST",
            dataType: "JSON",
            url: base_url + "vessel/delete_transshipment",
            data: {
                id: id,
            },
            beforeSend: function () {
                loadingPannel.show();
            },
            success: function (response) {
                console.log(response);

                table_transshipment($('#noref').val())
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