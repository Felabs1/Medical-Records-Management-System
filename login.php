<!DOCTYPE html>
<html>

<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="./css/w3.css">

    <script src="./jquery/jquery.min.js"></script>

    <script src="./js/main.js"></script>

    <style>
    body{
        background-image: url('./images/pexels-mart-production-7230183.jpg');
        height: 100%;
        background-size: cover;
        background-position: center;
    }
    </style>
</head>

<body>
    <div class="wallpaper">
        <div class="overlay"><br>
            <br>
            <br>
            <br>
            <br>
            <div class="w3-container w3-white w3-round-large w3-auto" style="width: 350px;">
                <div class="w3-container w3-center">
                    <h3>Log In</h3>
                </div>
                <form id="frmlogin">
                    <label>Username</label>
                    <input class="w3-input w3-border w3-round" id="phone" name="phone" placeholder="enter ID Number">
                    <span class=" w3-text-red" id="phone_err" style="display: none;">this is span</span><br>
                    <label>Password</label>
                    <input class="w3-input w3-border w3-round" type="password" id="password" name="password"
                        placeholder="enter password">
                    <span style="display: none;" class="w3-text-red" id="password_err"></span><br>
                    <button class="w3-button w3-blue w3-round" type="button" onclick="login()">Log In</button>
                    <br><br>
                </form>
            </div>
        </div>
    </div>
</body>

</html>