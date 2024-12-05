$(document).ready(function () {
    var charLimit = 1;
    $(".otp").keydown(function (e) {
        var keys = [8, 9, /*16, 17, 18,*/ 19, 20, 27, 33, 34, 35, 36, 37, 38, 39, 40, 45, 46, 144, 145];
        if (e.which === 8 && this.value.length === 0) {
            $(this).prev('.otp').focus();
        } else if ($.inArray(e.which, keys) >= 0) {
            return true;
        } else if (this.value.length >= charLimit) {
            $(this).next('.otp').focus();
            return false;
        } else if (e.shiftKey || e.which < 48 || e.which >= 58) {
            return false;
        }
    }).keyup(function () {
        if (this.value.length >= charLimit) {
            $(this).next('.otp').focus();
            return false;
        }
    });

    $('.layout-container').on('change', '.village_code', function () {
        var curr = $(this);
        var dataString = 'village_code=' + curr.val() + '&type=2';
        $.ajax({
            url: 'ajax/getKashtkarVillageGata.php',
            data: dataString,
            type: "POST",
            success: function (data) {
                curr.closest('.card').find('.village_gata').html(data);
            }
        });
    });

    $('.layout-container').on('change', '.village_gata', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'village_code=' + curr.closest('.card').find('.village_code').val() + '&gata_no=' + curr.val();
            $.ajax({
                url: 'ajax/loadKashtkarKhata.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    curr.closest('.card').find('.village_khata').html(data);
                }
            });
        } else {
        }
    });

    $('.layout-container').on('change', '.village_khata', function () {
        var curr = $(this);
        if (curr.val()) {
            var dataString = 'village_code=' + curr.closest('.card').find('.village_code').val() + '&gata_no=' + curr.closest('.card').find('.village_gata').val() + '&khata_no=' + curr.val();
            $.ajax({
                url: 'ajax/loadMobileKashtkar.php',
                data: dataString,
                type: "POST",
                success: function (data) {
                    curr.closest('.card').find('.kashtkar').html(data);
                }
            });
        } else {
        }
    });

    $('.layout-container').on('change', '.kashtkar', function () {
        var curr = $(this);
        if (curr.attr('id') === 'griev_kashtkar') {
            if (curr.val() !== '##') {
                var dataString = 'village_code=' + curr.closest('.card').find('.village_code').val() + '&khata_no=' + curr.closest('.card').find('.village_khata').val() + '&gata_no=' + curr.closest('.card').find('.village_gata').val() + '&kashtkar=' + curr.val() + '&action=get_kashtkar_info';
                $.ajax({
                    url: 'action/userAction.php',
                    data: dataString,
                    type: "POST",
                    success: function (data) {
                        var response_data = JSON.parse(data);
                        if (response_data['status'] === '-1') {
                            printRespError(response_data['message'], 3000, '', '');
                        } else if (response_data['status'] === '1') {
                            $('.frm_hidden_data_1').html('<input type="hidden" name="owner_no" value="' + response_data['owner_no'] + '"><input type="hidden" name="owner_name" value="' + response_data['owner_name'] + '"><input type="hidden" name="owner_father" value="' + response_data['owner_father'] + '"><input type="hidden" name="gata_area" value="' + response_data['gata_area'] + '">');
                        }
                    }
                });
            } else if (curr.val() === '##') {
                $('#popup').load('popup/addMobileKashtkar.php?village_code=' + curr.closest('.card').find('.village_code').val() + '&khata_no=' + curr.closest('.card').find('.village_khata').val() + '&gata_no=' + curr.closest('.card').find('.village_gata').val() + '&mobile=' + $('#mobile').val() + '&kashtkar=' + curr.val(), function (data) {
                    $('#popup').html(data).show();
                });
            } else {
                $('.frm_hidden_data_1').html('');
            }
        } else {
            if (curr.val() !== '##') {
                $('#preview_form').hide();
                $('.frm_hidden_data_1').html('');
                var dataString = 'village_code=' + curr.closest('.card').find('.village_code').val() + '&khata_no=' + curr.closest('.card').find('.village_khata').val() + '&gata_no=' + curr.closest('.card').find('.village_gata').val() + '&kashtkar=' + curr.val() + '&action=check_sahmati_eligibility';
                $.ajax({
                    url: 'action/userAction.php',
                    data: dataString,
                    type: "POST",
                    success: function (data) {
                        var response_data = JSON.parse(data);
                        if (response_data['status'] === '-1') {
                            $('#preview_form').hide();
                            $('.frm_hidden_data_1').html('');
                            $('.rakba').val('');
                            printRespError(response_data['message'], 3000, '', '');
                        } else if (response_data['status'] === '1') {
                            curr.closest('.row').find('.rakba').val(response_data['gata_area']);
                            $('.frm_hidden_data_1').html('<input type="hidden" name="owner_no" value="' + response_data['owner_no'] + '"><input type="hidden" name="owner_name" value="' + response_data['owner_name'] + '"><input type="hidden" name="owner_father" value="' + response_data['owner_father'] + '"><input type="hidden" name="gata_area" value="' + response_data['gata_area'] + '">');
                            $('#preview_form').show();
                        }
                    }
                });
            } else if (curr.val() === '##') {
                $('#popup').load('popup/addMobileKashtkar.php?village_code=' + curr.closest('.card').find('.village_code').val() + '&khata_no=' + curr.closest('.card').find('.village_khata').val() + '&gata_no=' + curr.closest('.card').find('.village_gata').val() + '&mobile=' + $('#mobile').val() + '&kashtkar=' + curr.val(), function (data) {
                    $('#preview_form').hide();
                    $('.frm_hidden_data_1').html('');
                    $('.rakba').val('');
                    $('#popup').html(data).show();
                });
            } else {
                $('#preview_form').hide();
                $('.frm_hidden_data_1').html('');
                $('.rakba').val('');
            }
        }
    });

    $('.layout-container').on('click', '.add_bhu_more', function () {
        var str = `<div class="mb-3">
                        <div style="display: flex; gap: 10px;">
                            <input type="text" class="form-control fldrequired" name="fname[]" placeholder="नाम" value="" maxlength="100">
                            <input type="text" class="form-control fldrequired" name="pname[]" placeholder="पति/पिता श्री" value="" maxlength="100">
                            <input type="text" class="form-control fldrequired" name="ansh[]" placeholder="अंश" value="" maxlength="20">
                            <a style="cursor: pointer; color: #f00;" class="d-flex align-items-center justify-content-end remove_bhu_more">
                                <i class="bx bx-minus-circle scaleX-n1-rtl bx-sm"></i>
                            </a>
                        </div>
                    </div>`;
        $(this).closest('.card-body').find('.row').append(str);
    });

    $('.layout-container').on('click', '.remove_bhu_more', function () {
        $(this).closest('.card').remove();
    });

    $('.layout-container').on('click', '.add_gata_more', function () {
        var str = `<div class="card mb-4">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">गाँव चुनें</label>
                                    <select name="village_code[]" class="form-select fldrequired village_code">
                                        ${$('.village_code').html()}
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">गाटा चुनें</label>
                                    <select name="gata_no[]" class="form-select fldrequired village_gata">
                                        <option value="">गाटा चुनें</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">खाता चुनें</label>
                                    <select name="khata_no[]" class="form-select fldrequired village_khata">
                                        <option value="">खाता चुनें</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">काश्तकार चुनें</label>
                                    <select name="kashtkar[]" class="form-select fldrequired kashtkar">
                                        <option value="">काश्तकार चुनें</option>
                                    </select>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">अंश डालें</label>
                                    <input type="text" class="form-control fldrequired" name="ansh[]" placeholder="अंश डालें" value="" maxlength="15">
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="defaultSelect" class="form-label">रकबा डालें (हेक्टेयर में)</label>
                                    <input type="text" class="form-control fldrequired numeric" name="rakba[]" placeholder="रकबा डालें (हेक्टेयर में)" value="" maxlength="10" pattern="[0-9]*" inputmode="numeric">
                                </div>
                                <a style="cursor: pointer; color: #f00;" class="d-flex align-items-center justify-content-end remove_bhu_more">
                                    <i class="bx bx-minus-circle scaleX-n1-rtl bx-sm"></i>&nbsp;
                                    गाटा हटाएँ
                                </a>
                            </div>
                        </div>
                        <!-- /Account -->
                    </div>`;
        $('#appendDiv').append(str);
    });

    $('.layout-container').on('click', '.remove_gata_more', function () {
        $(this).closest('.mb-3').remove();
    });

    $('#popup').on('click', '.close_popup, .offcanvas-backdrop', function () {
        $('#popup').html('').hide();
        $('.kashtkar').val('');
    });

    $('.layout-container').on('click', "#preview_form", function () {
        var check = 0;
        $('.fldrequired').each(function () {
            if ($(this).val() === '') {
                check++;
                $(this).addClass('frm-merror');
            } else {
                $(this).removeClass('frm-merror');
            }
        });
        if (check > 0) {
            return false;
        } else {
            $('#frm').find('.frm_hidden_data').html('');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="preview_form" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/userAction" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#preview_form" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="आगे बढ़े" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="" autocomplete="off">');
        }
    });

    $('.layout-container').on('click', "#go_back", function () {
        $('#popup').html('').hide();
        $('#prev_btn_act').css('display', 'none');
    });

    $('.layout-container').on('click', "#upload_sahmati_otp", function () {
        var check = 0;
        $('.fldrequired').each(function () {
            if ($(this).val() === '') {
                check++;
                $(this).addClass('frm-merror');
            } else {
                $(this).removeClass('frm-merror');
            }
        });
        if (check > 0) {
            return false;
        } else {
            $('#frm').find('.frm_hidden_data').html('');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="upload_sahmati_otp" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/userAction" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#upload_sahmati_otp" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="आगे बढ़े" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="" autocomplete="off">');
        }
    });

    $('.layout-container').on('click', "#upload_sahmati", function () {
        var check = 0;
        $('.fldrequired').each(function () {
            if ($(this).val() === '') {
                check++;
                $(this).addClass('frm-merror');
            } else {
                $(this).removeClass('frm-merror');
            }
        });
        if (check > 0) {
            return false;
        } else {
            $('#frm').find('.frm_hidden_data').html('');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="upload_sahmati" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/userAction" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#upload_sahmati" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="सहमति पत्र जमा करें" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="kashtkarsahmati" autocomplete="off">');
        }
    });

    $('#popup').on('click', "#save_kashtkar", function () {
        var check = 0;
        $('#popup').find('.fldrequired').each(function () {
            if ($(this).val() === '') {
                check++;
                $(this).addClass('frm-merror');
            } else {
                $(this).removeClass('frm-merror');
            }
        });
        if (check > 0) {
            return false;
        } else {
            $('#pfrm').find('.frm_hidden_data').html('');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="save_kashtkar" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/userAction" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#save_kashtkar" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="काश्तकार जोड़ें" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="" autocomplete="off">');
            $('#pfrm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="" autocomplete="off">');
        }
    });

    $('.layout-container').on('click', "#save_grievance", function () {
        var check = 0;
        $('.fldrequired').each(function () {
            if ($(this).val() === '') {
                check++;
                $(this).addClass('frm-merror');
            } else {
                $(this).removeClass('frm-merror');
            }
        });
        if (check > 0) {
            return false;
        } else {
            $('#frm').find('.frm_hidden_data').html('');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="save_grievance" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/userAction" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#save_grievance" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="शिकायत दर्ज करें" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="kashtkargrievance" autocomplete="off">');
        }
    });

    $('.layout-container').on("submit", "#frm", function (e) {
        var postData = new FormData(this);
        var action = $('input[name="action"]').val();
        var action_btn_id = $('input[name="action_btn_id"]').val();
        var action_btn_name = $('input[name="action_btn_name"]').val();
        var action_url = $('input[name="action_url"]').val();
        var after_success_action = $('input[name="after_success_action"]').val();
        var after_success_redirect = $('input[name="after_success_redirect"]').val();
        var param = '';
        var formURL = action_url;
        $('.act_btn_ovrly').show();
        $(action_btn_id).text('कृपया प्रतीक्षा करें...');
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
                    printRespError(response_data['message'], 3000, '', '');
                    return false;
                } else if (response_data['status'] === '1') {
                    if (action === 'upload_sahmati_otp') {
                        $('.act_btn_ovrly').hide();
                        $('#preview_form').hide();
                        $('#popup').html('').hide();
                        $('#prev_btn_act').css('display', 'none');
                        $('.otpDiv').show();
                        $('.otp').closest('.mb-3').show();
                        $('.otp').addClass('fldrequired');
                        $('#upload_sahmati').show();
                        printRespSuccess(response_data['message'], 2000, after_success_action, after_success_redirect);
                    } else if (action === 'preview_form') {
                        $('#popup').html(response_data['data']).show();
                        $('#prev_btn_act').css('display', 'flex');
                    } else if (action === 'save_grievance') {
                        $('select, input').val('');
                        printRespSuccess(response_data.success_array['info'], 20000, after_success_action, after_success_redirect);
                    } else {
                        printRespSuccess(response_data['message'], 10000, after_success_action, after_success_redirect);
                    }
                } else if (response_data['status'] === '0') {
                    printRespError(response_data['message'], 3000, 'reload', '');
                    return false;
                } else {
                    printRespError(response_data['message'], 3000, 'reload', '');
                    return false;
                }
            },
            error: function (xhr, status, error) {
                printRespError(handleAjaxError(xhr), 3000, 'reload', '');
                return false;
            }
        });
        e.preventDefault(); //STOP default action
    });

    $("#popup").on('submit', '#pfrm', function (e) {
        var postData = new FormData(this);
        var action = $('input[name="action"]').val();
        var action_btn_id = $('input[name="action_btn_id"]').val();
        var action_btn_name = $('input[name="action_btn_name"]').val();
        var action_url = $('input[name="action_url"]').val();
        var after_success_action = $('input[name="after_success_action"]').val();
        var after_success_redirect = $('input[name="after_success_redirect"]').val();
        var param = '';
        var formURL = action_url;
        $('.act_btn_ovrly').show();
        $(action_btn_id).text('कृपया प्रतीक्षा करें...');
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
                    printRespError(response_data['message'], 3000, '', '');
                    return false;
                } else if (response_data['status'] === '1') {
                    if (action === 'save_kashtkar') {
                        $('.act_btn_ovrly').hide();
                        $('.kashtkar:last').append('<option value="' + response_data.success_array['kasht_info'] + '" area="' + response_data.success_array['area'] + '">' + response_data.success_array['kashtkar'] + '</option>');
                        $('.kashtkar:last').val(response_data.success_array['kasht_info']).change();
                        //$('.frm_hidden_data_1').html('<input type="hidden" name="owner_no" value="' + response_data.success_array['owner_no'] + '"><input type="hidden" name="owner_name" value="' + response_data.success_array['owner_name'] + '"><input type="hidden" name="owner_father" value="' + response_data.success_array['owner_father'] + '"><input type="hidden" name="gata_area" value="' + response_data.success_array['gata_area'] + '">');
                        //$('.rakba:last').val(response_data.success_array['gata_area']);
                        $('#popup').html('').hide();
                        printRespSuccess(response_data['message'], 2000, after_success_action, after_success_redirect);
                    } else if (action === 'preview_form') {
                        $('#popup').html(response_data['data']).show();
                        $('#prev_btn_act').css('display', 'flex');
                    } else {
                        printRespSuccess(response_data['message'], 2000, after_success_action, after_success_redirect);
                    }
                } else if (response_data['status'] === '0') {
                    printRespError(response_data['message'], 3000, 'reload', '');
                    return false;
                } else {
                    printRespError(response_data['message'], 3000, 'reload', '');
                    return false;
                }
            },
            error: function (xhr, status, error) {
                printRespError(handleAjaxError(xhr), 3000, 'reload', '');
                return false;
            }
        });
        e.preventDefault(); //STOP default action
    });

//    $('.layout-container').find('.village_code').val('152748').change();
//    setTimeout(function () {
//        $('.layout-container').find('.village_gata').val('7').change();
//        setTimeout(function () {
//            $('.layout-container').find('.village_khata').val('00527').change();
//            setTimeout(function () {
//                $('.layout-container').find('.kashtkar:last').val('sd8fAwKYGqstWbqOqNLvGXTyfOgOINBuGdWrlle5E9R/WhRx3YQb4kW9e/llBuolnGEkB+bPxfTp').change();
//                $('.type').val('1');
//            }, 50);
//        }, 50);
//    }, 50);
});