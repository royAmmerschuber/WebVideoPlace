<input type="hidden" id="authToken" value="<?php echo $_SESSION["authToken"];?>">
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
                if(isset($_SESSION["uid"])){
                    echo
                    "<li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"/WebVideoPlace/Auth/logout\">Logout</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"/WebVideoPlace/Auth/edit\">edit User</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"/WebVideoPlace/Video/upload\">Upload</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link\" href=\"/WebVideoPlace/Main/favorites\">Favorites</a>
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
                        <a class=\"nav-link disabled\">Upload</a>
                    </li>
                    <li class=\"nav-item\">
                        <a class=\"nav-link disabled\">Favorites</a>
                    </li>
                    ";
                }

            ?>
            <!--<li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>-->
        </ul>
        <script>
            function search() {
                window.location.href="/WebVideoPlace/Main?search="+$("#search").val();
            }
        </script>
        <div class="form-inline mt-2 mt-md-0">
            <input class="form-control mr-sm-2" type="text" placeholder="Search" id="search" aria-label="Search" name="search">
            <button class="btn btn-outline-success my-2 my-sm-0" type="submit" id="searchSubmit" onclick="search()" >Search</button>

        </div>
    </div>
</nav>