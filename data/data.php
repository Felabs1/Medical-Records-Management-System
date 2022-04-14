<?php

session_start();

class Connection {

	public $conn;

	public function __construct(){
		$this->conn = new mysqli("localhost", "root", "", "favor");
	}
}


class User extends Connection{

	private function user_exist($phone){
		$sql = "SELECT * FROM users WHERE phone = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s", $phone);
		$stmt->execute() or die($this->conn->error);
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}


	//INSERT INTO `users`(`id`, `full_name`, `phone`, `password`, `usertype`, `date_registered`, `last_login`) VALUES ('[value-1]','[value-2]','[value-3]','[value-4]','[value-5]','[value-6]','[value-7]')
	public function insert_user($full_name, $phone, $password, $usertype){
		if($this->user_exist($phone)){
			return "PHONE_NUMBER_EXIST";
		}else{
			$pass_hash = password_hash($password, PASSWORD_DEFAULT);
			$sql = "INSERT INTO `users`(`full_name`, `phone`, `password`, `usertype`) VALUES (?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("ssss", $full_name, $phone, $pass_hash, $usertype);
			$result = $stmt->execute() or die($this->conn->error);
			if($result){
				return $this->conn->insert_id;
			}else{
				return "SOME_ERROR";
			}
		}
	}

	//phone, password

	public function login($phone, $password){
		$sql = "SELECT * FROM users WHERE phone = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s", $phone);
		$stmt->execute() or die($this->conn->error);
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			$row = $result->fetch_assoc();
			if(password_verify($password, $row['password'])){
				$_SESSION['last_login'] = date("Y-m-d h:i:s");
				$_SESSION['true_pass'] = $password;
				$_SESSION['id'] = $row['id'];
				$_SESSION['full_name'] = $row['full_name'];
				$_SESSION['phone'] = $row['phone'];
				$_SESSION['usertype'] = $row['usertype'];

				$last_login = date("Y-m-d h:i:s");

				$sql = "UPDATE users SET last_login = '".$last_login."' WHERE id = '".$_SESSION['id']."'";
				$result = $this->conn->query($sql);
				if($result){
					return 1;
				}else{
					return 0;
				}				
			}else{
				return "INCORRECT_PASS";
			}
		}else{
			return "INVALID_USERNAME";
		}
	}

	// public function logout(){
	// 	session_start();
	// 	session_destroy();
	// }

	public function editUser($full_name, $phone, $password, $usertype){
		$id = $_SESSION['id'];
		$pass_hash = password_hash($password, PASSWORD_DEFAULT);
		$sql = "UPDATE users SET full_name = ?, phone = ?, `password` = ?, usertype = ? WHERE id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("sssss", $full_name, $phone, $pass_hash, $usertype, $id);
		$result = $stmt->execute() or die($this->conn->error);
		if($result){
			return 1;
		}else{
			return "SOME_ERROR";
		}
	}
}

$user = new User;

if(isset($_GET['login'])){
	echo $user->login($_POST['phone'], $_POST['password']);
}
// echo $user->insert_user("Admin", "0787654321", "1234", "admin");
// echo $user->login("0787654321", "1234");
// echo $_SESSION['full_name'];

if(isset($_GET['newuser'])){
	$insert_U = $user->insert_user($_POST['full_name'], $_POST['phone'], $_POST['password'], $_POST['usertype']);

	if($insert_U == "PHONE_NUMBER_EXIST"){
		header("location: ../index.php?msg=Phone number exist");
	}else{
		header("location: ../index.php?msg=user inserted successfully");
		
	}
}

if(isset($_GET['edituser'])){
	$insert_U = $user->editUser($_POST['full_name'], $_POST['phone'], $_POST['password'], $_POST['usertype']);
	echo $insert_U;

	if($insert_U){
		header("location: ../index.php?msg=insertion successful");
		$_SESSION['full_name'] = $_POST['full_name'];
		$_SESSION['phone'] = $_POST['phone'];
		$_SESSION['true_pass'] = $_POST['password'];
		$_SESSION['usertype'] = $_POST['usertype'];
	}
}





//Medicine

//

class Medicine extends Connection {
	public function addCat($name){
		$sql = "INSERT INTO `category`(`category_name`) VALUES (?)";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s", $name);
		$result = $stmt->execute() or die($this->conn->error);
		if($result){
			return 1;
		}else{
			return 0;
		}
	}

	public function view_data($sql){
		$array = array();
		$result = $this->conn->query($sql);
		while($row = $result->fetch_assoc()){
			$array[] = $row;
		}
		return $array;
	}

	public function editCat($id, $category){
		$sql = "UPDATE category SET category_name = ? WHERE id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ss", $category, $id);
		$result = $stmt->execute() or die($this->conn->error);
		if($result){
			return 1;
		}else{
			return 0;
		}

	}

	public function deleteCat($id){
		
	}


	public function uploadfile($image){
		$_acceptedformats = ['image/jpg', 'image/png', 'image/gif', 'image/jpeg'];
		
        if(is_array($image)){

            if(in_array($image['type'], $_acceptedformats)){
                
                    move_uploaded_file($image['tmp_name'], '../images/uploads/' . $image['name']);
					return "../images/uploads/".$image['name'];


            }else{
                return "NO_SUPPORT";
            }

        }else{

            return "NO_IMAGE_DETECTED";

        }
    }


	// INSERT INTO `products`(`id`, `med_name`, `chem_name`, `category`, `price`, `image`, `date_added`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7])

	public function add_product($med_name, $chem_name, $category, $price, $image){

		if($this->uploadfile($image) == 'NO_SUPPORT'){
			return 'NO_SUPPORT';
		}else if($this->uploadfile($image) == 'NO_IMAGE_DETECTED'){
			return 'NO_IMAGE_DETECTED';
		}else{
			$image = $this->uploadfile($image);
			$sql = "INSERT INTO `products`(`med_name`, `chem_name`, `category`, `price`, `image`) VALUES (?,?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("sssss", $med_name, $chem_name, $category, $price, $image);
			$result = $stmt->execute() or die($this->conn->error);
			if($result){
				$sql = "SELECT * FROM category WHERE id = '".$category."'";
				$result = $this->conn->query($sql);
				$row = $result->fetch_assoc();
				$prev_quantity = $row['num_count'];
				$cur_qty = $prev_quantity += 1;
				$sql = "UPDATE category SET num_count = '".$cur_qty."' WHERE id = '".$category."'";
				$result = $this->conn->query($sql);
				if($result){
					return 1;
				}else{
					return 0;
				}

			}else{
				return 0;
			}

			
		}

	}

	private function stock_exist($serial){
		$sql = "SELECT * FROM stock WHERE serial_no = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s", $serial);
		$stmt->execute() or die($this->conn->error);
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	public function add_stock($serial, $name){
		if($this->stock_exist($serial)){
			return "stock_exist";
		}else{
			$sql = "INSERT INTO `stock`(`serial_no`, `stock_name`) VALUES (?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("ss", $serial, $name);
			$result = $stmt->execute() or die($this->conn->error);
			if($result){
				$sql = "SELECT * FROM products WHERE id = '".$name."'";
				$result = $this->conn->query($sql);
				$row = $result->fetch_assoc();
				$q1 = $row['quantity_left'];
				$q2 = $q1 += 1;
				$sql = "UPDATE products SET quantity_left='".$q2."' WHERE id = '".$name."'";
				$result = $this->conn->query($sql);
				if($result){
					return 1;
				}else{
					return 0;
				}
			}

		}
	}


	// INSERT INTO `sales`(`id`, `serial_no`, `name`, `price`, `sold_to`, `date_sold`) VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6])
	private function saleexist($serial_no){
		$sql = "SELECT * FROM sales WHERE serial_no = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("s", $serial_no);
		$stmt->execute() or die($this->conn->error);
		$result = $stmt->get_result();
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	public function makeSales($serial_no, $name, $price, $sold_to, $ref_no){
		if($this->saleexist($serial_no)){
			return "SALE_EXIST";
		}else{
			$sql = "INSERT INTO `sales`(`serial_no`, `name`, `price`, `sold_to`) VALUES (?,?,?,?)";
			$stmt = $this->conn->prepare($sql);
			$stmt->bind_param("ssss", $serial_no, $name, $price, $sold_to);
			$result = $stmt->execute() or die($this->conn->error);
			if($result){
				$sql = "SELECT * FROM products WHERE id = '".$ref_no."'";
				$result = $this->conn->query($sql);
				$row = $result->fetch_assoc();
				$cur_amount = $row["quantity_left"];
				$next_amount = $cur_amount -= 1;
				$sql2 = "UPDATE products SET quantity_left = '".$next_amount."' WHERE id = '".$ref_no."'";
				$resul2 = $this->conn->query($sql2);
				if($resul2){
					$sql = "UPDATE stock SET `status` = 'sold_out' WHERE serial_no = '".$serial_no."'";
					$result = $this->conn->query($sql);
					if($result){
						return 1;
					}else{
						return 0;
					}
				}
			}
		}
		
	}


	/**
	 * 
	 * update Product
	 * 
	 * 
	 */



	 public function updateProduct($id2, $med_name2, $short_form2, $Price2){
		$sql = "UPDATE `products` SET `med_name`= ?,`chem_name`= ?, `price`= ? WHERE id = ?";
		$stmt = $this->conn->prepare($sql);
		$stmt->bind_param("ssss", $med_name2, $short_form2, $Price2, $id2);
		$result = $stmt->execute() or die($this->conn->error);
		if($result){
			return 1;
		}else{
			return $this->conn->error;
		}

	 }

	private function delstock_exist($id){
		$sql = "SELECT * FROM stock WHERE stock_name = '".$id."' AND `status` = 'in_stock'";
		$result = $this->conn->query($sql);
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}

	public function deleteProduct($id){
		if($this->delstock_exist($id)){
			return "Prescence of stock(Undeletable)";
		}else{
			$sql = 	"DELETE FROM products WHERE id = '".$id."'";
			$result = $this->conn->query($sql) or die($this->conn->error);
			if($result){
				return 1;
			}else{
				return 0;
			}
		}
		
	}

	private function del_prodExist($id){
		$sql = "SELECT * FROM products WHERE category = '".$id."'";
		$result = $this->conn->query($sql);
		if($result->num_rows > 0){
			return 1;
		}else{
			return 0;
		}
	}


	public function deleteCategory($id){
		if($this->del_prodExist($id)){
			return "Parent Category Has Children(Undeletable)";
		}else{
			$sql = 	"DELETE FROM category WHERE id = '".$id."'";
			$result = $this->conn->query($sql) or die($this->conn->error);
			if($result){
				return 1;
			}else{
				return 0;
			}
		}
	}

}

$med = new Medicine;

if(isset($_GET['deletecat'])){
	// echo $_GET['deletecat'];
	echo $med->deleteCategory($_GET['deletecat']);
}

if(isset($_GET['dfrom'])){
	// echo $_GET['dfrom'];
	$fetchMed = $med->view_data("SELECT * FROM sales WHERE date_sold BETWEEN '".$_GET['dfrom']."' AND '".$_GET['dto']."'");
	?>
<h5>REPORTS BETWEEN <i><span class="w3-border-bottom"><?php echo $_GET['dfrom']; ?></span></i> AND <i><span
            class="w3-border-bottom"><?php echo $_GET['dto']; ?></span></i></h5>
<hr>
<table class="w3-table w3-text-grey">
    <small></small>
    <tr>
        <th><small>Serial</small></th>
        <th><small>Name</small></th>
        <th><small>Price</small></th>
        <th><small>Customer</small></th>
        <th><small>Time</small></th>
    </tr></small>
    <?php
	foreach($fetchMed as $row){
		?>
    <tr>
        <td><small><?php echo $row['serial_no'] ?></small></td>
        <td><small><?php echo $row['name'] ?></small></td>
        <td><small><?php echo number_format($row['price'], 2) ?></small></td>
        <td><small><?php echo $row['sold_to'] ?></small></td>
        <td><small><?php echo $row['date_sold'] ?></small></td>
    </tr>
    <?php
	}

	?>
</table>
<br><br>
<div class="w3-center w3-text-grey w3-large" style="display: flex;">
    <div>Total Cash Sold</div>&nbsp;&nbsp;&nbsp;
    <div class="w3-border-top w3-border-bottom">
        <?php
				$fetchMed2 = $med->view_data("SELECT SUM(price) AS total_sold FROM sales WHERE date_sold BETWEEN '".$_GET['dfrom']."' AND '".$_GET['dto']."'");
				foreach($fetchMed2 as $row2){
					echo number_format($row2['total_sold'], 2);
				}
			?>
    </div>
</div><br><br>

<?php
}

if(isset($_GET['viewreports'])){
	$fetchMed = $med->view_data("SELECT * FROM sales");
	?>
<h4>All Reports</h4>
<hr>
<table class="w3-table w3-text-grey">
    <small></small>
    <tr>
        <th><small>Serial</small></th>
        <th><small>Name</small></th>
        <th><small>Price</small></th>
        <th><small>Customer</small></th>
        <th><small>Time</small></th>
    </tr></small>
    <?php
	foreach($fetchMed as $row){
		?>
    <tr>
        <td><small><?php echo $row['serial_no'] ?></small></td>
        <td><small><?php echo $row['name'] ?></small></td>
        <td><small><?php echo number_format($row['price'], 2) ?></small></td>
        <td><small><?php echo $row['sold_to'] ?></small></td>
        <td><small><?php echo $row['date_sold'] ?></small></td>
    </tr>
    <?php
	}

	?>
</table>
<br><br>
<div class="w3-center w3-text-grey w3-large" style="display: flex;">
    <div>Total Cash Sold</div>&nbsp;&nbsp;&nbsp;
    <div class="w3-border-top w3-border-bottom">
        <?php
				$fetchMed2 = $med->view_data("SELECT SUM(price) AS total_sold FROM sales");
				foreach($fetchMed2 as $row2){
					echo number_format($row2['total_sold'], 2);
				}
			?>
    </div>
</div><br><br>

<?php
}

if(isset($_GET['deleteprod'])){
	// echo $_GET['deleteprod'];
	$delprod = $med->deleteProduct($_GET['deleteprod']);
	echo $delprod;
}

if(isset($_GET['sell_stock'])){
	// echo "WOhoo";
	$sell = $med->makeSales($_POST['serial_no'], $_POST['product_name'], $_POST['price'], $_POST['sold_to'], $_POST['ref_no']);
	if($sell){
		session_start();
		$_SESSION['serial_no'] == $_POST['serial_no'];
		$_SESSION['product_name'] == $_POST['product_name'];
		$_SESSION['price'] == $_POST['price'];
		$_SESSION['sold_to'] == $_POST['sold_to'];
		header("location: ../stock.php?msg=sold_successfully");
	}
	
}

if(isset($_GET['buyer2'])){
	$fetchMed = $med->view_data("SELECT * FROM products WHERE id = '".$_GET['buyer2']."'");
	foreach($fetchMed as $row){
		echo json_encode($row);
	}
}

if(isset($_GET['buyer'])){
	$fetchMed = $med->view_data("SELECT * FROM stock WHERE id = '".$_GET['buyer']."'");
	foreach($fetchMed as $row){
		echo json_encode($row);
	}
	
}

if(isset($_GET['showstock'])){
	$fetchMed = $med->view_data("SELECT * FROM stock WHERE status = 'in_stock' ORDER BY id DESC");
	?>
<table class="w3-table w3-bordered" id="myTable">
    <tr>
        <th>#</th>
        <th>serial Number</th>
        <th>Action</th>
    </tr>
    <?php

	foreach($fetchMed as $row){
		?>
    <tr>
        <td><?php echo $row['id']; ?></td>
        <td><?php echo $row['serial_no']; ?></td>
        <td><button class="w3-button w3-blue w3-round"
                onclick="window.location.href='sell.php?id=<?php echo $row['id'] ?>'">Sell</button></td>
    </tr>

    <?php
	}
	?>
</table>
<?php
}

if(isset($_GET['add_stock'])){
	$newStock = $med->add_stock($_POST['serial_no'], $_POST['product_name']);
	if($newStock){
		header("location: ../stock.php?msg=Add success");
	}else{
		header("location: ../stock.php?err=try again");
	}
}

if(isset($_GET['addcat'])){
	$newMed = $med->addCat($_POST['category']);
	if($newMed){
		header("location: ../categories.php?msg=Add success");
	}else{
		return 0;
	}
}

if(isset($_GET['showprod'])){
	$fetchMed = $med->view_data("SELECT * FROM products ORDER BY id DESC");
	?>


<table class="w3-table w3-bordered" id="myTable">
    <tr>
        <th>#</th>
        <th>Name</th>
        <th>Chem Name</th>
        <th>Price</th>
        <th>Q left</th>
        <th>image</th>
        <th>Action</th>
    </tr>


    <?php

	foreach($fetchMed as $row){
		?>

    <tr>
        <td>
            <?php echo $row['id']; ?>
        </td>
        <td>
            <?php echo $row['med_name']; ?>
        </td>
        <td>
            <?php echo $row['chem_name']; ?>
        </td>
        <td>
            <?php echo number_format($row['price'], 2); ?>
        </td>
        <td>
            <?php echo $row['quantity_left']; ?>
        </td>
        <td>
            <image class="w3-image" src="<?php echo "." .  ltrim($row['image'], "."); ?>"></image>

        </td>
        <td>
            <?php
				if($_SESSION['usertype'] == 'admin'){
					?>
            <button class="w3-button w3-blue w3-round"
                onclick="editProduct('<?php echo $row['id']; ?>')">Edit</button><br><br>
            <button class="w3-button w3-red w3-round"
                onclick="deleteProduct(<?php echo $row['id']; ?>)">Delete</button><br>
            <?php
				}else{
					?>
            <button disabled class="w3-button w3-blue w3-round"
                onclick="alert('you dont have permission to edit this')">Edit</button><br><br>
            <button disabled class="w3-button w3-red w3-round" onclick="">Delete</button><br>
            <?php
				}
			?>
        </td>
    </tr>

    <?php
	}
	?>
</table>

<?php
}

if(isset($_GET['showcat'])){
	$fetchMed = $med->view_data("SELECT * FROM category ORDER BY id DESC");
	?>
<option value="" selected disabled>select Category</option>
<?php
	foreach($fetchMed as $row){
		?>

<option value="<?php echo $row['id'];?>"><?php echo $row['category_name']; ?></option>

<?php
	}
}

if(isset($_GET['add_product'])){
	$add_pro = $med->add_product($_POST['med_name'], $_POST['short_form'], $_POST['category'], $_POST['price'], $_FILES['image']);
	if($add_pro){
		header('location: ../products.php?msg=Add success');
	}else{
		header('location: ../products.php?err=please try again');
	}
}

if(isset($_GET['showprodattr'])){
	$fetchMed = $med->view_data("SELECT * FROM products WHERE id = '".$_GET['showprodattr']."'");
	?>
<table class="w3-table">
    <?php
	foreach($fetchMed as $row){
		?>
    <tr>
        <td colspan="4">
            <image class="w3-image" src="<?php echo "." .  ltrim($row['image'], "."); ?>"></image>

        </td>
    </tr>
    <tr>
        <th class="w3-center w3-wide" colspan="4"><?php echo $row['med_name'] ?></th>
    </tr>
    <tr>
        <th>
            Chemical Formula

        </th>
        <td>
            <?php echo $row['chem_name'] ?>
        </td>
        <th>
            Quantity Left

        </th>
        <td>
            <?php echo $row['quantity_left']; ?>
        </td>
    </tr>
    <tr>
        <th>
            Category

        </th>
        <td>
            <?php

				$cat_id = $row['category'];
				$row_cat_id = $med->view_data("SELECT * FROM category WHERE id = '".$cat_id."'");
				foreach($row_cat_id as $row2){
					echo $row2['category_name'];
				}


				?>
        </td>
        <th>
            Price

        </th>
        <td>
            <?php echo number_format($row['price'], 2); ?>
        </td>
    </tr>
    <?php
	}
}



if(isset($_GET['showproducts'])){
	$fetchMed = $med->view_data("SELECT * FROM products");
	?>
    <option value="" selected disabled>Stock Name</option>
    <?php
	foreach($fetchMed as $row){
		?>

    <option value="<?php echo $row['id']; ?>"><?php echo $row['med_name']; ?></option>

    <?php
	}
}

if(isset($_GET['editcat'])){
	$editcat = $med->editCat($_GET['editcat'], $_POST['category']);
	if($editcat){
		header("location: ../categories.php");
	}
}

if(isset($_GET['fetch_cat'])){
	$fetchMed = $med->view_data("SELECT * FROM category ORDER BY id DESC");
	?>
    <table class="w3-table w3-bordered">
        <tr>
            <th>Cat Id</th>
            <th>Cat Name</th>
            <th>Item Count</th>
            <th>action</th>
        </tr>

        <?php
	foreach($fetchMed as $row){
		?>
        <tr>
            <td><?php echo $row['id']; ?></td>
            <td><?php echo $row['category_name']; ?></td>
            <td><?php echo $row['num_count']; ?></td>
            <?php
				if($_SESSION['usertype'] == 'admin'){
					?>
            <td><span class="w3-text-blue"
                    onclick="window.location.href='./categories.php?edit=<?php echo $row['id']; ?>#edit'">Edit</span>&nbsp;&nbsp;<span
                    class="w3-text-red"
                    onclick="deleteCat(<?php echo $row['id']; ?>)">Delete</span>&nbsp;&nbsp;
            </td>
            <?php
				}else{
					?>
<td><small>No Permission</small></td>
					<?php
				}

			?>

        </tr>

        <?php

	}
	?>
    </table>
    <?php
}

if(isset($_GET['fetch_single_cat'])){
	$fetchMed = $med->view_data("SELECT * FROM category WHERE id = '".$_GET['fetch_single_cat']."'");
	foreach ($fetchMed as $row) {
		echo json_encode($row);
	}

}

if(isset($_GET['showprodupdate'])){
	$fetchMed = $med->view_data("SELECT * FROM products WHERE id = '".$_GET['showprodupdate']."'");
	foreach($fetchMed as $row){
		echo json_encode($row);
		// $fetchMed2 = $med->view_data("SELECT * FROM category WHERE id = '".$row['category']."'");
		// foreach($fetchMed2 as $row2){
		// 	echo json_encode($row2);
		// }

		
	}
}

if(isset($_GET['prupdate'])){
	$update = $med->updateProduct($_POST['id2'], $_POST['med_name2'], $_POST['short_form2'], $_POST['price2']);
	// $update = $med->updateProduct("7", "AMO!!", "H
	if($update){
		header("location: ../products.php?msg=update Successfull");
	}
	
}


// echo password_hash("1234", PASSWORD_DEFAULT);