var aft;
$(document).ready(function () {

    $(".full-column").on("mouseover", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").show();
    });

    $(".full-column").on("mouseleave", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").hide();
    });

    // add new grievances popup
    $('.dev_wrap').on('click', '.add_grienvaces', function () {
        $('#popup').load('popup/addNewGrievancesPopup.php', function () {
            $('#popup').show();
            $('body').css('overflow-y', 'hidden');
            makeDragable('.popup-header', '.popup-wrap');
        });
    });

    $('#popup').on('change', '.village_code', function () {
        var curr = $(this);
        var dataString = 'village_code=' + curr.val() + '&type=2';
        $.ajax({
            url: 'ajax/getOfflineKashtkarVillageGata.php',
            data: dataString,
            type: "POST",
            success: function (data) {
                curr.closest('.card_item').find('.village_gata').html(data);
            }
        });
    });

    $('#popup').on('change', '.village_gata', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'village_code=' + curr.closest('.card_item').find('.village_code').val() + '&gata_no=' + curr.val();
            $.ajax({
                url: 'ajax/loadOfflineKashtkarKhata.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    curr.closest('.card_item').find('.village_khata').html(data);
                }
            });
        } else {
        }
    });

    $('#popup').on('change', '.village_khata', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'village_code=' + curr.closest('.card_item').find('.village_code').val() + '&gata_no=' + curr.closest('.card_item').find('.village_gata').val() + '&khata_no=' + curr.val();
            $.ajax({
                url: 'ajax/loadOfflineMobileKashtkar.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    curr.closest('.card_item').find('.kashtkar').html(data);
                }
            });
        } else {
        }
    });

    $('#popup').on('change', '.kashtkar', function () {
        var curr = $(this);
        if ($(this).val() === 'other') {
            var str = `<div class="newkastkar_name">
                                   <div class="form-field-wrap posrel">
                                                <div class="posabsolut frm-lbl-actv">काश्तकार का नाम डालें*</div>
                                                <div class="form-type dev_req_msg">
                                                    <input type="text" class="frm-txtbox dept-frm-input fldrequired new-kashkar"name="fname"
                                                           maxlength="100" placeholder="काश्तकार का नाम डालें" autocomplete="off">
                                                </div>
                                                <div class="frm-er-msg"></div>
                                        </div>
                                        <div class="form-field-wrap posrel">
                                                <div class="posabsolut frm-lbl-actv">पति/पिता का नाम डालें*</div>
                                                <div class="form-type dev_req_msg">
                                                    <input type="text" class="frm-txtbox dept-frm-input fldrequired new-kashkar"name="pname"
                                                           maxlength="100" placeholder="पति/पिता का नाम डालें" autocomplete="off">
                                                </div>
                                                <div class="frm-er-msg"></div>
                                        </div>
                                        <div class="form-field-wrap posrel">
                                                <div class="posabsolut frm-lbl-actv">गाटे का रकबा (हेक्टेयर में)*</div>
                                                <div class="form-type dev_req_msg">
                                                    <input type="text" class="frm-txtbox dept-frm-input fldrequired numeric new-kashkar"name="area"
                                                           maxlength="10"  placeholder="गाटे का रकबा (हेक्टेयर में)" autocomplete="off">
                                                </div>
                                                <div class="frm-er-msg"></div>
                                        </div>
                              </div>`;
            $('.new_kashtkar').html('').html(str);
            $('.new_kashtkar').show();
        } else {
            $('.new_kashtkar').html('');
            $('.newkastkar_name').find('input').removeClass('fldrequired');
            $('.new_kashtkar').hide();
        }
    });

    $('#popup').on('click', '.brPic1', function () {
        $(this).closest('.dev_req_msg').find('.browsePic1').click();
    });

    $('#popup').on('change', '.browsePic1', function () {
        // GET THE FILE INPUT.
        var curr = $(this);

        curr.closest(".dev_req_msg").next(".frm-er-msg").text("");
        curr.removeClass("frm-error");

        var id = $(this).attr('id');
        var fi = document.getElementById(id);

        // RUN A LOOP TO CHECK EACH SELECTED FILE.
        var filec = 0;
        var filecount = 0;
        var check = 0;
        for (var i = 0; i <= fi.files.length - 1; i++) {
            var fname = fi.files.item(i).name;      // THE NAME OF THE FILE.
            var fsize = fi.files.item(i).size / 1024;    // THE SIZE OF THE FILE.
            var ext = fname.split(".");
            ext = ext[ext.length - 1].toLowerCase();
            var arrayExtensions = ["pdf", "PDF"];
            if (arrayExtensions.lastIndexOf(ext) === -1) {
                filec++;
            }
            filecount++;
            if (fsize > 101024) {
                check++;
                $.confirm({
                    title: "Alert",
                    message: "You can not upload pdf more than 100 MB.",
                    buttons: {
                        "OK": {
                            "class": "curr_btn",
                            action: function () {
                                curr.val('');
                            }
                        }
                    }
                });
                return false;
            }
        }
        if (filec > 0) {
            check++;
            $.confirm({
                title: "Alert",
                message: "Only pdf format is allowed.",
                buttons: {
                    "OK": {
                        "class": "curr_btn",
                        action: function () {
                            curr.val('');
                        }
                    }
                }
            });
            return false;
        }
        if (filecount > 1) {
            check++;
            $.confirm({
                title: "Alert",
                message: "Attach only 1 attachments at a time.",
                buttons: {
                    "OK": {
                        "class": "curr_btn",
                        action: function () {
                            curr.val('');
                        }
                    }
                }
            });
            return false;
        }
        $("#grievances_file").removeClass('hide');
        $("#grievances_file").text(filecount + ' File selected');

        if (check === 0) {
            printObjectFileList();
        }
    });

    // save new grievances
    $('#popup').on('click', '#add_grievances', function () {
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
                $(this).closest(".dev_req_msg").find(".frm-er-msg").text("");
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
            $('#pfrm').find('.frm_hidden_data').html('');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="add_grievances" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/lamsAction" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#add_grievances" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="Save" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="reload" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="" autocomplete="off">');
            $('#pfrm').submit();
        }
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
        var index = $('.filterColumn').index(this);
        if ($(this).is(':checked') === true) {
            $('.cellDivHeader:eq(' + (index) + '), .col' + (index + 1)).show();
        } else {
            $('.cellDivHeader:eq(' + (index) + '), .col' + (index + 1)).hide();
        }
    });

    $('.full-column').on('click', '.perPage', function () {
        $(this).next('ul').toggle();
    });

    $('.full-column').on('click', '.setPage', function () {
        $('#pagelimit').val($(this).text());
        $('.perPage').text($(this).text());
        $(this).closest('ul').toggle();
        loadMoreFeedbacks(0);
    });

    $('.full-column').on('click', '.export_excel', function () {
        exportSyncData('export', 'excel', $(this).attr('id'));
    });

    $('.full-column').on('click', '.export_pdf', function () {
        exportSyncData('export', 'pdf', $(this).attr('id'));
    });

    $('.full-column').on('click', '.export_print', function () {
        exportSyncData('export', 'print', $(this).attr('id'));
    });

    $('.full-column').on('click', '.export_excel_grievances', function () {
        exportGrievances('export', 'excel', $(this).attr('id'));
    });

    $('.full-column').on('click', '#selectAll', function () {
        if ($(this).is(':checked') === true) {
            $('.chkBox').attr('checked', 'checked');
        } else {
            $('.chkBox').removeAttr('checked');
        }
    });

    $('#popup').on('change', '#village_code', function () {
        var curr = $(this);
        var dataString = 'village_code=' + curr.val();
        $.ajax({
            url: 'ajax/getVillageGata.php',
            data: dataString,
            type: "POST",
            success: function (data) {
                $('#village_gata').html(data);
            }
        });
    });

    //filer search
    $('.full-column').on('click', '#showFilter', function () {
        if ($('#saveFilter').html() === '') {
            var curr = $(this);
            curr.addClass('active');
            var dataString = '';
            $.ajax({
                url: "ajax/showGrievances.php",
                type: "POST",
                data: dataString,
                cache: false,
                success: function (data) {
                    $('#popup').html(data).show();
                    makeDragable('.popup-header', '.popup-wrap');
                }
            });
        } else {
            getAppliedFilter($('#saveFilter').html());
            $('#popup').show();
            makeDragable('.popup-header', '.popup-wrap');
            $('.hasDatepicker').removeClass('hasDatepicker');
        }
    });

    $('#popup').on('click', '#cancelFilter', function () {
        $('#popup').html('').hide();
    });

    $('#popup').on('click', '.ftab', function () {
        var id = $(this).attr('id');
        $('#popup').find('.filter-tabber').find('.active').removeClass('active');
        $(this).addClass('active');
        $('#popup').find('.tab1').hide();
        $('#popup').find('#stab_' + id).show();
    });

    $('.full-column').on('click', '.clrallfltr', function () {
        window.location.reload();
    });

    $('.full-column').on('click', '.rm_apl_fltr', function () {
        var id = $(this).closest('.filterchip').attr('id').split('_');
        getAppliedFilter($('#saveFilter').html());
        $('#popup').hide();
        if (id[0] === 'checkbox' || id[0] === 'radio') {
            $('#stab_' + id[1]).find('input[value="' + id[2] + '"]').removeAttr('checked');
        } else if (id[0] === 'text') {
            $('#stab_' + id[1]).find('input').val('');
        } else if (id[0] === 'select') {
            $('#stab_' + id[1]).find('select').val('');
        }
        $('#saveFilter').html($('#ffrm').html());
        //$('#applyUserFilter').click();
        clearTimeout(aft);
        aft = setTimeout(applyFilter, 500);
        $(this).closest('.filterchip').remove();
    });

    $('#popup').on('keyup', '.apply_filter_keyup', function () {
        clearTimeout(aft);
        aft = setTimeout(applyFilter, 500);
    });

    $('#popup').on('change', '.apply_filter_change', function () {
        clearTimeout(aft);
        aft = setTimeout(applyFilter, 500);
    });

    $("#popup").on('submit', '#ffrm', function (e) {
        var postData = new FormData(this);
        postData.append('action', 'filter_applied');
        var formURL = "ajax/filterGrievances.php";
        setFilterHTML();
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                setTimeout(function () {
                    showAppliedFilter();
                    $('#main-body').html(data);
                    $('#columnFilterData').find('.filterColumn').each(function () {
                        var index = $('.filterColumn').index(this);
                        if ($(this).is(':checked') === true) {
                            $('.col' + (index + 1)).show();
                        } else {
                            $('.col' + (index + 1)).hide();
                        }
                    });
                    $('#saveFilter').html($('#ffrm').html());
                    $('tCount').text($('#total_count').val());
                }, 400);
            }
        });
        e.preventDefault();
    });

    $('.full-column').on('click', '.upload_griev_report', function () {
        var id = $(this).attr('id');
        $('#popup').load('popup/openGrievanceReport.php?id=' + id, function () {
            $('#popup').show();
        });
    });

    $('#popup').on('click', '.brPic', function () {
        $(this).closest('.dev_req_msg').find('.browsePic').click();
    });

    $('#popup').on('change', '.browsePic', function () {
        // GET THE FILE INPUT.
        var curr = $(this);
        var newID = randID();
        if ($('.col-wrapper').find('#' + newID).length > 0) {
            var newID = randID();
        }
        curr.attr('id', newID);
        var id = $(this).attr('id');
        var fi = document.getElementById(id);

        // RUN A LOOP TO CHECK EACH SELECTED FILE.
        var filec = 0;
        var filecount = 0;
        var check = 0;
        for (var i = 0; i <= fi.files.length - 1; i++) {
            var fname = fi.files.item(i).name;     // THE NAME OF THE FILE.
            var fsize = fi.files.item(i).size / 1024;    // THE SIZE OF THE FILE.
            var ext = fname.split(".");
            ext = ext[ext.length - 1].toLowerCase();
            var arrayExtensions = ["pdf", "PDF"];
            if (arrayExtensions.lastIndexOf(ext) === -1) {
                filec++;
            }
            filecount++;
        }
        if (filec > 0) {
            check++;
            printError("Only pdf is allowed", 3000, '', '');
            curr.val('');
            return false;
        }
        curr.closest('.upldfilediv').find('.upldfilediv_file_txt').text(filecount + ' file(s) is selected');
    });

    $('#popup').on('click', '#submit_grievance_report', function () {
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
                $(this).closest(".dev_req_msg").find(".frm-er-msg").text("");
            }
        });
        var rcheck = 0;
        $('.upldfilediv_file_txt').each(function () {
            if ($(this).text()) {
                rcheck++;
            }
        });
        if (rcheck === 0) {
            printError('Please select report.', 3000, '', '');
            return false;
        }
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
            $('#pfrm').find('.frm_hidden_data').html('');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="submit_grievance_report" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/lamsAction" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#submit_grievance_report" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="Save" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="reload" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="" autocomplete="off">');
            $('#pfrm').submit();
        }
    });

    $("#popup").on('submit', '#pfrm', function (e) {
        var postData = new FormData(this);
        var action_btn_id = $('input[name="action_btn_id"]').val();
        var action_btn_name = $('input[name="action_btn_name"]').val();
        var action_url = $('input[name="action_url"]').val();
        var formURL = action_url;
        $('.act_btn_ovrly').show();
        $(action_btn_id).text('Please wait...');
        $.ajax({
            url: formURL,
            type: "POST",
            data: postData,
            xhr: function () {
                var myXhr = $.ajaxSettings.xhr();
                if (myXhr.upload) {
                    myXhr.upload.addEventListener('progress', progress, false);
                }
                return myXhr;
            },
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                //console.log(data);
                $(action_btn_id).text(action_btn_name);
                var response_data = JSON.parse(data);
                if (response_data['status'] === '-1') {
                    $('#popupDiv').hide();
                    $('#popup_conf_msg').show();
                    $('#popup_conf_msg').find('.cnfrm-task').text(response_data['message']).show();
                    setTimeout(function () {
                        $('#popup_conf_msg').find('.cnfrm-task').text('');
                        $('#popup_conf_msg').hide();
                        $('#popupDiv').show();
                        $('.act_btn_ovrly').hide();
                    }, 2000);
                } else if (response_data['status'] === '1') {
                    $('#popupDiv').hide();
                    $('#popup_conf_msg').show();
                    $('#popup_conf_msg').find('.cnfrm-task').text(response_data['message']).show();
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else if (response_data['status'] === '0') {
                    $('#popupDiv').hide();
                    $('#popup_conf_msg').show();
                    $('#popup_conf_msg').find('.cnfrm-task').text(response_data['message']).show();
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                } else {
                    $('#popupDiv').hide();
                    $('#popup_conf_msg').show();
                    $('#popup_conf_msg').find('.cnfrm-task').text('Something went wrong').show();
                    setTimeout(function () {
                        window.location.reload();
                    }, 2000);
                }
            },
            error: function (xhr, status, error) {
                $('.act_btn_ovrly').hide();
                printError(handleAjaxError(xhr), 4000, 'reload', '');
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

function loadMoreFeedbacks(page) {
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
    fd.append('srno', $('#srno').val());
    $('#main-body').html('<div class="medical-spinner" id="load"></div>');
    $.ajax({
        type: "POST",
        url: "ajax/loadMoreFeedbacks.php",
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

function exportSyncData(exportlist, export_type, type) {
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
        $('.export_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_feedbacks.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_feedbacks.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_feedbacks.php";
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
                    $('.export_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_excel').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
}

function exportGrievances(exportlist, export_type, type) {
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
        $('.export_excel_grievances').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_grievances.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_grievances.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_grievances.php";
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
                    $('.export_excel_grievances').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_excel_grievances').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
        }
    });
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

function randID() {
    var arr = new Array("c1", "c2", "c3", "c4", "c5", "c6", "a1", "a2", "a3", "a4", "a5", "a6", "b1", "b2", "b3", "b4", "b5", "b6", "d1", "d2", "d3", "d4", "d5", "d6");
    var index = Math.floor(Math.random() * (arr.length));
    return arr[index];
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

function loadMoreGrievances(page) {
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
    fd.append('srno', $('#srno').val());
    $('#main-body').html('<div class="medical-spinner" id="load"></div>');
    $.ajax({
        type: "POST",
        url: "ajax/loadMoreGrievances.php",
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


function applyFilter() {
    $('#main-body').html('<div class="medical-spinner" id="load"></div>');
    $("#ffrm").submit();
}

function setFilterHTML() {
    $('#popup input').each(function () {
        if ($(this).attr('type') !== 'file') {
            $(this).attr('value', $(this).val());
        }
    });
    $('#popup select').each(function () {
        var selvalues = $(this).find('option:selected').val();
        $(this).find('option').removeAttr('selected');
        $(this).find('option').prop('selected', false);
        $(this).find('option[value="' + selvalues + '"]').attr('selected', 'selected');
        $(this).find('option[value="' + selvalues + '"]').prop('selected', true);
    });
    $('#popup input:checkbox').each(function () {
        if ($(this).prop('checked') === true) {
            $(this).attr('checked', 'checked');
        } else {
            $(this).removeAttr('checked');
        }
    });
    $('#popup input:radio').each(function () {
        if ($(this).prop('checked') === true) {
            $(this).attr('checked', 'checked');
        } else {
            $(this).removeAttr('checked');
        }
    });
    $('#popup textarea').each(function () {
        var value = $(this).val();
        $(this).text('');
        $(this).append(value);
    });
}

function showAppliedFilter() {
    var applied_filter = '';
    $('#popup input').each(function () {
        if ($(this).val() && ($(this).attr('type') === 'text')) {
            var filter_key_id = $(this).closest('.tab1').attr('id').replace('stab_', '');
            var filter_key = $('#popup').find('.filter-tabber').find('#' + filter_key_id).text();
            var filter_value = $(this).val();
            applied_filter += generateFilter(filter_key_id, filter_key, filter_value, $(this).attr('type'), filter_value);
        }
        if ($(this).prop('checked') === true && ($(this).attr('type') === 'checkbox' || $(this).attr('type') === 'radio')) {
            var filter_key_id = $(this).closest('.tab1').attr('id').replace('stab_', '');
            var filter_key = $('#popup').find('.filter-tabber').find('#' + filter_key_id).text();
            var filter_value = $(this).closest('.filter-choice').find('.fltr-name').text().trim();
            var fil_value = $(this).val();
            applied_filter += generateFilter(filter_key_id, filter_key, filter_value, $(this).attr('type'), fil_value);
        }
    });
    $('#popup select').each(function () {
        if ($(this).hasClass('apply_filter_change') === true) {
            var selvalues = $(this).find('option:selected').val();
            if (selvalues) {
                var filter_key_id = $(this).closest('.tab1').attr('id').replace('stab_', '');
                var filter_key = $('#popup').find('.filter-tabber').find('#' + filter_key_id).text();
                var filter_value = $(this).find('option:selected').text().trim();
                applied_filter += generateFilter(filter_key_id, filter_key, filter_value, 'select', selvalues);
            }
        }
    });
    applied_filter += `<div class="clrallfltr">Clear all filter</div>`;
    $('#appliedFilter').html(applied_filter);
    $('.filter-nos').text($('.filterchip').length + ' filters applied').removeClass('hide');
    if ($('.filterchip').length === 0) {
        $('.clrallfltr').remove();
        $('.filter-nos').text('').addClass('hide');
    }
}

function generateFilter(filter_key_id, filter_key, filter_value, attr_type, fil_value) {
    var applied_filter = '';
    applied_filter += `<div class="filterchip" id="${attr_type}_${filter_key_id}_${fil_value}">
                            <span class="left"><span style="font-weight:500;">${filter_key}:</span>${filter_value}</span>
                            <img class="right rm_apl_fltr" style="cursor:pointer;" title="Remove filter" src="img/clear.svg" alt="" height="12px">
                            <div class="clr"></div>
                        </div>`;
    return applied_filter;
}

function getAppliedFilter(html) {
    var str = `<div class="popup-overlay">
                        <div class="popup-wrap pp-medium-x">
                            <div class="popup-header" style="cursor: move;">
                                <span class="popup-title text-wrapping left">Select filters to apply</span>
                                <span class="popup-close right">
                                    <a style="cursor: pointer;" id="cancelFilter">
                                        <img src="img/clear-w.svg" alt="" width="18px">
                                    </a>
                                </span>
                                <div class="clr"></div>
                            </div>
                            <div id="popupDiv">
                                <div class="popup-body pp-medium-y">
                                    <form id="ffrm">
                                        ${html}
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>`;
    $('#popup').html(str);
}

function progress(e) {
    if (e.lengthComputable) {
        var max = e.total;
        var current = e.loaded;
        var Percentage = Math.round((current * 100) / max);
        printSuccess('File uploading in progress.. ' + Percentage + '% Uploaded', 100000, '', '');
        if (Percentage >= 100) {
            printSuccess('Process completed.', 100000, '', '');
        }
    }
}
$(window).load(function () {
    $.xhr.abortAll();
});
$.xhr = [];
$.xhr.abortAll = function () {
    $(this).each(function (e, t) {
        t.abort();
    });
}
