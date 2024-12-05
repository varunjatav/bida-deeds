var aft;
$(document).ready(function () {

    $(".full-column").on("mouseover", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").show();
    });

    $(".full-column").on("mouseleave", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").hide();
    });

    $('.col-wrapper').on('click', '.import_excel_data', function () {
        $('.browseFile').click();
    });

    $('.col-wrapper').on('change', '.browseFile', function () {
        // GET THE FILE INPUT.
        var curr = $(this);

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
            var arrayExtensions = ["xls", "xlsx"];
            if (arrayExtensions.lastIndexOf(ext) === -1) {
                filec++;
            }
            filecount++;
            if (fsize > 50000) {
                check++;
                $.confirm({
                    title: "Alert",
                    message: "You can upload upto 50 MB.",
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
                message: "Only Excel (xls or xlsx) files are allowed.",
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
        $('#exfrm').submit();
    });

    $(".col-wrapper").on('submit', '#exfrm', function (e) {
        $('.act_btn_ovrly').show();
        $('.import_excel_data').find('.crtxt').text('Please wait...');
        var postData = new FormData(this);
        postData.append('action', 'import_excel_data');
        $('#popup').load('popup/syncData.php', function () {
            $('#popup').show();
            $('.popup-body').find('.slcdstc').append('<p class="left greytxt">Importing data... Please have patience!</p><div class="clr"></div>');
            document.getElementById('log_content').scrollTop = document.getElementById('log_content').scrollHeight;
            $.ajax({
                url: 'action/lamsAction.php',
                type: "POST",
                data: postData,
                processData: false,
                contentType: false,
                success: function (data, textStatus, jqXHR) {
                    var response_data = JSON.parse(data);
                    if (response_data['status'] === '1') {
                        $('.popup-body').find('.slcdstc').append('<p class="left bluetxt">Data import completed.</p><div class="clr"></div>');
                        document.getElementById('log_content').scrollTop = document.getElementById('log_content').scrollHeight;
                        printSuccess(response_data['message'], 3000, 'reload', '');
                        setTimeout(function () {
                            $('#popup').hide().html('');
                            $('.act_btn_ovrly').hide();
                            $('.import_excel_data').find('.crtxt').text('Import Excel Data');
                        }, 2000);
                    } else if (response_data['status'] !== '1') {
                        $('.act_btn_ovrly').hide();
                        $('#popup').hide().html('');
                        printError(response_data['message'], 3000, 'reload', '');
                        $('.import_excel_data').find('.crtxt').text('Import Excel Data');
                    }
                },
                error: function (xhr, status, error) {
                    $('#popup').hide().html('');
                    $('.act_btn_ovrly').hide();
                    printError(handleAjaxError(xhr), 4000, 'reload', '');
                }
            });
        });
        e.preventDefault();
    });

    $('.col-wrapper').on('click', '.sync_data', function (e) {
        var curr = $(this);
        $.confirm({
            title: "Data Sync Confirmation",
            message: "Are you sure want to sync all data ?",
            buttons: {
                "Yes": {
                    "class": "curr_btn",
                    action: function () {
                        $('.act_btn_ovrly').show();
                        $('#confirmOverlay').remove();
                        curr.find('.crtxt').text('Please wait...');
                        $('#popup').load('popup/syncData.php', function () {
                            $('#popup').show();
                            $('.popup-body').find('.slcdstc').append('<p class="left">Sync started. It will take 3-4 minutes. Please wait...</p><div class="clr"></div>');
                            var dataString = 'action=sync_village_data';
                            $.ajax({
                                url: "action/lamsAction.php",
                                type: "POST",
                                data: dataString,
                                cache: false,
                                success: function (data) {
                                    var response_data = JSON.parse(data);
                                    $('#village_codes').val(response_data.success_array['village_data']);
                                    var village_codes_array = $('#village_codes').val().split(',');
                                    syncVillageData(village_codes_array[0], 0);
                                }
                            });
                        });
                        e.preventDefault();
                    }
                },
                No: {
                    "class": "",
                    action: function () {}
                }
            }
        });
    });

    // update api sync data
    $('.col-wrapper').on('click', '.update_sync_data', function (e) {
        var curr = $(this);
        $.confirm({
            title: "Data Sync Confirmation",
            message: "Are you sure want to update sync all data ?",
            buttons: {
                "Yes": {
                    "class": "curr_btn",
                    action: function () {
                        $('.act_btn_ovrly').show();
                        $('#confirmOverlay').remove();
                        curr.find('.crtxt').text('Please wait...');
                        $('#popup').load('popup/updateSyncData.php', function () {
                            $('#popup').show();
                            $('.popup-body').find('.slcdstc').append('<p class="left">Update started. It will take 3-4 minutes. Please wait...</p><div class="clr"></div>');
                            var dataString = 'action=sync_village_data';
                            $.ajax({
                                url: "action/lamsAction.php",
                                type: "POST",
                                data: dataString,
                                cache: false,
                                success: function (data) {
                                    var response_data = JSON.parse(data);
                                    $('#village_codes').val(response_data.success_array['village_data']);
                                    var village_codes_array = $('#village_codes').val().split(',');
                                    updateSyncVillageData(village_codes_array[0], 0);
                                }
                            });
                        });
                        e.preventDefault();
                    }
                },
                No: {
                    "class": "",
                    action: function () {}
                }
            }
        });
    });

    $("#popup").on("click", "#cancel_sync_popup", function () {
        $('#popup').hide().html('');
        window.location.reload();
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
                url: "ajax/showSyncData.php",
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
        var formURL = "ajax/filterSyncData.php";
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
        loadMoreSyncData(0);
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

    $('.full-column').on('click', '#selectAll', function () {
        if ($(this).is(':checked') === true) {
            $('.chkBox').attr('checked', 'checked');
        } else {
            $('.chkBox').removeAttr('checked');
        }
    });

    // E-BASTA
    $('.col-wrapper').on('change', '#type', function () {
        $('#village_code').val('');
        //$('.village_gata').parent.addClass('hide');
        $('.village_khata').parent().addClass('hide');
        $('.containerDiv').html('');
        $('.kashtkar').html('');
        $('.village_gata, .village_khata, .kashtkar').val('');
        $('.village_khata').html('');
        $('.kashtkar, #add_kashtkar').parent().addClass('hide');
        $('.titimma_chk').parent().parent().addClass('hide');
        $('.titimma_chk').prop('checked', false);
        $('.gata_div').addClass('hide');
        $('#appendDiv').html('');
        //$('.gata_kashtkar_div').html('');
        if ($(this).val() === '1') {
            $('.report_feedback').attr('report_type', 'village_wise');
        } else {
            $('.report_feedback').attr('report_type', 'gata_wise');
        }
        $('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
        $('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
        $('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
        $('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
        $('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
    });

    $('.col-wrapper').on('change', '#village_code', function () {
        var curr = $(this);
        if ($('#type').val() === '2') {
            var dataString = 'village_code=' + curr.val() + '&type=2';
            $.ajax({
                url: 'ajax/getVillageGata.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    $('#appendDiv').html('');
                    $('.village_gata').html(data);
                    $('.village_gata').parent().removeClass('hide');
                    $('.kashtkar').html('');
                    $('.kashtkar, #add_kashtkar, #add_more_kashtkar, .village_khata').parent().addClass('hide');
                    $('.titimma_chk').parent().parent().addClass('hide');
                    $('.titimma_chk').prop('checked', false);
                    $('.village_khata').val('');
                    $('.containerDiv').html('');
                    $('.gata_div').removeClass('hide');
                    $('.append_ansh_rakba_div').html('');
                }
            });
        } else {
            $('#appendDiv').html('');
            //$('.village_gata').html('');
            $('.village_gata').parent().addClass('hide');
            if (curr.val()) {
                var dataString = 'village_code=' + curr.val();
                $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
                $.ajax({
                    url: 'ajax/loadVillageEbasta.php',
                    data: dataString,
                    type: "POST",
                    success: function (data) {
                        setTimeout(function () {
                            $('.containerDiv').html(data);
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
                        }, 400);
                    }
                });
            } else {
                $('.containerDiv').html('');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
            }
        }
    });

    $('.col-wrapper').on('change', '.village_gata', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'village_code=' + $('#village_code').val() + '&gata_no=' + curr.val();
            if ($('.village_gata').length === 1) {
                $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
            }
            $.ajax({
                url: 'ajax/loadKhata.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('');
                    curr.closest('.gata_kashtkar_div').find('.kashtkar').html('');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.kashtkar').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.village_khata').html(data);
                    curr.closest('.gata_kashtkar_div').find('.village_khata').parent().removeClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
                    $('#add_kashtkar').parent().removeClass('hide');
                    $('.titimma_chk').parent().parent().addClass('hide');
                    $('.titimma_chk').prop('checked', false);
                    if ($('.village_gata').length === 1) {
                        $('.containerDiv').html('');
                    }
                }
            });
        } else {
            if ($('.village_gata').length === 1) {
                curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('');
                curr.closest('.gata_kashtkar_div').find('.village_khata').html('');
                curr.closest('.gata_kashtkar_div').find('.village_khata').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.kashtkar').html('');
                curr.closest('.gata_kashtkar_div').find('.kashtkar').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
                $('#add_kashtkar').parent().addClass('hide');
                $('.titimma_chk').parent().parent().addClass('hide');
                $('.titimma_chk').prop('checked', false);
                $('.containerDiv').html('');
            } else {
                curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('');
                curr.closest('.gata_kashtkar_div').find('.village_khata').html('');
                curr.closest('.gata_kashtkar_div').find('.village_khata').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.kashtkar').html('');
                curr.closest('.gata_kashtkar_div').find('.kashtkar').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
                curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
            }
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
        }
    });

    $('.col-wrapper').on('change', '.village_khata', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'village_code=' + $('#village_code').val() + '&gata_no=' + curr.closest('.gata_kashtkar_div').find('.village_gata').val() + '&khata_no=' + curr.val();
            if ($('.village_khata').length === 1) {
                $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
            }
            $.ajax({
                url: 'ajax/loadKashtkar.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    curr.closest('.gata_kashtkar_div').find('.kashtkar').html(data);
                    curr.closest('.gata_kashtkar_div').find('.kashtkar').parent().removeClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
                    $('#add_kashtkar').parent().removeClass('hide');
                    $('.titimma_chk').parent().parent().addClass('hide');
                    $('.titimma_chk').prop('checked', false);
                    if ($('.village_khata').length === 1) {
                        $('.containerDiv').html('');
                    }
                }
            });
        } else {
            if ($('.village_khata').length === 1) {
                curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('');
                curr.closest('.gata_kashtkar_div').find('.kashtkar').html('');
                curr.closest('.gata_kashtkar_div').find('.kashtkar').parent().addClass('hide');
                $('#add_kashtkar').parent().addClass('hide');
                $('.titimma_chk').parent().parent().addClass('hide');
                $('.titimma_chk').prop('checked', false);
                $('.containerDiv').html('');
            } else {
                curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('');
                curr.closest('.gata_kashtkar_div').find('.kashtkar').html('');
                curr.closest('.gata_kashtkar_div').find('.kashtkar').parent().addClass('hide');
            }
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
        }
    });

    $('.col-wrapper').on('change', '.kashtkar', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'village_code=' + $('#village_code').val() + '&khata_no=' + curr.closest('.gata_kashtkar_div').find('.village_khata').val() + '&gata_no=' + curr.closest('.gata_kashtkar_div').find('.village_gata').val() + '&kashtkar=' + curr.val() + '&kashtkar_name=' + $('.kashtkar option:selected').text().replace(/ /g, '%20');
            $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
            $.ajax({
                url: 'ajax/loadGataEbasta.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    setTimeout(function () {
                        $('.containerDiv').html(data);
                        $('#add_more_kashtkar').parent().removeClass('hide');
                        $('.titimma_chk').parent().parent().removeClass('hide');
                        $('.titimma_chk').prop('checked', false);
                        curr.closest('.gata_kashtkar_div').find('.rm_gata_kashtkar_div').parent().removeClass('hide');
                        curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('').append($('#ansh_rakba_div').html());
                        if (curr.closest('.gata_kashtkar_div').find('.ebasta_doc_1').attr('id')) {
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', $('.ebasta_doc_1').attr('id')).parent().removeClass('hide');
                        } else {
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
                        }
                        if (curr.closest('.gata_kashtkar_div').find('.ebasta_doc_2').attr('id')) {
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', $('.ebasta_doc_2').attr('id')).parent().removeClass('hide');
                        } else {
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
                        }
                        if (curr.closest('.gata_kashtkar_div').find('.ebasta_doc_3').attr('id')) {
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', $('.ebasta_doc_3').attr('id')).parent().removeClass('hide');
                        } else {
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
                        }
                        if (curr.closest('.gata_kashtkar_div').find('.ebasta_doc_4').attr('id')) {
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', $('.ebasta_doc_4').attr('id')).parent().removeClass('hide');
                        } else {
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
                        }
                        if (curr.closest('.gata_kashtkar_div').find('.ebasta_doc_5').attr('id')) {
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', $('.ebasta_doc_5').attr('id')).parent().removeClass('hide');
                        } else {
                            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
                        }
                        $('#ansh_rakba_div').html('');
                    }, 400);
                }
            });
        } else {
            $('.containerDiv').html('');
            curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('');
            $('.titimma_chk').parent().parent().removeClass('hide');
            $('.titimma_chk').prop('checked', false);
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
            curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc5').attr('href', '').parent().addClass('hide');
        }
    });

    $('.col-wrapper').on('click', '.titimma_chk', function () {
        if ($(this).is(':checked') === true) {
            $('#frm_5').removeClass('hide');
        } else {
            $('#frm_5').addClass('hide');
        }
    });

    $('.col-wrapper').on('click', '.brPic', function () {
        $(this).closest('.dev_req_msg').find('.browsePic').click();
    });

    $('.col-wrapper').on('change', '.browsePic', function () {
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
        curr.closest('.upldfilediv').find('.brPic').removeClass('brPic');
        curr.closest('.upldfilediv').find('.upldfilediv_crs').removeClass('hide');

        var files_selected = [];
        $('.upload').each(function () {
            if ($(this).find('.upldfilediv_file_txt').text()) {
                var index = $(this).closest('form').attr('id').replace('frm_', '');
                files_selected.push(index);
            }
        });
        $('#total_files_count').val(files_selected);
    });

    $('.col-wrapper').on('click', '.upldfilediv_crs', function () {
        var curr = $(this);
        curr.closest('.upldfilediv').find('.browsePic').val('');
        curr.closest('.upldfilediv').find('.upldfilediv_file_txt').text('');
        curr.closest('.upldfilediv').find('.upload').addClass('brPic');
        curr.closest('.upldfilediv').find('.upldfilediv_crs').addClass('hide');
        var files_selected = [];
        $('.upload').each(function () {
            if ($(this).find('.upldfilediv_file_txt').text()) {
                var index = $(this).closest('form').attr('id').replace('frm_', '');
                files_selected.push(index);
            }
        });
        $('#total_files_count').val(files_selected);
    });

    $('.col-wrapper').on('click', '.save_village_ebasta', function (e) {
        if ($('#village_code').val()) {
            var check = 0;
            $('.upldfilediv_file_txt').each(function () {
                if ($(this).text()) {
                    check++;
                }
            });
            if (check === 0) {
                printError('Please select atleast on file.', 3000, '', '');
            } else {
                $('.act_btn_ovrly').show();
                var files_count_array = $('#total_files_count').val().split(',');
                uploadVilageEbastaFiles(files_count_array[0], 0);
            }
        } else {
            printError('Please select village', 3000, '', '');
        }
    });

    $('.col-wrapper').on('click', '.save_gata_ebasta', function (e) {
        if ($('.village_gata').val()) {
            var check = 0;
            $('.fldrequired').each(function () {
                if ($(this).val() === '') {
                    check++;
                    $(this).addClass('frm-error');
                } else {
                    $(this).removeClass('frm-error');
                }
            });
            if (check > 0) {
                return false;
            }
            var check = 0;
            $('.upldfilediv_file_txt').each(function () {
                if ($(this).text()) {
                    check++;
                }
            });
            if (check === 0) {
                printError('Please select atleast on file.', 3000, '', '');
            } else {
                $('.act_btn_ovrly').show();
                var files_count_array = $('#total_files_count').val().split(',');
                uploadGataEbastaFiles(files_count_array[0], 0);
            }
        } else {
            printError('Please select gata', 3000, '', '');
        }
    });

    $(".col-wrapper").on('click', '#add_more_kashtkar', function (e) {
        var str = '';
        str += `<div class="gata_kashtkar_div bmarg">`;
        str += $('.village_gata:last').parent().prop('outerHTML');
        str += `<div class="ebasta_gata_select dev_req_msg left rmarg hide">
                        <select class="village_khata fldrequired" id="village_khata" name="khata[]">
                            <option value="">Select Khata</option>
                        </select>
                        <div class="ebasta_gata_select__arrow"></div>
                    </div>
                    <div class="ebasta_select dev_req_msg left rmarg hide">
                        <select class="kashtkar fldrequired" name="kashtkar[]">
                            <option value="">Select Kashtkar</option>
                        </select>
                        <div class="ebasta_select__arrow"></div>
                    </div>
                    <div class="append_ansh_rakba_div"></div>
                    <div class="posrel left lmarg" style="width:28px; height:28px; top:4px;">
                        <div class="upldfilediv_crs rm_gata_kashtkar_div" title="Remove">
                            <div style="position: relative;">
                                <img src="img/close_remove.svg">
                            </div>
                        </div>
                    </div>
                    <div class="posrel left lmarg hide" style="width:28px; height:28px; top:4px;">
                        <a class="ebasta_dwnldfilediv dwnld_ebasta_doc1" title="Download Sehmati Document" target="_blank">
                            <div style="position: relative;">
                                <img src="img/download_1.svg">
                            </div>
                        <a>
                    </div>
                    <div class="posrel left lmarg hide" style="width:28px; height:28px; top:4px;">
                        <a class="ebasta_dwnldfilediv dwnld_ebasta_doc2" title="Download Bainama/Letter Document" target="_blank">
                            <div style="position: relative;">
                                <img src="img/download_1.svg">
                            </div>
                        </a>
                    </div>
                    <div class="posrel left lmarg hide" style="width:28px; height:28px; top:4px;" target="_blank">
                        <a class="ebasta_dwnldfilediv dwnld_ebasta_doc3" title="Download Kabza Document">
                            <div style="position: relative;">
                                <img src="img/download_1.svg">
                            </div>
                        </a>
                    </div>
                    <div class="posrel left lmarg hide" style="width:28px; height:28px; top:4px;" target="_blank">
                        <a class="ebasta_dwnldfilediv dwnld_ebasta_doc4" title="Download Khatauni Document">
                            <div style="position: relative;">
                                <img src="img/download_1.svg">
                            </div>
                        </a>
                    </div>
                    <div class="posrel left lmarg hide" style="width:28px; height:28px; top:4px;" target="_blank">
                        <a class="ebasta_dwnldfilediv dwnld_ebasta_doc5" title="Download Titimma Document">
                            <div style="position: relative;">
                                <img src="img/download_1.svg">
                            </div>
                        </a>
                    </div>
                    `;
        str += `<div class="clr"></div>
                </div>`;
        $('#appendDiv').append(str);
    });

    $(".col-wrapper").on('click', '.rm_gata_kashtkar_div', function (e) {
        $(this).closest('.gata_kashtkar_div').remove();
    });

    $(".col-wrapper").on('click', '#add_kashtkar', function (e) {
        var village_name = $('#village_code option:selected').text().replace(/ /g, '%20');
        var village_code = $('#village_code option:selected').val();
        var gata_name = $('.village_gata:last option:selected').text().replace(/ /g, '%20');
        var gata_no = $('.village_gata:last option:selected').val().replace(/ /g, '%20');
        var khata_no = $('.village_khata:last option:selected').val().replace(/ /g, '%20');
        if (gata_no && khata_no) {

            $('#popup').load('popup/addKashtkar.php?village_name=' + village_name + '&village_code=' + village_code + '&gata_name=' + gata_name + '&gata_no=' + gata_no + '&khata_no=' + khata_no, function () {
                $('#popup').show();
                makeDragable('.popup-header', '.popup-wrap');
            });
        } else {
            printError("Please select Gata & Khata.", 3000, '', '');
        }
    });

    $('#popup').on('click', '#save_kashtkar', function () {
        var check = 0;
        $('#popup').find('.fldrequired').each(function () {
            $('.frm-txtbox').removeClass('frm-focus');
            if ($(this).val() === '') {
                check++;
                $(this).closest('.dev_req_msg').next('.frm-er-msg').text('This field is required');
                $(this).addClass('frm-error');
            } else {
                $(this).closest('.dev_req_msg').next('.frm-er-msg').text('');
                $(this).removeClass('frm-error');
            }
        });
        if (check > 0) {
            return false;
        }
        $('.act_btn_ovrly').show();
        $("#kfrm").on('submit', function (event) {
            event.preventDefault();
            var postData = new FormData(this);
            postData.append('action', 'save_kashtkar');
            var formURL = "action/lamsAction.php";
            $('#save_kashtkar').text('Please wait...');
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                processData: false,
                contentType: false,
                success: function (data, textStatus, jqXHR) {
                    unsaved = false;
                    var response_data = JSON.parse(data);
                    $('#save_kashtkar').text('save');
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
                            $('#popup').hide().html('');
                            $('.kashtkar:last').append('<option value="' + response_data.success_array['owner_no'] + '">' + response_data.success_array['kashtkar'] + '</option>');
                            $('.kashtkar:last').val(response_data.success_array['owner_no']).change();
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
                }
            });
            event.preventDefault();	//STOP default action
        });
        $("#kfrm").submit(); //SUBMIT FORM
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
        if (resource_type === '3') {
            if (report_type === 'village_wise' && village_code === '') {
                printError("Please select village.", 3000, '', '');
                return false;
            } else if (report_type === 'gata_wise' && village_code === '' && village_gata === '') {
                printError("Please select village.", 3000, '', '');
                return false;
            } else if (report_type === 'gata_wise' && village_gata === '') {
                printError("Please select gata.", 3000, '', '');
                return false;
            }
        } else if (resource_type === '4') {
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

    $('.full-column').on('click', '.export_village_ansh_excel', function () {
        if ($('#village_code').val() === '') {
            printError('Please select village.', 4000, 'reload', '');
            return false;
        }
        exportEbastaData('export', 'excel', $(this).attr('id'));
    });

    $(document).mouseup(function (e) {
        var container = $("#checkboxes");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
        }
    });
});

function syncVillageData(village_code, count) {
    var dataString = 'village_code=' + village_code + '&count=' + count + '&action=sync_village_detail_data';
    $('.popup-body').find('.slcdstc').append('<p class="left greytxt">Start sync data of village code: ' + village_code + '</p><div class="clr"></div>');
    document.getElementById('log_content').scrollTop = document.getElementById('log_content').scrollHeight;
    //console.log('Start sync data of village code: ' + village_code);
    $.ajax({
        url: 'action/deedAction.php',
        data: dataString,
        type: "POST",
        success: function (data) {
            var response_data = JSON.parse(data);
            if (response_data['status'] === '1') {
                $('.popup-body').find('.slcdstc').append('<p class="left grntxt" time="' + response_data.success_array['time'] + '">Sync completed of village code: ' + village_code + ' in (' + response_data.success_array['time_execution'] + ')</p><div class="clr"></div>');
                //console.log('Sync completed of village code: ' + village_code);
                var village_codes_array = $('#village_codes').val().split(',');
                const index = village_codes_array.indexOf(village_code);
                if (index > -1) {
                    village_codes_array.splice(index, 1);
                    $('#village_codes').val(village_codes_array);
                }

                if ($('#village_codes').val()) {
                    //console.log(response_data.success_array['count']);
                    setTimeout(function () {
                        syncVillageData(village_codes_array[0], response_data.success_array['count']);
                    }, 800);
                } else {
                    $('.sync_data').find('.crtxt').text('Sync Data');
                    var total_time = 0;
                    $('#popup').find('.grntxt').each(function () {
                        total_time += parseFloat($(this).attr('time'));
                    });

                    $('.popup-body').find('.slcdstc').append('<p class="left bluetxt">Sync completed. Total time: (' + convertStoMs(total_time) + ')</p><div class="clr"></div>');
                    //console.log("Sync Completed.");
                    $('#cancel_sync_popup').parent().show();
                }
                document.getElementById('log_content').scrollTop = document.getElementById('log_content').scrollHeight;
            } else if (response_data['status'] !== '1') {
                $('.popup-body').find('.slcdstc').append('<p class="left redtxt">Error in sync data of village code: ' + village_code + '</p><div class="clr"></div>');
                //console.log('Error in sync data of village code: ' + village_code);
                var village_codes_array = $('#village_codes').val().split(',');
                const index = village_codes_array.indexOf(village_code);
                if (index > -1) {
                    village_codes_array.splice(index, 1);
                    $('#village_codes').val(village_codes_array);
                }

                if ($('#village_codes').val()) {
                    setTimeout(function () {
                        syncVillageData(village_codes_array[0]);
                    }, 1000);
                } else {
                    $('.sync_data').find('.crtxt').text('Sync Data');
                    $('.popup-body').find('.slcdstc').append('<p class="left bluetxt">Sync completed.</p><div class="clr"></div>');
                    //console.log("Sync Completed.");
                    $('#cancel_sync_popup').parent().show();
                }
                document.getElementById('log_content').scrollTop = document.getElementById('log_content').scrollHeight;
            }
        },
        async: true
    });
}

// update sync data fucntion
function updateSyncVillageData(village_code, count) {
    var dataString = 'village_code=' + village_code + '&count=' + count + '&action=update_sync_village_detail_data';
    $('.popup-body').find('.slcdstc').append('<p class="left greytxt">Start sync data of village code: ' + village_code + '</p><div class="clr"></div>');
    document.getElementById('log_content').scrollTop = document.getElementById('log_content').scrollHeight;
    //console.log('Start sync data of village code: ' + village_code);
    $.ajax({
        url: 'action/deedAction.php',
        data: dataString,
        type: "POST",
        success: function (data) {
            var response_data = JSON.parse(data);
            if (response_data['status'] === '1') {
                $('.popup-body').find('.slcdstc').append('<p class="left grntxt" time="' + response_data.success_array['time'] + '">Update completed of village code: ' + village_code + ' in (' + response_data.success_array['time_execution'] + ')</p><div class="clr"></div>');
                //console.log('Sync completed of village code: ' + village_code);
                var village_codes_array = $('#village_codes').val().split(',');
                const index = village_codes_array.indexOf(village_code);
                if (index > -1) {
                    village_codes_array.splice(index, 1);
                    $('#village_codes').val(village_codes_array);
                }

                if ($('#village_codes').val()) {
                    //console.log(response_data.success_array['count']);
                    setTimeout(function () {
                        updateSyncVillageData(village_codes_array[0], response_data.success_array['count']);
                    }, 800);
                } else {
                    $('.update_sync_data').find('.crtxt').text('Update Data');
                    var total_time = 0;
                    $('#popup').find('.grntxt').each(function () {
                        total_time += parseFloat($(this).attr('time'));
                    });

                    $('.popup-body').find('.slcdstc').append('<p class="left bluetxt">Update completed. Total time: (' + convertStoMs(total_time) + ')</p><div class="clr"></div>');
                    //console.log("Sync Completed.");
                    $('#cancel_sync_popup').parent().show();
                }
                document.getElementById('log_content').scrollTop = document.getElementById('log_content').scrollHeight;
            } else if (response_data['status'] !== '1') {
                $('.popup-body').find('.slcdstc').append('<p class="left redtxt">Error in update data of village code: ' + village_code + '</p><div class="clr"></div>');
                //console.log('Error in sync data of village code: ' + village_code);
                var village_codes_array = $('#village_codes').val().split(',');
                const index = village_codes_array.indexOf(village_code);
                if (index > -1) {
                    village_codes_array.splice(index, 1);
                    $('#village_codes').val(village_codes_array);
                }

                if ($('#village_codes').val()) {
                    setTimeout(function () {
                        updateSyncVillageData(village_codes_array[0]);
                    }, 1000);
                } else {
                    $('.update_sync_data').find('.crtxt').text('Update Data');
                    $('.popup-body').find('.slcdstc').append('<p class="left bluetxt">Update completed.</p><div class="clr"></div>');
                    //console.log("Sync Completed.");
                    $('#cancel_sync_popup').parent().show();
                }
                document.getElementById('log_content').scrollTop = document.getElementById('log_content').scrollHeight;
            }
        },
        async: true
    });
}

function uploadVilageEbastaFiles(files_count, count) {
    $('#frm_' + files_count).find('.upldfilediv_crs').addClass('hide');
    $(".col-wrapper").on('submit', '#frm_' + files_count, function (e) {
        var postData = new FormData(this);
        var formURL = 'action/lamsAction.php';
        postData.append('action', 'save_village_ebasta');
        postData.append('files_count', files_count);
        postData.append('village_code', $('#village_code').val());
        postData.append('count', count);
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
                var response_data = JSON.parse(data);
                var files_count_array = $('#total_files_count').val().split(',');
                const index = files_count_array.indexOf(files_count);
                if (index > -1) {
                    files_count_array.splice(index, 1);
                    $('#total_files_count').val(files_count_array);
                }
                if ($('#total_files_count').val()) {
                    setTimeout(function () {
                        uploadVilageEbastaFiles(files_count_array[0], response_data.success_array['count']);
                    }, 100);
                } else {
                    $('.act_btn_ovrly').hide();
                    unsaved = false;
                    (async () => {
                        printSuccess('Ebasta updated successfully.', 2000, '', '');
                        await new Promise((resolve) => {
                            var dataString = 'village_code=' + $('#village_code').val();
                            $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
                            $.ajax({
                                url: 'ajax/loadVillageEbasta.php',
                                data: dataString,
                                type: "POST",
                                success: function (data) {
                                    setTimeout(function () {
                                        $('.containerDiv').html(data);
                                    }, 400);
                                }
                            });
                        });
                    })();
                }
            },
            error: function (xhr, status, error) {
                printError(handleAjaxError(xhr), 3000, 'reload', '');
            }
        });
        e.stopImmediatePropagation();
        e.preventDefault();
    });
    $('#frm_' + files_count).submit();
}

function uploadGataEbastaFiles(files_count, count) {
    $('#frm_' + files_count).find('.upldfilediv_crs').addClass('hide');
    $(".col-wrapper").on('submit', '#frm_' + files_count, function (e) {
        var gata_no = [];
        var khata_no = [];
        var kashtkar = [];
        var kashtkar_ansh = [];
        var ansh_rakba = [];
        var ansh_date = [];
        var postData = new FormData(this);
        var formURL = 'action/lamsAction.php';
        postData.append('action', 'save_gata_ebasta');
        postData.append('files_count', files_count);
        postData.append('village_code', $('#village_code').val());
        $('.col-wrapper').find('.village_gata').each(function () {
            gata_no.push($(this).val());
        });
        $('.col-wrapper').find('.village_khata').each(function () {
            khata_no.push($(this).val());
        });
        $('.col-wrapper').find('.kashtkar').each(function () {
            kashtkar.push($(this).val());
        });
        $('.col-wrapper').find('.ansh').each(function () {
            kashtkar_ansh.push($(this).val());
        });
        $('.col-wrapper').find('.ansh_rakba').each(function () {
            ansh_rakba.push($(this).val());
        });
        $('.col-wrapper').find('.ansh_date').each(function () {
            ansh_date.push($(this).val());
        });
        postData.append('gata_no', gata_no);
        postData.append('khata_no', khata_no);
        postData.append('kashtkar', kashtkar);
        postData.append('kashtkar_ansh', kashtkar_ansh);
        postData.append('ansh_rakba', ansh_rakba);
        postData.append('ansh_date', ansh_date);
        postData.append('count', count);
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
                var response_data = JSON.parse(data);
                var files_count_array = $('#total_files_count').val().split(',');
                const index = files_count_array.indexOf(files_count);
                if (index > -1) {
                    files_count_array.splice(index, 1);
                    $('#total_files_count').val(files_count_array);
                }
                if ($('#total_files_count').val()) {
                    setTimeout(function () {
                        uploadGataEbastaFiles(files_count_array[0], response_data.success_array['count']);
                    }, 100);
                } else {
                    $('.act_btn_ovrly').hide();
                    unsaved = false;
                    (async () => {
                        printSuccess('Ebasta updated successfully.', 2000, '', '');
                        await new Promise((resolve) => {
                            $($('.village_gata').get().reverse()).each(function () {
                                var curr = $(this);
                                if ($('.village_gata').length === 1) {
                                    curr.val('');
                                    curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('');
                                    curr.closest('.gata_kashtkar_div').find('.village_khata').html('');
                                    curr.closest('.gata_kashtkar_div').find('.village_khata').parent().addClass('hide');
                                    curr.closest('.gata_kashtkar_div').find('.kashtkar').html('');
                                    curr.closest('.gata_kashtkar_div').find('.kashtkar').parent().addClass('hide');
                                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc1').attr('href', '').parent().addClass('hide');
                                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc2').attr('href', '').parent().addClass('hide');
                                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc3').attr('href', '').parent().addClass('hide');
                                    curr.closest('.gata_kashtkar_div').find('.dwnld_ebasta_doc4').attr('href', '').parent().addClass('hide');
                                    $('#add_kashtkar, #add_more_kashtkar').parent().addClass('hide');
                                    $('.titimma_chk').parent().parent().addClass('hide');
                                    $('.titimma_chk').prop('checked', false);
                                    $('.containerDiv').html('');
                                } else {
                                    curr.closest('.gata_kashtkar_div').remove();
                                    $('.titimma_chk').parent().parent().addClass('hide');
                                    $('.titimma_chk').prop('checked', false);
                                }
                            });
                        });
                    })();
                }
            },
            error: function (xhr, status, error) {
                printError(handleAjaxError(xhr), 3000, 'reload', '');
            }
        });
        e.stopImmediatePropagation();
        e.preventDefault();
    });
    $('#frm_' + files_count).submit();
}

function loadMoreSyncData(page) {
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
    $('#main-body').html('<div class="medical-spinner" id="load"></div>');
    $.ajax({
        type: "POST",
        url: "ajax/loadMoreSyncData.php",
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
        var formUrl = "report/export_sync_data.php";
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

function exportEbastaData(exportlist, export_type, type) {
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
    fd.append('village_name', $('#village_code option:selected').text());

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
        $('.export_village_ansh_excel').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "report/export_village_ansh_data.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_village_ansh_data.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_village_ansh_data.php";
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
                    $('.export_village_ansh_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_village_ansh_excel').html('<img src="img/pdf.svg" height="22px">');
                }
                window.open('downloadexport?file=' + response_data['url'], '_blank');
            }
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

function convertStoMs(seconds) {
    let minutes = ~~(seconds / 60);
    let extraSeconds = Math.floor(seconds % 60);
    return minutes + " mins : " + extraSeconds + " secs";
}

function randID() {
    var arr = new Array("c1", "c2", "c3", "c4", "c5", "c6", "a1", "a2", "a3", "a4", "a5", "a6", "b1", "b2", "b3", "b4", "b5", "b6", "d1", "d2", "d3", "d4", "d5", "d6");
    var index = Math.floor(Math.random() * (arr.length));
    return arr[index];
}

function progress(e) {
    var files_count_array = $('#total_files_count').val().split(',');
    if (e.lengthComputable && $('#frm_' + files_count_array[0]).find('.browsePic').val()) {
        var max = e.total;
        var current = e.loaded;
        var Percentage = Math.round((current * 100) / max);
        $('#frm_' + files_count_array[0]).find('.upldfilediv_file_txt').text(Percentage + '% Uploaded');
        if (Percentage >= 100) {
            $('#frm_' + files_count_array[0]).find('.upldfilediv_file_txt').text('Upload completed');
            $.xhr.abortAll();
        }
    }
}
$(window).on('load', function () {
    $.xhr.abortAll();
});
$.xhr = [];
$.xhr.abortAll = function () {
    $(this).each(function (e, t) {
        t.abort();
    });
};