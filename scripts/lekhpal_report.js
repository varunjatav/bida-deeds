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
    });

    $('.full-column').on('click', '.filterColumn', function () {
        var index = $('.filterColumn').index(this);
        if ($(this).is(':checked') === true) {
            $('.repoCellDivHeaderCenter:eq(' + (index) + '), .col' + (index + 1)).show();
        } else {
            $('.repoCellDivHeaderCenter:eq(' + (index) + '), .col' + (index + 1)).hide();
        }
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

    $('.full-column').on('click', '.export_excel_lekhpal_report', function () {
        exportLekhpalReport('export', 'excel', $(this).attr('id'));
    });

    $('.full-column').on('click', '.export_excel_lekhpal_report_view', function () {
        exportLekhpalReportView('export', 'excel', $(this).attr('id'));
    });
    
    $('#popup').on('click', '.export_lekhpal_view_report', function () {
        exportLekhpalViewReport('export', 'excel', $(this).attr('id'));
    });
    
    $('.full-column').on('click', '.export_excel_lekhpal_app_report', function () {
        exportLekhpalAppReport('export', 'excel', $(this).attr('id'));
    });

    $('.full-column').on('click', '.export_excel_lekhpal_app_report_view', function () {
        exportLekhpalAppReportView('export', 'excel', $(this).attr('id'));
    });
    
    $('#popup').on('click', '.export_lekhpal_app_view_report', function () {
        exportLekhpalAppViewReport('export', 'excel', $(this).attr('id'));
    });

    $('.col-wrapper').on('click', '.view_lekhpal_data', function () {
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
                var village_code = curr.attr('id');
                var lekhpal_user_id = $('#user_id').val();
                var lekhpal_name = $('#lekhpal_name').val();
                var title = curr.text().replace(/ /g, '%20');
                $('#popup').load('popup/viewLekhpalReportPopup.php?village_code=' + village_code + '&title=' + title + '&lekhpal_user_id=' + lekhpal_user_id + '&lekhpal_name=' + lekhpal_name, function () {
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
                    makeDragable('.popup-header', '.popup-wrap');
                });
            });
        })();
    });
    
    $('.col-wrapper').on('click', '.view_lekhpal_app_data', function () {
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
                var village_code = curr.attr('id');
                var lekhpal_user_id = $('#user_id').val();
                var lekhpal_name = $('#lekhpal_name').val();
                var title = curr.text().replace(/ /g, '%20');
                $('#popup').load('popup/viewLekhpalAppReportPopup.php?village_code=' + village_code + '&title=' + title + '&lekhpal_user_id=' + lekhpal_user_id + '&lekhpal_name=' + lekhpal_name, function () {
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
                    makeDragable('.popup-header', '.popup-wrap');
                });
            });
        })();
    });

    $('#popup').on('keyup', '#search_data', function () {
        var filter = $(this).val();
        var count = 0;
        $('#popup').find('.rowDiv').each(function() {
            if ($(this).find(".cellDiv").text().trim().search(new RegExp(filter, "i")) < 0) {
                $(this).hide();
            } else {
                $(this).show();
                count++;
            }
        });
        $('#disp_row_count').text(count + ' records found');
    });
    
    $(document).mouseup(function (e) {
        var container = $("#checkboxes");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
        }
    });
});

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

var expanded = false;
function showCheckboxes() {
    var checkboxes = document.getElementById("checkboxes");
    if (!expanded) {
        checkboxes.style.display = "block";
        expanded = true;
    } else {
        checkboxes.style.display = "none";
        expanded = false;
    }
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

function exportLekhpalReport(exportlist, export_type, type) {
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
        $('.export_excel_lekhpal_report').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_lekhpal_report.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_lekhpal_report.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_lekhpal_report.php";
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
                    $('.export_excel_lekhpal_report').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_excel_lekhpal_report').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportLekhpalAppReport(exportlist, export_type, type) {
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
        $('.export_excel_lekhpal_app_report').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_lekhpal_app_report.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_lekhpal_app_report.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_lekhpal_app_report.php";
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
                    $('.export_excel_lekhpal_app_report').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_excel_lekhpal_app_report').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportLekhpalReportView(exportlist, export_type, type) {
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
    fd.append('id', $('#user_id').val());

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
        $('.export_excel_lekhpal_report_view').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_lekhpal_report_view.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_lekhpal_report_view.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_lekhpal_report_view.php";
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
                    $('.export_excel_lekhpal_report_view').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_excel_lekhpal_report_view').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportLekhpalAppReportView(exportlist, export_type, type) {
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
    fd.append('id', $('#user_id').val());

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
        $('.export_excel_lekhpal_app_report_view').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_lekhpal_app_report_view.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_lekhpal_app_report_view.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_lekhpal_app_report_view.php";
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
                    $('.export_excel_lekhpal_app_report_view').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_excel_lekhpal_app_report_view').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportLekhpalViewReport(exportlist, export_type, type) {
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
    fd.append('lekhpal_user_id', $('#lekhpal_user_id').val());

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
        $('.export_lekhpal_view_report').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_lekhpal_view_report.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_lekhpal_view_report.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_lekhpal_view_report.php";
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
                    $('.export_lekhpal_view_report').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_lekhpal_view_report').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportLekhpalAppViewReport(exportlist, export_type, type) {
    var column_arr = [];
    var column_head = [];
    var fd = new FormData();
    fd.append('action', '');
    // check if any filter applied
    if ($('#popup').find('.filterchip').length) {
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
    fd.append('lekhpal_user_id', $('#lekhpal_user_id').val());

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
        $('.act_btn_ovrly').show();
        $('.export_lekhpal_app_view_report').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_lekhpal_app_view_report.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_lekhpal_app_view_report.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_lekhpal_app_view_report.php";
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
                    $('.export_lekhpal_app_view_report').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_lekhpal_app_view_report').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}