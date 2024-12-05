var aft;
$(document).ready(function () {

    $(".full-column").on("mouseover", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").show();
    });

    $(".full-column").on("mouseleave", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").hide();
    });

    $('.full-column').on('click', '#columnFilter', function () {
        if ($('#type1').val() === '3') {
            var str = '';
            $('.repoCellDivHeaderCenter').each(function () {
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
        } else {
            var str = '';
            $('.cellDivHeader').each(function () {
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
        }
    });

    $('.full-column').on('click', '.filterColumn', function () {
        if ($('#type1').val() === '3') {
            var index = $('.filterColumn').index(this);
            if ($(this).is(':checked') === true) {
                $('.repoCellDivHeaderCenter:eq(' + (index) + '), .col' + (index + 1)).show();
            } else {
                $('.repoCellDivHeaderCenter:eq(' + (index) + '), .col' + (index + 1)).hide();
            }
        } else {
            var index = $('.filterColumn').index(this);
            if ($(this).is(':checked') === true) {
                $('.cellDivHeader:eq(' + (index) + '), .col' + (index + 1)).show();
            } else {
                $('.cellDivHeader:eq(' + (index) + '), .col' + (index + 1)).hide();
            }
        }
    });

    $('#popup').on('click', '#columnFilter', function () {
        var str = '';
        $('#popup').find('.cellDivHeader').each(function () {
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

    $('#popup').on('click', '.filterColumn', function () {
        var index = $('.filterColumn').index(this);
        if ($(this).is(':checked') === true) {
            $('#popup').find('.cellDivHeader:eq(' + (index) + '), .col' + (index + 1)).show();
        } else {
            $('#popup').find('.cellDivHeader:eq(' + (index) + '), .col' + (index + 1)).hide();
        }
    });

    $('.full-column').on('click', '.perPage', function () {
        $(this).next('ul').toggle();
    });

    $('.full-column').on('click', '.setPage', function () {
        $('#pagelimit').val($(this).text());
        $('.perPage').text($(this).text());
        $(this).closest('ul').toggle();
        loadMoreVillageReport(0);
    });

    $('.full-column').on('click', '.export_village_report_excel', function () {
        if ($('#type1').val() === '1') {
            exportConsolidateVillageReport('export', 'excel', $(this).attr('id'));
        } else if ($('#type1').val() === '2') {
            if ($('#village_code').val()) {
                if ($('#report_type').val()) {
                    exportVillageReport('export', 'excel', $(this).attr('id'));
                } else {
                    printError("Please select report type.", 3000, '', '');
                }
            } else {
                printError("Please select village.", 3000, '', '');
            }
        } else if ($('#type1').val() === '3') {
            exportGridVillageReport('export', 'excel', $(this).attr('id'));
        } else if ($('#type1').val() === '4') {
            exportBainamaReport('export', 'excel', $(this).attr('id'));
        } else {
            printError("Please select something.", 3000, '', '');
        }
    });
    
    $('.full-column').on('click', '.export_village_report_pdf', function () {
        if ($('#type1').val() === '1') {
            exportConsolidateVillageReport('export', 'pdf', $(this).attr('id'));
        } else if ($('#type1').val() === '2') {
            printError("PDF not available.", 3000, '', '');
        } else if ($('#type1').val() === '3') {
            printError("PDF not available.", 3000, '', '');
        } else if ($('#type1').val() === '4') {
            printError("PDF not available.", 3000, '', '');
        } else {
            printError("Please select something.", 3000, '', '');
        }
    });

    $('.full-column').on('click', '.export_gata_report_excel', function () {
        if ($('#village_code').val()) {
            if ($('#type2').val() === '1') {
                exportConsolidateGataReport('export', 'excel', $(this).attr('id'));
            } else if ($('#type2').val() === '2') {
                if ($('#village_gata').val()) {
                    exportGataReport('export', 'excel', $(this).attr('id'));
                } else {
                    printError("Please select gata.", 3000, '', '');
                }
            } else {
                printError("Please select something.", 3000, '', '');
            }
        } else {
            printError("Please select village.", 3000, '', '');
        }
    });
    
    $('.full-column').on('click', '.export_gata_report_pdf', function () {
        if ($('#village_code').val()) {
            if ($('#type2').val() === '1') {
                exportConsolidateGataReport('export', 'excel', $(this).attr('id'));
            } else if ($('#type2').val() === '2') {
                if ($('#village_gata').val()) {
                    exportGataReport('export', 'pdf', $(this).attr('id'));
                } else {
                    printError("Please select gata.", 3000, '', '');
                }
            } else {
                printError("Please select something.", 3000, '', '');
            }
        } else {
            printError("Please select village.", 3000, '', '');
        }
    });

    $('.full-column').on('click', '#selectAll', function () {
        if ($(this).is(':checked') === true) {
            $('.chkBox').attr('checked', 'checked');
        } else {
            $('.chkBox').removeAttr('checked');
        }
    });

    // Reports
    $('.col-wrapper').on('change', '#type', function () {
        if ($('#type').val() === '2') {
            $('#village_code').parent().removeClass('hide');
            $('#village_code').val('');
            $('#type2').val('');
            $('#type2').parent().addClass('hide');
            $('#village_gata').html('');
            $('#village_gata').val('');
            $('#village_gata').parent().addClass('hide');
            $('#type1').parent().addClass('hide');
            $('#type1').val('');
            $('#report_type').val('');
            $('#report_type').parent().addClass('hide');
            $('#disp_row_count').html('');
            $('#all').removeClass('export_village_report_excel');
            $('#all').addClass('export_gata_report_excel');
            $('#allpdf').removeClass('export_village_report_pdf');
            $('#allpdf').addClass('export_gata_report_pdf');
            $('.report_feedback').attr('report_type', 'gata_wise');
        } else {
            $('#type1').parent().removeClass('hide');
            $('#village_code').parent().addClass('hide');
            $('#village_code').val('');
            $('#type2').val('');
            $('#type2').parent().addClass('hide');
            $('#village_gata').html('');
            $('#village_gata').val('');
            $('#village_gata').parent().addClass('hide');
            $('#type1').val('');
            $('#disp_row_count').html('');
            $('#report_type').val('');
            $('#report_type').parent().addClass('hide');
            $('#all').removeClass('export_gata_report_excel');
            $('#all').addClass('export_village_report_excel');
            $('#allpdf').removeClass('export_gata_report_pdf');
            $('#allpdf').addClass('export_village_report_pdf');
            $('.report_feedback').attr('report_type', 'village_wise');
            $('.containerDiv').parent().addClass('scrl-tblwrap');
            $('.containerDiv').parent().removeClass('scrl-repo-tblwrap');
            $('.containerDiv').css('table-layout', '');
        }
        $('.containerDiv').html('');
    });

    $('.col-wrapper').on('change', '#type1', function () {
        $('.containerDiv').html('');
        if ($('#type1').val() === '1') {
            $('#report_type').val('');
            $('#report_type').parent().addClass('hide');
            $('#village_code').parent().addClass('hide');
            $('#village_code').val('');
            $('#type2').val('');
            $('#type2').parent().addClass('hide');
            $('#village_gata').html('');
            $('#village_gata').val('');
            $('#village_gata').parent().addClass('hide');
            $('#disp_row_count').html('');
            var curr = $(this);
            if (curr.val()) {
                var dataString = 'type=' + curr.val();
                $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
                $.ajax({
                    url: 'ajax/loadConsolidateVillageReport.php',
                    data: dataString,
                    type: "POST",
                    success: function (data) {
                        setTimeout(function () {
                            $('.containerDiv').parent().addClass('scrl-tblwrap');
                            $('.containerDiv').parent().removeClass('scrl-repo-tblwrap');
                            $('.containerDiv').css('table-layout', '');
                            $('.containerDiv').html(data);
                        }, 400);
                    }
                });
            } else {
                $('.containerDiv').html('');
            }
        } else if ($('#type1').val() === '2') {
            $('#report_type').val('');
            $('#report_type').parent().addClass('hide');
            $('#village_code').parent().removeClass('hide');
            $('#village_code').val('');
            $('#type2').val('');
            $('#type2').parent().addClass('hide');
            $('#village_gata').html('');
            $('#village_gata').val('');
            $('#disp_row_count').html('');
            $('#village_gata').parent().addClass('hide');
            $('.containerDiv').parent().addClass('scrl-tblwrap');
            $('.containerDiv').parent().removeClass('scrl-repo-tblwrap');
            $('.containerDiv').css('table-layout', '');
        } else if ($('#type1').val() === '3') {
            $('#report_type').val('');
            $('#report_type').parent().addClass('hide');
            $('#village_code').parent().addClass('hide');
            $('#village_code').val('');
            $('#type2').val('');
            $('#type2').parent().addClass('hide');
            $('#village_gata').html('');
            $('#village_gata').val('');
            $('#disp_row_count').html('');
            $('#village_gata').parent().addClass('hide');
            var curr = $(this);
            if (curr.val()) {
                var dataString = 'type=' + curr.val();
                $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
                $.ajax({
                    url: 'ajax/loadGridVillageReport.php',
                    data: dataString,
                    type: "POST",
                    success: function (data) {
                        setTimeout(function () {
                            $('.containerDiv').parent().removeClass('scrl-tblwrap');
                            $('.containerDiv').parent().addClass('scrl-repo-tblwrap');
                            $('.containerDiv').css('table-layout', 'fixed');
                            $('.containerDiv').html(data);
                        }, 400);
                    }
                });
            } else {
                $('.containerDiv').parent().addClass('scrl-tblwrap');
                $('.containerDiv').parent().removeClass('scrl-repo-tblwrap');
                $('.containerDiv').css('table-layout', '');
                $('.containerDiv').html('');
            }
        } else if ($('#type1').val() === '4') {
            $('#report_type').val('');
            $('#report_type').parent().addClass('hide');
            $('#village_code').parent().addClass('hide');
            $('#village_code').val('');
            $('#type2').val('');
            $('#type2').parent().addClass('hide');
            $('#village_gata').html('');
            $('#village_gata').val('');
            $('#village_gata').parent().addClass('hide');
            $('#disp_row_count').html('');
            var curr = $(this);
            if (curr.val()) {
                var dataString = 'type=' + curr.val();
                $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
                $.ajax({
                    url: 'ajax/loadBainamaReport.php',
                    data: dataString,
                    type: "POST",
                    success: function (data) {
                        setTimeout(function () {
                            $('.containerDiv').parent().addClass('scrl-tblwrap');
                            $('.containerDiv').parent().removeClass('scrl-repo-tblwrap');
                            $('.containerDiv').css('table-layout', '');
                            $('.containerDiv').html(data);
                        }, 400);
                    }
                });
            } else {
                $('.containerDiv').html('');
            }
        } else {
            $('#disp_row_count').html('');
            $('#report_type').val('');
            $('#report_type').parent().addClass('hide');
            $('#village_code').parent().addClass('hide');
            $('#village_code').val('');
            $('#type2').val('');
            $('#type2').parent().addClass('hide');
            $('#village_gata').html('');
            $('#village_gata').val('');
            $('#village_gata').parent().addClass('hide');
            $('.containerDiv').parent().addClass('scrl-tblwrap');
            $('.containerDiv').parent().removeClass('scrl-repo-tblwrap');
            $('.containerDiv').css('table-layout', '');
        }
    });

    $('.col-wrapper').on('change', '#village_code', function () {
        var curr = $(this);
        if ($('#type').val() === '1') {
            $('#report_type').val('');
            $('#report_type').parent().removeClass('hide');
        } else if ($('#type').val() === '2') {
            if (curr.val()) {
                $('#report_type').val('');
                $('#report_type').parent().addClass('hide');
                $('#type2').val('');
                $('#type2').parent().removeClass('hide');
                $('#village_gata').html('');
                $('#village_gata').parent().addClass('hide');
                $('.containerDiv').html('');
            } else {
                $('#report_type').val('');
                $('#report_type').parent().addClass('hide');
                $('#type2').parent().addClass('hide');
                $('#village_gata').html('');
                $('#village_gata').parent().addClass('hide');
                $('.containerDiv').html('');
            }
        } else {
            $('#type2').parent().addClass('hide');
        }
    });

    $('.col-wrapper').on('change', '#type2', function () {
        if ($('#type2').val() === '1') {
            $('#village_gata').html('');
            $('#village_gata').parent().addClass('hide');
            var curr = $(this);
            if (curr.val()) {
                var dataString = 'village_code=' + $('#village_code').val() + '&type=' + curr.val();
                $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
                $.ajax({
                    url: 'ajax/loadConsolidateGataReport.php',
                    data: dataString,
                    type: "POST",
                    success: function (data) {
                        setTimeout(function () {
                            $('.containerDiv').html(data);
                        }, 400);
                    }
                });
            } else {

            }
        } else if ($('#type2').val() === '2') {
            var dataString = 'village_code=' + $('#village_code').val() + '&type=1';
            $.ajax({
                url: 'ajax/getVillageGata.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    $('#village_gata').html(data);
                    $('#village_gata').parent().removeClass('hide');
                    $('.containerDiv').html('');
                }
            });
        } else {
            $('#village_gata').html('');
            $('#village_gata').parent().addClass('hide');
            $('.containerDiv').html('');
        }
    });

    $('.col-wrapper').on('change', '#village_gata', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'village_code=' + $('#village_code').val() + '&gata_no=' + curr.val();
            $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
            $.ajax({
                url: 'ajax/loadGataReport.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    setTimeout(function () {
                        $('.containerDiv').parent().removeClass('scrl-repo-tblwrap');
                        $('.containerDiv').parent().addClass('scrl-tblwrap');
                        $('.containerDiv').html(data);
                    }, 400);
                }
            });
        } else {
            $('.containerDiv').parent().removeClass('scrl-repo-tblwrap');
            $('.containerDiv').parent().addClass('scrl-tblwrap');
            $('.containerDiv').html('');
        }
    });

    $('.col-wrapper').on('change', '#report_type', function () {
        var curr = $(this);
        if (curr.val() && $('#village_code').val()) {
            var dataString = 'village_code=' + $('#village_code').val() + '&report_type=' + curr.val();
            $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
            $.ajax({
                url: 'ajax/loadVillageReport.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    //console.log(data);
                    setTimeout(function () {
                        $('.containerDiv').html(data);
                        $('#disp_row_count').text($('#total_count').val() + ' records found');
                    }, 400);
                }
            });
        } else if ($('#village_code').val() === '') {
            $('#report_type').val('');
            printError("Please select village.", 3000, '', '');
            $('.containerDiv').html('');
            $('#disp_row_count').text('');
        } else {
            $('#report_type').val('');
            $('.containerDiv').html('');
            $('#disp_row_count').text('');
        }
    });

    $('.col-wrapper').on('click', '.report_feedback', function () {
        var curr = $(this);
        var resource_type = curr.attr('id');
        var report_type = curr.attr('report_type');
        var village_code = $('#village_code').length ? $('#village_code').val() : '';
        var village_gata = ($('#type1').val() === '2' && $('#type2').val() === '2') ? ($('#village_gata').length ? $('#village_gata').val().replace(/ /g, '%20') : '') : '';
        var report_no = $('#report_type').length ? $('#report_type').val() : '';
        var title = 'Feedback'.replace(/ /g, '%20');
        var text = 'Are you satisfied with the report ?'.replace(/ /g, '%20');
        var remarks = 'yes';
        var remarks_enabled = 'no';
        var remarks_mandatory = '';
        var btn_id = 'send_report_feedback';
        var btn_name = 'Send'.replace(/ /g, '%20');
        if (resource_type === '4') {
            if (report_type === 'village_wise' && report_no === '') {
                printError("Please select village and report type.", 3000, '', '');
                return false;
            } else if (report_type === 'gata_wise') {
                if ($('#type1').val() === '1') {
                    $('#popup').load('popup/confirmPopup.php?title=' + title + '&btn_id=' + btn_id + '&btn_name=' + btn_name + '&text=' + text + '&remarks=' + remarks + '&remarks_enabled=' + remarks_enabled + '&remarks_mandatory=' + remarks_mandatory + '&resource_type=' + resource_type + '&report_type=' + report_type + '&village_code=' + village_code + '&village_gata=' + village_gata + '&report_no=' + report_no, function () {
                        $('#popup').show();
                        makeDragable('.popup-header', '.popup-wrap');
                    });
                } else if ($('#type1').val() === '2') {
                    if ($('#village_code').val()) {
                        if ($('#type2').val() === '1') {
                            $('#popup').load('popup/confirmPopup.php?title=' + title + '&btn_id=' + btn_id + '&btn_name=' + btn_name + '&text=' + text + '&remarks=' + remarks + '&remarks_enabled=' + remarks_enabled + '&remarks_mandatory=' + remarks_mandatory + '&resource_type=' + resource_type + '&report_type=' + report_type + '&village_code=' + village_code + '&village_gata=' + village_gata + '&report_no=' + report_no, function () {
                                $('#popup').show();
                                makeDragable('.popup-header', '.popup-wrap');
                            });
                        } else if ($('#type2').val() === '2') {
                            if ($('#village_gata').val()) {
                                $('#popup').load('popup/confirmPopup.php?title=' + title + '&btn_id=' + btn_id + '&btn_name=' + btn_name + '&text=' + text + '&remarks=' + remarks + '&remarks_enabled=' + remarks_enabled + '&remarks_mandatory=' + remarks_mandatory + '&resource_type=' + resource_type + '&report_type=' + report_type + '&village_code=' + village_code + '&village_gata=' + village_gata + '&report_no=' + report_no, function () {
                                    $('#popup').show();
                                    makeDragable('.popup-header', '.popup-wrap');
                                });
                            } else {
                                printError("Please select gata.", 3000, '', '');
                            }
                        } else {
                            printError("Please select something.", 3000, '', '');
                        }
                    } else {
                        printError("Please select village.", 3000, '', '');
                    }
                } else if ($('#type1').val() === '3') {
                    $('#popup').load('popup/confirmPopup.php?title=' + title + '&btn_id=' + btn_id + '&btn_name=' + btn_name + '&text=' + text + '&remarks=' + remarks + '&remarks_enabled=' + remarks_enabled + '&remarks_mandatory=' + remarks_mandatory + '&resource_type=' + resource_type + '&report_type=' + report_type + '&village_code=' + village_code + '&village_gata=' + village_gata + '&report_no=' + report_no, function () {
                        $('#popup').show();
                        makeDragable('.popup-header', '.popup-wrap');
                    });
                } else {
                    printError("Please select something.", 3000, '', '');
                }
                return false;
            } else if (report_type === 'gata_wise' && village_gata === '') {
                printError("Please select gata.", 3000, '', '');
                return false;
            }
        }
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
                //console.log(data);
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

    $('.col-wrapper').on('click', '.view_report_data', function () {
        $('.act_btn_ovrly').show();
        var curr = $(this);
        (async () => {
            $('#popup').html(`<div class="popup-overlay center-screen">
                                <div class="popup-wrap">
                                    <div class="popup-body pp-medium-y" id="log_content">
                                        <div class="form-field-wrap posrel">
                                            <div class="">
                                                <div class="slcdstc">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`);
            $('#popup').show();
            $('.slcdstc').html('<div class="medical-spinner" style="margin-top:35%; left:45%;" id="load"></div>');
            await new Promise((resolve) => {
                var report_data = curr.attr('id').replace('report_data_', '');
                var title = curr.closest('.rowDiv').find('.col2').text().replace(/ /g, '%20');
                $('#popup').load('popup/viewReportDataPopup.php?report_data=' + report_data + '&title=' + title, function () {
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    makeDragable('.popup-header', '.popup-wrap');
                    $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
                    var village_code_arr = [];
                    var area = 0;
                    var rakba = 0;
                    var opt_str = '<option value="">Select Village</option>';
                    $('#popup').find('.rowDiv').each(function () {
                        if ($(this).find('.col2').text()) {
                            var opt_name = $(this).find('.col1').text().trim();
                            var opt_value = $(this).find('.col2').text().trim();
                            if (village_code_arr.includes(opt_value) === false) {
                                opt_str += '<option value="' + opt_value + '">' + opt_name + '</option>';
                                village_code_arr.push(opt_value);
                            }
                        }
                        if (report_data === '5' || report_data === '6') {
                            if ($(this).find('.col6').text()) {
                                if (isNumeric($(this).find('.col6').text().trim())) {
                                    area += parseFloat($(this).find('.col6').text().trim());
                                }
                            }
                            if ($(this).find('.col8').text()) {
                                if (isNumeric($(this).find('.col8').text().trim())) {
                                    rakba += parseFloat($(this).find('.col8').text().trim());
                                }
                            }
                        }
                    });
                    $('#popup').find('#repo_filter_village_code').html(opt_str);
                    if (report_data === '5' || report_data === '6') {
                        var str = '<div><span style="font-weight:600;">Total area: </span>' + parseFloat(area).toFixed(3) + '</div>\n\
                                    <div><span style="font-weight:600;">Total rakba: </span>' + parseFloat(rakba).toFixed(3) + '</div>\n\
                                    <div><span style="font-weight:600;">Difference: </span>' + (parseFloat(area - rakba).toFixed(3)) + '</div>\n\
                                    ';
                        $('#additional_details').html(str);
                    }
                });
            });
        })();
    });

    $('#popup').on('change', '#repo_filter_village_code', function () {
        var report_data = $('#popup').find('#report_data').val();
        var village_code = $(this).val();
        var dataString = 'report_data=' + report_data + '&village_code=' + village_code;
        $('#popup').find('.containerDiv').addClass('height100');
        $('#popup').find('.containerDiv').html('<div class="medical-spinner" style="top:25%; left:50%;" id="load"></div>');
        //alert(dataString);
        $.ajax({
            url: 'ajax/filterConsolidateReportData.php',
            data: dataString,
            type: "POST",
            success: function (data) {
                //alert(data);
                $('#popup').find('.containerDiv').removeClass('height100');
                $('#popup').find('.containerDiv').html(data);
                $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
            }
        });
    });

    $('#popup').on('click', '.export_report_data_excel', function () {
        exportReportData('export', 'excel', $(this).attr('id'));
    });

    $('.col-wrapper').on('click', '.view_grid_data', function () {
        $('.act_btn_ovrly').show();
        var curr = $(this);
        (async () => {
            $('#popup').html(`<div class="popup-overlay center-screen">
                                <div class="popup-wrap">
                                    <div class="popup-body pp-medium-y" id="log_content">
                                        <div class="form-field-wrap posrel">
                                            <div class="">
                                                <div class="slcdstc">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`);
            $('#popup').show();
            $('.slcdstc').html('<div class="medical-spinner" style="margin-top:35%; left:45%;" id="load"></div>');
            await new Promise((resolve) => {
                var report_data = parseInt(curr.attr('id'));
                var village_code = curr.attr('village_code');
                var title = $('.containerDiv').find('.repoCellDivHeaderCenter:eq(' + (report_data + 1) + ')').find('p').text().replace(/ /g, '%20');
                $('#popup').load('popup/viewGridReportDataPopup.php?report_data=' + report_data + '&village_code=' + village_code + '&title=' + title, function () {
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    makeDragable('.popup-header', '.popup-wrap');
                    $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
                    var village_code_arr = [];
                    var area = 0;
                    var rakba = 0;
                    var opt_str = '<option value="">Select Village</option>';
                    $('#popup').find('.rowDiv').each(function () {
                        if ($(this).find('.col2').text()) {
                            var opt_name = $(this).find('.col1').text().trim();
                            var opt_value = $(this).find('.col2').text().trim();
                            if (village_code_arr.includes(opt_value) === false) {
                                opt_str += '<option value="' + opt_value + '" selected="selected">' + opt_name + '</option>';
                                village_code_arr.push(opt_value);
                            }
                        }
                        if (report_data === 5 || report_data === 6) {
                            if ($(this).find('.col6').text()) {
                                if (isNumeric($(this).find('.col6').text().trim())) {
                                    area += parseFloat($(this).find('.col6').text().trim());
                                }
                            }
                            if ($(this).find('.col8').text()) {
                                if (isNumeric($(this).find('.col8').text().trim())) {
                                    rakba += parseFloat($(this).find('.col8').text().trim());
                                }
                            }
                        }
                    });
                    $('#popup').find('#repo_filter_village_code').html(opt_str);
                    if (report_data === 5 || report_data === 6) {
                        var str = '<div><span style="font-weight:600;">Total area: </span>' + parseFloat(area).toFixed(3) + '</div>\n\
                                    <div><span style="font-weight:600;">Total rakba: </span>' + parseFloat(rakba).toFixed(3) + '</div>\n\
                                    <div><span style="font-weight:600;">Difference: </span>' + (parseFloat(area - rakba).toFixed(3)) + '</div>\n\
                                    ';
                        $('#additional_details').html(str);
                    }
                });
            });
        })();
    });

    $('.col-wrapper').on('click', '.view_grid_total_data', function () {
        $('.act_btn_ovrly').show();
        var curr = $(this);
        (async () => {
            $('#popup').html(`<div class="popup-overlay center-screen">
                                <div class="popup-wrap">
                                    <div class="popup-body pp-medium-y" id="log_content">
                                        <div class="form-field-wrap posrel">
                                            <div class="">
                                                <div class="slcdstc">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>`);
            $('#popup').show();
            $('.slcdstc').html('<div class="medical-spinner" style="margin-top:35%; left:45%;" id="load"></div>');
            await new Promise((resolve) => {
                var report_data = parseInt(curr.attr('id'));
                var title = $('.containerDiv').find('.repoCellDivHeaderCenter:eq(' + (report_data + 1) + ')').find('p').text().replace(/ /g, '%20');
                $('#popup').load('popup/viewReportDataPopup.php?report_data=' + report_data + '&title=' + title, function () {
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    makeDragable('.popup-header', '.popup-wrap');
                    $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
                    var village_code_arr = [];
                    var area = 0;
                    var rakba = 0;
                    var opt_str = '<option value="">Select Village</option>';
                    $('#popup').find('.rowDiv').each(function () {
                        if ($(this).find('.col2').text()) {
                            var opt_name = $(this).find('.col1').text().trim();
                            var opt_value = $(this).find('.col2').text().trim();
                            if (village_code_arr.includes(opt_value) === false) {
                                opt_str += '<option value="' + opt_value + '">' + opt_name + '</option>';
                                village_code_arr.push(opt_value);
                            }
                        }
                        if (report_data === 5 || report_data === 6) {
                            if ($(this).find('.col6').text()) {
                                if (isNumeric($(this).find('.col6').text().trim())) {
                                    area += parseFloat($(this).find('.col6').text().trim());
                                }
                            }
                            if ($(this).find('.col8').text()) {
                                if (isNumeric($(this).find('.col8').text().trim())) {
                                    rakba += parseFloat($(this).find('.col8').text().trim());
                                }
                            }
                        }
                    });
                    $('#popup').find('#repo_filter_village_code').html(opt_str);
                    if (report_data === 5 || report_data === 6) {
                        var str = '<div><span style="font-weight:600;">Total area: </span>' + parseFloat(area).toFixed(3) + '</div>\n\
                                    <div><span style="font-weight:600;">Total rakba: </span>' + parseFloat(rakba).toFixed(3) + '</div>\n\
                                    <div><span style="font-weight:600;">Difference: </span>' + (parseFloat(area - rakba).toFixed(3)) + '</div>\n\
                                    ';
                        $('#additional_details').html(str);
                    }
                });
            });
        })();
    });

    $(document).mouseup(function (e) {
        var container = $("#checkboxes");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
        }
    });
});

function loadMoreVillageReport(page) {
    var fd = new FormData();
    fd.append('action', '');
    if ($('.filterchip').length) {
        getAppliedFilter($('#saveFilter').html());
        $('#popup').hide();
        var other_data = $('#ffrm').serializeArray();
        $.each(other_data, function (key, input) {
            fd.append(input.name, input.value);
        });
        fd.append('action', 'filter_applied');
    } else {
        $('#popup').html('').hide();
    }
    fd.append('offset', page);
    fd.append('pagelimit', $('#pagelimit').val());
    fd.append('village_code', $('#village_code').val());
    fd.append('report_type', $('#report_type').val());
    $('#main-body').html('<div class="medical-spinner" id="load"></div>');
    $.ajax({
        type: "POST",
        url: "ajax/loadMoreVillageReport.php",
        data: fd,
        contentType: false,
        processData: false,
        cache: false,
        success: function (data) {
            setTimeout(function () {
                $("#main-body").html(data);
                $('#columnFilterData').find('.filterColumn').each(function () {
                    var index = $('.filterColumn').index(this);
                    if ($(this).is(':checked') === true) {
                        $('.col' + (index + 1)).show();
                    } else {
                        $('.col' + (index + 1)).hide();
                    }
                });
            }, 400);
        }
    });
}

function exportVillageReport(exportlist, export_type, type) {
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
    fd.append('village_code', $('#village_code').val());
    fd.append('report_type', $('#report_type').val());

    // check if any displayed columns exists
    if ($('.filterColumn').length === 0) {
        var str = '';
        $('.cellDivHeader').each(function () {
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
        $('.export_village_report_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_village_report_data.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_sync_data.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_sync_data.php";
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
                    $('.export_village_report_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_village_report_excel').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportGataReport(exportlist, export_type, type) {
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
    fd.append('village_code', $('#village_code').val());
    fd.append('gata_no', $('#village_gata').val());

    // check if any displayed columns exists
    if ($('.filterColumn').length === 0) {
        var str = '';
        $('.cellDivHeader').each(function () {
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
        $('.export_gata_report_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_gata_report_data.php";
    } else if (export_type === 'pdf') {
        $('.act_btn_ovrly').show();
        $('.export_gata_report_pdf').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "pdf/export_gata_report_data.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_sync_data.php";
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
                    $('.export_gata_report_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_gata_report_pdf').html('<img src="img/pdficn.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportConsolidateGataReport(exportlist, export_type, type) {
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
    fd.append('village_code', $('#village_code').val());

    // check if any displayed columns exists
    if ($('.filterColumn').length === 0) {
        var str = '';
        $('.cellDivHeader').each(function () {
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
        $('.export_gata_report_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_consolidate_gata_report.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_consolidate_gata_report.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_consolidate_gata_report.php";
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
                    $('.export_gata_report_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_gata_report_excel').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportConsolidateVillageReport(exportlist, export_type, type) {
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

    // check if any displayed columns exists
    if ($('.filterColumn').length === 0) {
        var str = '';
        $('.cellDivHeader').each(function () {
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
        $('.export_village_report_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_consolidate_village_report.php";
    } else if (export_type === 'pdf') {
        $('.act_btn_ovrly').show();
        $('.export_village_report_pdf').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "pdf/export_consolidate_village_report.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_consolidate_village_report.php";
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
                    $('.export_village_report_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_village_report_pdf').html('<img src="img/pdficn.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function validateMaxlength(place) {
    var MAX_LENGTH = event.target.dataset.maxlength;
    var currentLength = event.target.value.length;
    var length = event.target.value.replace(/\n/g, '').length;
    var char_count = parseInt(MAX_LENGTH - length);
    if (length > MAX_LENGTH) {
        event.target.value = event.target.value.substr(0, currentLength - 1);
    }
    if (char_count >= 0) {
        if (char_count === 1 || char_count === 0) {
            $('.msg_txt').eq(place).text('* ' + char_count + ' character remaining.');
        } else {
            $('.msg_txt').eq(place).text('* ' + char_count + ' characters remaining.');
        }
    }
}

function makeDragable(dragHandle, dragTarget) {
    // used to prevent dragged object jumping to mouse location
    let xOffset = 0;
    let yOffset = 0;
    let handle = document.querySelector(dragHandle);
    handle.addEventListener("mousedown", startDrag, true);
    handle.addEventListener("touchstart", startDrag, true);
    /*sets offset parameters and starts listening for mouse-move*/
    function startDrag(e) {
        e.preventDefault();
        e.stopPropagation();
        let dragObj = document.querySelector(dragTarget);
        // shadow element would take the original place of the dragged element, this is to make sure that every sibling will not reflow in the document
        let shadow = dragObj.cloneNode();
        shadow.id = ""
        // You can change the style of the shadow here
        shadow.style.opacity = 0.5
        dragObj.parentNode.insertBefore(shadow, dragObj.nextSibling);
        let rect = dragObj.getBoundingClientRect();
        dragObj.style.left = rect.left;
        dragObj.style.top = rect.top;
        dragObj.style.position = "absolute";
        dragObj.style.zIndex = 999999;
        /*Drag object*/
        function dragObject(e) {
            e.preventDefault();
            e.stopPropagation();
            if (e.type == "mousemove") {
                dragObj.style.left = e.clientX - xOffset + "px"; // adjust location of dragged object so doesn't jump to mouse position
                dragObj.style.top = e.clientY - yOffset + "px";
            } else if (e.type == "touchmove") {
                dragObj.style.left = e.targetTouches[0].clientX - xOffset + "px"; // adjust location of dragged object so doesn't jump to mouse position
                dragObj.style.top = e.targetTouches[0].clientY - yOffset + "px";
            }
        }
        /*End dragging*/
        document.addEventListener("mouseup", function () {
            // hide the shadow element, but still let it keep the room, you can delete the shadow element to let the siblings reflow if that is what you want
            shadow.style.opacity = 0
            shadow.style.zIndex = -999999
            window.removeEventListener('mousemove', dragObject, true);
            window.removeEventListener('touchmove', dragObject, true);
        }, true)

        if (e.type == "mousedown") {
            xOffset = e.clientX - rect.left; //clientX and getBoundingClientRect() both use viewable area adjusted when scrolling aka 'viewport'
            yOffset = e.clientY - rect.top;
            window.addEventListener('mousemove', dragObject, true);
        } else if (e.type == "touchstart") {
            xOffset = e.targetTouches[0].clientX - rect.left;
            yOffset = e.targetTouches[0].clientY - rect.top;
            window.addEventListener('touchmove', dragObject, true);
        }
    }
}

function exportReportData(exportlist, export_type, type) {
    var column_arr = [];
    var column_head = [];
    var fd = new FormData();
    fd.append('action', '');
    // check if any filter applied
    if ($('#popup').find('.filterchip').length) {
        getAppliedFilter($('#popup').find('#saveFilter').html());
        $('#popup').hide();
        var other_data = $('#ffrm').serializeArray();
        $.each(other_data, function (key, input) {
            fd.append(input.name, input.value);
        });
        fd.append('action', 'filter_applied');
    }
    fd.append('report_data', type);
    fd.append('exportlist', exportlist);
    fd.append('export_type', export_type);
    fd.append('village_code', $('#repo_filter_village_code').val());

    // check if any displayed columns exists
    if ($('#popup').find('.filterColumn').length === 0) {
        var str = '';
        $('#popup').find('.cellDivHeader').each(function () {
            var column_name = $(this).find('p').text();
            if (column_name && column_name !== 'Details') {
                var col_checked = '';
                if ($(this).is(':visible')) {
                    col_checked = 'checked';
                }
                str += `<label><input type="checkbox" class="filterColumn" ${col_checked}>${column_name}</label>`;
            }
        });
        $('#popup').find('#columnFilterData').html(str);
    }
    $('#popup').find('#columnFilterData').find('.filterColumn').each(function () {
        var index = $('.filterColumn').index(this);
        if ($(this).is(':checked') === true) {
            column_arr.push(index);
            column_head.push($(this).parent().text());
        }
    });
    fd.append('column_arr', column_arr);
    fd.append('column_head', column_head);
    if (export_type === 'excel') {
        $('#popup').find('.act_btn_ovrly').show();
        $('#popup').find('.export_report_data_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_report_data.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_report_data.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_report_data.php";
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
                    $('#popup').find('.act_btn_ovrly').hide();
                    $('#popup').find('.export_report_data_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('#popup').find('.act_btn_ovrly').hide();
                    $('#popup').find('.export_report_data_excel').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportGridVillageReport(exportlist, export_type, type) {
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

    // check if any displayed columns exists
    if ($('.filterColumn').length === 0) {
        var str = '';
        $('.repoCellDivHeaderCenter').each(function () {
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
        $('.export_village_report_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_grid_village_report.php";
    } else if (export_type === 'pdf') {
        $('.act_btn_ovrly').show();
        $('.export_village_report_pdf').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "pdf/export_grid_village_report.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_grid_village_report.php";
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
                    $('.export_village_report_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_village_report_pdf').html('<img src="img/pdficn.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportBainamaReport(exportlist, export_type, type) {
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

    // check if any displayed columns exists
    if ($('.filterColumn').length === 0) {
        var str = '';
        $('.repoCellDivHeaderCenter').each(function () {
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
        $('.export_village_report_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_bainama_report.php";
    } else if (export_type === 'pdf') {
        $('.act_btn_ovrly').show();
        $('.export_village_report_pdf').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "pdf/export_bainama_report.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_bainama_report.php";
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
                    $('.export_village_report_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_village_report_pdf').html('<img src="img/pdficn.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}