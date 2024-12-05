$(document).ready(function () {

    $('#popup').on('click', '#cancel_popup', function (event) {
        $('#popup').hide().html('');
        $('body').css('overflow-y', '');
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

    $(".header-fix").on("mouseover", ".showLang, .setting-dropdown", function () {
        $(this).closest(".lngwrap").find(".setting-dropdown").show();
    });

    $(".header-fix").on("mouseleave", ".showLang, .setting-dropdown", function () {
        $(this).closest(".lngwrap").find(".setting-dropdown").hide();
    });

    $(document).on('keydown', function (event) {
        if (event.key === "Escape") {
            $('#popup').hide().html('');
            $('#rightPopup').hide().html('');
        }
    });

    $('.header-fix').on('click', '.sel_lng', function () {
        var dataString = "lng=" + $(this).attr('id') + "&action=change_language";
        $.ajax({
            type: "POST",
            url: "action/deedAction.php",
            data: dataString,
            cache: !1,
            success: function (data) {
                var response_data = JSON.parse(data);
                if (response_data['status'] === '1') {
                    window.parent.location.reload();
                }
            }
        });
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
            var formURL = "action/lamsAction.php";
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

    $(".header-fix").on("click", "#logout", function () {
        var dataString = "tk=";
        $.ajax({
            type: "POST",
            url: "logout.php",
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

    $('.header-fix').on('click', '.showNotify', function () {
        var dataString = '';
        $('.notif-drawer').html('<div class="medical-spinner" style="top:45%; left:45%;" id="load"></div>');
        $('.notif-drawer').toggle();
        $.ajax({
            url: "ajax/showNotification.php",
            type: "POST",
            data: dataString,
            cache: false,
            success: function (data, textStatus, jqXHR) {
                setTimeout(function () {
                    $('.notif-drawer').html(data);
                }, 400);
            }
        });
    });

    $(".notif-drawer").on("click", ".rmbtmpop", function () {
        var curr = $(this);
        var id = $(this).attr('id');
        var o = "id=" + id + "&action=remove_alert_notiy";
        $.ajax({
            type: "POST",
            url: "action/lamsAction.php",
            data: o,
            cache: !1,
            success: function (o) {
                curr.closest('.ntf-wrap').slideUp(500).fadeOut(500);
                setTimeout(function () {
                    curr.closest('.ntf-wrap').remove();
                    $('.notifcnt').text($('.notifcnt').text() - 1);
                    localStorage.setItem("alert_count", $('.notifcnt').text());
                }, 500);
            }
        });
    });

    $(".notif-drawer").on("click", ".clear_all_notify", function () {
        var curr = $(this);
        var o = "action=remove_all_alert_notiy";
        $.ajax({
            type: "POST",
            url: "action/lamsAction.php",
            data: o,
            cache: !1,
            success: function (o) {
                var delay = 0;
                $('.ntf-wrap').each(function () {
                    $('.notifcnt').text($('.notifcnt').text() - 1);
                    $(this).slideUp(delay + 500).fadeOut(delay + 500);
                    setTimeout(function () {
                        localStorage.setItem("alert_count", $('.notifcnt').text());
                        $(this).remove();
                    }, delay + 500);
                    delay += 150;
                });
            }
        });
    });

    $(".notif-drawer").on("click", ".view_notify", function () {
        var curr = $(this);
        var id = $(this).attr('id');
        var name = $(this).attr('name');
        var o = "id=" + id + "&action=remove_alert_notiy";
        $('.notifcnt').text($('.notifcnt').text() - 1);
        $.ajax({
            type: "POST",
            url: "action/lamsAction.php",
            data: o,
            cache: !1,
            success: function (o) {
                localStorage.setItem("alert_count", $('.notifcnt').text());
                window.location.href = name;
            }
        });
    });

    $(".sidebar").on("click", ".dropbtn", function () {
        $(this).closest('.sidedropdown').find('.dropdown-content').slideToggle();
    });
    
    $(document).mouseup(function () {
        var container = $(".notif-drawer");
        if (!container.is(event.target) && !container.has(event.target).length) {
            container.hide();
        }
    });

    getNewNotificationCount();
});

var notifyAlertInterval;
var speak = false;
function getNewNotificationCount() {
    var dataString = '';
    $.ajax({
        url: "ajax/getNewNotification.php",
        type: "POST",
        data: dataString,
        cache: false,
        success: function (data, textStatus, jqXHR) {
            //console.log(data);
            var data = JSON.parse(data);
            if (data['new_notification'] > 0) {
                $('.notifcnt').text(data['new_notification']).show();
                if ($('.notifcnt').text() > localStorage.getItem("alert_count")) {
                    speak = true;
                    localStorage.setItem("alert_count", $('.notifcnt').text());
                }
            }
            if (speak === true) {
                notifySound(speak);
                speak = false;
            }
        }
    });
    notifyAlertInterval = setTimeout(getNewNotificationCount, 20000);
}

function notifySound(speak) {
    if (speak) {
        $('#chatAudio').remove();
        $('.header-wrapper').append('<audio id="chatAudio"><source src="img/notify.ogg" type="audio/ogg"></audio>');
        $('#chatAudio')[0].play();
    }
}