$(document).ready(function () {

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
        if (resource_type === '4') {
            if (report_type === 'village_wise' && report_no === '') {
                printError("Please select village and report type.", 3000, '', '');
                return false;
            } else if (report_type === 'gata_wise' && village_code === '' && village_gata === '') {
                printError("Please select village.", 3000, '', '');
                return false;
            } else if (report_type === 'gata_wise' && village_gata === '') {
                printError("Please select gata.", 3000, '', '');
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

    $('.card_content').each(function () {
        var randomColor = getRandomColor();
        var randomDarkColor = getDarkColor();
        $(this).find('.card_content').find('.view_data').css({'color': randomDarkColor});
        $(this).css({'background-color': randomDarkColor});
    });

    $('.col-wrapper').on('click', '.view_data', function () {
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
                var dashboard_data = curr.attr('id').replace('dashboard_data_', '');
                var title = curr.closest('.card_content').find('span:first').text().replace(/ /g, '%20');
                $('#popup').load('popup/viewDashboardDataPopup.php?dashboard_data=' + dashboard_data + '&title=' + title, function () {
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    makeDragable('.popup-header', '.popup-wrap');
                    var village_code_arr = [];
                    var opt_str = '<option value="">Select Village</option>';
                    if (dashboard_data === '47') {
                        $('#popup').find('.rowDiv').each(function () {
                            if ($(this).find('.col3').text()) {
                                var opt_name = $(this).find('.col2').text().trim();
                                var opt_value = $(this).find('.col3').text().trim();
                                if (village_code_arr.includes(opt_value) === false) {
                                    opt_str += '<option value="' + opt_value + '">' + opt_name + '</option>';
                                    village_code_arr.push(opt_value);
                                }
                            }
                        });
                        $('tCount').text($('#popup').find('.rowDiv').length);
                    } else {
                        if (dashboard_data === '6' || dashboard_data === '12' || dashboard_data === '13' || dashboard_data === '14' || dashboard_data === '15' || dashboard_data === '16' || dashboard_data === '39') {
                            var area = 0;
                            $('#popup').find('.rowDiv').each(function () {
                                if ($(this).find('.col5').text()) {
                                    if (isNumeric($(this).find('.col5').text().trim())) {
                                        area += parseFloat($(this).find('.col5').text().trim());
                                    }
                                }
                            });
                            $('tCount').text(parseFloat(area).toFixed(3));
                        } else if (dashboard_data === '42' || dashboard_data === '43' || dashboard_data === '45') {
                            var area = 0;
                            $('#popup').find('.rowDiv').each(function () {
                                if ($(this).find('.col6').text()) {
                                    if (isNumeric($(this).find('.col6').text().trim())) {
                                        area += parseFloat($(this).find('.col6').text().trim());
                                    }
                                }
                            });
                            $('tCount').text(parseFloat(area).toFixed(3));
                        } else if (dashboard_data === '24' || dashboard_data === '25') {
                            var area = 0;
                            $('#popup').find('.rowDiv').each(function () {
                                if ($(this).find('.col10').text()) {
                                    var numb = $(this).find('.col12').text().trim().match(/\d/g);
                                    numb = numb.join("");
                                    area += parseFloat(numb);
                                }
                            });
                            $('tCount').text(parseFloat(area).toFixed(4));
                        } else if (dashboard_data === '5' || dashboard_data === '48' || dashboard_data === '49' || dashboard_data === '50') {
                            var area = 0;
                            $('#popup').find('.rowDiv').each(function () {
                                if ($(this).find('.col8').text()) {
                                    if (isNumeric($(this).find('.col8').text().trim())) {
                                        area += parseFloat($(this).find('.col8').text().trim());
                                    }
                                }
                            });
                            $('tCount').text(parseFloat(area).toFixed(4));
                        } else {
                            $('tCount').text($('#popup').find('.rowDiv').length);
                            if (dashboard_data === '8') {
                                $('.export_qgis_excel').closest('.tbl-data').removeClass('hide');
                            }
                        }
                        $('#popup').find('.rowDiv').each(function () {
                            if ($(this).find('.col2').text()) {
                                var opt_name = $(this).find('.col1').text().trim();
                                var opt_value = $(this).find('.col2').text().trim();
                                if (village_code_arr.includes(opt_value) === false) {
                                    opt_str += '<option value="' + opt_value + '">' + opt_name + '</option>';
                                    village_code_arr.push(opt_value);
                                }
                            }
                        });
                    }
                    $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
                    $('#popup').find('#filter_village_code').html(opt_str);
                });
            });
        })();
    });

    $('#popup').on('change', '#filter_village_code', function () {
        var dashboard_data = $('#popup').find('#dashboard_data').val();
        var village_code = $(this).val();
        var dataString = 'dashboard_data=' + dashboard_data + '&village_code=' + village_code;
        $('#popup').find('.containerDiv').addClass('height100');
        $('#popup').find('.containerDiv').html('<div class="medical-spinner" style="top:25%; left:50%;" id="load"></div>');
        //alert(dataString);
        $.ajax({
            url: 'ajax/filterDashboardSummary.php',
            data: dataString,
            type: "POST",
            success: function (data) {
                //console.log(data);
                $('#popup').find('.containerDiv').removeClass('height100');
                $('#popup').find('.containerDiv').html(data);
                $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
                if (dashboard_data === '47') {
                    $('tCount').text($('#popup').find('.rowDiv').length);
                } else {
                    if (dashboard_data === '6' || dashboard_data === '12' || dashboard_data === '13' || dashboard_data === '14' || dashboard_data === '15' || dashboard_data === '16' || dashboard_data === '39') {
                        var area = 0;
                        $('#popup').find('.rowDiv').each(function () {
                            if ($(this).find('.col5').text()) {
                                if (isNumeric($(this).find('.col5').text().trim())) {
                                    area += parseFloat($(this).find('.col5').text().trim());
                                }
                            }
                        });
                        $('tCount').text(parseFloat(area).toFixed(3));
                    } else if (dashboard_data === '42' || dashboard_data === '43' || dashboard_data === '45') {
                        var area = 0;
                        $('#popup').find('.rowDiv').each(function () {
                            if ($(this).find('.col6').text()) {
                                if (isNumeric($(this).find('.col6').text().trim())) {
                                    area += parseFloat($(this).find('.col6').text().trim());
                                }
                            }
                        });
                        $('tCount').text(parseFloat(area).toFixed(3));
                    } else if (dashboard_data === '24' || dashboard_data === '25') {
                        var area = 0;
                        $('#popup').find('.rowDiv').each(function () {
                            if ($(this).find('.col10').text()) {
                                var numb = $(this).find('.col12').text().trim().match(/\d/g);
                                numb = numb.join("");
                                area += parseFloat(numb);
                            }
                        });
                        $('tCount').text(parseFloat(area).toFixed(4));
                    } else if (dashboard_data === '5' || dashboard_data === '48' || dashboard_data === '49' || dashboard_data === '50') {
                        var area = 0;
                        $('#popup').find('.rowDiv').each(function () {
                            if ($(this).find('.col8').text()) {
                                if (isNumeric($(this).find('.col8').text().trim())) {
                                    area += parseFloat($(this).find('.col8').text().trim());
                                }
                            }
                        });
                        $('tCount').text(parseFloat(area).toFixed(4));
                    } else {
                        $('tCount').text($('#popup').find('.rowDiv').length);
                    }
                }
            }
        });
    });

    $('#popup').on('click', '.export_dashboard_excel', function () {
        exportDashboardData('export', 'excel', $(this).attr('id'));
    });

    $('#popup').on('click', '.export_new_dashboard_excel', function () {
        exportNewDashboardData('export', 'excel', $(this).attr('id'));
    });

    $('#popup').on('click', '.export_qgis_excel', function () {
        exportQgisData('export', 'excel', $(this).attr('id'));
    });

    $('#popup').on('click', '#columnFilter', function () {
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
    });

    $('#popup').on('click', '.filterColumn', function () {
        var index = $('.filterColumn').index(this);
        if ($(this).is(':checked') === true) {
            $('.cellDivHeader:eq(' + (index) + '), .col' + (index + 1)).show();
        } else {
            $('.cellDivHeader:eq(' + (index) + '), .col' + (index + 1)).hide();
        }
    });

    $('#popup').mouseup(function (e) {
        var container = $("#checkboxes");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
        }
    });

    // sync dashboard tile data
    var promise_arr = [];
    $('.hero-box').find('.cards_item').each(function (index) {
        if ($(this).closest('.hero-box').find('.main-card').is(':visible') === true) {
            if ($(this).attr('id').length) {
                var id = $(this).attr('id').replace('data_block_', '');
                if (isNumeric(id)) {
                    if ($('#tiles_count').val()) {
                        $('#tiles_count').val($('#tiles_count').val() + ',' + id);
                    } else {
                        $('#tiles_count').val(id);
                    }
                    promise_arr.push(syncDashboardData(id, index));
                }
            }
        }
    });

    // sync new dashboard tile data
    var promise_arr = [];
    $('.hero-box').find('.dash_cards_item').each(function (index) {
        if ($(this).closest('.hero-box').find('.main-card').is(':visible') === true) {
            if ($(this).attr('id').length) {
                var id = $(this).attr('id').replace('pmt_data_block_', '');
                if (isNumeric(id)) {
                    if ($('#tiles_count').val()) {
                        $('#tiles_count').val($('#tiles_count').val() + ',' + id);
                    } else {
                        $('#tiles_count').val(id);
                    }
                    promise_arr.push(newSyncDashboardData(id, index));
                }
            }
        }
    });

    const promises = [promise_arr];
    Promise.all(promises)
            .then()
            .catch((e) => console.log(e));

//        var update_fontsize = function () {
//            $('.rep-nos').each(function () {
//                var factor = 4;
//                while (parseFloat($(this).find("span").width()) > parseFloat($(this).width())) {
//                    factor += 0.5;
//                    var fontSize = parseInt($(this).width() / factor) + "px";
//                    $(this).find('span').css('font-size', fontSize);
//                }
//            });
//        };
//
//        $(window).resize(function () {
//            update_fontsize();
//        });
//
//        $(document).ready(function () {
//            update_fontsize();
//        });

    $('.full-column').on('click', '.hero-head', function () {
        var curr = $(this);
        if (curr.find('img').attr('src') === 'img/down-arrow.svg') {
            curr.parent().css('margin-bottom', '');
            curr.find('img').attr('src', 'img/up-arrow.svg');
            curr.animate({width: "255px"}, 400);
        } else {
            curr.parent().css('margin-bottom', '10px');
            curr.find('img').attr('src', 'img/down-arrow.svg');
            curr.css('width', '');
        }
        curr.closest('.expDiv').find('.hero-box').slideToggle(function () {
            curr.closest('.expDiv').find('.hero-box').find('.cards_item').each(function (index) {
                if ($(this).attr('id').length) {
                    var id = $(this).attr('id').replace('data_block_', '');
                    if (isNumeric(id)) {
                        if ($('#tiles_count').val()) {
                            $('#tiles_count').val($('#tiles_count').val() + ',' + id);
                        } else {
                            $('#tiles_count').val(id);
                        }
                        promise_arr.push(syncDashboardData(id, index));
                    }
                }
            });
            $('html, body').animate({
                scrollTop: curr.closest(".expDiv").offset().top
            }, 1000);
        });
    });

    $('.untdtls').each(function () {
        var randomColor = getRandomColor();
        var randomDarkColor = '#000';//getDarkColor();
        $(this).find('.tilenmbrs').find('span').css({'color': randomDarkColor});
        $(this).css({'background-color': randomColor});
    });

    // chat mode
    $('#popup').on('click', '.open_chart', function () {
        var village_list = $('#popup').find('#filter_village_code').html();
        var date_type = 'monthly';
        var year = '2024';
        localStorage.setItem("year", year);
        localStorage.setItem("date_type", date_type);
        localStorage.setItem("chart_edate", '');
        $('#popup').hide().html('');
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
                var dashboard_data = curr.attr('id').replace('dashboard_data_', '');
                var title = curr.attr('name').replace(/ /g, '%20');
                $('#popup').load('popup/viewDashboardChartPopup.php?dashboard_data=' + dashboard_data + '&title=' + title + '&date_type=' + date_type + '&year=' + year + '&village_code=' + '&village_name=', function () {
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    makeDragable('.popup-header', '.popup-wrap');
                    $('#popup').find('#filter_chart_village_code').html(village_list);
                });
            });
        })();
    });

    // switch to list mode
    $('#popup').on('click', '.list_mode_data', function () {
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
                var dashboard_data = curr.attr('id').replace('dashboard_data_', '');
                var title = curr.attr('name').replace(/ /g, '%20');
                $('#popup').load('popup/viewDashboardDataPopup.php?dashboard_data=' + dashboard_data + '&title=' + title, function () {
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    makeDragable('.popup-header', '.popup-wrap');
                    var village_code_arr = [];
                    var opt_str = '<option value="">Select Village</option>';
                    if (dashboard_data === '47') {
                        $('#popup').find('.rowDiv').each(function () {
                            if ($(this).find('.col3').text()) {
                                var opt_name = $(this).find('.col2').text().trim();
                                var opt_value = $(this).find('.col3').text().trim();
                                if (village_code_arr.includes(opt_value) === false) {
                                    opt_str += '<option value="' + opt_value + '">' + opt_name + '</option>';
                                    village_code_arr.push(opt_value);
                                }
                            }
                        });
                        $('tCount').text($('#popup').find('.rowDiv').length);
                    } else {
                        if (dashboard_data === '6' || dashboard_data === '12' || dashboard_data === '13' || dashboard_data === '14' || dashboard_data === '15' || dashboard_data === '16' || dashboard_data === '39') {
                            var area = 0;
                            $('#popup').find('.rowDiv').each(function () {
                                if ($(this).find('.col5').text()) {
                                    if (isNumeric($(this).find('.col5').text().trim())) {
                                        area += parseFloat($(this).find('.col5').text().trim());
                                    }
                                }
                            });
                            $('tCount').text(parseFloat(area).toFixed(3));
                        } else if (dashboard_data === '42' || dashboard_data === '43' || dashboard_data === '45') {
                            var area = 0;
                            $('#popup').find('.rowDiv').each(function () {
                                if ($(this).find('.col6').text()) {
                                    if (isNumeric($(this).find('.col6').text().trim())) {
                                        area += parseFloat($(this).find('.col6').text().trim());
                                    }
                                }
                            });
                            $('tCount').text(parseFloat(area).toFixed(3));
                        } else if (dashboard_data === '24' || dashboard_data === '25') {
                            var area = 0;
                            $('#popup').find('.rowDiv').each(function () {
                                if ($(this).find('.col10').text()) {
                                    var numb = $(this).find('.col12').text().trim().match(/\d/g);
                                    numb = numb.join("");
                                    area += parseFloat(numb);
                                }
                            });
                            $('tCount').text(parseFloat(area).toFixed(4));
                        } else if (dashboard_data === '5' || dashboard_data === '48' || dashboard_data === '49' || dashboard_data === '50') {
                            var area = 0;
                            $('#popup').find('.rowDiv').each(function () {
                                if ($(this).find('.col8').text()) {
                                    if (isNumeric($(this).find('.col8').text().trim())) {
                                        area += parseFloat($(this).find('.col8').text().trim());
                                    }
                                }
                            });
                            $('tCount').text(parseFloat(area).toFixed(4));
                        } else {
                            $('tCount').text($('#popup').find('.rowDiv').length);
                            if (dashboard_data === '8') {
                                $('.export_qgis_excel').closest('.tbl-data').removeClass('hide');
                            }
                        }
                        $('#popup').find('.rowDiv').each(function () {
                            if ($(this).find('.col2').text()) {
                                var opt_name = $(this).find('.col1').text().trim();
                                var opt_value = $(this).find('.col2').text().trim();
                                if (village_code_arr.includes(opt_value) === false) {
                                    opt_str += '<option value="' + opt_value + '">' + opt_name + '</option>';
                                    village_code_arr.push(opt_value);
                                }
                            }
                        });
                    }
                    $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
                    $('#popup').find('#filter_village_code').html(opt_str);
                });
            });
        })();
    });

    $('#popup').on('change', '#filter_chart_village_code, #date_type, #year, #chart_edate', function () {
        var village_code = $('#popup').find('#filter_chart_village_code').val();
        var village_name = $('#popup').find('#filter_chart_village_code option:selected').text().replace(/ /g, '%20');
        var village_list = $('#popup').find('#filter_chart_village_code').html();
        var dashboard_data = $('.list_mode_data').attr('id').replace('dashboard_data_', '');
        var title = $('.list_mode_data').attr('name').replace(/ /g, '%20');
        var date_type = $('#popup').find('#date_type').val();
        var year = $('#popup').find('#year').val();
        var chart_sdate = $('#chart_sdate').val();
        var chart_edate = $('#chart_edate').val();
        localStorage.setItem("chart_sdate", chart_sdate);
        localStorage.setItem("chart_edate", chart_edate);
        localStorage.setItem("year", year);
        localStorage.setItem("date_type", date_type);
        localStorage.setItem("village_code", village_code);
        if (date_type === 'date_range' && localStorage.getItem("chart_edate") === '') {
            $('.chart_date_range').show();
            return false;
        } else {
            $('.chart_date_range').hide();
        }
        $('#popup').hide().html('');
        $('.act_btn_ovrly').show();
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
                //console.log('dashboard_data=' + dashboard_data + '&title=' + title + '&date_type=' + date_type + '&year=' + year + '&village_code=' + village_code + '&village_name=' + village_name);
                $('#popup').load('popup/viewDashboardChartPopup.php?dashboard_data=' + dashboard_data + '&title=' + title + '&date_type=' + date_type + '&year=' + year + '&village_code=' + village_code + '&village_name=' + village_name + '&chart_sdate=' + chart_sdate + '&chart_edate=' + chart_edate, function (data) {
                    //console.log(data);
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    makeDragable('.popup-header', '.popup-wrap');
                    $('#popup').find('#filter_chart_village_code').html(village_list);
                    $('#popup').find('#filter_chart_village_code').val(localStorage.getItem("village_code"));
                    $('#popup').find('#date_type').val(localStorage.getItem("date_type"));
                    $('#popup').find('#year').val(localStorage.getItem("year"));
                    if (date_type === 'date_range' && localStorage.getItem("chart_edate")) {
                        $('.chart_date_range').show();
                        $('#chart_sdate').val(localStorage.getItem("chart_sdate"));
                        $('#chart_edate').val(localStorage.getItem("chart_edate"));
                    }
                });
            });
        })();
    });

    $('.col-wrapper').on('click', '.view_pmt_data', function () {
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
                var dashboard_data = curr.attr('id').replace('pmt_dash_data_', '');
                var title = curr.closest('.card_content').find('span:first').text().replace(/ /g, '%20');
                $('#popup').load('popup/viewNewDashboardDataPopup.php?dashboard_data=' + dashboard_data + '&title=' + title, function () {
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    makeDragable('.popup-header', '.popup-wrap');
                    var village_code_arr = [];
                    var opt_str = '<option value="">Select Village</option>';
                    if (dashboard_data === '2' || dashboard_data === '4' || dashboard_data === '5' || dashboard_data === '6') {
                        $('tCount').text($('#popup').find('#tCount').val());
                    } else {
                        $('tCount').text($('#popup').find('.rowDiv').length);
                    }
                    $('#popup').find('.rowDiv').each(function () {
                        if ($(this).find('.col2').text()) {
                            var opt_name = $(this).find('.col1').text().trim();
                            var opt_value = $(this).find('.col2').text().trim();
                            if (village_code_arr.includes(opt_value) === false) {
                                opt_str += '<option value="' + opt_value + '">' + opt_name + '</option>';
                                village_code_arr.push(opt_value);
                            }
                        }
                    });
                    $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
                    $('#popup').find('#dash_filter_village_code').html(opt_str);
                });
            });
        })();
    });

    $('#popup').on('change', '#dash_filter_village_code', function () {
        var dashboard_data = $('#popup').find('#dashboard_data').val();
        var village_code = $(this).val();
        var dataString = 'dashboard_data=' + dashboard_data + '&village_code=' + village_code;
        $('#popup').find('.containerDiv').addClass('height100');
        $('#popup').find('.containerDiv').html('<div class="medical-spinner" style="top:25%; left:50%;" id="load"></div>');
        //alert(dataString);
        $.ajax({
            url: 'ajax/filterNewDashboardSummary.php',
            data: dataString,
            type: "POST",
            success: function (data) {
                //console.log(data);
                $('#popup').find('.containerDiv').removeClass('height100');
                $('#popup').find('.containerDiv').html(data);
                $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
                if (dashboard_data === '2' || dashboard_data === '4' || dashboard_data === '5' || dashboard_data === '6') {
                    $('tCount').text($('#popup').find('#tCount').val());
                } else {
                    $('tCount').text($('#popup').find('.rowDiv').length);
                }
            }
        });
    });

    $('.col-wrapper').on('change', '#village_code', function () {
        if ($(this).val()) {
            var dataString = 'village_code=' + $('#village_code').val() + '&type=1';
            $.ajax({
                url: 'ajax/getVillageGata.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    $('#village_gata').html(data);
                }
            });
        }
    });

    $('.col-wrapper').on('click', '#showGataReports', function () {
        if ($('#village_code').val() && $('#village_gata').val()) {
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
                    var dataString = 'village_code=' + $('#village_code').val() + '&gata_no=' + $('#village_gata').val();
                    $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
                    $.ajax({
                        url: 'ajax/loadGataReport.php',
                        data: dataString,
                        type: "POST",
                        success: function (data) {
                            setTimeout(function () {
                                var str = `<div class="popup-overlay center-screen">
                                                <div class="popup-wrap pp-large-x">
                                                    <div class="popup-header" style="cursor: move;">
                                                        <span class="popup-title text-wrapping left">Gata Report</span>
                                                        <span class="popup-close right">
                                                            <a style="cursor:pointer;" id="cancel_popup">
                                                                <img src="img/clear-w.svg" alt="" width="18px">
                                                            </a>
                                                        </span>
                                                        <div class="clr"></div>
                                                    </div>
                                                    <div class="popup-body pp-large-y" style="padding: 2px 10px 25px 10px;">
                                                        ${data}
                                                    </div>
                                                    <div class="popup-actionwrap posrel">
                                                        <div class="posabsolut act_btn_ovrly"></div>
                                                        <a style="cursor: pointer;" id="cancel_popup" class="pp-secact right cancel">Cancel</a>
                                                        <div class="clr"></div>
                                                    </div>
                                                </div>
                                            </div>`;
                                $('#popup').html(str).show();
                                makeDragable('.popup-header', '.popup-wrap');
                            }, 400);
                        }
                    });
                });
            })();
        }
    });
});

function syncDashboardData(data_point, count) {
    var dataString = 'data_point=' + data_point + '&count=' + count + '&action=sync_dashboard_data';
    $('.block_loader').html('<div class="medical-spinner" style="top:36%; left:42%;" id="load"></div>');
    //console.log('Start sync data of data point: ' + data_point);
    $.ajax({
        url: 'ajax/syncDashboardData.php',
        data: dataString,
        type: "POST",
        success: function (data) {
            //console.log(data);
            var response_data = JSON.parse(data);
            if (response_data['status'] === '1') {
                $('#data_block_' + data_point).find('.block_loader').remove();
                //console.log('Sync completed of data point: ' + data_point);
                $('#data_block_' + data_point).find('p').each(function (index) {
                    index++;
                    $(this).find('.view_data').text(response_data.success_array['point' + index]);
                });
            } else {
            }
        },
        async: true
    });
}

function newSyncDashboardData(data_point, count) {
    var dataString = 'data_point=' + data_point + '&count=' + count + '&action=new_sync_dashboard_data';
    $('.block_loader').html('<div class="medical-spinner" style="top:36%; left:42%;" id="load"></div>');
    //console.log('Start sync data of data point: ' + data_point);
    $.ajax({
        url: 'ajax/newSyncDashboardData.php',
        data: dataString,
        type: "POST",
        success: function (data) {
            //console.log(data);
            var response_data = JSON.parse(data);
            if (response_data['status'] === '1') {
                $('#pmt_data_block_' + data_point).find('.block_loader').remove();
                //console.log('Sync completed of data point: ' + data_point);
                $('#pmt_data_block_' + data_point).find('p').each(function (index) {
                    index++;
                    $(this).find('.view_pmt_data').text(response_data.success_array['point' + index]);
                });
            } else {
            }
        },
        async: true
    });
}

//function syncDashboardData(data_point, count) {
//    var dataString = 'data_point=' + data_point + '&count=' + count + '&action=sync_dashboard_data';
//    $('.block_loader').html('<div class="medical-spinner" style="top:38%; left:43%;" id="load"></div>');
//    //console.log('Start sync data of data point: ' + data_point);
//    $.ajax({
//        url: 'ajax/syncDashboardData.php',
//        data: dataString,
//        type: "POST",
//        success: function (data) {
//            //console.log(data);
//            var response_data = JSON.parse(data);
//            if (response_data['status'] === '1') {
//                $('#data_block_' + data_point).find('.block_loader').remove();
//                //console.log('Sync completed of data point: ' + data_point);
//
//                $('#data_block_' + data_point).find('.tilenmbrs').each(function (index) {
//                    index++;
//                    $(this).find('.view_data').text(response_data.success_array['point' + index]);
//                });
//
//                var tiles_count_array = $('#tiles_count').val().split(',');
//                const index = tiles_count_array.indexOf(data_point);
//                if (index > -1) {
//                    tiles_count_array.splice(index, 1);
//                    $('#tiles_count').val(tiles_count_array);
//                }
//
//                if ($('#tiles_count').val()) {
//                    setTimeout(function () {
//                        syncDashboardData(tiles_count_array[0], response_data.success_array['count']);
//                    }, 50);
//                }
//            } else {
//                //$('#data_block_' + data_point).find('.block_loader').remove();
//            }
//        },
//        async: true
//    });
//}

function getRandomColor() {
    color = "hsl(" + Math.random() * 360 + ", 100%, 75%)";
    return color;
}
function getDarkColor() {
    var letters = '0123456789ABCDEF'.split('');
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += letters[Math.round(Math.random() * 15)];
    }
    return color;
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

function exportDashboardData(exportlist, export_type, type) {
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
    fd.append('dashboard_data', type);
    fd.append('exportlist', exportlist);
    fd.append('export_type', export_type);
    fd.append('village_code', $('#filter_village_code').val());

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
        $('#popup').find('.export_dashboard_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_dashboard_data.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_dashboard_data.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_dashboard_data.php";
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
                    $('#popup').find('.export_dashboard_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('#popup').find('.act_btn_ovrly').hide();
                    $('#popup').find('.export_dashboard_excel').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportNewDashboardData(exportlist, export_type, type) {
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
    fd.append('dashboard_data', type);
    fd.append('exportlist', exportlist);
    fd.append('export_type', export_type);
    fd.append('village_code', $('#dash_filter_village_code').val());

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
        $('#popup').find('.export_new_dashboard_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_new_dashboard_data.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_new_dashboard_data.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_new_dashboard_data.php";
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
                    $('#popup').find('.export_new_dashboard_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('#popup').find('.act_btn_ovrly').hide();
                    $('#popup').find('.export_new_dashboard_excel').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportQgisData(exportlist, export_type, type) {
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
    fd.append('dashboard_data', type);
    fd.append('exportlist', exportlist);
    fd.append('export_type', export_type);
    fd.append('village_code', $('#filter_village_code').val());

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
        $('#popup').find('.export_qgis_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_qgis_data.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_qgis_data.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_qgis_data.php";
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
                    $('#popup').find('.export_qgis_excel').html('<img src="img/map.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('#popup').find('.act_btn_ovrly').hide();
                    $('#popup').find('.export_qgis_excel').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}