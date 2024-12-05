$(document).ready(function () {

    $('.spbdate').on('keypress', function () {
        return false;
    });

    $('.full-column').on('click', '#export_excel', function () {
        exportMisReport('export', 'excel', $(this).attr('id'));
    });

    $('.full-column').on('click', '#columnFilter', function () {
        var str = '';
        $('.repoCellDivHeader').each(function () {
            var column_name = $(this).find('p').text();
            if (column_name && column_name !== 'Details') {
                var col_checked = '';
                if ($(this).is(':visible')) {
                    col_checked = 'checked';
                }
                str += `<label><input type="checkbox" class="filterColumn chk" ${col_checked}>${column_name}</label>`;
            }
        });
        $('#columnFilterData').html(str);
        $('#checkboxes').show();
    });

    $('.full-column').on('click', '.filterColumn', function () {
        var index = $('.filterColumn').index(this);
        if ($(this).is(':checked') === true) {
            $('.repoCellDivHeader:eq(' + (index) + '), .col' + (index + 1)).show();
        } else {
            $('.repoCellDivHeader:eq(' + (index) + '), .col' + (index + 1)).hide();
        }
    });

    $('.col-wrapper').on('change', '#report_type', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'report_type=' + curr.val();
            $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
            $('#mis_date').parent().addClass('hide');
            $('#mis_date').val('');
            $('#mis_report_date').parent().addClass('hide');
            $('#mis_report_date').val('');
            $.ajax({
                url: 'ajax/loadMisReportDates.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    setTimeout(function () {
                        if (data !== '-1') {
                            $('.containerDiv').html('');
                            $('#mis_report_date').html(data).parent().removeClass('hide');
                        } else {
                            var dataString = 'report_type=' + $('#report_type').val();
                            $.ajax({
                                url: 'ajax/loadMisReport.php',
                                data: dataString,
                                type: "POST",
                                success: function (data) {
                                    setTimeout(function () {
                                        $('.containerDiv').html(data);
                                        $('#edit_report, #export_excel, #columnFilter').show();
                                        $('#save_report').parent().hide();
                                    }, 400);
                                }
                            });
                        }
                    }, 400);
                }
            });
        } else {
            $('.containerDiv').html('');
            $('#edit_report, #export_excel, #columnFilter').hide();
            $('#save_report').parent().hide();
            $('#mis_date').parent().addClass('hide');
            $('#mis_date').val('');
            $('#mis_report_date').parent().addClass('hide');
            $('#mis_report_date').val('');
        }
    });

    $('.col-wrapper').on('change', '#mis_report_date', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'report_type=' + $('#report_type').val() + '&mis_date=' + curr.val();
            $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
            $.ajax({
                url: 'ajax/loadMisReport.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    setTimeout(function () {
                        $('.containerDiv').html(data);
                        $('#edit_report, #export_excel, #columnFilter').show();
                        $('#save_report').parent().hide();
                    }, 400);
                }
            });
        } else {
            $('.containerDiv').html('');
            $('#edit_report, #export_excel, #columnFilter').hide();
            $('#save_report').parent().hide();
        }
    });

    $('.col-wrapper').on('click', '#edit_report', function () {
        var dataString = 'report_type=' + $('#report_type').val() + '&mis_date=' + $('#mis_report_date').val();
        $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
        $.ajax({
            url: 'ajax/loadEditMisReport.php',
            data: dataString,
            type: "POST",
            success: function (data) {
                setTimeout(function () {
                    $('.containerDiv').html(data);
                    $('#edit_report').hide();
                    $('#save_report').parent().show();
                    $('#mis_date').parent().removeClass('hide');
                    $('#mis_report_date').parent().addClass('hide');
                }, 400);
            }
        });
    });

    $('.col-wrapper').on('click', '#cancel_report', function () {
        var dataString = 'report_type=' + $('#report_type').val() + '&mis_date=' + $('#mis_report_date').val();
        $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
        $.ajax({
            url: 'ajax/loadMisReport.php',
            data: dataString,
            type: "POST",
            success: function (data) {
                setTimeout(function () {
                    $('.containerDiv').html(data);
                    $('#save_report').parent().hide();
                    $('#edit_report, #export_excel, #columnFilter').show();
                    $('#mis_date').parent().addClass('hide');
                    $('#mis_date').val('');
                    if ($('#mis_report_date').val()) {
                        $('#mis_report_date').parent().removeClass('hide');
                    } else {
                        $('#mis_report_date').parent().addClass('hide');
                    }
                }, 400);
            }
        });
    });

    $('.col-wrapper').on('click', '#save_report', function () {
        if ($('#mis_date').val() === '') {
            printError('Please select report date', 3000, '', '');
            return false;
        }
        $('.act_btn_ovrly').show();
        $("#rfrm").on('submit', function (event) {
            event.preventDefault();
            var postData = new FormData(this);
            postData.append('report_type', $('#report_type').val());
            postData.append('mis_date', $('#mis_date').val());
            postData.append('action', 'save_mis_report');
            var formURL = "action/lamsAction.php";
            $('#save_report').find('p').text('Please wait...');
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                processData: false,
                contentType: false,
                success: function (data, textStatus, jqXHR) {
                    unsaved = false;
                    var response_data = JSON.parse(data);
                    if (response_data['status'] === '1') {
                        $('.act_btn_ovrly').hide();
                        (async () => {
                            printSuccess(response_data['message'], 2000, '', '');
                            await new Promise((resolve) => {
                                var date = $('#mis_date').val();
                                var newdate = date.split("-").reverse().join("-");
                                $('#mis_report_date').append('<option value="' + date + '">' + date + '</option>');
                                $('#mis_report_date').val(newdate);
                                var dataString = 'report_type=' + $('#report_type').val() + '&mis_date=' + $('#mis_report_date').val();
                                $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
                                $.ajax({
                                    url: 'ajax/loadMisReport.php',
                                    data: dataString,
                                    type: "POST",
                                    success: function (data) {
                                        setTimeout(function () {
                                            $('.containerDiv').html(data);
                                            $('#save_report').parent().hide();
                                            $('#edit_report, #export_excel, #columnFilter').show();
                                            $('#mis_date').parent().addClass('hide');
                                            $('#mis_date').val('');
                                            $('#mis_report_date').parent().removeClass('hide');
                                        }, 400);
                                    }
                                });
                            });
                        })();
                    } else {
                        printError('Some problem occurred.', 3000, '', '');
                    }
                },
                error: function (xhr, status, error) {
                    printError(handleAjaxError(xhr), 3000, 'reload', '');
                }
            });
            e.preventDefault();	//STOP default action
        });
        $("#rfrm").submit(); //SUBMIT FORM
    });

    $('.col-wrapper').on('click', '.report_feedback', function () {
        var curr = $(this);
        var resource_type = curr.attr('id');
        var report_type = curr.attr('report_type');
        var village_code = $('#village_code').length ? $('#village_code').val() : '';
        var village_gata = $('#village_gata').length ? $('#village_gata').val().replace(/ /g, '%20') : '';
        var report_no = $('#report_type').length ? $('#report_type').val() : '';
        var title = 'Feedback'.replace(/ /g, '%20');
        var text = 'Are you satisfied with the report ?'.replace(/ /g, '%20');
        var remarks = 'yes';
        var remarks_enabled = 'no';
        var remarks_mandatory = '';
        var btn_id = 'send_report_feedback';
        var btn_name = 'Send'.replace(/ /g, '%20');
        if (resource_type === '6') {
            if (report_no === '') {
                printError("Please select report type.", 3000, '', '');
                return false;
            }
        }
        $('#popup').load('popup/confirmPopup.php?title=' + title + '&btn_id=' + btn_id + '&btn_name=' + btn_name + '&text=' + text + '&remarks=' + remarks + '&remarks_enabled=' + remarks_enabled + '&remarks_mandatory=' + remarks_mandatory + '&resource_type=' + resource_type + '&report_type=' + report_type + '&village_code=' + village_code + '&village_gata=' + village_gata + '&report_no=' + report_no, function () {
            $('#popup').show();
            makeDragable('.popup-header', '.popup-wrap');
        });
    });

    $('#popup').on('change', '.chk_report_feedback', function () {
        if ($(this).val() === '1') {
            $('#message_txt').closest('.remarks_div').addClass('hide');
        } else {
            $('#message_txt').closest('.remarks_div').removeClass('hide');
        }
    });

    $('#popup').on('click', '#send_report_feedback', function () {
        var check = 0;
        var fldrequired_index_arr = [];
        $(".fldrequired").each(function (index) {
            $(".frm-txtbox").removeClass("frm-focus");
            if ($(this).val() === "") {
                fldrequired_index_arr.push(index);
                check++;
                $(this).addClass("frm-error");
                $(this).closest(".dev_req_msg").find(".frm-er-msg").text("This field is required");
            } else {
                $(this).closest(".dev_req_msg").next(".frm-er-msg").text("");
                $(this).removeClass("frm-error");
            }
        });
        if (check > 0) {
            var idx = fldrequired_index_arr.indexOf(Math.min.apply(null, fldrequired_index_arr));
            fldrequired_index_arr[idx];
            $('html, body').animate({
                scrollTop: $(".fldrequired:eq(" + fldrequired_index_arr[idx] + ")").offset().top - 100
            }, 500, function () {
                $(".fldrequired:eq(" + fldrequired_index_arr[idx] + ")").focus();
            });
            return false;
        } else {
            $('#confrm').find('.frm_hidden_data').html('');
            $('#confrm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="send_report_feedback" autocomplete="off">');
            $('#confrm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/lamsAction" autocomplete="off">');
            $('#confrm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#send_report_feedback" autocomplete="off">');
            $('#confrm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="Send" autocomplete="off">');
            $('#confrm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="" autocomplete="off">');
            $('#confrm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="" autocomplete="off">');
            $('#confrm').submit();
        }
    });

    $("#popup").on('submit', '#confrm', function (e) {
        var postData = new FormData(this);
        var action_btn_id = $('input[name="action_btn_id"]').val();
        var action_btn_name = $('input[name="action_btn_name"]').val();
        var action_url = $('input[name="action_url"]').val();
        var after_success_action = $('input[name="after_success_action"]').val();
        var after_success_redirect = $('input[name="after_success_redirect"]').val();
        var param = '';
        var formURL = action_url;
        $('.act_btn_ovrly').show();
        $(action_btn_id).text('Please wait...');
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                console.log(data);
                $(action_btn_id).text(action_btn_name);
                var response_data = JSON.parse(data);
                if (response_data['status'] === '-1') {
                    printError(response_data['message'], 3000, '', '');
                } else if (response_data['status'] === '1') {
                    if (after_success_redirect === '') {
                        printSuccess(response_data['message'], 2000, after_success_action, after_success_redirect);
                        setTimeout(function () {
                            $('#popup').html('').hide();
                        }, 2000);
                    } else {
                        printSuccess(response_data['message'], 2000, after_success_action, after_success_redirect);
                    }
                } else if (response_data['status'] === '0') {
                    printError(response_data['message'], 3000, 'reload', '');
                } else {
                    printError(response_data['message'], 3000, 'reload', '');
                }
            },
            error: function (xhr, status, error) {
                printError(handleAjaxError(xhr), 3000, after_success_action, after_success_redirect);
            }
        });
        e.preventDefault();
    });

    $(document).mouseup(function (e) {
        var container = $("#checkboxes");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
        }
    });
});

function exportMisReport(exportlist, export_type, type) {
    var column_arr = [];
    var column_head = [];
    var fd = new FormData();
    fd.append('action', '');
    // check if any filter applied
    if ($('.filterchip').length) {
        getAppliedFilter($('#saveFilter').html());
        $('#popup').hide();
        var other_data = $('#ffrm').serializeArray();
        $.each(other_data, function (key, input) {
            fd.append(input.name, input.value);
        });
        fd.append('action', 'filter_applied');
    }
    fd.append('status', type);
    fd.append('exportlist', exportlist);
    fd.append('export_type', export_type);
    fd.append('report_type', $('#report_type').val());
    fd.append('mis_date', $('#mis_report_date').val());

    // check if any displayed columns exists
    if ($('.filterColumn').length === 0) {
        var str = '';
        $('.repoCellDivHeader').each(function () {
            var column_name = $(this).find('p').text();
            if (column_name && column_name !== 'Details') {
                var col_checked = '';
                if ($(this).is(':visible')) {
                    col_checked = 'checked';
                }
                str += `<label><input type="checkbox" class="filterColumn" ${col_checked}>${column_name}</label>`;
            }
        });
        $('#columnFilterData').html(str);
    }
    $('#columnFilterData').find('.filterColumn').each(function () {
        var index = $('.filterColumn').index(this);
        if ($(this).is(':checked') === true) {
            column_arr.push(index);
            column_head.push($(this).parent().text());
        }
    });
    fd.append('column_arr', column_arr);
    fd.append('column_head', column_head);
    if (export_type === 'excel') {
        $('.act_btn_ovrly').show();
        $('#export_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_mis_report.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_mis_report.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_mis_report.php";
    }
    $.ajax({
        type: "POST",
        url: formUrl,
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: function (data) {
            var response_data = JSON.parse(data);
            if (export_type === 'print') {
                window.open('printdocument?file=' + response_data['url'] + '&ftype=' + response_data['ftype'], '_blank');
            } else {
                if (export_type === 'excel') {
                    $('.act_btn_ovrly').hide();
                    $('#export_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('#export_excel').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}