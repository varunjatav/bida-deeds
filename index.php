<?php
include_once "config.php";
if (isset($_COOKIE[$cookie_name])) {
    header('Location:dashboard');
}
?>
<!doctype html>
<html>

<head>
    <meta charset="UTF-8">
    <title>DGMS</title>
    <link href="css/stylus.css" rel="stylesheet" type="text/css" />
    <link href="css/common_master.css" rel="stylesheet" type="text/css" />
    <link href="css/font.css" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="css/style.css">
    <script src="scripts/jquery.min.js"></script>
    <script>
        document.write('<style type="text/css">body{display:none}</style>');
        jQuery(function (a) {
            a("body").css("display", "block");
        });
    </script>
</head>

<body>
    <div class="login_container">
        <form method="post" id="loginForm" autocomplete="off">
            <div class="login-block">
                <div class="left heroimg">
                    <img src="img/deed_home.jpg" alt="" />
                    <div class="clr"></div>
                </div>
                <div class="login-wrapper right boxsizing">
                    <div class="welcom-log alc" style="line-height: 30px;">Welcome, Deed Generation & Management System - BIDA</div>
                    <div class="welcom-log"></div>
                    <div class="form-field-wrap posrel">
                        <div class="form-type dev_req_msg">
                            <input type="text" name="username" class="frm-txtbox login-inputs boxsizing fldrequired"
                                placeholder="" value="" autocomplete="off">
                            <label for="" class="form-label">Username</label>
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="form-field-wrap posrel">
                        <div class="form-type dev_req_msg">
                            <input type="password" name="password" class="frm-txtbox login-inputs boxsizing fldrequired"
                                placeholder="" id="password" value="" autocomplete="off">
                            <label for="" class="form-label">Password</label>
                        </div>
                        <div class="frm-er-msg"></div>
                    </div>
                    <div class="clr"></div>
                    <div class="actionbuttons tmarg">
                        <div class="posabsolut act_btn_ovrly"></div>
                        <a style="cursor:pointer;" id="login" class="primary loginbtn boxsizing">Login</a>
                        <div class="clr"></div>
                    </div>
                    <div class="login-inbls alc">Developed By: Innobles</div>

                    <div class="clr"></div>

                </div>
                <div class="clr"></div>

            </div>
        </form>
    </div>
    <div class="disp_err_msg"></div>
</body>
<script src="scripts/jquery.confirm.js"></script>
<script src="scripts/common.js"></script>
<script>
    $(document).ready(function () {
        $("#password").keyup(function (event) {
            if (event.keyCode === 13) {
                $("#login").click();
            }
        });

        $('.login_container').on('click', "#login", function () {
           
            var check = 0;
            $('.fldrequired').each(function () {
                $('.frm-txtbox').removeClass('frm-focus');
                if ($(this).val() == '') {
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
            $("#loginForm").submit(function (e) {
                e.stopImmediatePropagation();
                var json_data = getTimeZoneData();
                var postData = new FormData(this);
             
                postData.append('offset', json_data['offset']);
                postData.append('dst', json_data['dst']);
                var formURL = "core/login.core.php";
                $('#login').text('Please wait...');
                $.ajax({
                    url: formURL,
                    type: "POST",
                    data: postData,
                    processData: false,
                    contentType: false,
                    success: function (data, textStatus, jqXHR) {
                      
                        var data = JSON.parse(data);
                        if (data['status'] === '1') {
                            localStorage.setItem("alert_count", 0);
                            $('#login').text('LOGIN');
                            $('.disp_err_msg').html('<div class="toast_wrapper posfix toast-grn"> <div class="toast-img left"><img src="img/check.svg" alt="" width="18px;"></div><div class="toast-msg left">Logged in successfully.</div><div class="clr"></div></div>').show().delay(2000).fadeOut(1000);
                            $('.act_btn_ovrly').hide();
                            setTimeout(function () {
                                window.location.href = data['page'];
                            }, 3500);
                        } else if (data['status'] === '-1') {
                            $('#login').text('LOGIN');
                            $('.disp_err_msg').html('<div class="toast_wrapper posfix toast-red"><div class="toast-img left"><img src="img/error.svg" alt="" width="18px;"></div><div class="toast-msg left text-wrapping">' + data['page'] + '</div><div class="clr"></div></div>').show().delay(2000).fadeOut(1000);
                            $('.act_btn_ovrly').hide();
                        } else if (data['status'] === '-3') {
                            $('#login').text('LOGIN');
                            $('.disp_err_msg').html('<div class="toast_wrapper posfix toast-red"><div class="toast-img left"><img src="img/error.svg" alt="" width="18px;"></div><div class="toast-msg left text-wrapping"> You are blacklisted. Contact administrator.</div><div class="clr"></div></div>').show().delay(2000).fadeOut(1000);
                            $('.act_btn_ovrly').hide();
                            setTimeout(function () {
                                $('.disp_err_msg').html('');
                            }, 3500);
                        } else if (data['status'] === '0') {
                            $('#login').text('LOGIN');
                            $('.disp_err_msg').html('<div class="toast_wrapper posfix toast-red"><div class="toast-img left"><img src="img/error.svg" alt="" width="18px;"></div><div class="toast-msg left text-wrapping"> ' + data['message'] + '</div><div class="clr"></div></div>').show().delay(2000).fadeOut(1000);
                            $('.act_btn_ovrly').hide();
                            setTimeout(function () {
                                window.location.reload();
                            }, 3500);
                        } else {
                            $('#login').text('LOGIN');
                            $('.disp_err_msg').html('<div class="toast_wrapper posfix toast-red"><div class="toast-img left"><img src="img/error.svg" alt="" width="18px;"></div><div class="toast-msg left text-wrapping"> Something went wrong</div><div class="clr"></div></div>').show().delay(2000).fadeOut(1000);
                            $('.act_btn_ovrly').hide();
                            setTimeout(function () {
                                window.location.reload();
                            }, 3500);
                        }
                    },
                    error: function (xhr, status, error) {
                        $('.disp_err_msg').html('<div class="frm-error"></div>');
                        handleAjaxError(xhr, status, error, "frm-error");
                        setTimeout(function () {
                            window.location.reload();
                        }, 2000);
                    }
                });
                e.preventDefault(); //STOP default action
            });
            $("#loginForm").submit(); //SUBMIT FORM
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