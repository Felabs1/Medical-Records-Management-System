
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
    <div class="w3-container w3-white w3-round-large" style="margin: 20px 300px 20px 300px;">
        <h3 class="w3-center">New Medicine</h3>
        <form action="./data/data.php?add_product=true" method='POST' enctype="multipart/form-data">
            <table>
                <tr>
                    <th>Med Name</th>
                    <td>
                        <input class="w3-input w3-border w3-round" name="med_name" id="med_name" type="text" required>
                    </td>
                </tr>
                <tr>
                    <th>Short Form</th>
                    <td>
                        <input class="w3-input w3-border w3-round" name="short_form" id="short_form" type="text"
                            required>
                    </td>
                </tr>
                <tr>
                    <th>Category</th>
                    <td>
                        <select name="category" id="category" class="w3-select w3-border w3-round" onfocus="showCat()">
                            <option value="" disabled selected>Select Category</option>
                        </select>
                    </td>
                </tr>
                <tr>
                    <th>Price</th>
                    <td>
                        <input class="w3-input w3-border w3-round" name="price" id="price" type="text" required>
                    </td>
                </tr>
                <tr>
                    <th>image</th>
                    <td>
                        <input class="w3-input w3-border w3-round" name="image" id="image" type="file" required>
                    </td>
                </tr>
                <tr>

                    <td>&nbsp;</td>
                    <td>
                        <?php
				if($_SESSION['usertype'] == 'admin'){
                    ?>
<button class="w3-button w3-blue w3-round" type="submit">Save</button>
                    <?php
                }else{
                    ?>
<button disabled class="w3-button w3-blue w3-round" type="submit">Save</button>

                    <?php
                }

                        ?>
                    </td>
                </tr>
            </table>
        </form>
    </div>


    <!-- Table -->
    <div class="w3-container w3-white w3-round-large" style="margin: 20px 300px 20px 300px;">
        <h3>Saved Products</h3>
        <div class="w3-right">
            <input class="w3-input w3-bar-item w3-border w3-round" id="myInput" placeholder="search"></input>
        </div>

        <div id="showProd">
        </div>
    </div>

    <div class="w3-modal" id="updatemodal">
        <div class="w3-modal-content w3-white w3-round-large">
            <div class="w3-container w3-round-large">
                <span class="w3-right"
                    onclick="document.getElementById('updatemodal').style.display='none';">Close</span>
                <span class="w3-large"> Edit Product</span>
            </div>
            <div class="w3-container">
                <form action="./data/data.php?prupdate=true" method="post">
                    <table>
                        <input type="hidden" id="id2" name="id2">
                        <tr>
                            <th>Med Name</th>
                            <td>
                                <input class="w3-input w3-border w3-round" name="med_name2" id="med_name2" type="text"
                                    required>
                            </td>
                        </tr>
                        <tr>
                            <th>Short Form</th>
                            <td>
                                <input class="w3-input w3-border w3-round" name="short_form2" id="short_form2"
                                    type="text" required>
                            </td>
                        </tr>
                        <tr>
                            <th>Price</th>
                            <td>
                                <input class="w3-input w3-border w3-round" name="price2" id="price2" type="text"
                                    required>
                            </td>
                        </tr>
                        <tr>
                            <td>
                                &nbsp;</td>
                            <td>
                                <button type="submit" class="w3-button w3-round w3-block w3-light-grey">Update </button>
                            </td>
                        </tr>
                    </table>
                </form>
            </div>
        </div>
    </div>

    <script type="text/javascript">
    function deleteProduct(id) {
        var ask = confirm('are you sure?');
        if (ask == true) {
            $.get('./data/data.php?deleteprod=' + id, function(data) {
                // $("#showProd").html(data);
                if(data == "1"){
                    window.location.href = "./products.php";
                }else{
                    alert(data);
                }
            })
        }
    }

    function editProduct(x) {
        $("#updatemodal").show();
        $.get('./data/data.php?showprodupdate=' + x, function(data) {
            result = JSON.parse(data);
            console.log(result);
            $("#med_name2").val(result.med_name);
            $("#short_form2").val(result.chem_name);
            $("#price2").val(result.price);
            $("#id2").val(result.id);
            // $("#catPrev").val(result.cat);
        })
    }
    $.get('./data/data.php?showprod=true', function(data) {
        $("#showProd").html(data);
    })

    $(".msg").hide(2000);

    function showCat2() {
        $.get("./data/data.php?showcat=true", function(data) {
            $("#category2").html(data);
        })
    }

    function showCat() {
        $.get("./data/data.php?showcat=true", function(data) {
            $("#category").html(data);
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