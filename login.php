<?php

    session_start();

    if(isset($_POST['login'])){

        $username = $_POST['username'];
        $password = $_POST['password'];

        if(($username == "admin") && ($password == "password")){

			// assign session variable
			$_SESSION['csrf_session'] = "csrfdscpsamplephp";

			// regenerate an id for session and store in a cookie
			session_regenerate_id();
			setcookie("csrf_session_cookie", session_id(), (time() + (56400)), "/");
			
			// include control.php to generate csrf token
			include(realpath(__DIR__)."/src/control.php");
			$csrf_token = generateCSRFToken(session_id());

			// set a cookie with the generated csrf token
			setcookie("csrf_token_cookie", $csrf_token, (time() + 300), '/');

            header("location: ./index.php");
        }
    }

?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Double Submit Cookies Pattern</title>

	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>
	<script src="https://unpkg.com/feather-icons"></script>

</head>

<body>

	<div class="container">
		<div class="row">

			<div class="col-md-4 mx-auto order-12">
			<h2 class="text-center">Double Submit Cookies Pattern</h2>
				<div class="card my-5 p-3 shadow">
				   	<div class="card-body">
						<h5 class="card-title text-center">Sign In</h5>

						<form class="mt-5 mb-3" action="login.php" method="POST">
							<div class="form-group">
								<label for="username">Username</label>
								<input type="text" class="form-control" id="username" name="username" value="admin" required autofocus/>
							</div>
							<div class="form-group">
								<label for="password">Password</label>
								<input type="password" class="form-control" id="password" name="password" value="password" required/>
							</div>
							<button type="submit" class="btn btn-primary btn-block mt-5" name="login">Login</button>
						</form>

					</div>
					<div class="card-footer">
						<div class="text-center">
							<span>Username: admin</span><br/>
							<span>Password: password</span>
						</div>						
					</div>
				</div>
			</div>
		</div>
	</div>

	<script>
		feather.replace()
	</script>

</body>

</html>