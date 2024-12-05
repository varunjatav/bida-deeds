var aft;
$(document).ready(function () {

    $(".full-column").on("mouseover", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").show();
    });

    $(".full-column").on("mouseleave", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").hide();
    });

    $('.full-column').on('click', '#columnFilter', function () {
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
                    $('#popup').find('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
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

    $('.untdtls').each(function () {
        var randomColor = getRandomColor();
        var randomDarkColor = '#000';//getDarkColor();
        $(this).find('.tilenmbrs').find('span').css({'color': randomDarkColor});
        $(this).css({'background-color': randomColor});
    });

    $('.card_content').each(function () {
        var randomColor = getRandomColor();
        var randomDarkColor = getDarkColor();
        $(this).find('.card_content').find('.view_data').css({'color': randomDarkColor});
        $(this).css({'background-color': randomDarkColor});
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

    $(document).mouseup(function (e) {
        var container = $("#checkboxes");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
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
