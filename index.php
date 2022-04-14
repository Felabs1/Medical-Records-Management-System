<html>

<head>
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./css/w3.css">
    <script src="./jquery/jquery.min.js"></script>


    <style type="text/css">
    body {
        background-image: url('./images/pexels-anna-tarazevich-5910953.jpg');
        background-size: cover;
        background-position: center;
        height: 100%;
    }

    .overlay {
        postion: absolute;
        background-color: rgba(0, 0, 0, 0.5);
        height: 100%;
    }

    /* *{
        color: #333;
    } */

    .w3-bar a:hover {
        border-bottom: 2px solid white;
        font-weight: 600;
    }
    </style>
</head>

<body>
    <div class="overlay">

        <?php include("./navbar.php") ?>
        <br><br>
        <div class="w3-container w3-round-large" style="margin: 20px 300px 20px 300px;">
            <h3 class='w3-text-white'>My Account</h3>
            <div class="w3-row-padding">
                <div class="w3-half">
                    <div class="w3-container w3-white w3-round-large">
                        <div class="w3-container"><br>
                        <div class="w3-center w3-auto " style="background-image:url('./images/pexels-thirdman-5327580.jpg'); background-size: contain; height: 180px; background-repeat: no-repeat; width: 120px;">
                        </div>
                        </div><br><br><br>
                        <span>Welcome <span
                                class="w3-text-blue"><?php echo $_SESSION['full_name']; ?></span>,</span><br>
                        <span>Logged In as <span
                                class="w3-text-green"><?php echo $_SESSION['usertype']; ?></span>,</span><br>
                        <span>Last Log in <span
                                class="w3-text-blue"><?php echo $_SESSION['last_login']; ?></span>,</span><br>
                    </div>

                </div>
                <div class="w3-col m6">
                    <div class="w3-container w3-white w3-round-large w3-center">
                        <iframe src="./images/time.html" frameborder="0"
                            style="min-height: 290px; width: 100%; margin-left: 50px; margin-top: 50px;"
                            class="w3-center"></iframe>

                    </div>
                </div>
            </div>


            <div class="w3-row-padding">
                <div class="w3-col m6">
                    <br>
                    <div class="w3-container w3-white">
                        <br>
                        <?php 
				if($_SESSION['usertype'] == 'admin'){
                    ?>
                        <button class="w3-button w3-blue w3-round" onclick="newUser()">Add New User</button>
                        <button class="w3-button w3-grey w3-round" onclick="editUser()">Edit Account</button><br><br>
                        <?php
                }else{
                    ?>
                        <button class="w3-button w3-grey w3-round" onclick="editUser()">Edit Account</button><br><br>
                        <?php
                }

                     ?>

                    </div>

                </div>

                <div class="w3-col m6">
                    <br>
                    <div class="w3-container w3-white">
                        <br>
                        <button class="w3-button w3-blue w3-round"
                            onclick="window.location.href='reports.php'">Reports</button><br><br>
                        <!-- <button class="w3-button w3-grey w3-round">Edit Account</button><br><br> -->
                    </div>

                </div>
            </div>
            <br>
        </div>

        <div id="id01" class="w3-modal">
            <div class="w3-modal-content">
                <div class="w3-container w3-blue">
                    <span onclick="document.getElementById('id01').style.display='none'"
                        class="w3-button w3-display-topright">&times;</span>
                    <h3>New User</h3>
                </div>
                <div class="w3-container">
                    <form action="data/data.php?newuser=true" method="post" autocomplete="off">
                        <label for="">Name</label>
                        <input name="full_name" type="text" class="w3-input w3-border w3-round">
                        <label for="">Phone</label>
                        <input name="phone" type="text" class="w3-input w3-border w3-round">
                        <label for="">Password</label>
                        <input name="password" type="password" class="w3-input w3-border w3-round">
                        <label for="">Usertype</label>
                        <!-- <input type="text" class="w3-input w3-border w3-round">
                 -->
                        <select name="usertype" id="" class="w3-select w3-border w3-round">
                            <option value="admin">Admin</option>
                            <option value="other">Other</option>
                        </select><br><br>
                        <button type="submit" class="w3-button w3-grey w3-round w3-block">SAVE USER</button>
                    </form>
                </div>
            </div>
        </div>

        <div id="id02" class="w3-modal">
            <div class="w3-modal-content">
                <div class="w3-container w3-blue">
                    <span onclick="document.getElementById('id02').style.display='none'"
                        class="w3-button w3-display-topright">&times;</span>
                    <h3>Edit User</h3>
                </div>
                <div class="w3-container">
                    <form action="data/data.php?edituser=true" method="post" autocomplete="off">
                        <label for="">Name</label>
                        <input name="full_name" type="text" class="w3-input w3-border w3-round"
                            value="<?php echo $_SESSION['full_name']; ?>">
                        <label for="">Phone</label>
                        <input name="phone" type="text" class="w3-input w3-border w3-round"
                            value="<?php echo $_SESSION['phone']; ?>" readonly>
                        <label for="">Password</label>
                        <input name="password" type="text" class="w3-input w3-border w3-round"
                            value="<?php echo $_SESSION['true_pass']; ?>">
                        <label for="">Usertype</label>
                        <!-- <input type="text" class="w3-input w3-border w3-round">
                 -->
                        <select name="usertype" id="" class="w3-select w3-border w3-round">
                            <?php
				if($_SESSION['usertype'] == 'admin'){
                    ?>
                            <option value="admin" selected>Admin</option>

                            <?php
                }else{
                    ?>
                            <option value="other">Other</option>

                            <?php
                }

                        ?>
                        </select><br><br>
                        <button type="submit" class="w3-button w3-grey w3-round w3-block">SAVE USER</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
    function newUser() {
        $("#id01").show();
    }

    function editUser() {
        $("#id02").show();
    }
    </script>
</body>

</html>