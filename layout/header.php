<nav class="navbar navbar-expand-md navbar-dark fixed-top bg-dark">
    <a class="navbar-brand" href="#">Web Video Place</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarCollapse" aria-controls="navbarCollapse" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarCollapse">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="/WebVideoPlace/Main/index">Home <span class="sr-only">(current)</span></a>
            </li>
            <?php
                if(isset($_SESSION["UID"])){
                    echo
                    "<li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"#\">Logout</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"#\">Upload</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"#\">Favorites</a>
                    </li>";
                }else{
                    echo
                    "<li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"/WebVideoPlace/Auth/register\">Register</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"/WebVideoPlace/Auth/login\">Login</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link disabled\" href=\"#\">Upload</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link disabled\" href=\"#\">Favorites</a>
                    </li>
                    ";
                }

            ?>
            <!--<li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>-->
        </ul>
        <form class="form-inline mt-2 mt-md-0" action="Main/index">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search" name="search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
        </form>
    </div>
</nav>