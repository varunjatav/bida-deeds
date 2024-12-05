$(document).ready(function (e) {
    $("body").on("keypress", ".integer", function (e) {
        return 8 != e.which && 0 != e.which && (e.which < 48 || e.which > 57) ? !1 : void 0
    }),
            $("body").on("keypress", ".alphabet_spec_chars", function (e) {
        return e.which > 47 && e.which < 58 && 32 != e.which ? !1 : void 0
    }),
            $("body").on("focus", ".spdate", function () {
        $(this).datepicker({
            changeMonth: !0,
            showAnim: "slideDown",
            changeYear: !0,
            dateFormat: "dd-mm-yy"
        }).datepicker("show")
    }),
            $("body").on("focus", ".spsdate", function () {
        $(this).datepicker({
            changeMonth: !0,
            showAnim: "slideDown",
            changeYear: !0,
            dateFormat: "dd-mm-yy"
        }).datepicker("show")
    }),
            $("body").on("focus", ".spedate", function () {
        $(this).datepicker("destroy"), sdate = $(".spsdate").val().split("-"), firstDate = new Date(sdate[1] + "/" + sdate[0] + "/" + sdate[2]), $(this).datepicker({
            changeMonth: !0,
            showAnim: "slideDown",
            changeYear: !0,
            dateFormat: "dd-mm-yy",
            minDate: firstDate
        }).datepicker("show"),
                $(this).datepicker("destroy")
    }),
            $("body").on("focus", ".spaedate", function () {
        sdate = $(".spadate").val().split("-"), firstDate = new Date(sdate[1] + "/" + sdate[0] + "/" + sdate[2]), $(this).datepicker({
            changeMonth: !0,
            showAnim: "slideDown",
            changeYear: !0,
            dateFormat: "dd-mm-yy",
            minDate: firstDate
        }).datepicker("show")
    }),
            $("body").on("focus", ".spbdate", function () {
        var e = new Date;
        $(this).datepicker({
            changeMonth: !0,
            showAnim: "slideDown",
            changeYear: !0,
            yearRange: "-120:+20",
            dateFormat: "dd-mm-yy",
            maxDate: e
        }).datepicker("show"),
                $('.spbedate').datepicker("destroy");
    }),
            $("body").on("keypress", ".spbdate,.spbedate,.spdate,.spsdate,.spedate,.spaedate", function () {
        return false;
    }),
            $("body").on("focus", ".spbedate", function () {
        var e = new Date;
        //$(this).datepicker("destroy"),
        sdate = $(".spbdate").val().split("-"), firstDate = new Date(sdate[1] + "/" + sdate[0] + "/" + sdate[2]), $(this).datepicker({changeMonth: !0, showAnim: "slideDown", changeYear: !0, dateFormat: "dd-mm-yy", minDate: firstDate, maxDate: e}).datepicker("show")
    }),
            $("body").on("focus", ".spadate", function () {
        var e = new Date;
        $(this).datepicker({
            changeMonth: !0,
            showAnim: "slideDown",
            changeYear: !0,
            dateFormat: "dd-mm-yy",
            minDate: e
        }).datepicker("show")
    }),
            $("body").on("focus", ".spa30date", function () {
        var e = new Date;
        var dt = new Date;
        dt.setDate(dt.getDate() + 90);
        $(this).datepicker({
            changeMonth: !0,
            showAnim: "slideDown",
            changeYear: !0,
            dateFormat: "dd-mm-yy",
            minDate: e,
            maxDate: dt
        }).datepicker("show")
    }),
            $("body").on("focus", ".spmdate", function () {
        var e = new Date;
        $(this).datepicker({
            changeMonth: !0,
            showAnim: "slideDown",
            changeYear: !0,
            dateFormat: "dd-mm-yy",
            maxDate: e
        }).datepicker("show")
    }),
            $("body").on("focus", ".sptime", function () {
        $(this).timepicker({
            timeFormat: "h:i A",
            'step': '10',
            minTime: "0:00 AM",
            maxTime: "11:59 PM"
        }).timepicker("show")
    }),
            $("body").on("focus", ".spstime", function () {
        $(this).timepicker({
            timeFormat: "h:i A",
            minTime: "0:00 AM",
            maxTime: "11:59 PM"
        }).timepicker("show")
    }), $("body").on("focus", ".spetime", function () {
        $(this).timepicker({
            timeFormat: "h:i A",
            minTime: "0:00 AM",
            maxTime: "11:59 PM"
        }).timepicker("show")
    }), $("body").on("keydown", ".decimal", function (event) {
        if (event.shiftKey == !0) {
            event.preventDefault()
        }
        if ((event.keyCode >= 48 && event.keyCode <= 57) || (event.keyCode >= 96 && event.keyCode <= 105) || event.keyCode == 8 || event.keyCode == 9 || event.keyCode == 37 || event.keyCode == 39 || event.keyCode == 46 || event.keyCode == 190) {
        } else {
            event.preventDefault()
        }
        if ($(this).val().indexOf('.') !== -1 && event.keyCode == 190) {
            event.preventDefault()
        }
    }),
            $('body').on('focus', '.frm-txtbox', function () {
        $('.frm-txtbox').removeClass('frm-focus');
        $(this).addClass('frm-focus');
    });
    // $('.frm-txtbox').live('keyup', function () {
    //     if ($(this).hasClass('nolabel') === false) {
    //         if ($(this).val() && $(this).hasClass('fldrequired') === true) {
    //             $(this).closest('.form-field-wrap').find('.frm-lbl-actv').text($(this).attr('placeholder') + '');
    //             $(this).closest('.form-field-wrap').find('.frm-er-msg').text('');
    //         } else if ($(this).val() && $(this).hasClass('fldrequired') === false) {
    //             $(this).closest('.form-field-wrap').find('.frm-lbl-actv').text($(this).attr('placeholder'));
    //             $(this).closest('.form-field-wrap').find('.frm-er-msg').text('');
    //         } else {
    //             $(this).closest('.form-field-wrap').find('.frm-lbl-actv').text('');
    //         }
    //     }
    // });
    // $('.frm-txarea').live('keyup', function () {
    //     if ($(this).hasClass('nolabel') === false) {
    //         if ($(this).val() && $(this).hasClass('fldrequired') === true) {
    //             $(this).closest('.form-field-wrap').find('.frm-lbl-actv').text($(this).attr('placeholder') + '');
    //             $(this).closest('.form-field-wrap').find('.frm-er-msg').text('');
    //         } else if ($(this).val() && $(this).hasClass('fldrequired') === false) {
    //             $(this).closest('.form-field-wrap').find('.frm-lbl-actv').text($(this).attr('placeholder'));
    //             $(this).closest('.form-field-wrap').find('.frm-er-msg').text('');
    //         } else {
    //             $(this).closest('.form-field-wrap').find('.frm-lbl-actv').text('');
    //         }
    //     }
    // });
    $('body').on('keypress', '.alphanum', function (event) {
        var regex = new RegExp("^[a-zA-Z0-9\b ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    $('body').on('keypress', '.alphanumnospace', function (event) {
        var regex = new RegExp("^[a-zA-Z0-9\b]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    $('body').on('keypress', '.alphabet', function (event) {
        var regex = new RegExp("^[a-zA-Z\b ]+$");
        var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
        if (!regex.test(key)) {
            event.preventDefault();
            return false;
        }
    });
    $('body').on('keypress', '.numeric', function (event) {
        if ((event.which != 46 || $(this).val().indexOf('.') != -1) && (event.which < 48 || event.which > 57)) {
            event.preventDefault();
        }
    });

    $('body').on('keyup', '.vlMinValMaxValMaxLen', function () {
        var curr = $(this);
        var minval = parseInt(curr.attr('min'));
        var maxval = parseInt(curr.attr('max'));
        var maxlen = parseInt(curr.attr('maxlength'));
        var inputval = curr.val();
        if (inputval) {
            if (inputval > maxval || inputval.length > maxlen || inputval < minval) {
                curr.addClass('frm-error');
                curr.closest('.form-type').find('span').remove();
                curr.closest('.form-type').append('<div class="clr"></div><span><i class="err_msg_txt" style="color:red; font-size:12px;">' + minval + '-' + maxval + ' allowed</i></span>');
            } else {
                curr.removeClass('frm-error');
                curr.closest('.form-type').find('span').remove();
            }
        } else {
            curr.removeClass('frm-error');
            curr.closest('.form-type').find('span').remove();
        }
    });

    $('body').on('keyup', '.vlMaxValMaxLen', function () {
        var curr = $(this);
        var maxval = parseInt(curr.attr('max'));
        var maxlen = parseInt(curr.attr('maxlength'));
        var inputval = curr.val();
        if (inputval) {
            if (inputval > maxval || inputval.length > maxlen) {
                curr.addClass('frm-error');
                curr.closest('.form-type').find('span').remove();
                curr.closest('.form-type').append('<div class="clr"></div><span><i class="err_msg_txt" style="color:red; font-size:12px;">max ' + maxval + ' allowed</i></span>');
            } else {
                curr.removeClass('frm-error');
                curr.closest('.form-type').find('span').remove();
            }
        } else {
            curr.removeClass('frm-error');
            curr.closest('.form-type').find('span').remove();
        }
    });

    $('body').on('keyup', '.vlMaxVal', function () {
        var curr = $(this);
        var maxval = parseInt(curr.attr('max'));
        var inputval = curr.val();
        if (inputval) {
            if (inputval > maxval) {
                curr.addClass('frm-error');
                curr.closest('.form-type').find('span').remove();
                curr.closest('.form-type').append('<div class="clr"></div><span><i class="err_msg_txt" style="color:red; font-size:12px;">max ' + maxval + ' allowed</i></span>');
            } else {
                curr.removeClass('frm-error');
                curr.closest('.form-type').find('span').remove();
            }
        } else {
            curr.removeClass('frm-error');
            curr.closest('.form-type').find('span').remove();
        }
    });

    $('body').on('keyup', '.vlMinValMinLen', function () {
        var curr = $(this);
        var minval = parseInt(curr.attr('min'));
        var minlen = parseInt(curr.attr('minlength'));
        var inputval = curr.val();
        if (inputval) {
            if (inputval < minval || inputval.length < minlen) {
                curr.addClass('frm-error');
                curr.closest('.form-type').find('span').remove();
                curr.closest('.form-type').append('<div class="clr"></div><span><i class="err_msg_txt" style="color:red; font-size:12px;">min ' + minval + ' allowed</i></span>');
            } else {
                curr.removeClass('frm-error');
                curr.closest('.form-type').find('span').remove();
            }
        } else {
            curr.removeClass('frm-error');
            curr.closest('.form-type').find('span').remove();
        }
    });

    $('body').on('keyup', '.vlMinVal', function () {
        var curr = $(this);
        var minval = parseInt(curr.attr('min'));
        var inputval = curr.val();
        if (inputval) {
            if (inputval < minval) {
                curr.addClass('frm-error');
                curr.closest('.form-type').find('span').remove();
                curr.closest('.form-type').append('<div class="clr"></div><span><i class="err_msg_txt" style="color:red; font-size:12px;">min ' + minval + ' allowed</i></span>');
            } else {
                curr.removeClass('frm-error');
                curr.closest('.form-type').find('span').remove();
            }
        } else {
            curr.removeClass('frm-error');
            curr.closest('.form-type').find('span').remove();
        }
    });

    $('body').on('keyup', '.vlMaxLenMinLen', function () {
        var curr = $(this);
        var minlength = parseInt(curr.attr('minlength'));
        var maxlen = parseInt(curr.attr('maxlength'));
        var inputval = curr.val();
        if (inputval) {
            if (inputval.length < minlength || inputval.length > maxlen) {
                curr.addClass('frm-error');
                curr.closest('.form-type').find('span').remove();
                curr.closest('.form-type').append('<div class="clr"></div><span><i class="err_msg_txt" style="color:red; font-size:12px;">' + minlength + ' to ' + maxlen + ' chars allowed</i></span>');
            } else {
                curr.removeClass('frm-error');
                curr.closest('.form-type').find('span').remove();
            }
        } else {
            curr.removeClass('frm-error');
            curr.closest('.form-type').find('span').remove();
        }
    });
});

function sort_name(value, type) {
    var tbody = $('#paginate-body');
    if (type === 'numeric') {
        tbody.find('.rowDiv').sort(function (a, b) {
            if ($('#name_order').val() === 'asc') {
                return parseInt($('.col' + value + '', a).attr('name')) - parseInt($('.col' + value + '', b).attr('name'));
            } else {
                return parseInt($('.col' + value + '', b).attr('name')) - parseInt($('.col' + value + '', a).attr('name'));
            }
        }).appendTo(tbody);
    } else {
        tbody.find('.rowDiv').sort(function (a, b) {
            if ($('#name_order').val() === 'asc') {
                return $('.col' + value + ':first', a).text().localeCompare($('.col' + value + ':first', b).text());
            } else {
                return $('.col' + value + ':first', b).text().localeCompare($('.col' + value + ':first', a).text());
            }
        }).appendTo(tbody);
    }

    var sort_order = $('#name_order').val();
    if (sort_order === "asc") {
        document.getElementById("name_order").value = "desc";
    }
    if (sort_order === "desc") {
        document.getElementById("name_order").value = "asc";
    }
}

function handleAjaxError(xhr) {
    var err_message = '';
    if (xhr.status === 403) {
        err_message = "Request denied.";
    } else if (xhr.status === 404) {
        err_message = "Page not found.";
    } else if (xhr.status === 413) {
        err_message = "Request data is too large.";
    } else if (xhr.status === 501 || xhr.status === 502 || xhr.status === 503) {
        err_message = "Bad gateway.";
    } else {
        err_message = "Unable to process request.";
    }
    return err_message;
}

function printError(err_msg, delay, page_reload, page_navigate) {
    var msg = `<div class="toast_wrapper posfix toast-red">
                    <div class="toast-img left">
                        <img src="img/error-w.svg" alt="" width="18px;">
                    </div>
                    <div class="toast-msg left">
                        ${err_msg}
                    </div>
                    <div class="clr"></div>
                </div>`;

    $("#notify").html('').show();
    $("#notify").html(msg).fadeIn("slow", function () {
        setTimeout(function () {
            $("#notify").hide().html('');
            $('.act_btn_ovrly').hide();
            if (page_reload === 'reload') {
                window.location.reload();
            }
            if (page_navigate) {
                window.location.href = page_navigate;
            }
        }, delay);
    });
}

function printSuccess(succ_msg, delay, page_reload, page_navigate) {
    var msg = `<div class="toast_wrapper posfix toast-grn">
                    <div class="toast-img left">
                        <img src="img/check.svg" alt="" width="18px;">
                    </div>
                    <div class="toast-msg left">
                        ${succ_msg}
                    </div>
                    <div class="clr"></div>
                </div>`;

    $("#notify").html('').show();
    $("#notify").html(msg).fadeIn("slow", function () {
        setTimeout(function () {
            $("#notify").hide().html('');
            $('.act_btn_ovrly').hide();
            if (page_reload === 'reload') {
                window.location.reload();
            }
            if (page_navigate) {
                window.location.href = page_navigate;
            }
        }, delay);
    });
}

function printRespError(err_msg, delay, page_reload, page_navigate) {
    var msg = `<div class="alert alert-dark mb-0" role="alert">${err_msg}</div>`;
    $("#notify").html('').show();
    $("#notify").html(msg).fadeIn("slow", function () {
        setTimeout(function () {
            $("#notify").hide().html('');
            $('.act_btn_ovrly').hide();
            if (page_reload === 'reload') {
                window.location.reload();
            }
            if (page_navigate) {
                window.location.href = page_navigate;
            }
        }, delay);
    });
}

function printRespSuccess(succ_msg, delay, page_reload, page_navigate) {
    var msg = `<div class="alert alert-success" role="alert">${succ_msg}</div>`;
    $("#notify").html('').show();
    $("#notify").html(msg).fadeIn("slow", function () {
        setTimeout(function () {
            $("#notify").hide().html('');
            $('.act_btn_ovrly').hide();
            if (page_reload === 'reload') {
                window.location.reload();
            }
            if (page_navigate) {
                window.location.href = page_navigate;
            }
        }, delay);
    });
}

//ajax call through data string url
function dataStringAjax(dataString, title, message, url) {
    $.confirm({
        title: title,
        message: message,
        buttons: {
            Yes: {
                class: "curr_btn",
                action: function (e) {
                    var curr_btn = $(this);
                    curr_btn.prop('disable', true);
                    $(".curr_btn").text("Please wait...");
                    $.ajax({
                        url: url,
                        type: "POST",
                        data: dataString,
                        cache: false,
                        success: function (data) {
                            var response_data = JSON.parse(data);
                            if (response_data["status"] == "1") {
                                $(".popup-cnfbody").text(response_data["message"]).show();
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            } else if (response_data["status"] == "0") {
                                $(".popup-cnfbody").text(response_data["message"]).show();
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            } else {
                                $(".popup-cnfbody").text('Something went wrong.').show();
                                setTimeout(function () {
                                    window.location.reload();
                                }, 2000);
                            }
                        },
                        error: function (xhr, status, error) {
                            console.log(error);
                            $(".popup-cnfbody").text('Some error occurred.').show();
                            setTimeout(function () {
                                window.location.reload();
                            }, 2000);
                        }
                    });
                    e.preventDefault();
                },
            },
            No: {
                class: "",
                action: function () {},
            },
        },
    });
}

function isNumeric(str) {
    if (typeof str !== "string")
        return false;
    return !isNaN(str) && !isNaN(parseFloat(str));
}

function format_rupees(amount) {
    amount = amount.toString();
    var lastThree = amount.substring(amount.length - 3);
    var otherNumbers = amount.substring(0, amount.length - 3);
    if (otherNumbers !== '')
        lastThree = ',' + lastThree;
    var res = '₹' + otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
    return res;
}

function format_number(amount) {
    amount = amount.toString();
    var lastThree = amount.substring(amount.length - 3);
    var otherNumbers = amount.substring(0, amount.length - 3);
    if (otherNumbers !== '')
        lastThree = ',' + lastThree;
    var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree;
    return res;
}