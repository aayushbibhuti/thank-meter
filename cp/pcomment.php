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
	<title>TM:CP - Moderate Comments</title>
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
				<li><a href="peditor.php">Page Editor</a></li>
				<li><a href="ieditor.php">Image Editor</a></li>
				<li class="active"><a href="pcomment.php">Moderate Comment</a></li>
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
		<h3 class="panel-title">Comment Settings</h3>
		</div>
		<div class="panel-body">
		<?php 
			if(isset($_POST['submit'])){
				if (isset($_POST['commentsystem'])){
					$rc = $row["ID"];
					mysqli_query($db, "UPDATE users SET disablecom='true' WHERE ID='$rc'");
				} else {
					$rc = $row["ID"];
					mysqli_query($db, "UPDATE users SET disablecom='false' WHERE ID='$rc'");
				}
				
				if (isset($_POST['motd'])){
					$rc = $row["ID"];
					$text = mysqli_real_escape_string($db, $_POST['motd']);
					mysqli_query($db, "UPDATE users SET motd='$text' WHERE ID='$rc'");
				} else {
					$rc = $row["ID"];
					mysqli_query($db, "UPDATE users SET motd='' WHERE ID='$rc'");
				}
				
				echo '<div class="alert alert-success" role="success">Data was successfully saved.</div>';
				header( "refresh:5" );
			}
		?>
		
			<form method="POST">
				<b>Message of the day (MOTD)</b><br>
				<input type="text" name="motd" class="form-control" aria-describedby="sizing-addon2" placeholder="Your MOTD" value="<?php echo $row['motd']; ?>"><br>
				<b>Banned Names (Syntax: Name1, Name2, Name3, ...) (e.g. Joe, Mark, John)</b><br>
				<input disabled type="text" name="bannames" class="form-control" aria-describedby="sizing-addon2" placeholder="e.g. Joe, Mark, John">
				<br>
				<b>Banned IPs (Syntax: IP1, IP2, IP3, ...) (e.g. 223.221.22.1, 101.22.34.1, 1.20.2.4)</b><br>
				<input disabled type="text" name="banips" class="form-control" aria-describedby="sizing-addon2" placeholder="e.g. 223.221.22.1, 101.22.34.1, 1.20.2.4">
				<br>
				<b>Disable Comment System: </b>
				<input type="checkbox" <?php if ($row['disablecom'] == "true") { echo "checked"; } ?> name="commentsystem">
				<br>
				<br>
				<input class="btn btn-lg btn-primary btn-block" value="Save All Changes" name="submit" type="submit" />
			</form>
		</div>
	</div>
	
	
	<div class="panel panel-primary">
		<div class="panel-heading">
		<h3 class="panel-title">Moderate Comments</h3>
		</div>
		<div class="panel-body">
		
		<?php 
		$commentfinaloutputs = "";
		if(isset($_POST['send'])){
        $namecomad = $row['name'];
        $msgc = $_POST['comment'];
        if ($namecomad == null || $namecomad == "" || $msgc == "" || $msgc == null || $msgc == "." || $namecomad == ".") {
		  echo '<div class="alert alert-danger" role="alert">Your message is empty!</div>';
        } else {
		  $namecomad = strip_tags($namecomad);
		  $msgc = strip_tags($msgc);
          $namecomadm = mysqli_real_escape_string($db, "<font color='purple'><b>".$namecomad."</b></font>");
          $msgcm = mysqli_real_escape_string($db, $msgc);
          $datetime = date("F j, Y h:i A");
		  mysqli_query($db, "INSERT INTO `comment` (`userid`, `time`, `name`, `comment`, `ip`) VALUES ('".$row["ID"]."', '$datetime', '$namecomadm', '$msgcm', '$ipaddress')");
		  echo '<div class="alert alert-success" role="success">Your message successfully submited!</div>';
		  $commentfinaloutputs = "<tr><td>-</td><td>A second ago</td><td><font color='purple'><b>$namecomad</b></font></td><td>$msgc</td></tr>".$commentfinaloutput;
        }
      }
	  
	  
	   if (isset($_GET['delete'])) {
        $rc = $_GET['delete'];
	   $getsDB = mysqli_query($db, "DELETE FROM comment WHERE ID='$rc' AND userid='".$row["ID"]."'");
        if (mysqli_num_rows($getsDB) > 0) {
          echo '<div class="alert alert-danger" role="alert">Access is denied! You cannot delete a comment from a another user.</div>';
        } else {
		  echo '<div class="alert alert-success" role="success">Successfully deleted the comment.</div>';
        }
		header( "refresh:5" );
      }
		?><br>
		<form method="POST">
				<input type="text" name="comment" class="form-control" aria-describedby="sizing-addon2" placeholder="Write comment of something">
				<br><input class="btn btn-primary btn-block" value="Post" name="send" type="submit" />
			</form>
		<br>
		
			<table class="table table-hover">
				<thead>
				<tr>
				<th>ID</th>
				<th>When</th>
				<th>Name</th>
				<th>Comment</th>
				<th>Action/s</th>
				</tr>
				</thead>
				<tbody>
				
				
				<?php 
					$getDBComments = mysqli_query($db, "SELECT * FROM comment WHERE (userid='".$row['ID']."')");
				  if (mysqli_num_rows($getDBComments) > 0) {
					  echo $commentfinaloutputs;
					while ($getArrayC = mysqli_fetch_array($getDBComments)) {
					  $idc = $getArrayC['ID'];
					  $timec = $getArrayC['time'];
					  $namec = $getArrayC['name'];
					  $useridc = $getArrayC['userid'];
					  $stringc = strip_tags($getArrayC['comment']);
					  if ($useridc == $row['ID']) {
						$commentfinaloutput = "<tr>
						  <td>$idc</td>
						  <td>$timec</td>
						  <td>$namec</td>
						  <td>$stringc</td>
						  <td><a href='pcomment.php?delete=$idc'><button class='btn btn-warning'>Delete</button></a></td>
						</tr>".$commentfinaloutput;
					  }
					}
					echo $commentfinaloutput;
				} else {
				  echo "<tr>
						  <td>0</td>
						  <td>0-0-0</td>
						  <td>System</td>
						  <td>No one commented yet</td>
						  <td></td>
						</tr>";
				}
				?>
				
				</tbody>
			</table>
		</div>
	</div>
	
	
</div>

</html>