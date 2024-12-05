$(document).ready(function () {

    $('#popup').on('click', '#cancel_popup', function (event) {
        $('#popup').hide().html('');
    });
    
    $('#rightPopup').on('click', '#cancel_popup', function (event) {
        $('#rightPopup').hide().html('');
    });

    $(".header-fix").on("mouseover", ".showDropdown, .setting-dropdown", function () {
        $(this).closest(".profile-wrap").find(".setting-dropdown").show();
    });

    $(".header-fix").on("mouseleave", ".showDropdown, .setting-dropdown", function () {
        $(this).closest(".profile-wrap").find(".setting-dropdown").hide();
    });

    $(document).on('keydown', function (event) {
        if (event.key === "Escape") {
            $('#popup').hide().html('');
            $('#rightPopup').hide().html('');
        }
    });

    $('.header-fix').on('click', '#change_password', function () {
        $('#popup').html('').load('popup/changePassword.php', function () {
            makeDragable('.popup-header', '.popup-wrap');
        }).fadeIn();
    });

    $('#popup').on('click', '#save_password', function () {
        var check = 0;
        $('.fldrequired').each(function () {
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
        if ($('#pass').val() !== $('#cpass').val()) {
            $('#popupDiv').hide();
            $('#popup_conf_msg').show();
            $('#popup_conf_msg').find('.cnfrm-task').text('Password does not matched').show();
            setTimeout(function () {
                $('#popup_conf_msg').find('.cnfrm-task').text('');
                $('#popup_conf_msg').hide();
                $('#popupDiv').show();
            }, 2000);
            return false;
        }
        $('.act_btn_ovrly').show();
        $("#frm").on('submit', function (event) {
            event.preventDefault();
            var postData = new FormData(this);
            postData.append('action', 'change_password');
            var formURL = "action/userAction.php";
            $('#save_password').text('Please wait...');
            $.ajax({
                url: formURL,
                type: "POST",
                data: postData,
                processData: false,
                contentType: false,
                success: function (data, textStatus, jqXHR) {
                    var response_data = JSON.parse(data);
                    $('#save_password').text('save');
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
                }
            });
            e.preventDefault();	//STOP default action
        });
        $("#frm").submit(); //SUBMIT FORM
    });

    $(".container-xxl").on("click", "#logout", function () {
        var dataString = "tk=";
        $.ajax({
            type: "POST",
            url: "kasht_logout.php",
            data: dataString,
            cache: !1,
            success: function (data) {
                var response_data = JSON.parse(data);
                if (response_data['status'] === '1') {
                    window.parent.location.href = response_data['page'];
                }
            }
        });
    });
});

