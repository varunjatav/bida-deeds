$(document).ready(function () {

    $('.col-wrapper').on('click', '.report_feedback', function () {
        var curr = $(this);
        var resource_type = curr.attr('id');
        var report_type = curr.attr('report_type');
        var tile_no = $('#tile_no').length ? $('#tile_no').val() : '';
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
            } else if (report_type === 'gata_wise' && tile_no === '' && village_gata === '') {
                printError("Please select village.", 3000, '', '');
                return false;
            } else if (report_type === 'gata_wise' && village_gata === '') {
                printError("Please select gata.", 3000, '', '');
                return false;
            }
        }
        $('#popup').load('popup/confirmPopup.php?title=' + title + '&btn_id=' + btn_id + '&btn_name=' + btn_name + '&text=' + text + '&remarks=' + remarks + '&remarks_enabled=' + remarks_enabled + '&remarks_mandatory=' + remarks_mandatory + '&resource_type=' + resource_type + '&report_type=' + report_type + '&tile_no=' + tile_no + '&village_gata=' + village_gata + '&report_no=' + report_no, function () {
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

    $('.untdtls').each(function () {
        var randomColor = getRandomColor();
        var randomDarkColor = '#000';//getDarkColor();
        $(this).find('.tilenmbrs').find('span').css({'color': randomDarkColor});
        $(this).css({'background-color': randomColor});
    });

    $('.col-wrapper').on('click', '.view_data', function () {
        $('.act_btn_ovrly').show();
        var curr = $(this);
        (async () => {
            $('#popup').load('popup/loadingData.php', function () {
                $('#popup').show();
                $('.slcdstc').html('<div class="medical-spinner" style="margin-top:35%; left:45%;" id="load"></div>');
            });
            await new Promise((resolve) => {
                var dashboard_data = curr.attr('id').replace('dashboard_data_', '');
                var title = curr.closest('.tilenmbrs').find('span:first').text().replace(/ /g, '%20');
                $('#popup').load('popup/viewDashboardDataPopup.php?dashboard_data=' + dashboard_data + '&title=' + title, function () {
                    $('#popup').show();
                    $('tCount').text($('.rowDiv').length);
                    $('.act_btn_ovrly').hide();
                    makeDragable('.popup-header', '.popup-wrap');
                });
            });
        })();
    });

    $('#popup').on('click', '.export_dashboard_excel', function () {
        exportDashboardData('export', 'excel', $(this).attr('id'));
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


    $('.col-wrapper').find('.view_data').each(function () {
        var id = $(this).attr('id').replace('dashboard_data_', '');
        if ($('#tiles_count').val()) {
            $('#tiles_count').val($('#tiles_count').val() + ',' + id);
        } else {
            $('#tiles_count').val(id);
        }
        
    });
    var tiles_count_array = $('#tiles_count').val().split(',');
    syncDashboardData(tiles_count_array[0], 0);




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
});

function syncDashboardData(tile_no, count) {
    var dataString = 'tile_no=' + tile_no + '&count=' + count + '&action=sync_dashboard_data';
    $('#dashboard_data_' + tile_no).html('<div class="medical-spinner" style="" id="load"></div>');
    //document.getElementById('log_content').scrollTop = document.getElementById('log_content').scrollHeight;
    console.log('Start sync data of tile no: ' + tile_no);
    $.ajax({
        url: 'ajax/syncDashboardData.php',
        data: dataString,
        type: "POST",
        success: function (data) {
            console.log(data);
            var response_data = JSON.parse(data);
            if (response_data['status'] === '1') {
                $('#dashboard_data_' + tile_no).html(response_data.success_array['data_count']);
                console.log('Sync completed of tile no: ' + tile_no);
                var tile_nos_array = $('#tiles_count').val().split(',');
                const index = tile_nos_array.indexOf(tile_no);
                if (index > -1) {
                    tile_nos_array.splice(index, 1);
                    $('#tiles_count').val(tile_nos_array);
                }

                if ($('#tiles_count').val()) {
                    //console.log(response_data.success_array['count']);
                    setTimeout(function () {
                        syncDashboardData(tile_nos_array[0], response_data.success_array['count']);
                    }, 200);
                } else {
//                    $('.sync_data').find('.crtxt').text('Sync Data');
//                    var total_time = 0;
//                    $('#popup').find('.grntxt').each(function () {
//                        total_time += parseFloat($(this).attr('time'));
//                    });
//
//                    $('.popup-body').find('.slcdstc').append('<p class="left bluetxt">Sync completed. Total time: (' + convertStoMs(total_time) + ')</p><div class="clr"></div>');
//                    //console.log("Sync Completed.");
//                    $('#cancel_sync_popup').parent().show();
                }
                //document.getElementById('log_content').scrollTop = document.getElementById('log_content').scrollHeight;
            }
        },
        async: true
    });
}

function getRandomColor() {
    color = "hsl(" + Math.random() * 360 + ", 100%, 75%)";
    return color;
}
function getDarkColor() {
    var color = '#';
    for (var i = 0; i < 6; i++) {
        color += Math.floor(Math.random() * 10);
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
    if ($('.filterchip').length) {
        getAppliedFilter($('#saveFilter').html());
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
        $('.export_dashboard_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
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
                    $('.act_btn_ovrly').hide();
                    $('.export_dashboard_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_dashboard_excel').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}