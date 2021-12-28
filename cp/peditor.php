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
	<title>TM:CP - Page Editor</title>
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
				<li><a href="profile.php">Profile</a></li>
				<li class="active"><a href="peditor.php">Page Editor</a></li>
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
		<h3 class="panel-title">Page Editor</h3>
		</div>
		<div class="panel-body">
		<?php 
		if(isset($_POST['submit'])){
			if (isset($_POST['replace1'])){
				$text = mysqli_real_escape_string($db, $_POST['replace1']);
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET replace1='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET replace1='' WHERE ID='$rc'");
			}
			
			if (isset($_POST['replace2'])){
				$rc = $row["ID"];
				$text = mysqli_real_escape_string($db, $_POST['replace2']);
				mysqli_query($db, "UPDATE users SET replace2='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET replace2='' WHERE ID='$rc'");
			}
			
			if (isset($_POST['profilerole'])){
				$rc = $row["ID"];
				$text = mysqli_real_escape_string($db, $_POST['profilerole']);
				mysqli_query($db, "UPDATE users SET profilerole='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET profilerole='' WHERE ID='$rc'");
			}
			
			if (isset($_POST['profilepic'])){
				$rc = $row["ID"];
				$text = mysqli_real_escape_string($db, $_POST['profilepic']);
				mysqli_query($db, "UPDATE users SET profilepic='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET profilepic='' WHERE ID='$rc'");
			}
			
			if (isset($_POST['facebooklink'])){
				$rc = $row["ID"];
				$text = mysqli_real_escape_string($db, $_POST['facebooklink']);
				mysqli_query($db, "UPDATE users SET facebooklink='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET facebooklink='' WHERE ID='$rc'");
			}
			
			if (isset($_POST['twitterlink'])){
				$rc = $row["ID"];
				$text = mysqli_real_escape_string($db, $_POST['twitterlink']);
				mysqli_query($db, "UPDATE users SET twitterlink='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET twitterlink='' WHERE ID='$rc'");
			}
			
			if (isset($_POST['background1'])){
				$rc = $row["ID"];
				$text = mysqli_real_escape_string($db, $_POST['background1']);
				mysqli_query($db, "UPDATE users SET background1='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET background1='' WHERE ID='$rc'");
			}
			
			if (isset($_POST['background2'])){
				$rc = $row["ID"];
				$text = mysqli_real_escape_string($db, $_POST['background2']);
				mysqli_query($db, "UPDATE users SET background2='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET background2='' WHERE ID='$rc'");
			}
			
			if (isset($_POST['background3'])){
				$rc = $row["ID"];
				$text = mysqli_real_escape_string($db, $_POST['background3']);
				mysqli_query($db, "UPDATE users SET background3='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET background3='' WHERE ID='$rc'");
			}
			
			if (isset($_POST['background4'])){
				$rc = $row["ID"];
				$text = mysqli_real_escape_string($db, $_POST['background4']);
				mysqli_query($db, "UPDATE users SET background4='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET background4='' WHERE ID='$rc'");
			}
			
			header( "refresh:5" );
			echo '<div class="alert alert-success" role="success">Data was successfully saved.</div>';
		}
		?>
			<form method="POST">
				<b><u><font color="red">WARNING: If you replaced these text into bad words/things or abused the system then you will be banned and you will be NOT recieve any refunds.</font></u></b>
				<br>
				<b>"You already gave me a thanks" replace as </b><br>
				<input type="text" name="replace1" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $row['replace1']; ?>">
				<br>
				<b>"Thanks for thanking me" replace as </b><br>
				<input type="text" name="replace2" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $row['replace2']; ?>">
				<br>
				<b>Your Role</b><br>
				<input type="text" name="profilerole" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $row['profilerole']; ?>">
				<br>
				<b>Your Profile Picture</b><br>
				<input type="text" name="profilepic" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $row['profilepic']; ?>">
				<br>
				<b>Facebook Link</b><br>
				<input type="text" name="facebooklink" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $row['facebooklink']; ?>">
				<br>
				<b>Twitter Link</b><br>
				<input type="text" name="twitterlink" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $row['twitterlink']; ?>">
				<br>
				<b>Background Image URL #1</b><br>
				<input type="text" name="background1" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $row['background1']; ?>">
				<br>
				<b>Background Image URL #2</b><br>
				<input type="text" name="background2" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $row['background2']; ?>">
				<br>
				<b>Background Image URL #3</b><br>
				<input type="text" name="background3" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $row['background3']; ?>">
				<br>
				<b>Background Image URL #4</b><br>
				<input type="text" name="background4" class="form-control" aria-describedby="sizing-addon2" value="<?php echo $row['background4']; ?>">
				<br>
				<br>
				<input class="btn btn-lg btn-primary btn-block" value="Save All Changes" name="submit" type="submit" />
			</form>
		</div>
	</div>
</div>

</html>