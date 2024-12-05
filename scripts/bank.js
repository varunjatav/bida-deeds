var aft;
$(document).ready(function () {

    $(".full-column").on("mouseover", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").show();
    });

    $(".full-column").on("mouseleave", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").hide();
    });

    $('.full-column').on('click', '.export_excel', function () {
        exportBankData('export', 'excel', $(this).attr('id'));
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
                printError('You can upload upto 50 MB.', 4000, 'reload', '');
                return false;
            }
        }
        if (filec > 0) {
            check++;
            printError('Only Excel (xls or xlsx) files are allowed.', 4000, 'reload', '');
            return false;
        }
        $('#exfrm').submit();
    });

    $(".col-wrapper").on('submit', '#exfrm', function (e) {
        $('.act_btn_ovrly').show();
        $('.import_excel_data').find('.crtxt').text('Please wait...');
        var postData = new FormData(this);
        postData.append('action', 'import_bank_data');
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
                        printError(response_data['message'], 4000, 'reload', '');
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

    //filer search
    $('.full-column').on('click', '#showFilter', function () {
        if ($('#saveFilter').html() === '') {
            var curr = $(this);
            curr.addClass('active');
            var dataString = '';
            $.ajax({
                url: "ajax/showBankData.php",
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
        var formURL = "ajax/filterBankData.php";
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
            $('.cellDivHeader:eq(' + (index + 1) + '), .col' + (index + 1)).show();
        } else {
            $('.cellDivHeader:eq(' + (index + 1) + '), .col' + (index + 1)).hide();
        }
    });

    $('.full-column').on('click', '.perPage', function () {
        $(this).next('ul').toggle();
    });

    $('.full-column').on('click', '.setPage', function () {
        $('#pagelimit').val($(this).text());
        $('.perPage').text($(this).text());
        $(this).closest('ul').toggle();
        loadMoreBankData(0);
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
                        }, 400);
                    }
                });
            } else {
                $('.containerDiv').html('');
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
                    curr.closest('.gata_kashtkar_div').find('.kashtkar').parent().addClass('hide');
                    curr.closest('.gata_kashtkar_div').find('.village_khata').html(data);
                    curr.closest('.gata_kashtkar_div').find('.village_khata').parent().removeClass('hide');
                    $('#add_kashtkar').parent().removeClass('hide');
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
                $('#add_kashtkar').parent().addClass('hide');
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
            }
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
                    $('#add_kashtkar').parent().removeClass('hide');
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
                $('.containerDiv').html('');
            } else {
                curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('');
                curr.closest('.gata_kashtkar_div').find('.kashtkar').html('');
                curr.closest('.gata_kashtkar_div').find('.kashtkar').parent().addClass('hide');
            }
        }
    });

    $('.col-wrapper').on('change', '.kashtkar', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'village_code=' + $('#village_code').val() + '&khata_no=' + curr.closest('.gata_kashtkar_div').find('.village_khata').val() + '&gata_no=' + curr.closest('.gata_kashtkar_div').find('.village_gata').val() + '&kashtkar=' + curr.val() + '&kashtkar_name=' + $('.kashtkar option:selected').text().replace(/ /g, '%20');
            $('.containerDiv').html('<div class="medical-spinner" id="load"></div>');
            $.ajax({
                url: 'ajax/loadMortagedData.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    setTimeout(function () {
                        $('.containerDiv').html(data);
                        $('#add_more_kashtkar').parent().removeClass('hide');
                        curr.closest('.gata_kashtkar_div').find('.rm_gata_kashtkar_div').parent().removeClass('hide');
                        curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('').append($('#ansh_rakba_div').html());
                        $('#ansh_rakba_div').html('');
                    }, 400);
                }
            });
        } else {
            $('.containerDiv').html('');
            curr.closest('.gata_kashtkar_div').find('.append_ansh_rakba_div').html('');
        }
    });

    $(".col-wrapper").on('click', '.mort', function () {
        var id = $(this).attr('id');
        if (id === 'mort_1') {
            $('#mort_2').find('img').attr('src', 'img/unchk-radio-button.svg');
            $('#mort_1').find('img').attr('src', 'img/radio-button.svg');
            $('#mortgaged').val('1');
            $('.mortgaged_amount').closest('.upldfilediv').removeClass('hide');
        } else {
            $('#mort_1').find('img').attr('src', 'img/unchk-radio-button.svg');
            $('#mort_2').find('img').attr('src', 'img/radio-button.svg');
            $('#mortgaged').val('2');
            $('.mortgaged_amount').closest('.upldfilediv').addClass('hide');
        }
    });

    $('.col-wrapper').on('click', '.save_mortgaged', function (e) {
        if ($('.village_gata').val()) {
            if ($('#mort_1').find('img').attr('src') === 'img/unchk-radio-button.svg' && $('#mort_2').find('img').attr('src') === 'img/unchk-radio-button.svg') {
                printError('Please select atleast one option.', 3000, '', '');
            } else if ($('.mortgaged_amount').val() === '') {
                printError('Please enter mortgaged amount.', 3000, '', '');
            } else {
                $('#frm').submit();
            }
        } else {
            printError('Please select gata', 3000, '', '');
        }
    });

    $(".col-wrapper").on('submit', '#frm', function (e) {
        $('.act_btn_ovrly').show();
        var gata_no = [];
        var khata_no = [];
        var kashtkar = [];
        var postData = new FormData(this);
        postData.append('action', 'save_gata_ebasta');
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
        postData.append('gata_no', gata_no);
        postData.append('khata_no', khata_no);
        postData.append('kashtkar', kashtkar);
        postData.append('action', 'save_mortgaged');
        $.ajax({
            url: 'action/lamsAction.php',
            type: "POST",
            data: postData,
            processData: false,
            contentType: false,
            success: function (data, textStatus, jqXHR) {
                unsaved = false;
                var response_data = JSON.parse(data);
                if (response_data['status'] === '1') {
                    (async () => {
                        printSuccess(response_data['message'], 3000, '', '');
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
                                    $('#add_kashtkar, #add_more_kashtkar').parent().addClass('hide');
                                    $('.containerDiv').html('');
                                } else {
                                    curr.closest('.gata_kashtkar_div').remove();
                                }
                            });
                        });
                    })();
                } else if (response_data['status'] !== '1') {
                    $('.act_btn_ovrly').hide();
                    printError(response_data['message'], 3000, 'reload', '');
                }
            },
            error: function (xhr, status, error) {
                $('.act_btn_ovrly').hide();
                printError(handleAjaxError(xhr), 4000, 'reload', '');
            }
        });
        e.preventDefault();
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
                        <a class="ebasta_dwnldfilediv dwnld_ebasta_doc4" title="Download khatauni Document">
                            <div style="position: relative;">
                                <img src="img/download_1.svg">
                            </div>
                        </a>
                    </div>`;
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
        var gata_no = $('.village_gata:last option:selected').val();
        var khata_no = $('.village_khata:last option:selected').val();
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

    $('.full-column').on('click', '.delete_bank_data', function () {
        var curr = $(this);
        $.confirm({
            title: "Delete Confirmation",
            message: "Are you sure want to delete this record ?",
            buttons: {
                "Yes": {
                    "class": "curr_btn",
                    action: function (e) {
                        var curr_btn = $(this);
                        curr_btn.unbind('click').click(function () {
                            return false;
                        });
                        $('.curr_btn').text('Please wait...');
                        var id = curr.attr('id');
                        var txn = curr.attr('name');
                        var dataString = 'id=' + id + '&txn=' + txn + '&action=delete_bank_data';
                        $.ajax({
                            url: "action/lamsAction.php",
                            type: "POST",
                            data: dataString,
                            cache: false,
                            success: function (data) {
                                try {
                                    var response_data = JSON.parse(data);
                                    if (response_data['status'] === '1') {
                                        $('.popup-cnfbody').text(response_data['message']).show();
                                        setTimeout(function () {
                                            $('tCount').text(parseInt($('tCount').text()) - 1);
                                            $('#confirmOverlay').remove();
                                            curr.closest('.rowDiv').slideUp().remove();
                                        }, 2000);
                                    } else if (response_data['status'] === '0') {
                                        $('.popup-cnfbody').text(response_data['message']).show();
                                        setTimeout(function () {
                                            window.location.reload();
                                        }, 2000);
                                    } else {
                                        $('.popup-cnfbody').text(response_data['message']).show();
                                        setTimeout(function () {
                                            window.location.reload();
                                        }, 2000);
                                    }
                                } catch (error) {
                                    printError('Error parsing JSON response: ' + error, 4000, 'reload', '');
                                }
                            },
                            error: function (xhr, status, error) {
                                printError(handleAjaxError(xhr), 4000, 'reload', '');
                            }
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

    $('.full-column').on('click', '#selectAll', function () {
        if ($(this).is(':checked') === true) {
            $('.selct_data').attr('checked', 'checked');
            $('.selct_data').prop('checked', true);
            $('deldata_count').text($('.selct_data:checked').length);
            $('#delete_selected').show();
        } else {
            $('.selct_data').removeAttr('checked');
            $('.selct_data').prop('checked', false);
            $('deldata_count').text($('.selct_data:checked').length);
            $('#delete_selected').hide();
        }
    });

    $('.full-column').on('click', '.selct_data', function () {
        if ($(this).is(':checked') === true) {
            $(this).attr('checked', 'checked');
            $('deldata_count').text($('.selct_data:checked').length);
            $('#delete_selected').show();
        } else {
            $(this).removeAttr('checked');
            $('deldata_count').text($('.selct_data:checked').length);
            if ($('.selct_data:checked').length === 0) {
                $('#delete_selected').hide();
            }
        }
    });

    $('.full-column').on('click', '#delete_selected', function () {
        $.confirm({
            title: 'Delete Confirmation',
            message: 'Are you sure want to delete selected records?',
            buttons: {
                Yes: {
                    class: "curr_btn",
                    action: function (e) {
                        var curr_btn = $(this);
                        curr_btn.prop('disable', true);
                        $(".curr_btn").text("Please wait...");
                        var ids = [];
                        var txn = [];
                        $('.selct_data:checked').each(function () {
                            ids.push($(this).val());
                            txn.push($(this).attr('name'));
                        });
                        var dataString = 'ids=' + ids + '&txn=' + txn + '&action=delete_bulk_bank_data';
                        $.ajax({
                            url: 'action/lamsAction.php',
                            type: "POST",
                            data: dataString,
                            cache: false,
                            success: function (data) {
                                try {
                                    var response_data = JSON.parse(data);
                                    if (response_data["status"] === "1") {
                                        $(".popup-cnfbody").text(response_data["message"]).show();
                                        setTimeout(function () {
                                            window.location.reload();
                                        }, 3000);
                                    } else if (response_data["status"] === "0") {
                                        $(".popup-cnfbody").text(response_data["message"]).show();
                                        setTimeout(function () {
                                            window.location.reload();
                                        }, 3000);
                                    } else {
                                        $(".popup-cnfbody").text('Something went wrong.').show();
                                        setTimeout(function () {
                                            window.location.reload();
                                        }, 3000);
                                    }
                                } catch (error) {
                                    printError('Error parsing JSON response: ' + error, 4000, 'reload', '');
                                }
                            },
                            error: function (xhr, status, error) {
                                console.log(error);
                                $(".popup-cnfbody").text('Some error occurred.').show();
                                setTimeout(function () {
                                    window.location.reload();
                                }, 3000);
                            }
                        });
                        e.preventDefault();
                    },
                },
                No: {
                    class: "",
                    action: function () {
                        $('.selct_data').removeAttr('checked');
                        $('.selct_data').prop('checked', false);
                        $('deldata_count').text($('.selct_data:checked').length);
                        $('#delete_selected').hide();
                        $('#selectAll').removeAttr('checked');
                        $('#selectAll').prop('checked', false);
                    },
                },
            },
        });
    });

    $(document).mouseup(function (e) {
        var container = $("#checkboxes");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
        }
    });
});

function loadMoreBankData(page) {
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
        url: "ajax/loadMoreBankData.php",
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

function exportBankData(exportlist, export_type, type) {
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
        var formUrl = "report/export_bank_report.php";
    } else if (export_type === 'pdf') {
        var formUrl = "pdf/export_bank_report.php";
    } else if (export_type === 'print') {
        var formUrl = "pdf/export_bank_report.php";
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