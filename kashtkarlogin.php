<?php
include_once "config.php";
include_once "dbcon/db_connect.php";
if (isset($_COOKIE[$kasht_cookie_name])) {
    include_once 'includes/kashtCheckSession.php';
    header('Location: kashtkarsahmati');
    exit();
}
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no, minimum-scale=1.0, maximum-scale=1.0">
        <title>Login</title>
        <meta name="description" content="">
        <link rel="icon" type="image/x-icon" href="assets/img/favicon/favicon.ico">
        <link href="css/font.css" rel="stylesheet">
        <link rel="stylesheet" href="css/style.css">
        <link rel="stylesheet" href="assets/vendor/fonts/boxicons.css">
        <link rel="stylesheet" href="assets/vendor/css/core.css" class="template-customizer-core-css">
        <link rel="stylesheet" href="assets/vendor/css/theme-default.css" class="template-customizer-theme-css">
        <link rel="stylesheet" href="assets/css/demo.css">
        <link rel="stylesheet" href="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.css">
        <link rel="stylesheet" href="assets/vendor/css/pages/page-auth.css">
    </head>

    <body>
        <div class="container-xxl">
            <div class="authentication-wrapper authentication-basic container-p-y">
                <div class="authentication-inner">
                    <!-- Register -->
                    <div class="card">
                        <div class="card-body">
                            <!-- Logo -->
                            <div class="app-brand justify-content-center">
                                <span class="app-brand-text demo text-body fw-bolder">BIDA LAMS</span>
                            </div>
                            <!-- /Logo -->
                            <h4 class="mb-2" style="text-align: center;">काश्तकार लॉगिन</h4>

                            <form id="frm" class="mb-3" autocomplete="off">
                                <div class="mb-3">
                                    <label for="email" class="form-label">मोबाइल नंबर</label>
                                    <input type="text" class="form-control fldrequired integer" id="mobile" name="mobile" placeholder="अपना मोबाइल डालें" value="" maxlength="10" pattern="[0-9]*" inputmode="numeric">
                                </div>
                                <div class="mb-3" style="display: none;">
                                    <label for="email" class="form-label">OTP डालें</label>
                                    <div style="display: flex; gap: 10px;">
                                        <input type="text" class="form-control integer otp" name="otp[]" placeholder="-" value="" maxlength="1" pattern="[0-9]*" inputmode="numeric" style="text-align: center;">
                                        <input type="text" class="form-control integer otp" name="otp[]" placeholder="-" value="" maxlength="1" pattern="[0-9]*" inputmode="numeric" style="text-align: center;">
                                        <input type="text" class="form-control integer otp" name="otp[]" placeholder="-" value="" maxlength="1" pattern="[0-9]*" inputmode="numeric" style="text-align: center;">
                                        <input type="text" class="form-control integer otp" name="otp[]" placeholder="-" value="" maxlength="1" pattern="[0-9]*" inputmode="numeric" style="text-align: center;">
                                    </div>
                                </div>
                                <div class="frm_hidden_data"></div>
                                <div class="posrel">
                                    <div class="posabsolut act_btn_ovrly"></div>
                                    <button id="send_otp" class="btn btn-primary d-grid w-100">OTP भेजें</button>
                                </div>
                            </form>
                            <p class="text-center frm_msg">
                                <span></span>
                            </p>
                        </div>
                    </div>
                    <!-- /Register -->
                </div>
            </div>
            <div id="notify" style="position: fixed; bottom: 0; width: 91%; z-index: 10;"></div>
        </div>
    </body>
    <script src="assets/vendor/js/helpers.js"></script>
    <script src="assets/js/config.js"></script>
    <script src="assets/vendor/libs/jquery/jquery.js"></script>
    <script src="assets/vendor/libs/popper/popper.js"></script>
    <script src="assets/vendor/js/bootstrap.js"></script>
    <script src="assets/vendor/libs/perfect-scrollbar/perfect-scrollbar.js"></script>
    <script src="assets/vendor/js/menu.js"></script>
    <script src="assets/js/main.js"></script>
    <script src="scripts/buttons.js"></script>
    <script src="scripts/common.js"></script>
    <script>
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

            $('.container-xxl').on('click', "#send_otp", function () {
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
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="send_otp" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/userAction" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#send_otp" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="OTP भेजें" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="" autocomplete="off">');
                }
            });

            $('.container-xxl').on('click', "#check_otp", function () {
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
                    var json_data = getTimeZoneData();
                    $('#frm').find('.frm_hidden_data').html('');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="check_otp" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="action/userAction" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_id" value="#check_otp" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_btn_name" value="लॉगिन करे" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_action" value="" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="after_success_redirect" value="choosemodule" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="offset" value="' + json_data['offset'] + '" autocomplete="off">');
                    $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="dst" value="' + json_data['dst'] + '" autocomplete="off">');
                }
            });

            $('.container-xxl').on("submit", "#frm", function (e) {
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
                        } else if (response_data['status'] === '1') {
                            if (action === 'send_otp') {
                                $('#send_otp').text('लॉगिन करे');
                                $('.btn-primary').removeAttr('id');
                                $('.btn-primary').attr('id', 'check_otp');
                                $('.act_btn_ovrly').hide();
                                $('.otp').closest('.mb-3').show();
                                $('.otp').addClass('fldrequired');
                            }
                            printRespSuccess(response_data['message'], 2000, after_success_action, after_success_redirect);
                        } else if (response_data['status'] === '0') {
                            printRespError(response_data['message'], 3000, 'reload', '');
                        } else {
                            printRespError(response_data['message'], 3000, 'reload', '');
                        }
                    },
                    error: function (xhr, status, error) {
                        printRespError(handleAjaxError(xhr), 3000, 'reload', '');
                    }
                });
                e.preventDefault(); //STOP default action
            });
        });

        function getTimeZoneData() {
            var today = new Date();
            var jan = new Date(today.getFullYear(), 0, 1);
            var jul = new Date(today.getFullYear(), 6, 1);
            var dst = today.getTimezoneOffset() < Math.max(jan.getTimezoneOffset(), jul.getTimezoneOffset());
            return {
                offset: -today.getTimezoneOffset() / 60,
                dst: +dst
            };
        }
    </script>
</html>