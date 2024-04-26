<?php
$showAlart = false;
$showError = false;
$error = "";
session_start();
if(!isset($_SESSION['user_id']))
    header("location: logout.php");
include 'partials/_dbconnect.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $fname = $_POST["f-name"];
    $lname = $_POST["l-name"];
    $gmail = $_POST["gmail"];
    $sid = $_POST["s_id"];
    $gsuit = $_POST["gsuit"];
    $dob = $_POST["dob"];
    $htown = $_POST["h-town"];
    $cpassword = $_POST["cpassword"];
    $exists = false;
    $msql = "update signup set first_name = '$fname',gmail = '$gmail',last_name = '$lname',gsuit = '$gsuit',dob = '$dob',home_town = '$htown' WHERE std_id = $sid";
    
    $sql = "SELECT * FROM signup WHERE username = '$username'";
    $result = mysqli_query($conn, $sql);
    $num = mysqli_num_rows($result);
    if ($num == 1) {
        while ($row = mysqli_fetch_assoc($result)) {
            if (password_verify($cpassword, $row["password_"])) {
                if(!empty($fname) && !empty($lname) && !empty($gmail) && !empty($gsuit) && !empty($dob) && !empty($htown)){               	
					mysqli_query($conn, $msql);
				    header("location: modify.php");
				    }
            } else {
                $showError = true;
                $error = "Invalid password".$msql;
            }
        }
    } else {
        $showError = true;
        $error = "Invalid Credentials";
        header("location: logout.php");
    }
}

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM signup WHERE std_id = '$user_id'";
$result = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_assoc($result)){
	$sql = "INSERT INTO signup (username, first_name, last_name, gmail, std_id, gsuit, dob, home_town, password_) VALUES ('$username', '$fname', '$lname', '$gmail', '$sid', '$gsuit', '$dob', '$htown', '$hash')";
	$user_name = $row['username'];
	$last_name = $row['last_name'];
	$first_name = $row['first_name'];
	$gsuit = $row['gsuit'];
	$gmail = $row['gmail'];
	$sid = $row['std_id'];
	$dob = $row['dob'];
	$htown = $row['home_town'];
}
?>

<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Profile</title>
    <link rel="shortcut icon" href="./images/add-user.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
</head>

<body>
    <?php
    require 'partials/_nav.php';
    ?>
    <div class="container p-5">
        <?php
        if ($showAlart) {
            echo '
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <strong>Success erzlich willkommen!</strong> Your account is now created and you can login
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
        <h2 class="text-center mb-5">SignUp To Bark</h2>
        <div class="row justify-content-center text-center">
            <div class="border border-success rounded-4 col-md-6">
                <form class="p-3" action="./modify.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username<a style="color:red">*</a></label>
                        <input type="text" maxlength="100" class="form-control" id="username" name="username" placeholder="abc00" aria-describedby="emailHelp" value='<?php echo $user_name?>' readonly>
                    </div>
                    <div class="mb-3">
                        <label for="f-name" class="form-label">First Name<a style="color:red">*</a></label>
                        <input type="text" maxlength="100" class="form-control" id="f-name" name="f-name" aria-describedby="emailHelp" require value='<?php echo $first_name?>'>
                    </div>
                    <div class="mb-3">
                        <label for="l-name" class="form-label">Last Name<a style="color:red">*</a></label>
                        <input type="text" maxlength="100" class="form-control" id="l-name" name="l-name" aria-describedby="emailHelp" value='<?php echo $last_name?>'>
                    </div>
                    <div class="mb-3">
                        <label for="gmail" class="form-label">Gmail<a style="color:red">*</a></label>
                        <input type="text" maxlength="100" class="form-control" id="gmail" name="gmail" aria-describedby="emailHelp" value='<?php echo $gmail?>'>
                    </div>
                    <div class="mb-3">
                        <label for="s_id" class="form-label">Student ID<a style="color:red">*</a></label>
                        <input type="text" maxlength="100" class="form-control" id="s_id" name="s_id" aria-describedby="emailHelp" require value='<?php echo $sid?>' readonly>
                    </div>
                    <div class="mb-3">
                        <label for="gsuit" class="form-label">Gsuit<a style="color:red">*</a></label>
                        <input type="text" maxlength="100" class="form-control" id="gsuit" name="gsuit" aria-describedby="emailHelp" value='<?php echo $gsuit?>'>
                    </div>
                    <div class="mb-3">
                        <label for="dob" class="form-label">Date of Birth<a style="color:red">*</a></label>
                        <input type="text" maxlength="100" class="form-control" id="dob" name="dob" aria-describedby="emailHelp" value='<?php echo $dob?>'>
                    </div>
                    <div class="mb-3">
                        <label for="h-town" class="form-label">Home Town<a style="color:red">*</a></label>
                        <select class="form-select" id="h-town" name="h-town" aria-label="Default select example" value='<?php echo $htown?>'>
                        	<?php
                        		$towns = array("Dhaka", "Chittagong", "Khulna", "Maymensingh","Rajshahi","Rangpur","Sylhet","Barisal");
                        		foreach($towns as $city){
                        			if($htown == $city)
                        				echo "<option value='$city' selected>$city</option>";
                        			else
                        				echo "<option value='$city'>$city</option>";
                        		}
                        	?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="cpassword" class="form-label">Confirm Password<a style="color:red">*</a></label>
                        <input type="password" class="form-control" id="cpassword" name="cpassword">
                        <small id="cpassword" class="form-text text-muted">make sure you type the same password</small>
                    </div>
                    <button type="submit" class="btn btn-primary col-12">SaveData</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script>
        $(function() {
            $("#dob").datepicker({
                dateFormat: 'yy-mm-dd', // Format date as 'yyyy-mm-dd'
                changeMonth: true, // Allow changing month
                changeYear: true, // Allow changing year
                yearRange: "-100:+0", // Set year range from 100 years ago to present
                maxDate: '0' // Set max date to today's date
            });
        });
    </script>

</body>

</html>
