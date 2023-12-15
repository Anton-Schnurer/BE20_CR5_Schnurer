<?php
    echo "
    <nav class='navbar navbar-expand-lg bg-body-tertiary'>
        <div class='container-fluid'>
            <a class='navbar-brand' href='".ROOT."/index.php'>Navbar</a>
            <button class='navbar-toggler' type='button' data-bs-toggle='collapse' data-bs-target='#navbarSupportedContent' aria-controls='navbarSupportedContent' aria-expanded='false' aria-label='Toggle navigation'>
            <span class='navbar-toggler-icon'></span>
            </button>
            <div class='collapse navbar-collapse' id='navbarSupportedContent'>
                <ul class='navbar-nav me-auto mb-2 mb-lg-0'>";

                // display username and picture

                if(isset($_SESSION["user"]) || isset($_SESSION["adm"])) {
                    echo "<li class='container'>
                          <img style='width:50px;height:50px' src='".ROOT."/pictures/users/".$_SESSION["picture"]."'>".$_SESSION["user_name"]."</li>";
                }
                echo "
                    <li class='nav-item'>
                        <a class='nav-link active' aria-current='page' href= '".ROOT."/index.php'>Home</a>
                    </li>";

                    // user specific entries in navbar

                    if(isset($_SESSION["user"]) || isset($_SESSION["adm"])){
                        echo "<li class='nav-item'>
                        <a class='nav-link' href='".ROOT."/users/logout.php'>Logout</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='".ROOT."/users/update.php'>Update user</a>
                    </li>
                    ";
                    }
                    else{
                        echo "<li class='nav-item'>
                        <a class='nav-link' href='".ROOT."/users/register.php'>Register</a>
                    </li>
                    <li class='nav-item'>
                        <a class='nav-link' href='".ROOT."/users/login.php'>Login</a>
                    </li>";
                    }

                    // admin specific entries in navbar

                    if(isset($_SESSION["adm"])){
                        echo "
                        <li class='nav-item'>
                        <a class='nav-link' href='".ROOT."/furries/create.php'>Create Furry</a>
                        </li>
                        <li class='nav-item'>
                        <a class='nav-link' href='".ROOT."/users/adm_user.php'>Manage users</a>
                        </li>";
                    }
                echo "</ul>
            </div>
        </div>
    </nav>
    ";