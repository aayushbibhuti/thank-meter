<?php 
session_start();
require ("func.mysqli.php");

if ((isset($_SESSION['cctmuser']) != '')) {
header('Location: index.php');
}

$error = "";
if (isset($_POST["submit"])) {
	if (empty($_POST["username"]) || empty($_POST["password"])) {
		$error = " Both fields are required.";
	} else {
		$username = $_POST["username"];
		$password = $_POST["password"];
		
		$username = stripslashes($username);
		$password = stripslashes($password);
		$username = mysqli_real_escape_string($db, $username);
		$password = mysqli_real_escape_string($db, $password);
		$password = md5($password);
		
		$result = mysqli_query($db, "SELECT * FROM users WHERE smallname='$username' and password='$password'");
		$row = mysqli_fetch_array($result, MYSQLI_ASSOC);
		
		if (mysqli_num_rows($result) == 1) {
			$_SESSION["cctmuser"] = $row["smallname"];
			header ("location: index.php");
		} else {
			$error = "Incorrect username or password.";
		}
	}
}

?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Curt Creation Thank Meter">
    <meta name="author" content="Curt">

    <title>TM:CP - Login</title>

    <!-- Bootstrap core CSS -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/login.css" rel="stylesheet">
	
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

  <body>

    <div class="container">

      <form class="form-signin" method="POST">
        <h2 class="form-signin-heading">Please sign in</h2>
		<?php 
		if ($error != "") {
			echo '<div class="alert alert-danger" role="alert">'.$error.'</div>';
		}
		?>
        <label for="inputEmail" class="sr-only">Username</label>
        <input type="text" id="username" name="username" class="form-control" placeholder="Username" required autofocus>
        <label for="inputPassword" class="sr-only">Password</label>
        <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
        <input class="btn btn-lg btn-primary btn-block" value="Sign in" name="submit" type="submit" />
      </form>

    </div> <!-- /container -->

  </body>
</html>
