<!DOCTYPE html>
<html>
<head>
<title>PCM | HomePage</title>
    <?php 
    include_once 'includes/header.php' ?>
</head>
<body style="background-image: url('images/intro-bg.png');overflow-x: hidden;";>

    <!--navbar-->
    <nav style="background-color: #fff; box-shadow: 0px 0px 30px -10px rgba(0,0,0,0.57);" class="navbar navbar-expand-lg navbar-dark">
        <a class="navbar-brand text-dark" href="#">PCM-System</a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
            <i class="fa fa-bars text-dark"></i>
        </button>
        <div style="margin-right: 100px;cursor: pointer;" class="collapse navbar-collapse" id="navbarText">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item active">
                    <a class="nav-link text-dark" href="index.php">Home <span class="sr-only">(current)</span></a>
                </li>
                <div class="dropdown">
                    <a class="btn  dropdown-toggle ttext-dark" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Login
                    </a>
                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                        <a class="dropdown-item" href="plogin.php">Login as Police</a>
                        <a class="dropdown-item" href="clogin.php">Login as Registerer</a>
                    </div>
                </div>
            </ul>
        </div>
    </nav>

    <div class="row">     
        <div class="col-4">
            <img class="image-fluid mx-5 mt-5 h-50 img1" src="images/police-1.png">
        </div>
        <div class="col-4">
            <img class="image-fluid mx-5 mt-5 h-50 img2" src="images/police.png">
        </div>
        <div class="col-lg-4 col-sm-12 text-center">
        <h2 class="text-white mt-5 animated slideInRight">We Serve our Community! We Protect our Citizens! <br>United we stand, Divided we fall.<br> Justice will be served!</h2>
        </div>
    </div>
</body>
</html>