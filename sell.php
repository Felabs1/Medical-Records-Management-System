
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
        <h3 class="w3-center">Make sales</h3>
        <div class="w3-row-padding">
            <div class="w3-half">
                <form action="./data/data.php?sell_stock=true" method='POST' autocomplete="off">
                    <table>
                        <tr>
                            <th>serial no</th>
                            <td>
                                <input class="w3-input w3-border w3-round" name="serial_no" id="serial_no" type="text"
                                    readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>ref No</th>
                            <td>
                                <input class="w3-input w3-border w3-round" name="ref_no" id="ref_no" type="text"
                                    readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>Name</th>
                            <td>
                                <input class="w3-input w3-border w3-round" name="product_name" id="product_name"
                                    type="text" readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>
                                <input class="w3-input w3-border w3-round" name="price" id="price" type="number"
                                    readonly>
                            </td>
                        </tr>
                        <tr>
                            <th>Sold To</th>
                            <td>
                                <input class="w3-input w3-border w3-round" name="sold_to" id="sold_to" type="text"
                                    required>
                            </td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td><button class="w3-button w3-blue w3-round" type="submit">Sell</button></td>
                        </tr>
                    </table>
                </form>

            </div>
            <div class="w3-half">
                <img class="w3-image" id="previmg">
            </div>
        </div>



    </div>


    <!-- Table -->
    <!-- <div class="w3-container w3-white w3-round-large" style="margin: 20px 300px 20px 300px;">
        <h3>Make Sales</h3>
        <div class="w3-right">
            <input class="w3-input w3-bar-item w3-border w3-round" placeholder="search"></input>
        </div>

        <div id="showProd">

        </div>
        <br>
    </div> -->

    <script type="text/javascript">
    $.get('./data/data.php?buyer=<?php echo $_GET['id']; ?>', function(data) {
        result = JSON.parse(data);
        // console.log(result);
        $("#serial_no").val(result.serial_no);
        sName = result.stock_name;
        $.get('./data/data.php?buyer2=' + sName, function(data) {
            result2 = JSON.parse(data);
            // console.log(result2);
            $("#product_name").val(result2.med_name)
            $("#price").val(result2.price);
            $("#ref_no").val(result2.id);
            $("#previmg").attr("src", result2.image.slice(1));
        })
    });

    // function showprodattr(x) {
    //     $.get("./data/data.php?showprodattr=" + x.value, function(data) {
    //         $("#medpreview").html(data);
    //     })
    // }

    // $(".msg").hide(2000);

    // function showProd() {
    //     $.get("./data/data.php?showproducts=true", function(data) {
    //         $("#product_name").html(data);
    //     })
    // }
    </script>
</body>

</html>