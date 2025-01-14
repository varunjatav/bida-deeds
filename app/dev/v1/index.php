<?php
// header("location: ../error"); // Shoot viewer back to the homepage of the site if they try to look here
// exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <script src="../../../scripts/jquery.min.js"></script>
</head>

<body>
    <div class="signup_container">
        <h1>Sign Up</h1>
        <form id="frm">
            <div class="frm-focus dev_req_msg">
                <label for="username">User Name:</label>
                <input type="text" id="username" class="frm-txtbox boxsizing fldrequired frm-focus" name="username"
                    placeholder="Please Type your User Name here" value="">
                <div class="frm-er-msg"></div>
            </div>
            <div class="frm-focus dev_req_msg">
            <label for="email">Email:</label>
            <input type="text" id="email" class="frm-txtbox boxsizing fldrequired frm-focus" name="email"
                placeholder="Please Type your Email here" value="">
            <div class="frm-er-msg"></div>
            </div>
            <div class="frm-focus dev_req_msg">
            <label for="password">Password:</label>
            <input type="text" id="password" class="frm-txtbox boxsizing fldrequired frm-focus" name="password"
                placeholder="Please Type your Password here" value="">
            <div class="frm-er-msg"></div>
            </div>
            <button id="create_user">Create User</button>
            <div id="frm_hidden_data"></div>
        </form>
    </div>


    <script>
       $(document).ready(function() {
    $('.signup_container').on('click', '#create_user', function() {
        var check = 0;
        var fldrequired_index_arr = [];
        $(".fldrequired").each(function(index) {
            $(".frm-txtbox").removeClass("frm-focus");
            if ($(this).val() === "") {
                fldrequired_index_arr.push(index);
                check++;
                $(this).addClass("frm-error");
                $(this).closest(".dev_req_msg").find(".frm-er-msg").text("This field is required");
            } else {
                $(this).closest(".dev_req_msg").find(".frm-er-msg").text("");
                $(this).removeClass("frm-error");
            }
        });

        if (check > 0) {
            var idx = fldrequired_index_arr.indexOf(Math.min.apply(null, fldrequired_index_arr));
            $('html, body').animate({
                scrollTop: $(".fldrequired:eq(" + fldrequired_index_arr[idx] + ")").offset().top - 100
            }, 500, function() {
                $(".fldrequired:eq(" + fldrequired_index_arr[idx] + ")").focus();
            });
            return false;
        } else {
            $('#frm').find('.frm_hidden_data').html('');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action" value="create_user" autocomplete="off">');
            $('#frm').find('.frm_hidden_data').append('<input type="hidden" name="action_url" value="actionFold/registrationAction.php" autocomplete="off">');
        }
    });

    $(".signup_container").on('submit', '#frm', function(e) {
        e.preventDefault();
        var postData = new FormData(this);

        for (var pair of postData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        $.ajax({
            url: 'actionFold/registrationAction.php',
            type: "POST",
            data: postData,
            processData: false,
            contentType: false,
            success: function(data) {
                try {
                    var response_data = typeof data === 'string' ? JSON.parse(data) : data;
                    if (response_data.status === '1') {
                        alert(response_data.message);
                    } else {
                        alert(response_data.message || 'Something went wrong.');
                    }
                } catch (error) {
                    console.error('Invalid response:', data);
                    alert('Unexpected response from the server.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('An error occurred.');
            }
        });
    });
});

    </script>
</body>

</html>