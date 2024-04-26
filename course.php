<?php
$login = false;
$showError = false;
$error = "";
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if(isset($_POST['add']))
		$_SESSION['f_size']++;
	else if(isset($_POST['action'])){
			$showError = true;
			$error = "Not finshed yet";
	}
	else if(isset($_POST['remove_field'])){
			$showError = true;
			$indx = $_POST['remove_field'] + 1;
			$error = "Field $indx removed";
			$_SESSION['f_size']--;
		}
}else{
$_SESSION['f_size'] = 1;
}

?>
<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Counrse entry</title>
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
        <h2 class="text-center mb-5">Counrse entry</h2>
        <div class="row justify-content-center text-center">
            <div class="border border-success rounded-4 col-md-6">
                <form class="p-3" action="./course.php" method="post">
                    <div class="mb-3">
                        <label for="username" class="form-label">Username</label>
                        <?php
                        for($i=0;$i<$_SESSION['f_size'];$i++)
                        	echo '
                    	<div class="container d-flex">
		                    <input type="text" class="form-control" name="c_field" aria-describedby="emailHelp">
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
