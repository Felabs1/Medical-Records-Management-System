
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

    .w3-table td,
    th {
        border: 1px solid #ccc;
    }
    </style>
</head>

<body>
<?php include("./navbar.php") ?>
    
    <br><br>
    <div class="w3-container w3-white w3-round-large" style="margin: 20px 300px 20px 300px;">
        <h3 class="w3-center">New Category</h3>
        <table>
            <form action="<?php echo htmlspecialchars("./data/data.php?addcat=true") ?>" method="post">
                <tr>
                    <td>Category Name</td>
                    <td class="w3-padding-small"><input name="category" class="w3-input w3-border w3-round" required>
                    </td>
                    <td>
                        <?php
				if($_SESSION['usertype'] == 'admin'){
					?>
                        <button class="w3-button w3-light-grey w3-round" type="submit">Save Category</button>
                    </td>

                    <?php
				}else{
					?>
                    <button class="w3-button w3-light-grey w3-round" disabled type="submit">Save Category</button></td>

                    <?php
				}

						?>
                </tr>
            </form>
        </table><br>
    </div>
    <?php
		if(isset($_GET['msg'])){
			?>
    <div class="w3-panel w3-padding w3-round w3-green msg" style="margin: 20px 300px 20px 300px;">
        <?php echo $_GET['msg']; ?></div>


    <?php
		}
	?>
    <div class="w3-container w3-white w3-round-large" style="margin: 20px 300px 20px 300px;">
        <h3>Saved Categories</h3>
        <div class="w3-right">
            <input class="w3-input w3-border w3-round" placeholder="search"></input>
        </div>
        <br>
        <div id="showCat">



        </div>
        <br>
    </div>
    <br>
    <?php
		if(isset($_GET['edit'])){
			?>
    <div class="w3-container w3-white w3-round-large" style="margin: 20px 300px 20px 300px;" id="edit">
        <h3>Edit</h3>
        <form action="<?php echo htmlspecialchars("./data/data.php?editcat=".$_GET['edit']); ?>" method="post">
            <table>
                <tr>
                    <td>Category Name</td>
                    <td class="w3-padding-small"><input name="category" id="categoryedit"
                            class="w3-input w3-border w3-round" value="" required></td>
                    <td>
                        <?php
				if($_SESSION['usertype'] == 'admin'){
						?>
                        <button class="w3-button w3-light-grey w3-round" type="submit">Edit</button>
                        <?php
				}else{
					?>
                        <!-- <button class="w3-button w3-light-grey w3-round" disabled type="submit">Edit</button> -->

                        <?php
				}
						
						?>
                    </td>
                </tr>
            </table>
        </form>
    </div>
    <script type="text/javascript">
    $.get('./data/data.php?fetch_single_cat=<?php echo $_GET['edit']; ?>', function(data) {
        result = JSON.parse(data);
        $("#categoryedit").val(result.category_name);
    })
    </script>

    <?php
		}

	?>


    <script type="text/javascript">
    function deleteCat(id) {
        var ask = confirm('are you sure?');
        if (ask == true) {
            $.get('./data/data.php?deletecat=' + id, function(data) {
                // $("#showProd").html(data);
				// console.log(data);
                if (data == "1") {
                    window.location.href = "./categories.php";
                } else {
                    alert(data);
                }
            })
        }
    }
    $.get('./data/data.php?fetch_cat=true', function(data) {
        $("#showCat").html(data);
    })

    $(".msg").hide(2000);
    </script>
</body>

</html>