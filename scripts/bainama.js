var aft;
$(document).ready(function () {

    $(".full-column").on("mouseover", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").show();
    });

    $(".full-column").on("mouseleave", ".showAction, .nwactdrops", function () {
        $(this).closest(".cellDivacts").find(".nwactdrops").hide();
    });

    $('.card_content').each(function () {
        var randomColor = getRandomColor();
        var randomDarkColor = getDarkColor();
        $(this).find('.card_content').find('.view_data').css({'color': randomDarkColor});
        $(this).css({'background-color': randomDarkColor});
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
                    promise_arr.push(syncVilekhReports(id, index));
                }
            }
        }
    });

    const promises = [promise_arr];
    Promise.all(promises)
            .then()
            .catch((e) => console.log(e));

    $('.full-column').on('click', '#columnFilter', function () {
        var str = '';
        $('.cellDivHeader').each(function () {
            var column_name = $(this).find('p').text();
            if (column_name && (column_name !== 'Details' || column_name !== 'Action')) {
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

    //filer search
    $('.full-column').on('click', '#showFilter', function () {
        if ($('#saveFilter').html() === '') {
            var curr = $(this);
            curr.addClass('active');
            var dataString = 'sort_by=' + $('#sort_by').val();
            $.ajax({
                url: "ajax/showBainamaAmount.php",
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
        var formURL = "ajax/filterBainamaAmount.php";
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
                    $('total_bainama_amount').text(format_rupees($('#total_bainama_amount').val()));
                    $('payment_total_amount').text(format_rupees($('#payment_total_amount').val()));
                    $('amount_left').text(format_rupees($('#amount_left').val()));
                    $('vilekh_without_payment').text(format_number($('#vilekh_without_payment').val()));
                    $('total_bainama_area').text($('#total_bainama_area').val());
                    $('total_parisampatti_amount').text(format_rupees($('#total_parisampatti_amount').val()));
                }, 400);
            }
        });
        e.preventDefault();
    });

    $('.full-column').on('click', '#columnFilter', function () {
        var str = '';
        $('.cellDivHeader').each(function () {
            var column_name = $(this).find('p').text();
            if (column_name && (column_name !== 'Details' || column_name !== 'Action')) {
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
        loadMoreBainamaAmount(0);
    });

    $('.full-column').on('click', '.export_excel', function () {
        exportBainamaAmount('export', 'excel', $(this).attr('id'));
    });

    $('.full-column').on('click', '.export_pdf', function () {
        exportBainamaAmount('export', 'pdf', $(this).attr('id'));
    });

    $('.full-column').on('click', '.export_print', function () {
        exportBainamaAmount('export', 'print', $(this).attr('id'));
    });

    $('.full-column').on('click', '#selectAll', function () {
        if ($(this).is(':checked') === true) {
            $('.chkBox').attr('checked', 'checked');
        } else {
            $('.chkBox').removeAttr('checked');
        }
    });

    $(document).mouseup(function (e) {
        var container = $("#checkboxes");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
        }
    });

    $('.col-wrapper').on('click', '.edit_bainama_amount', function () {
        $(this).addClass('hide');
        $(this).closest('.rowDiv').find('.vilekh_sankhya').addClass('hide');
        $(this).closest('.rowDiv').find('.bainama_area_text').addClass('hide');
        $(this).closest('.rowDiv').find('.bainama_amount').addClass('hide');
        $(this).closest('.rowDiv').find('.payment_amount_text').addClass('hide');
        $(this).closest('.rowDiv').find('.payment_date_text').addClass('hide');
        $(this).closest('.rowDiv').find('.land_amount_text').addClass('hide');
        $(this).closest('.rowDiv').find('.pari_amount_text').addClass('hide');
        $(this).closest('.rowDiv').find('.btn-min-actionwrap').removeClass('hide');
        $(this).closest('.rowDiv').find('.vilekh').removeClass('hide');
        $(this).closest('.rowDiv').find('.amount').removeClass('hide');
        $(this).closest('.rowDiv').find('.payment_amount').removeClass('hide');
        $(this).closest('.rowDiv').find('.payment_date').removeClass('hide');
        $(this).closest('.rowDiv').find('.bainama_area').removeClass('hide');
        $(this).closest('.rowDiv').find('.land_amount').removeClass('hide');
        $(this).closest('.rowDiv').find('.pari_amount').removeClass('hide');
        var vilekh_sankhya = $(this).closest('.rowDiv').find('.vilekh_sankhya').text() === '--' ? '' : $(this).closest('.rowDiv').find('.vilekh_sankhya').text();
        var bainama_area_text = $(this).closest('.rowDiv').find('.bainama_area_text').text() === '--' ? '' : $(this).closest('.rowDiv').find('.bainama_area_text').text();
        var bainama_amount = $(this).closest('.rowDiv').find('.bainama_amount').text() === '--' ? '' : $(this).closest('.rowDiv').find('.bainama_amount').text();
        var payment_amount_text = $(this).closest('.rowDiv').find('.payment_amount_text').text() === '--' ? '' : $(this).closest('.rowDiv').find('.payment_amount_text').text();
        var payment_date_text = $(this).closest('.rowDiv').find('.payment_date_text').text() === '--' ? '' : $(this).closest('.rowDiv').find('.payment_date_text').text();
        var land_amount_text = $(this).closest('.rowDiv').find('.land_amount_text').text() === '--' ? '' : $(this).closest('.rowDiv').find('.land_amount_text').text();
        var pari_amount_text = $(this).closest('.rowDiv').find('.pari_amount_text').text() === '--' ? '' : $(this).closest('.rowDiv').find('.pari_amount_text').text();
        $(this).closest('.rowDiv').find('.vilekh').val(vilekh_sankhya);
        $(this).closest('.rowDiv').find('.bainama_area').val(bainama_area_text);
        $(this).closest('.rowDiv').find('.amount').val(bainama_amount);
        $(this).closest('.rowDiv').find('.payment_amount').val(payment_amount_text);
        $(this).closest('.rowDiv').find('.payment_date').val(payment_date_text);
        $(this).closest('.rowDiv').find('.land_amount').val(land_amount_text);
        $(this).closest('.rowDiv').find('.pari_amount').val(pari_amount_text);
    });

    $('.col-wrapper').on('click', '.cancel_bainama_amount', function () {
        $(this).closest('.rowDiv').find('.btn-min-actionwrap').addClass('hide');
        $(this).closest('.rowDiv').find('.vilekh').addClass('hide');
        $(this).closest('.rowDiv').find('.amount').addClass('hide');
        $(this).closest('.rowDiv').find('.payment_amount').addClass('hide');
        $(this).closest('.rowDiv').find('.payment_date').addClass('hide');
        $(this).closest('.rowDiv').find('.land_amount').addClass('hide');
        $(this).closest('.rowDiv').find('.pari_amount').addClass('hide');
        $(this).closest('.rowDiv').find('.bainama_area').addClass('hide');
        $(this).closest('.rowDiv').find('.edit_bainama_amount').removeClass('hide');
        $(this).closest('.rowDiv').find('.vilekh_sankhya').removeClass('hide');
        $(this).closest('.rowDiv').find('.bainama_amount').removeClass('hide');
        $(this).closest('.rowDiv').find('.payment_amount_text').removeClass('hide');
        $(this).closest('.rowDiv').find('.payment_date_text').removeClass('hide');
        $(this).closest('.rowDiv').find('.bainama_area_text').removeClass('hide');
        $(this).closest('.rowDiv').find('.land_amount_text').removeClass('hide');
        $(this).closest('.rowDiv').find('.pari_amount_text').removeClass('hide');
    });

    $('.col-wrapper').on('click', '.save_bainama_amount', function () {
        var curr = $(this);
        var id = curr.attr('id');
        var village_code = curr.attr('village_code');
        var bainama_date = curr.attr('bainama_date');
        var vilekh = $(this).closest('.rowDiv').find('.vilekh').val();
        var amount = $(this).closest('.rowDiv').find('.amount').val();
        var payment_amount = $(this).closest('.rowDiv').find('.payment_amount').val();
        var payment_date = $(this).closest('.rowDiv').find('.payment_date').val();
        var bainama_area = $(this).closest('.rowDiv').find('.bainama_area').val();
        var land_amount = $(this).closest('.rowDiv').find('.land_amount').val();
        var pari_amount = $(this).closest('.rowDiv').find('.pari_amount').val();
        $('.act_btn_ovrly').show();
        var dataString = 'vilekh=' + vilekh + '&village_code=' + village_code + '&bainama_area=' + bainama_area + '&bainama_date=' + bainama_date + '&amount=' + amount + '&id=' + id + '&payment_amount=' + payment_amount + '&payment_date=' + payment_date + '&land_amount=' + land_amount + '&pari_amount=' + pari_amount + '&action=save_bainama_amount';
        curr.text('Please wait...');
        $.ajax({
            url: "action/lamsAction.php",
            type: "POST",
            data: dataString,
            cache: false,
            success: function (data) {
                var response_data = JSON.parse(data);
                if (response_data['status'] === '1') {
                    $('.act_btn_ovrly').hide();
                    printSuccess(response_data['message'], 2000, '', '');
                    curr.closest('.rowDiv').find('.btn-min-actionwrap').addClass('hide');
                    curr.closest('.rowDiv').find('.vilekh').addClass('hide');
                    curr.closest('.rowDiv').find('.amount').addClass('hide');
                    curr.closest('.rowDiv').find('.payment_amount').addClass('hide');
                    curr.closest('.rowDiv').find('.payment_date').addClass('hide');
                    curr.closest('.rowDiv').find('.bainama_area').addClass('hide');
                    curr.closest('.rowDiv').find('.land_amount').addClass('hide');
                    curr.closest('.rowDiv').find('.pari_amount').addClass('hide');
                    curr.closest('.rowDiv').find('.edit_bainama_amount').removeClass('hide');
                    curr.closest('.rowDiv').find('.vilekh_sankhya').text(response_data['success_array']['vilekh']).removeClass('hide');
                    curr.closest('.rowDiv').find('.bainama_amount').text(response_data['success_array']['amount']).removeClass('hide');
                    curr.closest('.rowDiv').find('.payment_amount_text').text(response_data['success_array']['payment_amount']).removeClass('hide');
                    curr.closest('.rowDiv').find('.payment_date_text').text(response_data['success_array']['payment_date']).removeClass('hide');
                    curr.closest('.rowDiv').find('.bainama_area_text').text(response_data['success_array']['bainama_area']).removeClass('hide');
                    curr.closest('.rowDiv').find('.land_amount_text').text(response_data['success_array']['land_amount']).removeClass('hide');
                    curr.closest('.rowDiv').find('.pari_amount_text').text(response_data['success_array']['pari_amount']).removeClass('hide');
                    curr.text('Save');
                } else {
                    curr.text('Save');
                    printError(response_data['message'], 3000, '', '');
                    return false;
                }
            },
            error: function (xhr, status, error) {
                printError(handleAjaxError(xhr), 3000, 'reload', '');
                return false;
            }
        });
    });

    $('.col-wrapper').on('click', '.update_patravali', function () {
        var curr = $(this);
        var id = curr.attr('id');
        var village = $(this).closest('.rowDiv').find('.col1').text().replace(/ /g, '%20');
        var rakba = $(this).closest('.rowDiv').find('.col3').text().replace(/ /g, '%20');
        var date = $(this).closest('.rowDiv').find('.col4').text().replace(/ /g, '%20');
        var vilekh = $(this).closest('.rowDiv').find('.vilekh_sankhya').text().replace(/ /g, '%20');
        var amount = $(this).closest('.rowDiv').find('.bainama_amount').text().replace(/ /g, '%20');
        if (vilekh === '--' || amount === '--') {
            printError('Vilekh Sankhya or Bainama Amount is missing.', 3000, '', '');
            return false;
        }
        $('#popup').load('popup/updatePatravaliPopup.php?id=' + id + '&village=' + village + '&rakba=' + rakba + '&date=' + date + '&vilekh=' + vilekh + '&amount=' + amount, function () {
            $('#popup').show();
            makeDragable('.popup-header', '.popup-wrap');
        });
    });

    $('#popup').on('click', '#update_patravali', function () {
        var ebasta_id = $('#popup').find('#ebasta_id').val();
        var status = $('#popup').find('#status').val();
        if (status === '') {
            printError('Please select status.', 3000, '', '');
            return false;
        }
        $('.act_btn_ovrly').show();
        var dataString = 'id=' + ebasta_id + '&status=' + status + '&action=update_patravali';
        $('#update_patravali').text('Please wait...');
        $.ajax({
            url: "action/lamsAction.php",
            type: "POST",
            data: dataString,
            cache: false,
            success: function (data) {
                var response_data = JSON.parse(data);
                if (response_data['status'] === '1') {
                    $('.act_btn_ovrly').hide();
                    printSuccess(response_data['message'], 2000, 'reload', '');
                } else {
                    printError(response_data['message'], 3000, 'reload', '');
                    return false;
                }
            },
            error: function (xhr, status, error) {
                printError(handleAjaxError(xhr), 3000, 'reload', '');
                return false;
            }
        });
    });

    //sort
    $('.full-column').on('change', '#sort_by', function () {
        var sort_by = $(this).val();
        window.location.href = '?sort_by=' + sort_by;
    });
});

function loadMoreBainamaAmount(page) {
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
    fd.append('sort_by', $('#sort_by').val());
    $('#main-body').html('<div class="medical-spinner" id="load"></div>');
    $.ajax({
        type: "POST",
        url: "ajax/loadMoreBainamaAmount.php",
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

function exportBainamaAmount(exportlist, export_type, type) {
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
    fd.append('sort_by', $('#sort_by').val());

    // check if any displayed columns exists
    if ($('.filterColumn').length === 0) {
        var str = '';
        $('.cellDivHeader').each(function () {
            var column_name = $(this).find('p').text();
            if (column_name && (column_name !== 'Details' || column_name !== 'Action')) {
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
        var formUrl = "report/export_bainama_amount.php";
    } else if (export_type === 'pdf') {
        $('.act_btn_ovrly').show();
        $('.export_pdf').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "pdf/export_bainama_amount.php";
    } else if (export_type === 'print') {
        $('.act_btn_ovrly').show();
        $('.export_print').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "pdf/export_bainama_amount.php";
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
                $('.act_btn_ovrly').hide();
                $('.export_print').html('<img src="img/printicn.svg" height="22px">');
                window.open('printdocument?file=' + response_data['url'] + '&ftype=' + response_data['ftype'], '_blank');
            } else {
                if (export_type === 'excel') {
                    $('.act_btn_ovrly').hide();
                    $('.export_excel').html('<img src="img/excel.svg" height="22px">');
                } else if (export_type === 'pdf') {
                    $('.act_btn_ovrly').hide();
                    $('.export_pdf').html('<img src="img/pdficn.svg" height="22px">');
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
                                <div class="popup-body pp-large-y">
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

// ### parisampatti module count ###
function syncVilekhReports(data_point, count) {
    var dataString = 'data_point=' + data_point + '&count=' + count + '&action=sync_dashboard_data';
    $('.block_loader').html('<div class="medical-spinner" style="top:36%; left:42%;" id="load"></div>');
    console.log('Start sync data of data point: ' + data_point);
    $.ajax({
        url: 'ajax/syncVilekhReports.php',
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