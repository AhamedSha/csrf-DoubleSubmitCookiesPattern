<?php

    session_start();

    if(!isset($_COOKIE['csrf_session_cookie']) || !isset($_SESSION['csrf_session'])){
        header("location: ./login.php");
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>CSRF Double Submit Cookies Pattern</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
   
</head>

<body>

    <ul class="nav justify-content-center mt-3">
        <?php
            if(isset($_COOKIE['csrf_session_cookie'])){
                echo 
                    '<li class="nav-item">
                        <form class="nav-link" method="POST" action="./src/control.php">
                            <button class="btn btn-link" type="submit" value="Logout" name="logout">Logout</button>
                        </form>
                    </li>';
            }
        ?> 
    </ul>

    <div class="container">
        <div class="row">

            <div class="col-md-5 mx-auto align-self-center">
                <div class="card shadow my-5 p-3">
                    <div class="card-body">
                        <h5 class="card-title text-center">User Profile</h5>
                        <hr class="my-4">

                        <form class="mt-3 mb-3" action="./src/control.php" method="POST">

                            <input type="hidden" id="csrf_token" name="csrf_token" value="admin" />

                            <div class="form-group">
                                <label for="fname">Firstname  : </label>
                                <input type="text" class="form-control" id="fname" name="fname" placeholder="Enter Your Firstname" required autofocus/>
                            </div>
                            <div class="form-group">
                                <label for="lname">Lastname  :</label>
                                <input type="text" class="form-control" id="lname" name="lname" placeholder="Enter Your Lastname" required/>
                            </div>
                            <button type="submit" class="btn btn-success btn-block mt-5" name="verify">Submit</button>
                        </form>

                    </div>
                    <div class="card-footer">
						<div class="text-center">
                         generated CSRF token : <b><i><span id="csrf_token_string"></span></i></b>
						</div>						
					</div>
                </div>
            </div>

        </div>
    </div>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script>

        // extract generated CSRF token from stored cookie
        function extractToken() {

            var cookieName = "csrf_token_cookie=";
            var decodedCookies = decodeURIComponent(document.cookie);
            var cookies = decodedCookies.split(";");

            var token = null;

            for (var c in cookies) {

                var cookie = cookies[c];

                while (cookie.charAt(0) == ' ') {
                    cookie = cookie.substring(1);
                }

                if (cookie.indexOf(cookieName) == 0) {
                    token = cookie.substring(cookieName.length, cookie.length);
                }
            }

            return token;
        }

        function appendToken() {
            document.getElementById("csrf_token").value = extractToken();
        }

        $(document).ready(function () {
            $("#csrf_token_string").text(extractToken());
            appendToken();
        })

        feather.replace();
    </script>

</body>

</html>