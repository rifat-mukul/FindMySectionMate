<div class="container bg-secondary text-dark rounded-4 fw-bold">
    <nav class="navbar navbar-expand-lg bg-body-tertiary>

    <a class=" navbar-brand" href="#">StudyMateFinder</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="./index.php">Home</a>
                </li>
                <?php
                if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] != true){
                	echo '
                <li class="nav-item">
                    <a class="nav-link" href="./login.php">Login</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./signup.php">SignUp</a>
                </li>';
                }
                else{
                	echo '
                <li class="nav-item">
                    <a class="nav-link" href="./logout.php">LogOut</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./modify.php">EditProfile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="./course.php">EditCourse</a>
                </li>';
                }
                ?>
            </ul>
        </div>
    </nav>
</div>
  
