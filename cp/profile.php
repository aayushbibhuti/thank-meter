<?php 
	require ("func.check.php");
?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
	<link rel="stylesheet" href="css/bootstrap.css"/>
	<script data-rocketsrc="js/bootstrap.js" type="text/rocketscript"></script>
	<script data-rocketsrc="js/bootstrap.min.js" type="text/rocketscript"></script>
	<script data-rocketsrc="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js" type="text/rocketscript"></script>
	<script data-rocketsrc="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js" type="text/rocketscript"></script>
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>TM:CP - Profile</title>
	<meta name="description" content="Curt Creation Thank Meter">
    <meta name="author" content="Curt">
</head>
 
 
<nav class="navbar navbar-inverse navbar-fixed-top">
	<div class="container">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
				<span class="sr-only">Toggle navigation</span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href="#">Curt Creation Thank Meter</a>
		</div>
		<div id="navbar" class="navbar-collapse collapse">
			<ul class="nav navbar-nav">
				<li><a href="index.php">Home</a></li>
				<li class="active"><a href="profile.php">Profile</a></li>
				<li><a href="peditor.php">Page Editor</a></li>
				<li><a href="ieditor.php">Image Editor</a></li>
				<li><a href="pcomment.php">Moderate Comment</a></li>
				<li><a href="https://cit2.net/index.php?topic=232418.0">Support Thread</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<li class="dropdown">
				<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?php echo $row['name']; ?> <span class="caret"></span></a>
					<ul class="dropdown-menu">
					<li><a href="logout.php">Logout</a></li>
					</ul>
				</li>
			</ul>
		</div> 
	</div>
</nav>
 
<br/>
<br/>
<br/>
<br/>
<br/>

<div class="col-md-3"></div>
<div class="col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
		<h3 class="panel-title">Profile</h3>
		</div>
		<div class="panel-body">
		<?php 
		if(isset($_POST['submit'])){
			if (isset($_POST['name'])){
				$text = mysqli_real_escape_string($db, $_POST['name']);
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET name='$text' WHERE ID='$rc'");
			}
			
			if (isset($_POST['ingamename'])){
				$text = mysqli_real_escape_string($db, $_POST['ingamename']);
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET igname='$text' WHERE ID='$rc'");
			}
			
			if (isset($_POST['password'])){
				if ($_POST['password'] != "") {
				if ($_POST['password'] == $_POST['repassword']) {
					$rc = $row["ID"];
					$text = md5($_POST['repassword']);
					$text = mysqli_real_escape_string($db, $text);
					mysqli_query($db, "UPDATE users SET password='$text' WHERE ID='$rc'");
				} else {
					echo '<div class="alert alert-alert" role="alert">Password and Repassword are not the same.</div>';
				}
			}
			header( "refresh:5" );
			echo '<div class="alert alert-success" role="success">Data was successfully saved.</div>';
			}
		}
		?>
			<form method="POST">
				<div class="input-group">
				  <span class="input-group-addon" id="sizing-addon2">Username</span>
				  <input type="text" name="username" class="form-control" placeholder="Username" disabled aria-describedby="sizing-addon2" value="<?php echo $row['smallname']; ?>">
				</div>
				<br>
				<div class="input-group">
				  <span class="input-group-addon" id="sizing-addon2">Name</span>
				  <input type="text" name="name" class="form-control" placeholder="Name" aria-describedby="sizing-addon2" value="<?php echo $row['name']; ?>">
				</div>
				<br>
				<div class="input-group">
				  <span class="input-group-addon" id="sizing-addon2">In Game Nickname</span>
				  <input type="text" name="ingamename" class="form-control" placeholder="In Game Name" aria-describedby="sizing-addon2" value="<?php echo $row['igname']; ?>">
				</div>
				
				<br>
				<hr>
				<center><b>Change Password</b></center><br>
				<br>
				<div class="input-group">
				  <span class="input-group-addon" id="sizing-addon2">Password</span>
				  <input type="password" name="password" class="form-control" placeholder="Password" aria-describedby="sizing-addon2">
				</div>
				<br>
				<div class="input-group">
				  <span class="input-group-addon" id="sizing-addon2">Re-type Password</span>
				  <input type="password" name="repassword" class="form-control" placeholder="Re-type Password" aria-describedby="sizing-addon2">
				</div>
				<br>
				<input class="btn btn-lg btn-primary btn-block" value="Save All Changes" name="submit" type="submit" />
			</form>
		</div>
	</div>
</div>

</html>