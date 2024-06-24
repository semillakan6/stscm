$(document).ready(function () {
    $(".select2").select2();
    $(".fancybox").fancybox();
    $(".fancybox_images").fancybox({
        'titlePosition'  : 'over',
        'type': "image",
    })
});

document.addEventListener("DOMContentLoaded", function () {
    let alertElement = document.querySelector('meta[name="alert"]');
    let alert = alertElement
        ? JSON.parse(alertElement.getAttribute("content"))
        : null;

    if (alert && alert !== "no alert data") {
        Swal.fire({
            icon: alert.type,
            title: alert.type === "success" ? "Exito!" : "Error...",
            text: alert.message,
        });
    }

    let alertTmpElement = document.querySelector('meta[name="alert_tmp"]');
    let alert_tmp = alertTmpElement
        ? JSON.parse(alertTmpElement.getAttribute("content"))
        : null;
    let timerInterval;

    if (alert_tmp && alert_tmp !== "no alert-tmp data") {
        Swal.fire({
            icon: alert_tmp.type,
            title: alert_tmp.type === "success" ? "Exito" : "Atencion",
            html:
                alert_tmp.message +
                ". <br/> Me cerrare en <b></b> millisegundos.",
            timer: 3000,
            timerProgressBar: true,
            didOpen: () => {
                Swal.showLoading();
                const timer = Swal.getPopup().querySelector("b");
                timerInterval = setInterval(() => {
                    timer.textContent = `${Swal.getTimerLeft()}`;
                }, 100);
            },
            willClose: () => {
                clearInterval(timerInterval);
            },
        }).then((result) => {
            /* Read more about handling dismissals below */
            if (result.dismiss === Swal.DismissReason.timer) {
            }
        });
    }

    window.handleRadioChange = function () {
        // Get references for the radio buttons
        const radioPDF = $("#radioPDF");
        // Get references for the input fields
        const office_pdf = $("#office_pdf");
        const order_addon_text = $("#order_addon_text");
        const signature_entrega = $("#signature_entrega");
        const signature_entrega2 = $("#signature_entrega2");
        const signature_entrega3 = $("#signature_entrega3");

        if (radioPDF.is(":checked")) {
            // Enable the PDF input and disable the text area
            office_pdf.prop("disabled", true);
            office_pdf.addClass("disabled");
            order_addon_text.prop("disabled", false);
            order_addon_text.removeClass("disabled");
            signature_entrega.prop("disabled", false);
            signature_entrega2.prop("disabled", false);
            signature_entrega3.prop("disabled", false);
            // Clear the PDF input
            office_pdf.val("");

        } else {
            // Enable the text area and disable the PDF input

            office_pdf.prop("disabled", false);
            signature_entrega.prop("disabled", true);
            signature_entrega2.prop("disabled", true);
            signature_entrega3.prop("disabled", true);
            order_addon_text.addClass("disabled");
            order_addon_text.prop("disabled", true);
        }
    };
    window.handleRadioChangeDiagnosis = function () {
        // Get references for the radio buttons
        const radioAnexo = $("#radioAnexo");
        const diagnosis_pdf = $("#diagnosis_pdf");
        const order_diagnosis_text = $("#order_diagnosis_text");
        const order_diagnosis_cost = $("#order_diagnosis_cost");

        if (radioAnexo.is(":checked")) {
            // Enable the PDF input and disable the text area
            diagnosis_pdf.prop("disabled", true);
            diagnosis_pdf.addClass("disabled");
            order_diagnosis_text.prop("disabled", false);
            order_diagnosis_text.removeClass("disabled");
            order_diagnosis_cost.prop("disabled", false);
            order_diagnosis_cost.removeClass("disabled");
            diagnosis_pdf.val("");

        } else {
            // Enable the text area and disable the PDF input
            diagnosis_pdf.prop("disabled", false);
            order_diagnosis_text.prop("disabled", true);
            order_diagnosis_text.addClass("disabled");
            order_diagnosis_cost.prop("disabled", true);
            order_diagnosis_cost.addClass("disabled");
        }
    };
    window.handleRadioChangeRepair = function () {
        // Get references for the radio buttons
        const radioAnexo = $("#radioAnexo");
        const delivery_pdf = $("#delivery_pdf");
        const order_repair_text = $("#order_repair_text");

        if (radioAnexo.is(":checked")) {
            // Enable the PDF input and disable the text area
            delivery_pdf.prop("disabled", true);
            delivery_pdf.addClass("disabled");
            order_repair_text.prop("disabled", false);
            order_repair_text.removeClass("disabled");
            delivery_pdf.val("");

        } else {
            // Enable the text area and disable the PDF input
            delivery_pdf.prop("disabled", false);
            order_repair_text.prop("disabled", true);
            order_repair_text.addClass("disabled");
        }
    };
});

function showModal(data, callback) {
    Swal.fire({
        title: data.title,
        html: data.content,
        width: data.width || 600,
        padding: data.padding || "3em",
        background: data.background || "#fff",
        showConfirmButton: data.confirm||false,
        showCloseButton: data.close||false,
        allowOutsideClick: data.outside === undefined ? true : data.outside,
        allowEscapeKey: data.escape === undefined ? true : data.escape,
        didOpen: () => {
            if (typeof callback === "function") {
                callback();
                console.log("Calling back...");
            }
            $('.select2').select2();
        },
    });
}

function dynamicLoad(route, target) {
    $.ajax({
        type: "get",
        url: route,
        success: function (data) {
            var response = $(data).find("#main").html();
            $(target).fadeOut(200, function () {
                $(this).html(response).fadeIn(200);
            });
            if (typeof callback === "function") {
                callback();
                console.log("Calling back...");
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            console.error(`AJAX Error: ${textStatus}: ${errorThrown}`);
        },
    });
}

function dynamicDelFunc(url, id) {
    var csrf_token = $('meta[name="csrf-token"]').attr("content"); // Fetching the CSRF token
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": csrf_token,
        },
    });

    // Sweet Alert 2 for confirmation
    Swal.fire({
        title: "¿Estas seguro que deseas eliminarlo?",
        text: "Los registros eliminados se conservan en el sistema, pero no se vuelven a mostrar",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "red",
        cancelButtonColor: "black",
        confirmButtonText: "Borrar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: url,
                data: {
                    id: id,
                },
                dataType: "json",
                success: function (response) {
                    if (response.message === "1") {
                        // Sweet Alert message
                        Swal.fire(
                            "Success",
                            "Registro eliminado exitosamente",
                            "success"
                        ).then((value) => {
                            location.reload(); // Reload the page after the alert is closed
                        });
                    } else {
                        // Sweet Alert message
                        Swal.fire(
                            "Error",
                            "Error borrando el registro: " +
                            JSON.stringify(response),
                            "error"
                        ).then((value) => {
                            location.reload(); // Reload the page after the alert is closed
                        });
                    }
                },
            });
        }
    });
}

function dynamicAceptFunc(url, data, modal_info) {
    var csrf_token = $('meta[name="csrf-token"]').attr("content"); // Fetching the CSRF token
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": csrf_token,
        },
    });

    // Sweet Alert 2 for confirmation
    Swal.fire({
        title: modal_info.title,
        text: modal_info.text,
        icon: modal_info.icon,
        showCancelButton: true,
        confirmButtonColor: "red",
        cancelButtonColor: "black",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.message === "1") {
                        // Sweet Alert message
                        Swal.fire(
                            "Success",
                            "Registro realizado con exito",
                            "success"
                        ).then((value) => {
                            location.reload(); // Reload the page after the alert is closed
                        });
                    } else {
                        // Sweet Alert message
                        Swal.fire(
                            "Error",
                            "Error al realizar el registro: " +
                            JSON.stringify(response),
                            "error"
                        ).then((value) => {
                            location.reload(); // Reload the page after the alert is closed
                        });
                    }
                },
            });
        }
    });
}
function succesModal(data) {
    Swal.fire({
        position: "center",
        icon: "success",
        title: data.title,
        showConfirmButton: false,
        timer: 1000,
    });
}

function destroy_table(tables_todelete) {
    tables_todelete.forEach(function (table_delete) {
        if ($.fn.DataTable.isDataTable(table_delete)) {
            $(table_delete).DataTable().destroy();
        }
    });
}

function dynamicAceptFuncDinamicResponses(url, data, modal_info) {
    var csrf_token = $('meta[name="csrf-token"]').attr("content"); // Fetching the CSRF token
    $.ajaxSetup({
        headers: {
            "X-CSRF-TOKEN": csrf_token,
        },
    });

    // Sweet Alert 2 for confirmation
    Swal.fire({
        title: modal_info.title,
        text: modal_info.text,
        icon: modal_info.icon,
        showCancelButton: true,
        confirmButtonColor: "red",
        cancelButtonColor: "black",
        confirmButtonText: "Aceptar",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                type: "POST",
                url: url,
                data: data,
                dataType: "json",
                success: function (response) {
                    if (response.message === "1") {
                        // Sweet Alert message
                        Swal.fire(
                            "Success",
                            "Registro realizado con exito",
                            "success"
                        ).then((value) => {
                            location.reload(); // Reload the page after the alert is closed
                        });;
                    } else {
                        // Sweet Alert message
                        Swal.fire(
                            "Error",
                            "Error al realizar el registro: " +
                            response.error,
                            "error"
                        );
                    }
                },
            });
        }
    });
}
