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
	<title>TM:CP - Image Editor</title>
	<meta name="description" content="Curt Creation Thank Meter">
    <meta name="author" content="Curt">
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
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
				<li class="active"><a href="ieditor.php">Image Editor</a></li>
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
			if (isset($_POST['rename_xmeterpos'])){
				$text = mysqli_real_escape_string($db, $_POST['rename_xmeterpos']);
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET x_meterpos='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET x_meterpos='' WHERE ID='$rc'");
			}
			
			
			if (isset($_POST['rename_iymeterpos'])){
				$text = mysqli_real_escape_string($db, $_POST['rename_iymeterpos']);
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET y_meterpos='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET y_meterpos='' WHERE ID='$rc'");
			}
			
			
			if (isset($_POST['rename_sizemeter'])){
				$text = mysqli_real_escape_string($db, $_POST['rename_sizemeter']);
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET image_metersize='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET image_metersize='' WHERE ID='$rc'");
			}
			
			
			if (isset($_POST['rename_xonlinepos'])){
				$text = mysqli_real_escape_string($db, $_POST['rename_xonlinepos']);
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET x_onoffpos='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET x_onoffpos='' WHERE ID='$rc'");
			}
			
			
			if (isset($_POST['rename_yonlinepos'])){
				$text = mysqli_real_escape_string($db, $_POST['rename_yonlinepos']);
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET y_onoffpos='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET y_onoffpos='' WHERE ID='$rc'");
			}
			
			
			if (isset($_POST['rename_sizeonline'])){
				$text = mysqli_real_escape_string($db, $_POST['rename_sizeonline']);
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET size_onlineoff='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET size_onlineoff='' WHERE ID='$rc'");
			}
			
			
			if (isset($_POST['x_igfeatures'])){
				if ($_POST['x_igfeatures'] == "-30") {
					$rc = $row["ID"];
					mysqli_query($db, "UPDATE users SET showstatsonsig='false' WHERE ID='$rc'");
					mysqli_query($db, "UPDATE users SET x_igfeatures='-30' WHERE ID='$rc'");
				} else { 
					$text = mysqli_real_escape_string($db, $_POST['x_igfeatures']);
					$rc = $row["ID"];
					mysqli_query($db, "UPDATE users SET x_igfeatures='$text' WHERE ID='$rc'");
					mysqli_query($db, "UPDATE users SET showstatsonsig='true' WHERE ID='$rc'");
				}
				mysqli_query($db, "UPDATE users SET x_igfeatures='$text' WHERE ID='$rc'");
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET x_igfeatures='' WHERE ID='$rc'");
				mysqli_query($db, "UPDATE users SET showstatsonsig='false' WHERE ID='$rc'");
			}
			
			
			if (isset($_POST['y_igfeatures'])){
				if ($_POST['y_igfeatures'] == "-30") {
					$rc = $row["ID"];
					mysqli_query($db, "UPDATE users SET showstatsonsig='false' WHERE ID='$rc'");
					mysqli_query($db, "UPDATE users SET y_igfeatures='-30' WHERE ID='$rc'");
				} else { 
					$text = mysqli_real_escape_string($db, $_POST['y_igfeatures']);
					$rc = $row["ID"];
					mysqli_query($db, "UPDATE users SET y_igfeatures='$text' WHERE ID='$rc'");
					mysqli_query($db, "UPDATE users SET showstatsonsig='true' WHERE ID='$rc'");
				}
			} else {
				$rc = $row["ID"];
				mysqli_query($db, "UPDATE users SET y_igfeatures='' WHERE ID='$rc'");
				mysqli_query($db, "UPDATE users SET showstatsonsig='false' WHERE ID='$rc'");
			}
			
			header( "refresh:5" );
			echo '<div class="alert alert-success" role="success">Data was successfully saved.</div>';
		}
		?>
			<form method="POST">
				
				<b>Preview:</b> <div id="previewimg">Please edit a field! When you edit a field, this preview image will automatically update & it doesn't means it will NOT automatically saved, you must press save to Save all changes!</div><br>
				<b>Move the cursor in the image to show the co-ordinates. And left click to show the clicked co-ordinates.</b><br>
				<div id="coord_move" ></div><br>
				<div id="coord_click" ></div><br>
				<input type="hidden" id="smallname" name="smallname" value="<?php echo $row["smallname"]; ?>"/><br>
				<b>True Image:</b> <img src="https://curtcreation.net/tm/local_data/<?php echo $row["smallname"]; ?>/true.png"></img> <input type="file" name="trueimg"><br>
				<b>False Image:</b> <img src="https://curtcreation.net/tm/local_data/<?php echo $row["smallname"]; ?>/false.png"></img> <input type="file" name="falseimg"><br>
				<b>X Meter Pos: </b> <input id="rename_xmeterpos" type="text" name="rename_xmeterpos" value="<?php echo $row["x_meterpos"]; ?>" /><br>
				<b>Y Meter Pos: </b> <input id="rename_iymeterpos" type="text" name="rename_iymeterpos" value="<?php echo $row["y_meterpos"]; ?>" /><br>
				<b>Size Meter: </b> <input id="rename_sizemeter" type="text" name="rename_sizemeter" value="<?php echo $row["image_metersize"]; ?>" /><br>
				<b>X Online Label Pos: </b> <input id="rename_xonlinepos" type="text" name="rename_xonlinepos" value="<?php echo $row["x_onoffpos"]; ?>" />(To disable type: -30)<br>
				<b>Y Online Label Pos: </b> <input id="rename_yonlinepos" type="text" name="rename_yonlinepos" value="<?php echo $row["y_onoffpos"]; ?>" />(To disable type: -30)<br>
				<b>Size Online Label: </b> <input id="rename_sizeonline" type="text" name="rename_sizeonline" value="<?php echo $row["size_onlineoff"]; ?>" />(To disable type: 1)<br>
				<b>X Player Information: </b> <input id="x_igfeatures" type="text" name="x_igfeatures" value="<?php echo $row["x_igfeatures"]; ?>" /> (To disable type: -30)<br>
				<b>Y Player Information: </b> <input id="y_igfeatures" type="text" name="y_igfeatures" value="<?php echo $row["y_igfeatures"]; ?>" /> (To disable type: -30)<br>
				<b>Generated Code BBC:</b> [url=https://curtcreation.net/tm/<?php echo $row["smallname"]; ?>][img]https://curtcreation.net/tm/img/<?php echo $row["smallname"]; ?>[/img][/url]<br>
				<br>
				<input class="btn btn-lg btn-primary btn-block" value="Save All Changes" name="submit" type="submit" />
			</form>
		</div>
	</div>
</div>
<script>
    $(document).ready(function() {
        $('#previewimg').click(function(e) {
            var offset = $(this).offset();
            var X = (e.pageX - offset.left);
            var Y = (e.pageY - offset.top);
            $('#coord_click').text('Clicked Co-Ordinates: X: ' + X + ' | Y: ' + Y);
        });
        $('#previewimg').on("mousemove", function(e) {
            var offset = $(this).offset();
            var X = (e.pageX - offset.left);
            var Y = (e.pageY - offset.top);
            $('#coord_move').text('Current Co-Ordinates: X: ' + X + ' | Y: ' + Y);
        });        
    });
	
	var rename_numthank = 30;
	var rename_font = "font.tff";
	var rename_xmeterpos = "rename_xmeterpos";
	var rename_iymeterpos = "rename_iymeterpos";
	var rename_sizemeter = "rename_sizemeter";
	var rename_xonlinepos = "rename_xonlinepos";
	var rename_yonlinepos = "rename_yonlinepos";
	var rename_sizeonline = "rename_sizeonline";
	var x_igfeatures = "x_igfeatures";
	var y_igfeatures = "y_igfeatures";

	$('#'+rename_font).on('change',function(e){
		$("#previewimg").html("<img src='https://curtcreation.net/tm/previewimg.php?u=" + $("#smallname").val() + "&igname=DemoPreview&name=DemoPreview&thanksmeter=" + rename_numthank+ "&image_metersize=" + $("#rename_sizemeter").val() + "&x_meterpos=" + $("#rename_xmeterpos").val() + "&y_meterpos=" + $("#rename_iymeterpos").val() + "&x_onoff=" + $("#rename_xonlinepos").val() + "&y_onoff=" + $("#rename_yonlinepos").val() + "&size_onlineoff=" + $("#rename_sizeonline").val() + "&fss=" + $("#rename_font").val() + "&x_igfeatures="+$("#x_igfeatures").val()+"&y_igfeatures="+$("#y_igfeatures").val()+"' />");
	});
	$('#'+rename_xmeterpos).on('change',function(e){
		$("#previewimg").html("<img src='https://curtcreation.net/tm/previewimg.php?u=" + $("#smallname").val() + "&igname=DemoPreview&name=DemoPreview&thanksmeter=" + rename_numthank+ "&image_metersize=" + $("#rename_sizemeter").val() + "&x_meterpos=" + $("#rename_xmeterpos").val() + "&y_meterpos=" + $("#rename_iymeterpos").val() + "&x_onoff=" + $("#rename_xonlinepos").val() + "&y_onoff=" + $("#rename_yonlinepos").val() + "&size_onlineoff=" + $("#rename_sizeonline").val() + "&fss=" + $("#rename_font").val() + "&x_igfeatures="+$("#x_igfeatures").val()+"&y_igfeatures="+$("#y_igfeatures").val()+"' />");
	});
	$('#'+rename_iymeterpos).on('change',function(e){
		$("#previewimg").html("<img src='https://curtcreation.net/tm/previewimg.php?u=" + $("#smallname").val() + "&igname=DemoPreview&name=DemoPreview&thanksmeter=" + rename_numthank+ "&image_metersize=" + $("#rename_sizemeter").val() + "&x_meterpos=" + $("#rename_xmeterpos").val() + "&y_meterpos=" + $("#rename_iymeterpos").val() + "&x_onoff=" + $("#rename_xonlinepos").val() + "&y_onoff=" + $("#rename_yonlinepos").val() + "&size_onlineoff=" + $("#rename_sizeonline").val() + "&fss=" + $("#rename_font").val() + "&x_igfeatures="+$("#x_igfeatures").val()+"&y_igfeatures="+$("#y_igfeatures").val()+"' />");
	});
	$('#'+rename_sizemeter).on('change',function(e){
		$("#previewimg").html("<img src='https://curtcreation.net/tm/previewimg.php?u=" + $("#smallname").val() + "&igname=DemoPreview&name=DemoPreview&thanksmeter=" + rename_numthank+ "&image_metersize=" + $("#rename_sizemeter").val() + "&x_meterpos=" + $("#rename_xmeterpos").val() + "&y_meterpos=" + $("#rename_iymeterpos").val() + "&x_onoff=" + $("#rename_xonlinepos").val() + "&y_onoff=" + $("#rename_yonlinepos").val() + "&size_onlineoff=" + $("#rename_sizeonline").val() + "&fss=" + $("#rename_font").val() + "&x_igfeatures="+$("#x_igfeatures").val()+"&y_igfeatures="+$("#y_igfeatures").val()+"' />");
	});
	$('#'+rename_xonlinepos).on('change',function(e){
		$("#previewimg").html("<img src='https://curtcreation.net/tm/previewimg.php?u=" + $("#smallname").val() + "&igname=DemoPreview&name=DemoPreview&thanksmeter=" + rename_numthank+ "&image_metersize=" + $("#rename_sizemeter").val() + "&x_meterpos=" + $("#rename_xmeterpos").val() + "&y_meterpos=" + $("#rename_iymeterpos").val() + "&x_onoff=" + $("#rename_xonlinepos").val() + "&y_onoff=" + $("#rename_yonlinepos").val() + "&size_onlineoff=" + $("#rename_sizeonline").val() + "&fss=" + $("#rename_font").val() + "&x_igfeatures="+$("#x_igfeatures").val()+"&y_igfeatures="+$("#y_igfeatures").val()+"' />");
	});
	$('#'+rename_yonlinepos).on('change',function(e){
		$("#previewimg").html("<img src='https://curtcreation.net/tm/previewimg.php?u=" + $("#smallname").val() + "&igname=DemoPreview&name=DemoPreview&thanksmeter=" + rename_numthank+ "&image_metersize=" + $("#rename_sizemeter").val() + "&x_meterpos=" + $("#rename_xmeterpos").val() + "&y_meterpos=" + $("#rename_iymeterpos").val() + "&x_onoff=" + $("#rename_xonlinepos").val() + "&y_onoff=" + $("#rename_yonlinepos").val() + "&size_onlineoff=" + $("#rename_sizeonline").val() + "&fss=" + $("#rename_font").val() + "&x_igfeatures="+$("#x_igfeatures").val()+"&y_igfeatures="+$("#y_igfeatures").val()+"' />");
	});
	$('#'+rename_sizeonline).on('change',function(e){
		$("#previewimg").html("<img src='https://curtcreation.net/tm/previewimg.php?u=" + $("#smallname").val() + "&igname=DemoPreview&name=DemoPreview&thanksmeter=" + rename_numthank+ "&image_metersize=" + $("#rename_sizemeter").val() + "&x_meterpos=" + $("#rename_xmeterpos").val() + "&y_meterpos=" + $("#rename_iymeterpos").val() + "&x_onoff=" + $("#rename_xonlinepos").val() + "&y_onoff=" + $("#rename_yonlinepos").val() + "&size_onlineoff=" + $("#rename_sizeonline").val() + "&fss=" + $("#rename_font").val() + "&x_igfeatures="+$("#x_igfeatures").val()+"&y_igfeatures="+$("#y_igfeatures").val()+"' />");
	});
	$('#'+x_igfeatures).on('change',function(e){
		$("#previewimg").html("<img src='https://curtcreation.net/tm/previewimg.php?u=" + $("#smallname").val() + "&igname=DemoPreview&name=DemoPreview&thanksmeter=" + rename_numthank+ "&image_metersize=" + $("#rename_sizemeter").val() + "&x_meterpos=" + $("#rename_xmeterpos").val() + "&y_meterpos=" + $("#rename_iymeterpos").val() + "&x_onoff=" + $("#rename_xonlinepos").val() + "&y_onoff=" + $("#rename_yonlinepos").val() + "&size_onlineoff=" + $("#rename_sizeonline").val() + "&fss=" + $("#rename_font").val() + "&x_igfeatures="+$("#x_igfeatures").val()+"&y_igfeatures="+$("#y_igfeatures").val()+"' />");
	});
	$('#'+y_igfeatures).on('change',function(e){
		$("#previewimg").html("<img src='https://curtcreation.net/tm/previewimg.php?u=" + $("#smallname").val() + "&igname=DemoPreview&name=DemoPreview&thanksmeter=" + rename_numthank+ "&image_metersize=" + $("#rename_sizemeter").val() + "&x_meterpos=" + $("#rename_xmeterpos").val() + "&y_meterpos=" + $("#rename_iymeterpos").val() + "&x_onoff=" + $("#rename_xonlinepos").val() + "&y_onoff=" + $("#rename_yonlinepos").val() + "&size_onlineoff=" + $("#rename_sizeonline").val() + "&fss=" + $("#rename_font").val() + "&x_igfeatures="+$("#x_igfeatures").val()+"&y_igfeatures="+$("#y_igfeatures").val()+"' />");
	});
</script>

</html>