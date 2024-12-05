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
                    promise_arr.push(syncParisampattiData(id, index));
                }
            }
        }
    });

    const promises = [promise_arr];
    Promise.all(promises)
            .then()
            .catch((e) => console.log(e));

//    $('.col-wrapper').on('click', '.view_data', function () {
//        $('.act_btn_ovrly').show();
//        var curr = $(this);
//        (async () => {
//            $('#popup').html(`<div class="popup-overlay center-screen">
//                                <div class="popup-wrap">
//                                    <div class="popup-body pp-medium-y" id="log_content">
//                                        <div class="form-field-wrap posrel">
//                                            <div class="">
//                                                <div class="slcdstc">
//                                                </div>
//                                            </div>
//                                        </div>
//                                    </div>
//                                </div>
//                            </div>`);
//            $('#popup').show();
//            $('.slcdstc').html('<div class="medical-spinner" style="margin-top:35%; left:45%;" id="load"></div>');
//            await new Promise((resolve) => {
//                var dashboard_data = curr.attr('id').replace('dashboard_data_', '');
//                var title = curr.closest('.card_content').find('span:first').text().replace(/ /g, '%20');
//                $('#popup').load('popup/viewParisampattiDataPopup.php?dashboard_data=' + dashboard_data + '&title=' + title, function () {
//                    $('#popup').show();
//                    $('.act_btn_ovrly').hide();
//                    makeDragable('.popup-header', '.popup-wrap');
//                    var village_code_arr = [];
//                    var opt_str = '<option value="">Select Village</option>';
//                    if (dashboard_data === '47') {
//                        $('#popup').find('.rowDiv').each(function () {
//                            if ($(this).find('.col3').text()) {
//                                var opt_name = $(this).find('.col2').text().trim();
//                                var opt_value = $(this).find('.col3').text().trim();
//                                if (village_code_arr.includes(opt_value) === false) {
//                                    opt_str += '<option value="' + opt_value + '">' + opt_name + '</option>';
//                                    village_code_arr.push(opt_value);
//                                }
//                            }
//                        });
//                        $('tCount').text($('#popup').find('.rowDiv').length);
//                    } else {
//                        if (dashboard_data === '6' || dashboard_data === '12' || dashboard_data === '13' || dashboard_data === '14' || dashboard_data === '15' || dashboard_data === '16' || dashboard_data === '39') {
//                            var area = 0;
//                            $('#popup').find('.rowDiv').each(function () {
//                                if ($(this).find('.col5').text()) {
//                                    if (isNumeric($(this).find('.col5').text().trim())) {
//                                        area += parseFloat($(this).find('.col5').text().trim());
//                                    }
//                                }
//                            });
//                            $('tCount').text(parseFloat(area).toFixed(3));
//                        } else if (dashboard_data === '42' || dashboard_data === '43' || dashboard_data === '45') {
//                            var area = 0;
//                            $('#popup').find('.rowDiv').each(function () {
//                                if ($(this).find('.col6').text()) {
//                                    if (isNumeric($(this).find('.col6').text().trim())) {
//                                        area += parseFloat($(this).find('.col6').text().trim());
//                                    }
//                                }
//                            });
//                            $('tCount').text(parseFloat(area).toFixed(3));
//                        } else if (dashboard_data === '24' || dashboard_data === '25') {
//                            var area = 0;
//                            $('#popup').find('.rowDiv').each(function () {
//                                if ($(this).find('.col10').text()) {
//                                    var numb = $(this).find('.col12').text().trim().match(/\d/g);
//                                    numb = numb.join("");
//                                    area += parseFloat(numb);
//                                }
//                            });
//                            $('tCount').text(parseFloat(area).toFixed(4));
//                        } else if (dashboard_data === '5' || dashboard_data === '48' || dashboard_data === '49' || dashboard_data === '50') {
//                            var area = 0;
//                            $('#popup').find('.rowDiv').each(function () {
//                                if ($(this).find('.col8').text()) {
//                                    if (isNumeric($(this).find('.col8').text().trim())) {
//                                        area += parseFloat($(this).find('.col8').text().trim());
//                                    }
//                                }
//                            });
//                            $('tCount').text(parseFloat(area).toFixed(4));
//                        } else {
//                            $('tCount').text($('#popup').find('.rowDiv').length);
//                            if (dashboard_data === '8') {
//                                $('.export_qgis_excel').closest('.tbl-data').removeClass('hide');
//                            }
//                        }
//                        $('#popup').find('.rowDiv').each(function () {
//                            if ($(this).find('.col2').text()) {
//                                var opt_name = $(this).find('.col1').text().trim();
//                                var opt_value = $(this).find('.col2').text().trim();
//                                if (village_code_arr.includes(opt_value) === false) {
//                                    opt_str += '<option value="' + opt_value + '">' + opt_name + '</option>';
//                                    village_code_arr.push(opt_value);
//                                }
//                            }
//                        });
//                    }
//                    $('#disp_row_count').text($('#popup').find('.rowDiv').length + ' records found');
//                    $('#popup').find('#filter_village_code').html(opt_str);
//                });
//            });
//        })();
//    });

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

    //filer search
    $('.full-column').on('click', '#showFilter', function () {
        if ($('#saveFilter').html() === '') {
            var curr = $(this);
            curr.addClass('active');
            var dataString = '';
            $.ajax({
                url: "ajax/showParisampattiModule.php",
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
        var formURL = "ajax/filterParisampattiModule.php";
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
        loadMoreParisampattiModule(0);
    });

    $('.full-column').on('click', '.export_excel', function () {
        exportParisampattiModule('export', 'excel', $(this).attr('id'));
    });

    $('.full-column').on('click', '.export_pdf', function () {
        exportParisampattiModule('export', 'pdf', $(this).attr('id'));
    });

    $('.full-column').on('click', '.export_print', function () {
        exportParisampattiModule('export', 'print', $(this).attr('id'));
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

    // add new parisampatti popup
    $('.dev_wrap').on('click', '.add_new_parisampatti', function () {
        $('#popup').load('popup/addNewparisampattiPopup.php', function () {
            $('#popup').show();
            $('body').css('overflow-y', 'hidden');
            makeDragable('.popup-header', '.popup-wrap');
        });
    });

    //  parisampatti details popup
    $('.dev_wrap').on('click', '.parisamaptti_details', function () {
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
                var asset_surveyId = curr.attr('id');
                var village_name = curr.attr('village_name').replace(/ /g, '%20');
                var gata_no = curr.attr('gata_no').replace(/ /g, '%20');
                var khata_no = curr.attr('khata_no').replace(/ /g, '%20');
                var department_name = curr.attr('department_name').replace(/ /g, '%20');
                //var title = curr.closest('.card_content').find('span:first').text().replace(/ /g, '%20');
                $('#popup').load('popup/parisampattiDetailsPopup.php?asset_surveyId=' + asset_surveyId + '&department_name=' + department_name + '&village_name=' + village_name + '&gata_no=' + gata_no + '&khata_no=' + khata_no, function () {
                    $('#popup').show();
                    $('.act_btn_ovrly').hide();
                    makeDragable('.popup-header', '.popup-wrap');
                });
            });
        })();
    });

    $('#popup').on('change', '.village_code', function () {
        var curr = $(this);
        var dataString = 'village_code=' + curr.val() + '&type=2';
        $.ajax({
            url: 'ajax/getParisampattiKashtkarVillageGata.php',
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
                url: 'ajax/loadParisampattiKashtkarKhata.php',
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
                url: 'ajax/loadParisampattiMobileKashtkar.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    curr.closest('.card_item').find('.kashtkar').html(data);
                }
            });
        } else {
        }
    });

    $('#popup').on('change', '.department', function () {
        var curr = $(this);
        var dept_val = curr.val();
        var dept_val = curr.val().split('@BIDA');
        var dataString = 'department_id=' + dept_val[0] + '&department_type=' + dept_val[1];
        if (dept_val[0] && dept_val[1]) {
            $.ajax({
                url: 'ajax/getPropertyType.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    $('#dimention_amount').addClass('hide');
                    $('#dimention_number').addClass('hide');
                    $('#add_more_hide').removeClass('hide');
                    $('.dimention_amount').val('');
                    $('.dimention_number').val('');
                    $('.property_type').html('').html(data);
                }
            });
        } else {
            $('#add_more_hide').addClass('hide');
            $('.property_type').html('');
        }
    });

    $('#popup').on('change', '.tree_id', function () {
        var curr = $(this);
        if ($(this).val()) {
            curr.closest('.change_tree_append').find('.dimention_number').val('');
            curr.closest('.change_tree_append').find('.dimention_amount').val('');
            curr.closest('.change_tree_append').find('#dimention_number').removeClass('hide');
            curr.closest('.change_tree_append').find('#total_dimention_amt').addClass('hide');
            curr.closest('.change_tree_append').find('#dimention_number_count').addClass('hide');
            curr.closest('.change_tree_append').find('#property_amount').addClass('hide');
            curr.closest('.change_tree_append').find('.property_amount').val('');
            curr.closest('.change_tree_append').find('.total_dimention_amt').val('');
            curr.closest('.change_tree_append').find('.total_dimention_amt').val('');
            curr.closest('.change_tree_append').find('.dimention_number_count').val('');
            curr.closest('.change_tree_append').find('.dimen_amt').addClass('hide');
        } else {
            curr.closest('.change_tree_append').find('.dimention_number').val('');
            curr.closest('.change_tree_append').find('.dimention_amount').val('');
            curr.closest('.change_tree_append').find('.dimention_number_count').val('');
            curr.closest('.change_tree_append').find('.total_dimention_amt').val('');
            curr.closest('.change_tree_append').find('#dimention_number').addClass('hide');
            curr.closest('.change_tree_append').find('#dimention_number_count').addClass('hide');
            curr.closest('.change_tree_append').find('.dimen_amt').addClass('hide');
            curr.closest('.change_tree_append').find('#property_amount').addClass('hide');
            curr.closest('.change_tree_append').find('.property_amount').val('');
        }
    });

    $('#popup').on('change', '.dimention_number', function () {
        var curr = $(this);
        var dimention_val = $(this).val();
        var tree_id = $('.tree_id').val();
        if (dimention_val) {
            var dataString = 'tree_id=' + tree_id + '&dimention_val=' + dimention_val;
            $.ajax({
                url: 'ajax/getDimentionAmount.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    curr.closest('.change_tree_append').find('#dimention_number_count').removeClass('hide');
                    curr.closest('.change_tree_append').find('#dimen_amount').removeClass('hide');
                    curr.closest('.change_tree_append').find('#property_amount').removeClass('hide');
                    curr.closest('.change_tree_append').find('.property_amount').val('');
                    curr.closest('.change_tree_append').find('.total_dimention_amt').val('');
                    curr.closest('.change_tree_append').find('.dimention_number_count').val('');
                    $('.dimen_amt').removeClass('hide');
                    curr.closest('.dimention_append').find('.dimen_amt').html('').html(data);
                }
            });
        } else {
            curr.closest('.change_tree_append').find('#dimention_number_count').addClass('hide');
            curr.closest('.change_tree_append').find('#total_dimention_amt').addClass('hide');
            curr.closest('.change_tree_append').find('#property_amount').addClass('hide');
            curr.closest('.change_tree_append').find('#dimen_amount').addClass('hide');
            curr.closest('.change_tree_append').find('.property_amount').val('');
            curr.closest('.change_tree_append').find('.dimention_amount').val('');
            curr.closest('.change_tree_append').find('.total_dimention_amt').val('');
            curr.closest('.change_tree_append').find('.dimention_number_count').val('');
        }
    });

    // ### total dimension count ###
    $('#popup').on('keyup', '.dimention_number_count', function () {
        var curr = $(this);
        var dimention_count = $(this).val();
        var dimension_amount = curr.closest('.dimention_append').find('.dimention_amount').val();
        var dimension_amt = dimension_amount.replace('₹', ''); // Remove the ₹ symbol
        var total_amt = Number(dimention_count) * Number(dimension_amt);
        if (dimention_count) {
            curr.closest('.change_tree_append').find('#total_dimention_amt').removeClass('hide');
            curr.closest('.dimention_append').find('.total_dimention_amt').val('₹ ' + total_amt);
        } else {
            curr.closest('.dimention_append').find('.total_dimention_amt').val('');
        }
    });

    // ### add more parisampatti ###
    $('#popup').on('click', '#add_more_prisampatti', function () {
        var curr = $(this);
        var dept_val = $('.department').val().split('@BIDA');
        var dataString = 'department_id=' + dept_val[0] + '&department_type=' + dept_val[1] + '&type=' + 'append cross';
        $.ajax({
            url: 'ajax/getPropertyType.php',
            data: dataString,
            type: "POST",
            success: function (data) {
                $('#dimention_number').find('input').removeClass('fldrequired');
                $('.property_type').append(data);
            }
        });
    });

// ### remove parisampatti details ###
    $("#popup").on('click', '.rm_parisampatti_div', function (e) {
        $(this).closest('.change_tree_append').remove();
    });

    // save new asset
    $('#popup').on('click', '#add_parisampatti', function () {
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
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="add_parisampatti" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/lamsAction" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#add_parisampatti" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="Save" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="reload" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="" autocomplete="off">');
            $('#pfrm').submit();
        }
    });

    // ### submit form ###
    $("#popup").on('submit', '#pfrm', function (e) {
        var postData = new FormData(this);
        var action_btn_id = $('input[name="action_btn_id"]').val();
        var action_btn_name = $('input[name="action_btn_name"]').val();
        var action_url = $('input[name="action_url"]').val();
        var after_success_action = $('input[name="after_success_action"]').val();
        var after_success_redirect = $('input[name="after_success_redirect"]').val();
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
                printError(handleAjaxError(xhr), 3000, after_success_action, after_success_redirect);
            }
        });
        e.preventDefault();
    });
});

// ### parisampatti module count ###
function syncParisampattiData(data_point, count) {
    var dataString = 'data_point=' + data_point + '&count=' + count + '&action=sync_dashboard_data';
    $('.block_loader').html('<div class="medical-spinner" style="top:36%; left:42%;" id="load"></div>');
    //console.log('Start sync data of data point: ' + data_point);
    $.ajax({
        url: 'ajax/syncParisampattiData.php',
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

function loadMoreParisampattiModule(page) {
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
        url: "ajax/loadMoreParisampattiModule.php",
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

function exportParisampattiModule(exportlist, export_type, type) {
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
        var formUrl = "report/export_parisampatti_module.php";
    } else if (export_type === 'pdf') {
        $('.act_btn_ovrly').show();
        $('.export_pdf').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "pdf/export_parisampatti_module.php";
    } else if (export_type === 'print') {
        $('.act_btn_ovrly').show();
        $('.export_print').html('<div class="medical-spinner" style="top:0; left:20%;" id="load"></div>');
        var formUrl = "pdf/export_parisampatti_module.php";
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

function process(input) {
    let value = input.value;
    let numbers = value.replace(/[^0-9]/g, "");
    input.value = numbers;
}
