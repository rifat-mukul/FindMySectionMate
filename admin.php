<?php
$showError = false;
$error = "";
session_start();
$user_id = $_SESSION['user_id'];
include 'partials/_dbconnect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST"){
	if(isset($_POST["add_admin"]) || isset($_POST["remove_admin"])){
		if(isset($_POST["add_admin"]))
			$cng_id = $_POST["add_admin"];
		else
			$cng_id = $_POST["remove_admin"];
		if(isset($_POST["add_admin"]))
			$mode = 1;
		else
			$mode = 0;
		$sql = "insert into role values ('$cng_id','$mode') on duplicate key update admin = '$mode'";
		$result = mysqli_query($conn, $sql);
		if(!$result){
			$showError = true;
			$error = "Change failed";
		}
    }else if(isset($_POST["delete_id"])){
    	$cuser_id = $_POST["delete_id"];
		$sql = "delete from courses where student_id = '$cuser_id'";
		$result = mysqli_query($conn, $sql);
		if(!$result){
			$showError = true;
			$error = "Change failed";
		}
		$sql = "delete from role where student_id = '$cuser_id'";
		$result = mysqli_query($conn, $sql);
		if(!$result){
			$showError = true;
			$error = "Change failed";
		}
		$sql = "delete from signup where std_id = '$cuser_id'";
		$result = mysqli_query($conn, $sql);
		if(!$result){
			$showError = true;
			$error = "Change failed";
		}
    }
} 
?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>LogIn</title>
    <link rel="shortcut icon" href="./images/log-in.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
	<script>
	function searchTable() {
	  var input, filter, table, tr, td, i, txtValue;
	  input = document.getElementById("searchInput");
	  filter = input.value.toLowerCase();
	  table = document.getElementById("myTable");
	  tr = table.getElementsByTagName("tr");

	  for (i = 0; i < tr.length; i++) {
		td = tr[i].getElementsByTagName("td")[0]; // Assuming filtering by 1st column
		if (td) {
		  txtValue = td.textContent || td.innerText;
		  if (txtValue.toLowerCase().indexOf(filter) > -1) {
		    tr[i].style.display = "";
		  } else {
		    tr[i].style.display = "none";
		  }
		}
	  }
	}
	</script>
</head>

<body>
    <?php
    require 'partials/_nav.php';
    ?>
    <div class="container p-5">
        <?php
        if ($login) {
            echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success erzlich willkommen!</strong> Your are logged in
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
        }
        if ($showError) {
            echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Entschuldigung!!!  </strong>' . $error . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
        }
        ?>
        <h2 class="text-center mb-5">Admin Panel</h2>
        <div class="row justify-content-center text-center">
            <div class="border border-success rounded-4 col-md-6">
                <table class="table">
				  <thead class="thead-dark">
					<tr>
					  <th scope="col">Name</th>
					  <th scope="col">OTP</th>
					  <th scope="col">GSuit</th>
					</tr>
				  </thead>
				  <tbody>
				  	<?php
					$sql = "SELECT * FROM signup left join role on std_id = student_id WHERE (admin is NULL or admin = 0) and not otp = 0";
					$result = mysqli_query($conn, $sql);
					$num = mysqli_num_rows($result);
					if($num > 0){
						$c_table = array();
						$s_table = array();
						while ($row = mysqli_fetch_assoc($result)) {
							$cuser_name = $row["username"];
							$cuser_otp = $row["otp"];
							$cuser_gsuit = $row["gsuit"];
							$mailtoLink = "mailto:$cuser_gsuit?subject="."OTP for Section Mate Finder"."&body=Hi%0D%0AThis is an automated mail%0D%0AYour OTP is $cuser_otp%0D%0APlease do not share to anyone";
							echo "<tr>
							  <td>$cuser_name</td>
							  <td>$cuser_otp</td>
							  <td><a href='$mailtoLink'>$cuser_gsuit</a></td>
							</tr>";
						}
					}
				  	?>
				  </tbody>
				</table>
				<input type="text"  class="form-control"  id="searchInput" onkeyup="searchTable()" placeholder="Search for names">
				<form class="p-3" action="./admin.php" method="post">
                <table class="table" id="myTable">
				  <thead class="thead-dark">
					<tr>
					  <th scope="col">Name</th>
					  <th scope="col">Student ID</th>
					  <th scope="col">Adminer</th>
					  <th scope="col">Remover</th>
					</tr>
				  </thead>
				  <tbody>
				  	<?php
					$sql = "SELECT * FROM signup left join role on std_id = student_id where otp = 0";
					$result = mysqli_query($conn, $sql);
					$num = mysqli_num_rows($result);
					if($num > 0){
						$c_table = array();
						$s_table = array();
						while ($row = mysqli_fetch_assoc($result)) {
							if($_SESSION['user_id'] == $row["std_id"])
								continue;
							$cuser_name = $row["username"];
							$cuser_id = $row["std_id"];
							$cuser_admin = $row["admin"];
							if($cuser_admin == "")
								$cuser_admin = '0';
							echo "<tr>
							  <td>$cuser_name</td>
							  <td>$cuser_id</td>";
							 if($cuser_admin == "1")
							  echo "<td><button class='btn btn-secondary' name='remove_admin' value='$cuser_id'>Remove as Admin</button></td>";
							 else
							  echo "<td><button class='btn btn-dark' name='add_admin' value='$cuser_id'>Add as Admin</button></td>";
							echo "<td><button class='btn btn-danger' name='delete_id' value='$cuser_id'>Delete Account</button></td>";
							echo "</tr>";
						}
					}
				  	?>
				  </tbody>
				</table>
				</form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
