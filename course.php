<?php
$login = false;
$showError = false;
$error = "";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	var_dump($_SESSION['c_tab']);
	if(isset($_POST['add']))
		$_SESSION['f_size']++;
	else if(isset($_POST['action'])){
    		include 'partials/_dbconnect.php';
			$course_t = array();
			$section_t = array(); 
			$i = 0;
			$user_id = $_SESSION['user_id'];
			$sql = "delete from courses  where student_id = '$user_id'";
			$result = mysqli_query($conn, $sql);
			if (!$result){
			    $showError = true;
			    $error = "Failed to store course $i!";
			}
			while($i < $_SESSION['f_size']){
				if(!preg_match("/^[a-zA-Z]{3}[0-9]{3}$/", $_POST["c_field".$i])){
					$showError = true;
					$error = "Incorrect Course $i";				
					$i++;
					continue;
				}
				if(!(isset($_POST["c_field".$i]) && isset($_POST["s_field".$i]) && !empty($_POST["s_field".$i])))
					continue;
				$c_code = strtoupper($_POST["c_field".$i]);
				$s_code = $_POST["s_field".$i];
				$sql = "INSERT INTO courses VALUES ('$user_id', '$c_code', '$s_code')";
				$result = mysqli_query($conn, $sql);
				if (!$result){
				    $showError = true;
				    $error = "Failed to store course $i!";
				}
				$i++;
			}
			header("location: course.php");
	}
	else if(isset($_POST['remove_field'])){
			$showError = true;
			$indx = $_POST['remove_field'] + 1;
			$error = "Field $indx removed";
			$_SESSION['f_size']--;
			array_splice($_SESSION['c_tab'], $indx-1, 1);
			array_splice($_SESSION['s_tab'], $indx-1, 1);
		}
}else{
	include 'partials/_dbconnect.php';
	$_SESSION['f_size'] = 1;
	$user_id = $_SESSION['user_id'];
	$sql = "SELECT * FROM courses WHERE student_id = '$user_id'";
	$result = mysqli_query($conn, $sql);
	$num = mysqli_num_rows($result);
	if($num > 0){
		$_SESSION['f_size'] = 0;
		$c_table = array();
		$s_table = array();
		while ($row = mysqli_fetch_assoc($result)) {
			array_push($c_table,$row["course_code"]);
			array_push($s_table,$row["section"]);
			$_SESSION['f_size']++;
		}
		$_SESSION['c_tab'] = $c_table;
		$_SESSION['s_tab'] = $s_table;
	}
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Course entry</title>
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
        <h2 class="text-center mb-5">Course entry</h2>
        <div class="row justify-content-center text-center">
            <div class="border border-success rounded-4 col-md-6">
                <form class="p-3" action="./course.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Courses</label>
                        <?php
                        if(isset($_SESSION['c_tab'])){
							$c_table = $_SESSION['c_tab'];
							$s_table = $_SESSION['s_tab'];
						}
                        for($i=0;$i<$_SESSION['f_size'];$i++)
                        	echo '
                    	<div class="container d-flex">
		                    <input type="text" class="form-control" name="c_field'.$i.'" value="'.$c_table[$i].'" aria-describedby="emailHelp">
		                    <input type="number" class="form-control" name="s_field'.$i.'" value="'.$s_table[$i].'" aria-describedby="emailHelp">
		                    <button class="btn btn-secondary" name="remove_field" value="'.$i.'">Remove</button>
                        </div></br>';
                        ?>
                    </div>
                    <button class="btn btn-primary col-12" name="add">Add</button></br></br>
                    <button type="submit" class="btn btn-primary col-12" name="action">Save</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
</body>

</html>
