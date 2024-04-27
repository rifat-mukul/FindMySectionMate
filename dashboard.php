<?php
// require 'partials/_nav.php';

// // Assuming you've already established a database connection

// // Query to retrieve data from your database
// $sql = "SELECT name, student_id, g_suite, gmail FROM your_table_name";

// // Execute the query
// $result = mysqli_query($connection, $sql);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link rel="shortcut icon" href="./images/dashboard.png" type="image/x-icon">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        .scroll-box {
            max-height: 300px;
            overflow-y: auto;
            border: 2px solid green;
            border-radius: 5px;
        }

        .red-text {
            color: red;
        }
    </style>
</head>

<body>
    <?php
    require 'partials/_nav.php';
    ?>
    <div class="container mt-3">
        <div class="card bg-secondary-subtle rounded-4">
            <div class="card-body rounded-4">
                <p class="m-3 fw-bolder fs-5 text-center">Here are the list of people whose class time is match with you</p>
                <p class="m-3 fw-normal fs-5 red-text text-center">Please use gmail for communicate to your mate</p>
                <div class="card  rounded-4">
                    <div class="card-body rounded-4">
                        <div class="scroll-box">
                            <table class="table table-striped table-info text-center">
                                <thead class="sticky-top bg-light">
                                    <tr>
                                        <th>Name</th>
                                        <th>Student ID</th>
                                        <th>G Suite</th>
                                        <th>Gmail</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    // Generate dummy data for 50 records
                                    for ($i = 1; $i <= 50; $i++) {
                                        $name = "Person " . $i;
                                        $studentId = "ID-" . sprintf("%04d", $i);
                                        $gSuite = "GSuite-" . $i;
                                        $gmail = "person" . $i . "@example.com";

                                        echo "<tr>";
                                        echo "<td>" . $name . "</td>";
                                        echo "<td>" . $studentId . "</td>";
                                        echo "<td>" . $gSuite . "</td>";
                                        echo "<td>" . $gmail . "</td>";
                                        echo "</tr>";
                                    }

                                    // while ($row = mysqli_fetch_assoc($result)) {
                                    //     echo "<tr>";
                                    //     echo "<td>" . $row['name'] . "</td>";
                                    //     echo "<td>" . $row['student_id'] . "</td>";
                                    //     echo "<td>" . $row['g_suite'] . "</td>";
                                    //     echo "<td>" . $row['gmail'] . "</td>";
                                    //     echo "</tr>";
                                    // }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <p class="m-3 fw-bolder fs-4 text-center">After finding your mate please <a href="./logout.php" class="btn btn-outline-danger">Logout</a> </p>
            </div>
        </div>

        <div class="otp-design m-5">
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

        </div>
        
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>