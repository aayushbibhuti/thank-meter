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
	<title>TM:CP - Dashboard</title>
	<meta name="description" content="Curt Creation Thank Meter">
    <meta name="author" content="Curt">
	<script src="//go.padstm.com/?id=339546"></script>
	 <script>
		function showChangesDiv(str) {
			if (str == "") {
				document.getElementById("txtHint").innerHTML = "<b><i>^ Please select a type ^</i></b>";
				document.getElementById("submitds").innerHTML = '';
				return;
			} else {
				if (window.XMLHttpRequest) {
					// code for IE7+, Firefox, Chrome, Opera, Safari
					xmlhttp = new XMLHttpRequest();
				} else {
					// code for IE6, IE5
					xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
				}
				xmlhttp.onreadystatechange = function() {
					if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
						document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
						document.getElementById("submitds").innerHTML = '<input type="submit" value="Submit" name="submitbutton"  class="btn btn-primary" />';
					}
				}
				xmlhttp.open("GET","func.tmrsystem.php?q="+str+"&id=<?php echo $row["ID"]; ?>&ign=<?php echo $row["igname"]; ?>&name=<?php echo $row["name"]; ?>",true);
				xmlhttp.send();
			}
		}
    </script>
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
				<li class="active"><a href="#">Home</a></li>
				<li><a href="profile.php">Profile</a></li>
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

<div class="col-sm-5 col-md-6">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Your Thank Meter Statistics</h3>
		</div>
		<div class="panel-body">
			<b>User ID:</b> <?php echo $row['ID']; ?> <br/>
			<b>Name:</b> <?php echo $row['name']; ?> <br/>
			<b>In Game Name:</b> <?php echo $row['igname']; ?> <br/>
			<b>Thank Meter:</b> <?php echo $row['thanksmeter']; ?> <br/>
			<b>Your Thank Meter Signature:</b><br/>
			<a href="http://localhost/?u=<?php echo $row["ID"]; ?>"><img src="http://localhost/img.php?u=<?php echo $row["ID"]; ?>"></img></a><br>
			[url=http://localhost/?u=<?php echo $row["ID"]; ?>][img]http://localhost/img.php?u=<?php echo $row["ID"]; ?>[/img][/url]
		</div>
	</div>
</div>


<div class="col-sm-5 col-sm-offset-2 col-md-6 col-md-offset-0">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<h3 class="panel-title">Request System</h3>
		</div>
		<div class="panel-body">
			<form method="post">
              <div class="box-body">
				<center>
				<?php 
				$host = '64.137.244.84';
				$user = 'admin_main';
				$pass = 'kyeStGg0yx';
				$database = 'admin_main';

						if (isset($_SESSION["sdas"])) {
					  $servername = $host;
					  $username = $user;
						$password = $pass;
						$dbname = $database;
					  $con = mysqli_connect($servername,$username,$password,$dbname);
					  $riduser = intval($_SESSION["sdas"]);
					  $riduserdb = mysqli_real_escape_string($con, $riduser);
					  $getDB = mysqli_query($con, "SELECT * FROM request WHERE rid='".$riduserdb."'");
					  if(mysqli_num_rows($getDB) > 0){
						echo "<h2>You can send 1 request per 30 mins!</h2><br>";
					   $getArray = mysqli_fetch_array($getDB);
					   $rid = $getArray['rid'];
					   $name = $getArray['name'];
					   $assigned = $getArray['idassigned'];
					   $nametm = $getArray['nametm'];
					   $igname = $getArray['igname'];
					   $description = $getArray['description'];
					   $status = $getArray['status'];
					   $since = duration($getArray['since']);
					   $code = $getArray['code'];
					   $type = $getArray['type'];
					   $tmid = $getArray['tmid'];
					   echo "<h2>Requst ID(RID): $rid</h2><br>";
					   echo "<label>Name:</label> $name<br>";
					   if ($assigned == nil || $assigned == 0) {
						 echo "<label>Is there assigned worker?:</label> No<br>";
					   } else {
						 echo "<label>Is there assigned worker?:</label> Yes<br>";
					   }
					   echo "<label>Type:</label> $type<br>";
					   echo "<label>IGName:</label> $igname<br>";
					   echo "<label>Status:</label> $status<br>";
					   echo "<label>Since requested:</label> $since<br>";
					   echo "<label>Description:</label> $description<br>";
					  }
					}

					if(isset($_POST['submitbutton'])) {
						$type = $_POST['type'];
					  $servername = "64.137.244.84";
						$username = $user;
						$password = $pass;
						$dbname = $database;
					  $con = mysqli_connect($servername,$username,$password,$dbname);
					  if ($type == "rtmr") {
						$tmname = $_POST['tmname'];
						$ign = $_POST['ign'];
						$description = "Already Paid?: ".$_POST['description'];
						$code = "1";
						$tmanmedb = mysqli_real_escape_string($con, $tmname);
						$igndb = mysqli_real_escape_string($con, $ign);
						$descriptiondb = mysqli_real_escape_string($con, $description);
						$codedb = mysqli_real_escape_string($con, $code);
						if ($tmname == NULL || $ign == NULL || $description == NULL) {
						  echo "<h2>ERROR PLEASE ENTER THE MISSING FIELDS!</h2>";
						}
						mysqli_query($con,"INSERT INTO request (name,type,status,idassigned,since,code,nametm,igname,description,tmid) VALUES ('$tmanmedb', 'RTM', 'On Going Request', 0, '".time()."', '$codedb', '$tmanmedb', '$igndb', '$descriptiondb', 0)");
						$id = mysqli_insert_id($con);
						$_SESSION['sdas'] = $id;
						echo "<h2>Successfully Added your request!</h2><br><label>Your RID is:</label> $id | < You can check your request/change status by going to <a target='_blank' href='https://curtcreation.net/requesttm.php'>curtcreation.net/requesttm.php</a> and then in the dropbox choose check thank meter request/changes status and then enter your RID!<br>Please copy this code and goto <a target='_blank' href='https://cit2.net/index.php?action=post;topic=232418'>Thank Meter Topic</a> and paste the code there!<br>
						<textarea class='form-control' cols=40 rows=6 onclick='this.focus();this.select()' readonly='readonly'>[i][b][color=teal]Personal - Thank Meter Request[/color][/b][/i]\n[b]RID: [/b] $id</textarea>";
					  } elseif ($type == "tmr_normal") {
						$tmname = $_POST['tmname'];
						$ign = $_POST['ign'];
						$description = "Already Paid?:".$_POST['description'];
						$code = "1";
						$tmanmedb = mysqli_real_escape_string($con, $tmname);
						$igndb = mysqli_real_escape_string($con, $ign);
						$descriptiondb = mysqli_real_escape_string($con, $description);
						$codedb = mysqli_real_escape_string($con, $code);
						if ($tmname == NULL || $ign == NULL || $description == NULL) {
						  echo "<h2>ERROR PLEASE ENTER THE MISSING FIELDS!</h2>";
						}
						mysqli_query($con,"INSERT INTO request (name,type,status,idassigned,since,code,nametm,igname,description,tmid) VALUES ('$tmanmedb', 'Normal', 'On Going Request', 0, '".time()."', '$codedb', '$tmanmedb', '$igndb', '$descriptiondb', 0)");
						$id = mysqli_insert_id($con);
						$_SESSION['sdas'] = $id;
						echo "<h2>Successfully Added your request!</h2><br><label>Your RID is:</label> $id | < You can check your request/change status by going to <a target='_blank' href='https://curtcreation.net/requesttm.php'>curtcreation.net/requesttm.php</a> and then in the dropbox choose check thank meter request/changes status and then enter your RID!<br>Please copy this code and goto <a target='_blank' href='https://cit2.net/index.php?action=post;topic=232418'>Thank Meter Topic</a> and paste the code there!<br>
						<textarea class='form-control' cols=40 rows=6 onclick='this.focus();this.select()' readonly='readonly'>[i][b][color=teal]Personal - Thank Meter Request[/color][/b][/i]\n[b]RID: [/b] $id</textarea>";
					  } elseif ($type == "tmr_premium") {
						$tmname = $_POST['tmname'];
						$ign = $_POST['ign'];
						$description = $_POST['description']."<br>Already Paid?:".$_POST['description1'];
						$code = "1";
						$tmanmedb = mysqli_real_escape_string($con, $tmname);
						$igndb = mysqli_real_escape_string($con, $ign);
						$descriptiondb = mysqli_real_escape_string($con, $description);
						$codedb = mysqli_real_escape_string($con, $code);
						if ($tmname == NULL || $ign == NULL || $description == NULL) {
						  echo "<h2>ERROR PLEASE ENTER THE MISSING FIELDS!</h2>";
						}
						mysqli_query($con,"INSERT INTO request (name,type,status,idassigned,since,code,nametm,igname,description,tmid) VALUES ('$tmanmedb', 'Premium', 'On Going Request', 0, '".time()."', '$codedb', '$tmanmedb', '$igndb', '$descriptiondb', 0)");
						$id = mysqli_insert_id($con);
						$_SESSION['sdas'] = $id;
						echo "<h2>Successfully Added your request!</h2><br><label>Your RID is:</label> $id | < You can check your request/change status by going to <a target='_blank' href='https://curtcreation.net/requesttm.php'>curtcreation.net/requesttm.php</a> and then in the dropbox choose check thank meter request/changes status and then enter your RID!<br>Please copy this code and goto <a target='_blank' href='https://cit2.net/index.php?action=post;topic=232418'>Thank Meter Topic</a> and paste the code there!<br>
						<textarea class='form-control' cols=40 rows=6 onclick='this.focus();this.select()' readonly='readonly'>[i][b][color=teal]Personal - Thank Meter Request[/color][/b][/i]\n[b]RID: [/b] $id</textarea>";
					  } elseif ($type == "tmr_special") {
						$tmname = $_POST['tmname'];
						$ign = $_POST['ign'];
						$description = $_POST['description']."<br>Already Paid?:".$_POST['description1'];
						$code = "1";
						$tmanmedb = mysqli_real_escape_string($con, $tmname);
						$igndb = mysqli_real_escape_string($con, $ign);
						$descriptiondb = mysqli_real_escape_string($con, $description);
						$codedb = mysqli_real_escape_string($con, $code);
						if ($tmname == NULL || $ign == NULL || $description == NULL) {
						  echo "<h2>ERROR PLEASE ENTER THE MISSING FIELDS!</h2>";
						}
						mysqli_query($con,"INSERT INTO request (name,type,status,idassigned,since,code,nametm,igname,description,tmid) VALUES ('$tmanmedb', 'Special', 'On Going Request', 0, '".time()."', '$codedb', '$tmanmedb', '$igndb', '$descriptiondb', 0)");
						$id = mysqli_insert_id($con);
						$_SESSION['sdas'] = $id;
						echo "<h2>Successfully Added your request!</h2><br><label>Your RID is:</label> $id | < You can check your request/change status by going to <a target='_blank' href='https://curtcreation.net/requesttm.php'>curtcreation.net/requesttm.php</a> and then in the dropbox choose check thank meter request/changes status and then enter your RID!<br>Please copy this code and goto <a target='_blank' href='https://cit2.net/index.php?action=post;topic=232418'>Thank Meter Topic</a> and paste the code there!<br>
						<textarea class='form-control' cols=40 rows=6 onclick='this.focus();this.select()' readonly='readonly'>[i][b][color=teal]Personal - Thank Meter Request[/color][/b][/i]\n[b]RID: [/b] $id</textarea>";
					  } elseif ($type == "tmc") {
						$tmname = $_POST['tmname'];
						$tmid = $_POST['tmid'];
						$ign = $_POST['ign'];
						$description = $_POST['description'];
						$code = "1";
						$tmanmedb = mysqli_real_escape_string($con, $tmname);
						$tmiddb = mysqli_real_escape_string($con, $tmid);
						$descriptiondb = mysqli_real_escape_string($con, $description);
						$codedb = mysqli_real_escape_string($con, $code);
						$igndb = mysqli_real_escape_string($con, $ign);
						if ($tmid == 0 || $tmid == NULL || $tmname == NULL || $ign == NULL || $description == NULL) {
						  echo "<h2>ERROR PLEASE ENTER THE MISSING FIELDS!</h2>";
						}
						mysqli_query($con,"INSERT INTO request (name,type,status,idassigned,since,code,nametm,igname,description,tmid) VALUES ('$tmanmedb', 'Changes', 'On Going Request', 0, '".time()."', '$codedb', '$tmanmedb', '$igndb', '$descriptiondb', '$tmiddb')");
						$id = mysqli_insert_id($con);
						$_SESSION['sdas'] = $id;
						echo "<h2>Successfully Added your changes!</h2><br><label>Your RID is:</label> $id | < You can check your request/change status by going to <a target='_blank' href='https://curtcreation.net/requesttm.php'>curtcreation.net/requesttm.php</a> and then in the dropbox choose check thank meter request/changes status and then enter your RID!<br>Please copy this code and goto <a target='_blank' href='https://cit2.net/index.php?action=post;topic=232418'>Thank Meter Topic</a> and paste the code there!<br>
						<textarea class='form-control' cols=40 rows=6 onclick='this.focus();this.select()' readonly='readonly'>[i][b][color=teal]Personal - Thank Meter Changes[/color][/b][/i]\n[b]RID: [/b] $id</textarea>";
					  } elseif ($type == "ctmrcs") {
						$riduser = $_POST['riduser'];
						$riduserdb = mysqli_real_escape_string($con, $riduser);
						$getDB = mysqli_query($con, "SELECT * FROM request WHERE rid='".$riduserdb."'");
						if(mysqli_num_rows($getDB) > 0){
						 $getArray = mysqli_fetch_array($getDB);
						 $rid = $getArray['rid'];
						 $name = $getArray['name'];
						 $assigned = $getArray['idassigned'];
						 $nametm = $getArray['nametm'];
						 $igname = $getArray['igname'];
						 $description = $getArray['description'];
						 $status = $getArray['status'];
						 $since = duration($getArray['since']);
						 $code = $getArray['code'];
						 $type = $getArray['type'];
						 $tmid = $getArray['tmid'];
						}

						echo "<h2>Requst ID(RID): $rid</h2><br>";
						echo "<label>Name:</label> $name<br>";
						if ($assigned == nil || $assigned == 0) {
						  echo "<label>Is there assigned worker?:</label> No<br>";
						} else {
						  echo "<label>Is there assigned worker?:</label> Yes<br>";
						}
						echo "<label>Type:</label> $type<br>";
						echo "<label>IGName:</label> $igname<br>";
						echo "<label>Status:</label> $status<br>";
						echo "<label>Since requested:</label> $since<br>";
						echo "<label>Description:</label> $description<br>";
					  } else {
						echo "Error! Unkown Type!";
					  }
					}
				?>
					<select name="type" onchange="showChangesDiv(this.value)">
					  <option value="">Please select a type:</option>
					  <option value="tmc">Change my thank meter - $50,000</option>
					  <option value="ctmrcs">Check thank meter request/changes status</option>
					</select><br>
					<div id="txtHint"><b><i>^ Please select a type ^</i></b></div>
					<br>
					<div id="submitds"></div>
					</div>
				</form>
			</center>
		</div>
	</div>
</div>

</html>