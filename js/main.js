function login() {
    var phone = $("#phone");
    var password = $("#password");
    var phone_err = $("#phone_err");
    var password_err = $("#password_err");
    var status;
    var form = $("#frmlogin");

    if (phone.val() == "") {
        phone.addClass("w3-border-red");
        phone_err.show();
        phone_err.html("please enter username")
        status = false;
    }

    if (password.val() == "") {
        password_err.show();
        password_err.html("please enter password");
        password.addClass("w3-border-red");
        status = false;
    }

    if (status !== false) {
        $.ajax({
            url: "./data/data.php?login=true",
            method: "POST",
            data: form.serialize(),
            success: function(data) {
                if (data == "INVALID_USERNAME") {
                    phone.addClass("w3-border-red");
                    phone_err.show();
                    phone_err.html("invalid username");
                } else if (data == "INCORRECT_PASS") {
                    password_err.show();
                    password_err.html("incorrect password");
                    password.addClass("w3-border-red");
                } else {
                    window.location.href = "./index.php";
                }
            }
        });
    }
}