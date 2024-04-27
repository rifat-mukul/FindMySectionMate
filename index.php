<?php
session_start();
// echo var_dump(session_start());
// $session_expiration = 10;
// session_set_cookie_params($session_expiration);

if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true) {
	header("location:login.php");
	// echo var_dump($_SESSION());

	exit;
}
if ($_SESSION['loggedin'] < time()) {
	header("location:logout.php");
}

include 'partials/_dbconnect.php';
$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM signup WHERE std_id = '$user_id'";
$result = mysqli_query($conn, $sql);
$num = mysqli_num_rows($result);
if ($num == 1) {
	while ($row = mysqli_fetch_assoc($result)) {
		$GOTP = $row['otp'];
	}
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	$ctp = $_POST['iotp'];
	if ($ctp == $GOTP) {
		$sql = "update signup set otp = 0 WHERE std_id = $user_id";
		$result = mysqli_query($conn, $sql);
		header("location:index.php");
		if ($result) {
			$showAlart  = true;
		} else {
			$showError = true;
			$error = "Failed to insert record!";
		}
	} else {
		$showError = true;
		$error = "Invalid OTP!";
	}
}

?>
<!doctype html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>Welcome - <?php echo $_SESSION['username'] ?></title>
	<link rel="shortcut icon" href="./images/welcome.png" type="image/x-icon">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
</head>

<body>
	<?php
	require 'partials/_nav.php';
	?>
	<div class="container mt-3">
		<?php
		if ($showError) {
			echo '
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Entschuldigung!!!  </strong>' . $error . '
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
        ';
		}
		?>
		<div class="alert alert-success" role="alert">
			<h4 class="alert-heading">Well done! <?php echo $_SESSION['username'] ?> </h4>
			<p>Aww yeah, you successfully read this important alert message. This example text is going to run a bit longer so that you can see how spacing within an alert works with this kind of content.</p>
			<hr>
			<p>Whenever you need to, make sure to Logout. <a href="./logout.php" class="btn btn-outline-danger">Logout</a></p>
		</div>
		<?php
		if (isset($GOTP) && $GOTP != 0)
			echo '
		<form class="p-3" action="./index.php" method="post">
			<div class="alert alert-success alert-dismissible fade show" role="alert">
				<div class="container d-flex align-items-center"> 
					<div class="col-10 me-3"> 
						<input type="text" class="form-control otp-input" name="iotp" aria-describedby="emailHelp" placeholder="Enter Your OTP">
					</div>
					<div class="col-auto">
						<button type="submit" class="btn btn-outline-success">Submit OTP</button>
					</div>
				</div>
			</div>
		</form>
    	';
		else if (isset($GOTP) && $GOTP == 0) {
			$sql = "SELECT * FROM courses WHERE student_id = '$user_id'";
			$result = mysqli_query($conn, $sql);
			$num = mysqli_num_rows($result);
			if ($num > 0) {
				$c_table = array();
				$s_table = array();
				echo '<table class="table"><thead class="thead-dark">';
				//echo '<tr><th scope="col">Course</th><th scope="col">Section</th></tr></thead><tbody>';
				//select first_name,last_name,gsuit from signup where std_id = any(select student_id from courses where course_code = 'MAT215' and section = 14);
				while ($row = mysqli_fetch_assoc($result)) {
					$cc_code = $row["course_code"];
					$ss_code = $row["section"];
					echo '<tr><th scope="col">' . $cc_code . ' - ' . $ss_code . '</th>';
					echo '<tr><th scope="col">Name</th><th scope="col">GSuit</th></tr>';
					$ssql = "select first_name,last_name,gsuit from signup where std_id = any(select student_id from courses where course_code = '$cc_code' and section = $ss_code) and not std_id = '$user_id'";
					$sresult = mysqli_query($conn, $ssql);
					$snum = mysqli_num_rows($sresult);
					if ($snum > 0) {
						while ($srow = mysqli_fetch_assoc($sresult)) {
							$c_name = $srow["first_name"] . " " . $srow["last_name"];
							$c_gsuit = $srow["gsuit"];
							echo "<tr><td>$c_name</td><td>$c_gsuit</td></tr>";
						}
					}
				}
				echo '</tbody></table>';
			}
		}
		//echo "<tr><td>$cc_code</td><td>$ss_code</td></tr>";
		?>
	</div>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>