<!--sidebar starts-->
    <div id="side-menu" class="side-nav">
        <a href="#" class="btn-close" onclick="closeSideMenu()">
        <i class="fa fa-arrow-left"></i>
        </a>
        <a href="policedashboard.php"><i class="fa fa-home nav_icon"></i> Dashboard</a>
        <a href="assignment.php"><i class="fa fa-list-ul"></i> Assignments</a>
        <a href="solveddisp.php"><i class="fa fa-trophy"></i> Solved</a>

        <div class="dropdown show">
            <a href="#" role="button" id="dropdownMenuLink" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            <i class="fa fa-plus"></i> Criminal Details
            </a>

            <div class="dropdown-menu" aria-labelledby="dropdownMenuLink">
                <a class="dropdown-item" href="criminaldisp.php"><i class="fa fa-eye"></i> View All</a>
                <a class="dropdown-item" href="searchcriminal.php"><i class="fa fa-search"></i> Search</a>
            </div>
        </div>
        <a href="logout.php"><i class="fa fa-power-off"></i> Logout</a>
    </div>
    <!--sidebar ends-->