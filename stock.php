
<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./css/w3.css">
    <script src="./jquery/jquery.min.js"></script>


    <style type="text/css">
    body {
        background-color: #eeeeff;
    }

    .w3-bar a:hover {
        border-bottom: 2px solid white;
        font-weight: 600;
    }

    .w3-table th,
    .w3-table td {
        border: 1px solid #ccc;
    }
    </style>
</head>

<body>
<?php include("./navbar.php") ?>
   
    <br><br>
    <div class="w3-container w3-white w3-round-large" style="margin: 20px 300px 20px 300px; min-height: 300px;">
        <h3 class="w3-center">New Stock</h3>
        <div class="w3-row-padding">
            <div class="w3-half">
                <form action="./data/data.php?add_stock=true" method='POST' autocomplete="off">
                    <table>
                        <tr>
                            <th>serial no</th>
                            <td>
                                <input class="w3-input w3-border w3-round" name="serial_no" id="serial_no" type="text"
                                    required>
                            </td>
                        </tr>
                        <tr>
                            <th>product Name</th>
                            <td>
                                <select name="product_name" id="product_name" class="w3-select w3-border w3-round"
                                    onclick="showprodattr(this)" onfocus="showProd()" required>
                                    <option value="1" disabled selected>Stock Name</option>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><button class="w3-button w3-blue w3-round" type="submit">Save</button></td>
                        </tr>
                    </table>
                </form>
            </div>
            <div class="w3-half">
                <div class="w3-container" id="medpreview">

                </div>
            </div>
        </div>
    </div>


    <!-- Table -->
    <div class="w3-container w3-white w3-round-large" style="margin: 20px 300px 20px 300px;">
        <h3>Make Sales</h3>
        <div class="w3-right">
            <input class="w3-input w3-bar-item w3-border w3-round" id="myInput" placeholder="search"></input>
        </div>

        <div id="showProd">

        </div>
        <br>
    </div>

    <script type="text/javascript">
    $.get('./data/data.php?showstock=true', function(data) {
        $("#showProd").html(data);
    })

    function showprodattr(x) {
        $.get("./data/data.php?showprodattr=" + x.value, function(data) {
            $("#medpreview").html(data);
        })
    }

    $(".msg").hide(2000);

    function showProd() {
        $.get("./data/data.php?showproducts=true", function(data) {
            $("#product_name").html(data);
        })
    }

    $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        });
    });
    </script>
</body>

</html>