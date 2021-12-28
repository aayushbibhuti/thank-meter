<?php 
require ("core/functions.php");

$ipaddress = getIPAddress();
$motd = "";
if (isDBOffline("connection") == true) {
	$pagetitle = "Database is offline";
    $id = 0;
    $commentfinaloutput = '<li class="cmmnt">
	<div class="avatar"><a href="javascript:void(0);"><img src="_include/img/profile/system.png" width="55" height="55" alt="photo avatar"></a></div>
	<div class="cmmnt-content">
		<header><a href="javascript:void(0);" class="userlink">System</a> - <span class="pubdate">notice</span></header>
		<p>Database is currently offline right now, please try again later :(</a></p>
	</div>
	</li>';
    $thankyouecho = "Database is offline";
    $thanks = "0";
    $name = "Database is offline";
    $globalstats_totalu = 0;
    $globalstats_totalthanks = 0;
    $globalstats_totalcom = 0;
    $globalstats_activestaff = 0;
} elseif (checkMaintenance() == true) {
    $pagetitle = "Maintenance";
    $id = 0;
    $commentfinaloutput = '<li class="cmmnt">
	<div class="avatar"><a href="javascript:void(0);"><img src="_include/img/profile/system.png" width="55" height="55" alt="photo avatar"></a></div>
	<div class="cmmnt-content">
		<header><a href="javascript:void(0);" class="userlink">System</a> - <span class="pubdate">notice</span></header>
		<p>Thank Meter is under Maintenance for '.getMaintenanceReason().'</a></p>
	</div>
	</li>';
    $thankyouecho = "Under Maintenance";
    $thanks = "0";
    $name = "Under Maintenance";
    $globalstats_totalu = 0;
    $globalstats_totalthanks = 0;
    $globalstats_totalcom = 0;
    $globalstats_activestaff = 0;
  } else {
    if (isset($_GET['u'])) {
      $user = $_GET['u'];
    } else {
      $user = null;
    }
	
	if (isset($_GET["u"])) {
		$user = mysqli_real_escape_string(getDbConnection(1), $user);
		$getDB = mysqli_query(getDbConnection(1), "SELECT * FROM users WHERE (smallname='$user' OR ID='$user')");
		if (mysqli_num_rows($getDB) > 0) {
			$getArray = mysqli_fetch_array($getDB);
			$idzers = $getArray["ID"]; //Get User's ID
			$smallname = $getArray["smallname"]; //Get User's username 
			$igname = $getArray["igname"]; //Get User's IGN
			$name = $getArray["name"]; //Get User's Name 
			$thanks = $getArray["thanksmeter"]; //Get User's Meter 
			$sus_reason = $getArray["sus_reason"]; //Get User's banned reason 
			$ip_used = $getArray["ip_used"]; //Get User's IP Used 
			$isBanned = $getArray["isBanned"]; //Get User's is banned 
			$disablecom = $getArray["disablecom"]; //Get User's Comment System Settings 
			$motd = $getArray["motd"]; //Get User's MOTD
			$replace1 = $getArray["replace1"]; //Get User's Replacement for "You Thanked me!"
			$replace2 = $getArray["replace2"]; //Get User's Replacement for "You already thanked me!"
			$profilerole = $getArray["profilerole"]; //Profile Role
			$profilepic = $getArray["profilepic"]; //Profile Picture URL
			$profiledescription = $getArray["profiledescription"]; //Profile description
			$twitter = $getArray["twitterlink"]; //Twitter Link
			$facebook = $getArray["facebooklink"]; //Facebook Link
			$background1 = $getArray["background1"]; //background1 Link
			$background2 = $getArray["background2"]; //background2 Link
			$background3 = $getArray["background3"]; //background3 Link
			$background4 = $getArray["background4"]; //background4 Link
			if ($disablecom == "true") {
				$commentsection = false;
			} else {
				$commentsection = true;
			}
			
			$commentfinaloutput = "";
        
			$id = $idzers;
			$globalstats_totalu = getGlobalStatistics("members");
			$globalstats_totalcom = getGlobalStatistics("comments");
			$globalstats_activestaff = 5;
			
			if ($isBanned == "true") {
			  $pagetitle = $name;
			  $id = $idzers;
			  $commentfinaloutput = '<li class="cmmnt">
				<div class="avatar"><a href="javascript:void(0);"><img src="_include/img/profile/system.png" width="55" height="55" alt="photo avatar"></a></div>
				<div class="cmmnt-content">
					<header><a href="javascript:void(0);" class="userlink">System</a> - <span class="pubdate">notice</span></header>
					<p>This account is banned! Viewing/Posting Comments are disabled to this account</a></p>
				</div>
				</li>';
			  $commentsection = false;
			  $thankyouecho = "Account is Banned";
			  $thanks = "0";
			  $name = $name;
			  $hasGroup = false;
			  $motd = "";
			} elseif ($isBanned == "delete") {
			  $pagetitle = "Account doesnt exists";
			  $id = "0";
			  $commentfinaloutput = '<li class="cmmnt">
				<div class="avatar"><a href="javascript:void(0);"><img src="_include/img/profile/system.png" width="55" height="55" alt="photo avatar"></a></div>
				<div class="cmmnt-content">
					<header><a href="javascript:void(0);" class="userlink">System</a> - <span class="pubdate">notice</span></header>
					<p>Account doesnt exists!</a></p>
				</div>
				</li>';
			  $commentsection = false;
			  $thankyouecho = "Account doesnt exists";
			  $thanks = "0";
			  $name = "Account doesnt exists";
			  $hasGroup = false;
			  $motd = "";
			} else {
				
				$pagetitle = $name;
				if (isset($_COOKIE[$idzers."_anticheat"])) { $cookies = "false"; } else { $cookies = $_COOKIE[$idzers."_anticheat"]; }
				if (strpos($ip_used, $ipaddress) == true || $cookies == "true") {
				  if ($replace1 != "") {
					  $thankyouecho = $replace1;
				  } else {
					$thankyouecho = "You already gave me a thanks";
				  }
				setcookie($idzers."_anticheat");
				} else {
					
					
				if ($replace2 != "") {
					  $thankyouecho = $replace2;
				  } else {
					$thankyouecho = "Thanks for thanking me";
				  }
				mysqli_query(getDbConnection(1), "UPDATE users SET ip_used='$ip_used, $ipaddress' WHERE smallname='$smallname'");
				setcookie($idzers."_anticheat", "true");
				$plus = intval($thanks) + 1;
				mysqli_query(getDbConnection(1), "UPDATE users SET thanksmeter='$plus' WHERE smallname='$smallname'");
				$thanks = $plus;
				}
				
				//Comment System
				$getDBComments = mysqli_query(getDbConnection(1), "SELECT * FROM comment WHERE (userid='".$idzers."')");
				  if (mysqli_num_rows($getDBComments) > 0) {
					while ($getArrayC = mysqli_fetch_array($getDBComments)) {
					  $idc = $getArrayC['ID'];
					  $timec = $getArrayC['time'];
					  $namec = $getArrayC['name'];
					  $useridc = $getArrayC['userid'];
					  $stringc = strip_tags($getArrayC['comment']);
					  if ($useridc == $idzers) {
						/*$commentfinaloutput = "<tr>
						  <td>$timec</td>
						  <td>$namec<br><a href='?u=$id&rc=$idc#more'><button>Report Comment</button></a></td>
						  <td>$stringc</td>
						</tr>".$commentfinaloutput;
					  */
					  $commentfinaloutput = '<li class="cmmnt">
						<div class="avatar"><a href="javascript:void(0);"><img src="/_include/img/profile/default.png" width="55" height="55" alt="photo avatar"></a></div>
						<div class="cmmnt-content">
							<header><a href="javascript:void(0);" class="userlink">'.$namec.'</a> - <span class="pubdate">'.$timec.'</span> - <a class="button button-mini" href="?u='.$id.'&rc='.$idc.'#contact">Report</a></header>
							<p>'.$stringc.'</a></p>
						</div>
					  </li>'.$commentfinaloutput;
						}
					  
					  $isThereComments = true;
					}
				} else {
				  $isThereComments = false;
				}
				//End of Comment System 
				
				
				
			}
		} else {
			$pagetitle = "Account doesnt exists";
			$id = "0";
			  $commentfinaloutput = '<li class="cmmnt">
				<div class="avatar"><a href="javascript:void(0);"><img src="images/pikabob.png" width="55" height="55" alt="photo avatar"></a></div>
				<div class="cmmnt-content">
					<header><a href="javascript:void(0);" class="userlink">System</a> - <span class="pubdate">notice</span></header>
					<p>Account doesnt exists!</a></p>
				</div>
				</li>';
			$commentsection = false;
			$thankyouecho = "Account doesnt exists";
			$thanks = "0";
			$name = "Account doesnt exists";
			$globalstats_totalu = getGlobalStatistics("members");
			$globalstats_totalcom = getGlobalStatistics("comments");
			$motd = "";
			$globalstats_activestaff = 5;
		}
	} else {
		$pagetitle = "Account doesnt exists";
		$id = "0";
		  $commentfinaloutput = '<li class="cmmnt">
			<div class="avatar"><a href="javascript:void(0);"><img src="images/pikabob.png" width="55" height="55" alt="photo avatar"></a></div>
			<div class="cmmnt-content">
				<header><a href="javascript:void(0);" class="userlink">System</a> - <span class="pubdate">notice</span></header>
				<p>Account doesnt exists!</a></p>
			</div>
			</li>';
		$commentsection = false;
		$thankyouecho = "Account doesnt exists";
		$thanks = "0";
		$name = "Account doesnt exists";
		$motd = "";
		$globalstats_totalu = getGlobalStatistics("members");
		$globalstats_totalcom = getGlobalStatistics("comments");
		$globalstats_activestaff = 5;
	}
	
	//Ads System 
	$getDBs = mysqli_query(getDbConnection(1), "SELECT * FROM ads WHERE enabled='1' and location='1' order by RAND() LIMIT 1");
	if (mysqli_num_rows($getDBs) > 0) {
	  $getArray = mysqli_fetch_array($getDBs);
	  $nameid = $getArray["id"];
	  $adname = $getArray["name"];
	  $balance = intval($getArray["balance"]);
	  $free = $getArray["free"];
	  $clicks = intval($getArray["clicks"]);
	  $views = intval($getArray["views"]);
	  $getDBip = mysqli_query(getDbConnection(1), "SELECT * FROM ads_ip WHERE ip='$ipaddress' and adid='$nameid'");
	  if ($free == "1") {
		$theTopAd =  "<a href='gourl.php?id=$nameid' id='u1246-ad'><img src='//curtcreation.net/tm/local_ads/".str_replace(' ', '', $adname)."_a.png' height='90' width='468'></img></a>";
		mysqli_query(getDbConnection(1), "UPDATE ads SET views='".$views."' WHERE id='".$nameid."'");
	  } else {
		  if ($balance >= 350) {
			$theTopAd =  "<a href='gourl.php?id=$nameid' id='u1246-ad'><img src='//curtcreation.net/tm/local_ads/".str_replace(' ', '', $adname)."_a.png' height='90' width='468'></img></a>";
			if (mysqli_num_rows($getDBip) > 0) {

			} else {
			  $views = intval($views) + 1;
			  $balance = intval($balance) - 350;
			  mysqli_query(getDbConnection(1), "UPDATE ads SET views='".$views."' WHERE id='".$nameid."'");
			  mysqli_query(getDbConnection(1), "UPDATE ads SET balance='".$balance."' WHERE id='".$nameid."'");
			  mysqli_query(getDbConnection(1), "INSERT INTO ads_ip (ip, adid, date) VALUES ('$ipaddress', '$nameid', '".time()."')");
			}
		  }
	  }
	} else {
	  $theTopAd =  "<a href='gourl.php?id=0' id='u1246-ad'><img src='//curtcreation.net/tm/local_ads/top.png' height='90' width='468'></img></a>";
	}
	
	$getDBs = mysqli_query(getDbConnection(1), "SELECT * FROM ads WHERE enabled='1' and location='2' order by RAND() LIMIT 1");
	if (mysqli_num_rows($getDBs) > 0) {
	  $getArray = mysqli_fetch_array($getDBs);
	  $nameid = $getArray["id"];
	  $adname = $getArray["name"];
	  $balance = intval($getArray["balance"]);
	  $free = $getArray["free"];
	  $clicks = intval($getArray["clicks"]);
	  $views = intval($getArray["views"]);
	  $getDBip = mysqli_query(getDbConnection(1), "SELECT * FROM ads_ip WHERE ip='$ipaddress' and adid='$nameid'");
	  if ($free == "1") {
		$theBottomAd =  "<img id='u1246-bad' src='//curtcreation.net/tm/local_ads/".str_replace(' ', '', $adname)."_a.png'></img>";
		mysqli_query(getDbConnection(1), "UPDATE ads SET views='".$views."' WHERE id='".$nameid."'");
	  } else {
		  if ($balance >= 150) {
			$theBottomAd =  "<a href='gourl.php?id=$nameid' id='u1246-bad'><img src='//curtcreation.net/tm/local_ads/".str_replace(' ', '', $adname)."_a.png' height='90' width='468'></img></a>";
			if (mysqli_num_rows($getDBip) > 0) {

			} else {
			  $views = intval($views) + 1;
			  $balance = intval($balance) - 150;
			  mysqli_query(getDbConnection(1), "UPDATE ads SET views='".$views."' WHERE id='".$nameid."'");
			  mysqli_query(getDbConnection(1), "UPDATE ads SET balance='".$balance."' WHERE id='".$nameid."'");
			  mysqli_query(getDbConnection(1), "INSERT INTO ads_ip (ip, adid, date) VALUES ('$ipaddress', '$nameid', '".time()."')");
			}
		  }
	  }
	} else {
	  $theBottomAd =  "<a href='gourl.php?id=0' id='u1246-bad'><img src='//curtcreation.net/tm/local_ads/bottom.png' height='90' width='468'></img></a>";
	}
	//End of Ads System 
  }
	
?>

<!DOCTYPE html>
<!--[if lt IE 7]><html class="no-js lt-ie9 lt-ie8 lt-ie7" lang="en"> <![endif]-->
<!--[if (IE 7)&!(IEMobile)]><html class="no-js lt-ie9 lt-ie8" lang="en"><![endif]-->
<!--[if (IE 8)&!(IEMobile)]><html class="no-js lt-ie9" lang="en"><![endif]-->
<!--[if (IE 9)]><html class="no-js ie9" lang="en"><![endif]-->
<!--[if gt IE 8]><!--> <html lang="en-US"> <!--<![endif]-->
<head>

<!-- Meta Tags -->
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />

<title><?php echo $pagetitle; ?></title>

<meta name="description" content="Thank Meter | Developed by Curt | Curt Creation" /> 

<!-- Mobile Specifics -->
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="HandheldFriendly" content="true"/>
<meta name="MobileOptimized" content="320"/>   

<!-- Mobile Internet Explorer ClearType Technology -->
<!--[if IEMobile]>  <meta http-equiv="cleartype" content="on">  <![endif]-->

<!-- Bootstrap -->
<link href="_include/css/bootstrap.min.css" rel="stylesheet">

<!-- Main Style -->
<link href="_include/css/main.css" rel="stylesheet">

<!-- Supersized -->
<link href="_include/css/supersized.css" rel="stylesheet">
<link href="_include/css/supersized.shutter.css" rel="stylesheet">

<!-- FancyBox -->
<link href="_include/css/fancybox/jquery.fancybox.css" rel="stylesheet">

<!-- Font Icons -->
<link href="_include/css/fonts.css" rel="stylesheet">

<!-- Shortcodes -->
<link href="_include/css/shortcodes.css" rel="stylesheet">

<!-- Responsive -->
<link href="_include/css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="_include/css/responsive.css" rel="stylesheet">

<!-- Supersized -->
<link href="_include/css/supersized.css" rel="stylesheet">
<link href="_include/css/supersized.shutter.css" rel="stylesheet">

<!-- Google Font -->
<link href='//fonts.googleapis.com/css?family=Titillium+Web:400,200,200italic,300,300italic,400italic,600,600italic,700,700italic,900' rel='stylesheet' type='text/css'>

<!-- Fav Icon -->
<link rel="shortcut icon" href="#">

<link rel="apple-touch-icon" href="#">
<link rel="apple-touch-icon" sizes="114x114" href="#">
<link rel="apple-touch-icon" sizes="72x72" href="#">
<link rel="apple-touch-icon" sizes="144x144" href="#">

<!-- Modernizr -->
<script src="_include/js/modernizr.js"></script>

<link rel="stylesheet" type="text/css" href="_include/css/comment.css">


</head>


<body>

<!-- This section is for Splash Screen -->
<div class="ole">
<section id="jSplash">
	<div id="circle"></div>
</section>
</div>
<!-- End of Splash Screen -->

<!-- Homepage Slider -->
<div id="home-slider">	
    <div class="overlay"></div>

    <div class="slider-text">
    	<div id="slidecaption">
			<div class="slide-content">Name</div>
		</div>
    </div>   
	
	<div class="control-nav">
        <a id="prevslide" class="load-item"><i class="font-icon-arrow-simple-left"></i></a>
        <a id="nextslide" class="load-item"><i class="font-icon-arrow-simple-right"></i></a>
        <ul id="slide-list"></ul>
        
        <a id="nextsection" href="#work"><i class="font-icon-arrow-simple-down"></i></a>
    </div>
</div>
<!-- End Homepage Slider -->

<!-- Header -->
<header>
    <div class="sticky-nav">
    	<a id="mobile-nav" class="menu-nav" href="#menu-nav"></a>
        
        <div id="logo">
        	<a id="goUp" href="#home-slider" title="logo">logo</a>
        </div>
        
        <nav id="menu">
        	<ul id="menu-nav">
            	<li class="current"><a href="#home-slider">Name</a></li>
                <li><a href="#about">About Me</a></li>
                <li><a href="#contact">Comments</a></li>
				<li><a href="/ucp/index.php">UCP</a></li>
            </ul>
        </nav>
        
    </div>
</header>
<!-- End Header -->

<!-- About Section -->
<div id="about" class="page-alternate">
<div class="container">
    <!-- Title Page -->
    <div class="row">
        <div class="span12">
            <div class="title-page">
                <h2 class="title">About <?php echo $name; ?></h2>
                <h3 class="title-description"><?php 
				if (isset($motd) || $motd != "") {
					echo $motd; 
				} else {
					echo "";
				}?></h3>
            </div>
        </div>
    </div>
    <!-- End Title Page -->
    
    <!-- People -->
    <div class="row">
    	
        <!-- Start Profile -->
    	<div class="span4 profile">
        </div>
        <!-- End Profile -->
		
        <!-- Start Profile -->
    	<div class="span4 profile">
        	<div class="image-wrap">
                <div class="hover-wrap">
                    <span class="overlay-img"></span>
                    <span class="overlay-text-thumb"><?php 
					if ($profilerole != "") {
						echo $profilerole;
					} else {
						echo "I have no role";
					}
				?></span>
                </div>
				<?php 
					if ($profilepic != "") {
						echo '<img src="'.$profilepic.'" alt="'.$name.'">';
					} else {
						echo '<img src="_include/img/profile/profile-02.jpg" alt="'.$name.'">';
					}
				?>
            </div>
            <h3 class="profile-name"><?php echo $name; ?></h3>
            <p class="profile-description">
				<?php 
					if ($profiledescription != "") {
						echo $profiledescription;
					} else {
						$autogen = array();
						$autogen["name"] = getPlayerInfo($igname, "name", true, $idzers);
						$autogen["gang"] = getPlayerInfo($igname, "gang", true, $idzers);
						$autogen["squad"] = getPlayerInfo($igname, "squad", true, $idzers);
						$autogen["playtime"] = getPlayerInfo($igname, "playtime", true, $idzers);
						$autogen["cash"] = getPlayerInfo($igname, "cash", true, $idzers);
						$autogen["wanted"] = getPlayerInfo($igname, "wanted", true, $idzers);
						$autogen["occupation"] = getPlayerInfo($igname, "occupation", true, $idzers);
						$autogen["country"] = getPlayerInfo($igname, "country", true, $idzers);
						
						
						if ($autogen["name"] == false) {
							echo "My description has not yet setted. Please set it at your User Control Panel (UCP).";
						} else {
						
							if ($autogen["squad"] != "N/A" && $autogen["gang"] != "N/A") {
								echo "Hi my in game name is ".$autogen["name"]." and I live at ".$autogen["country"]." and I also have ".$autogen["playtime"]."H 
								playtime. My in game group is ".$autogen["gang"]." and my squad is ".$autogen["squad"].". I also have 
								$".$autogen["cash"]." In Game Money on my hand. I also work as a ".$autogen["occupation"].". Thanks 
								for reading my description. <br><br>This description was regenerated by 
								the system. Information was gather via CIT In Game.";
							} elseif ($autogen["squad"] == "N/A" && $autogen["gang"] != "N/A") {
								echo "Hi my in game name is ".$autogen["name"]." and I live at ".$autogen["country"]." and I also have ".$autogen["playtime"]."H 
								playtime. My in game group is ".$autogen["gang"].". I also have 
								$".$autogen["cash"]." In Game Money on my hand. I also work as a ".$autogen["occupation"].". Thanks 
								for reading my description. <br><br>This description was regenerated by 
								the system. Information was gather via CIT In Game.";
							} elseif ($autogen["squad"] != "N/A" && $autogen["gang"] == "N/A") {
								echo "Hi my in game name is ".$autogen["name"]." and I live at ".$autogen["country"]." and I also have ".$autogen["playtime"]."H 
								playtime. My in game squad is ".$autogen["squad"].". I also have 
								$".$autogen["cash"]." In Game Money on my hand. I also work as a ".$autogen["occupation"].". Thanks 
								for reading my description. <br><br>This description was regenerated by 
								the system. Information was gather via CIT In Game.";
							} else {
								echo "Hi my in game name is ".$autogen["name"]." and I live at ".$autogen["country"]." and I also have ".$autogen["playtime"]."H 
								playtime. I also have $".$autogen["cash"]." In Game Money on my hand. I also work as a ".$autogen["occupation"].". Thanks 
								for reading my description. <br><br>This description was regenerated by 
								the system. Information was gather via CIT In Game.";
							}
							
						}
					}
				?>
			</p>
            	
            <div class="social">
            	<ul class="social-icons">
				<?php 
				if ($facebook != "") {
					echo '<li><a href="'.$facebook.'"><i class="font-icon-social-facebook"></i></a></li>';
				}
				
				if ($twitter != "") {
					echo '<li><a href="'.$twitter.'"><i class="font-icon-social-twitter"></i></a></li>';
				}
				?>
                </ul>
            </div>
        </div>
        <!-- End Profile -->
        
        <!-- Start Profile -->
    	<div class="span4 profile">
        </div>
        <!-- End Profile -->
        
    </div>
    <!-- End People -->
</div>
</div>
<!-- End About Section -->


<!-- Contact Section -->
<div id="contact" class="page">
<div class="container">
    <!-- Title Page -->
    <div class="row">
        <div class="span12">
            <div class="title-page">
                <h2 class="title">Comments</h2>
                <h3 class="title-description">Comment on this profile.</h3>
            </div>
        </div>
    </div>
    <!-- End Title Page -->
    
    <!-- Contact Form -->
    <div class="row">

    	<div class="span12">
		
			<?php 
			 if(isset($_POST['submit'])){
				$namecomad = $_POST['namer'];
				$msgc = $_POST['message'];
				if ($namecomad == null || $namecomad == "" || $msgc == "" || $msgc == null || $msgc == "." || $namecomad == ".") {
				  echo '<div class="alert alert-error fade in">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <strong>Oh snap!</strong> Please fill your name & your message.
					</div>';
				} else {
					$msgc = strip_tags($msgc);
					$namecomad = strip_tags($namecomad);
					$namecomadm = mysqli_real_escape_string(getDbConnection(1), $namecomad);
					$msgcm = mysqli_real_escape_string(getDbConnection(1), $msgc);
					$datetime = date("F j, Y h:i A");
					  if(count($_REQUEST)) {
						$ggspamstatus = $SpamChk->GetTextStatus();
						if (strpos($ggspamstatus, "Invalid") !== false ) {
						  echo '<div class="alert alert-error fade in">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<strong>Oh snap!</strong> Our spam checker detects that your message is spam.
						</div>';
						} else {
						  mysqli_query(getDbConnection(1), "INSERT INTO `comment` (`userid`, `time`, `name`, `comment`, `ip`) VALUES ('$idzers', '$datetime', '$namecomadm', '$msgcm', '$ipaddress')");
						  echo '<div class="alert alert-success fade in">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<strong>Success!</strong> Your message is now posted.
						</div>';
						  $commentfinaloutput = '<li class="cmmnt">
								<div class="avatar"><a href="javascript:void(0);"><img src="_include/img/profile/default.png" width="55" height="55" alt="photo avatar"></a></div>
								<div class="cmmnt-content">
									<header><a href="javascript:void(0);" class="userlink">'.$namecomad.'</a> - <span class="pubdate">'.$datetime.'</span></header>
									<p>'.$msgc.'</a></p>
								</div>
								</li>'.$commentfinaloutput;
						}
					  }
				}
			 }
			 
			  if (isset($_GET['rc'])) {
				$rc = $_GET['rc'];
				$rc = mysqli_real_escape_string(getDbConnection(1), $rc);
				$getsDB = mysqli_query(getDbConnection(1), "SELECT * FROM comment WHERE (ID='$rc')");
				if (mysqli_num_rows($getsDB) > 0) {
				  echo '<div class="alert alert-success fade in">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<strong>Success!</strong> Your report has been submited to the Curt Creation Staff Team.
						</div>';
				  mysqli_query(getDbConnection(1), "UPDATE comment SET report='true' WHERE ID='$rc'");
				} else {
				  echo '<div class="alert alert-error fade in">
						<a class="close" data-dismiss="alert" href="#">×</a>
						<strong>Oh snap!</strong> Your report has been not submited due to a database error.
						</div>';
				}
			  }
			?>
			
        	<div id="w">
				<div id="container">
				  <ul id="comments">
					
					<?php 
					if ($commentsection == false) {
						$commentfinaloutput = '<li class="cmmnt">
							<div class="avatar"><a href="javascript:void(0);"><img src="_include/img/profile/system.png" width="55" height="55" alt="photo avatar"></a></div>
							<div class="cmmnt-content">
								<header><a href="javascript:void(0);" class="userlink">System</a> - <span class="pubdate">notice</span></header>
								<p>This user disabled the comments.</a></p>
							</div>
							</li>';
					}
					
					if ($commentfinaloutput == "") {
						$commentfinaloutput = '<li class="cmmnt">
							<div class="avatar"><a href="javascript:void(0);"><img src="_include/img/profile/system.png" width="55" height="55" alt="photo avatar"></a></div>
							<div class="cmmnt-content">
								<header><a href="javascript:void(0);" class="userlink">System</a> - <span class="pubdate">notice</span></header>
								<p>No comments yet.</a></p>
							</div>
							</li>';
					}
					
					echo emojifeature($commentfinaloutput);
					?>
					
				  </ul>
				</div>
			  </div>
			  
			  <?php if ($commentsection != false) { ?>
			  
			  <form id="contact-form" class="contact-form" method="post" action="index.php?u=<?php echo $smallname; ?>#contact">
            	<p class="contact-name">
            		<input name="namer" id="name" type="text" placeholder="Your Name" value="" name="name">
                </p>
                <p class="contact-email">
                	<input name="message" id="message" type="text" placeholder="Message" value="">
                </p>
                <p class="contact-submit">
                	<input type="submit" name="submit" value="Post"> </input>
                </p>
			  <?php } ?>
			  
			  </form>
         
        </div>
       
    </div>
    <!-- End Contact Form -->
</div>
</div>
<!-- End Contact Section -->

<!-- Socialize -->
<div id="social-area" class="page">
	<div class="container">
    	<div class="row">
            <div class="span12">
                <nav id="social">
                    <ul>
						<?php 
							if ($facebook != "") {
								echo '<li><a href="'.$facebook.'" title="Follow Me on Facebook" target="_blank"><span class="font-icon-social-facebook"></span></a></li>';
							}
							
							if ($twitter != "") {
								echo '<li><a href="'.$twitter.'" title="Follow Me on Twitter" target="_blank"><span class="font-icon-social-twitter"></span></a></li>';
							}
						?>
						
                        
                    </ul>
                </nav>
            </div>
        </div>
    </div>
</div>
<!-- End Socialize -->

<!-- Footer -->
<footer>
	<p class="credits">&copy;2013-2016 Curt Creation.</p>
</footer>
<!-- End Footer -->

<!-- Back To Top -->
<a id="back-to-top" href="#">
	<i class="font-icon-arrow-simple-up"></i>
</a>
<!-- End Back to Top -->


<!-- Js -->
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script> <!-- jQuery Core -->
<script src="_include/js/bootstrap.min.js"></script> <!-- Bootstrap -->
<script src="_include/js/supersized.3.2.7.min.js"></script> <!-- Slider -->
<script src="_include/js/waypoints.js"></script> <!-- WayPoints -->
<script src="_include/js/waypoints-sticky.js"></script> <!-- Waypoints for Header -->
<script src="_include/js/jquery.isotope.js"></script> <!-- Isotope Filter -->
<script src="_include/js/jquery.fancybox.pack.js"></script> <!-- Fancybox -->
<script src="_include/js/jquery.fancybox-media.js"></script> <!-- Fancybox for Media -->
<script src="_include/js/jquery.tweet.js"></script> <!-- Tweet -->
<script src="_include/js/plugins.js"></script> <!-- Contains: jPreloader, jQuery Easing, jQuery ScrollTo, jQuery One Page Navi -->

<script>

jQuery(function($){

var BRUSHED = window.BRUSHED || {};

/* ==================================================
   Mobile Navigation
================================================== */
var mobileMenuClone = $('#menu').clone().attr('id', 'navigation-mobile');

BRUSHED.mobileNav = function(){
	var windowWidth = $(window).width();
	
	if( windowWidth <= 979 ) {
		if( $('#mobile-nav').length > 0 ) {
			mobileMenuClone.insertAfter('#menu');
			$('#navigation-mobile #menu-nav').attr('id', 'menu-nav-mobile');
		}
	} else {
		$('#navigation-mobile').css('display', 'none');
		if ($('#mobile-nav').hasClass('open')) {
			$('#mobile-nav').removeClass('open');	
		}
	}
}

BRUSHED.listenerMenu = function(){
	$('#mobile-nav').on('click', function(e){
		$(this).toggleClass('open');
		
		if ($('#mobile-nav').hasClass('open')) {
			$('#navigation-mobile').slideDown(500, 'easeOutExpo');
		} else {
			$('#navigation-mobile').slideUp(500, 'easeOutExpo');
		}
		e.preventDefault();
	});
	
	$('#menu-nav-mobile a').on('click', function(){
		$('#mobile-nav').removeClass('open');
		$('#navigation-mobile').slideUp(350, 'easeOutExpo');
	});
}


/* ==================================================
   Slider Options
================================================== */

BRUSHED.slider = function(){
	$.supersized({
		// Functionality
		slideshow               :   1,			// Slideshow on/off
		autoplay				:	1,			// Slideshow starts playing automatically
		start_slide             :   1,			// Start slide (0 is random)
		stop_loop				:	0,			// Pauses slideshow on last slide
		random					: 	0,			// Randomize slide order (Ignores start slide)
		slide_interval          :   12000,		// Length between transitions
		transition              :   1, 			// 0-None, 1-Fade, 2-Slide Top, 3-Slide Right, 4-Slide Bottom, 5-Slide Left, 6-Carousel Right, 7-Carousel Left
		transition_speed		:	300,		// Speed of transition
		new_window				:	1,			// Image links open in new window/tab
		pause_hover             :   0,			// Pause slideshow on hover
		keyboard_nav            :   1,			// Keyboard navigation on/off
		performance				:	1,			// 0-Normal, 1-Hybrid speed/quality, 2-Optimizes image quality, 3-Optimizes transition speed // (Only works for Firefox/IE, not Webkit)
		image_protect			:	1,			// Disables image dragging and right click with Javascript
												   
		// Size & Position						   
		min_width		        :   0,			// Min width allowed (in pixels)
		min_height		        :   0,			// Min height allowed (in pixels)
		vertical_center         :   1,			// Vertically center background
		horizontal_center       :   1,			// Horizontally center background
		fit_always				:	0,			// Image will never exceed browser width or height (Ignores min. dimensions)
		fit_portrait         	:   1,			// Portrait images will not exceed browser height
		fit_landscape			:   0,			// Landscape images will not exceed browser width
												   
		// Components							
		slide_links				:	'blank',	// Individual links for each slide (Options: false, 'num', 'name', 'blank')
		thumb_links				:	0,			// Individual thumb links for each slide
		thumbnail_navigation    :   0,			// Thumbnail navigation
		slides 					:  	[			// Slideshow Images
										<?php 
											if ($background1 != "") {
												?>
												{image : '<?php echo $background1; ?>', title : '<div class="slide-content"><?php echo $name; ?></div>', thumb : '', url : ''},
												<?php 
											} else {
												?>
												{image : '_include/img/dbackground_1.jpg', title : '<div class="slide-content"><?php echo $name; ?></div>', thumb : '', url : ''},
												<?php 
											}
										?>
										
										<?php 
											if ($background2 != "") {
												?>
												{image : '<?php echo $background2; ?>', title : '<div class="slide-content"><?php echo $thankyouecho; ?></div>', thumb : '', url : ''},
												<?php 
											} else {
												?>
												{image : '_include/img/dbackground_2.jpg', title : '<div class="slide-content"><?php echo $thankyouecho; ?></div>', thumb : '', url : ''},
												<?php 
											}
										?>
											
										<?php 
											if ($background3 != "") {
												?>
												{image : '<?php echo $background3; ?>', title : '<div class="slide-content"><?php echo $thanks; ?> Thanks</div>', thumb : '', url : ''},
												<?php 
											} else {
												?>
												{image : '_include/img/dbackground_3.jpg', title : '<div class="slide-content"><?php echo $thanks; ?> Thanks</div>', thumb : '', url : ''},
												<?php 
											}
										?>	
										
										<?php 
											if ($background4 != "") {
												?>
												{image : '<?php echo $background4; ?>', title : '<div class="slide-content">Thank Meter 7.0</div>', thumb : '', url : ''}  
												<?php 
											} else {
												?>
												{image : '_include/img/dbackground_4.jpg', title : '<div class="slide-content">Thank Meter 7.0</div>', thumb : '', url : ''}  
												<?php 
											}
										?>	
										
											
									],
									
		// Theme Options			   
		progress_bar			:	0,			// Timer for each slide							
		mouse_scrub				:	0
		
	});

}


/* ==================================================
   Navigation Fix
================================================== */

BRUSHED.nav = function(){
	$('.sticky-nav').waypoint('sticky');
}


/* ==================================================
   Filter Works
================================================== */

BRUSHED.filter = function (){
	if($('#projects').length > 0){		
		var $container = $('#projects');
		
		$container.imagesLoaded(function() {
			$container.isotope({
			  // options
			  animationEngine: 'best-available',
			  itemSelector : '.item-thumbs',
			  layoutMode : 'fitRows'
			});
		});
	
		
		// filter items when filter link is clicked
		var $optionSets = $('#options .option-set'),
			$optionLinks = $optionSets.find('a');
	
		  $optionLinks.click(function(){
			var $this = $(this);
			// don't proceed if already selected
			if ( $this.hasClass('selected') ) {
			  return false;
			}
			var $optionSet = $this.parents('.option-set');
			$optionSet.find('.selected').removeClass('selected');
			$this.addClass('selected');
	  
			// make option object dynamically, i.e. { filter: '.my-filter-class' }
			var options = {},
				key = $optionSet.attr('data-option-key'),
				value = $this.attr('data-option-value');
			// parse 'false' as false boolean
			value = value === 'false' ? false : value;
			options[ key ] = value;
			if ( key === 'layoutMode' && typeof changeLayoutMode === 'function' ) {
			  // changes in layout modes need extra logic
			  changeLayoutMode( $this, options )
			} else {
			  // otherwise, apply new options
			  $container.isotope( options );
			}
			
			return false;
		});
	}
}


/* ==================================================
   FancyBox
================================================== */

BRUSHED.fancyBox = function(){
	if($('.fancybox').length > 0 || $('.fancybox-media').length > 0 || $('.fancybox-various').length > 0){
		
		$(".fancybox").fancybox({				
				padding : 0,
				beforeShow: function () {
					this.title = $(this.element).attr('title');
					this.title = '<h4>' + this.title + '</h4>' + '<p>' + $(this.element).parent().find('img').attr('alt') + '</p>';
				},
				helpers : {
					title : { type: 'inside' },
				}
			});
			
		$('.fancybox-media').fancybox({
			openEffect  : 'none',
			closeEffect : 'none',
			helpers : {
				media : {}
			}
		});
	}
}


/* ==================================================
   Contact Form
================================================== */

BRUSHED.contactForm = function(){
	$("#contact-submit").on('click',function() {
		$contact_form = $('#contact-form');
		
		var fields = $contact_form.serialize();
		
		$.ajax({
			type: "POST",
			url: "_include/php/contact.php",
			data: fields,
			dataType: 'json',
			success: function(response) {
				
				if(response.status){
					$('#contact-form input').val('');
					$('#contact-form textarea').val('');
				}
				
				$('#response').empty().html(response.html);
			}
		});
		return false;
	});
}


/* ==================================================
   Twitter Feed
================================================== */

BRUSHED.tweetFeed = function(){
	
	var valueTop = -64; // Margin Top Value
	
    $("#ticker").tweet({
          modpath: '_include/js/twitter/',
          username: "Bluxart", // Change this with YOUR ID
          page: 1,
          avatar_size: 0,
          count: 10,
		  template: "{text}{time}",
		  filter: function(t){ return ! /^@\w+/.test(t.tweet_raw_text); },
          loading_text: "loading ..."
	}).bind("loaded", function() {
	  var ul = $(this).find(".tweet_list");
	  var ticker = function() {
		setTimeout(function() {
			ul.find('li:first').animate( {marginTop: valueTop + 'px'}, 500, 'linear', function() {
				$(this).detach().appendTo(ul).removeAttr('style');
			});	
		  ticker();
		}, 5000);
	  };
	  ticker();
	});
	
}


/* ==================================================
   Menu Highlight
================================================== */

BRUSHED.menu = function(){
	$('#menu-nav, #menu-nav-mobile').onePageNav({
		currentClass: 'current',
    	changeHash: false,
    	scrollSpeed: 750,
    	scrollOffset: 30,
    	scrollThreshold: 0.5,
		easing: 'easeOutExpo',
		filter: ':not(.external)'
	});
}

/* ==================================================
   Next Section
================================================== */

BRUSHED.goSection = function(){
	$('#nextsection').on('click', function(){
		$target = $($(this).attr('href')).offset().top-30;
		
		$('body, html').animate({scrollTop : $target}, 750, 'easeOutExpo');
		return false;
	});
}

/* ==================================================
   GoUp
================================================== */

BRUSHED.goUp = function(){
	$('#goUp').on('click', function(){
		$target = $($(this).attr('href')).offset().top-30;
		
		$('body, html').animate({scrollTop : $target}, 750, 'easeOutExpo');
		return false;
	});
}


/* ==================================================
	Scroll to Top
================================================== */

BRUSHED.scrollToTop = function(){
	var windowWidth = $(window).width(),
		didScroll = false;

	var $arrow = $('#back-to-top');

	$arrow.click(function(e) {
		$('body,html').animate({ scrollTop: "0" }, 750, 'easeOutExpo' );
		e.preventDefault();
	})

	$(window).scroll(function() {
		didScroll = true;
	});

	setInterval(function() {
		if( didScroll ) {
			didScroll = false;

			if( $(window).scrollTop() > 1000 ) {
				$arrow.css('display', 'block');
			} else {
				$arrow.css('display', 'none');
			}
		}
	}, 250);
}

/* ==================================================
   Thumbs / Social Effects
================================================== */

BRUSHED.utils = function(){
	
	$('.item-thumbs').bind('touchstart', function(){
		$(".active").removeClass("active");
      	$(this).addClass('active');
    });
	
	$('.image-wrap').bind('touchstart', function(){
		$(".active").removeClass("active");
      	$(this).addClass('active');
    });
	
	$('#social ul li').bind('touchstart', function(){
		$(".active").removeClass("active");
      	$(this).addClass('active');
    });
	
}

/* ==================================================
   Accordion
================================================== */

BRUSHED.accordion = function(){
	var accordion_trigger = $('.accordion-heading.accordionize');
	
	accordion_trigger.delegate('.accordion-toggle','click', function(event){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
		   	$(this).addClass('inactive');
		}
		else{
		  	accordion_trigger.find('.active').addClass('inactive');          
		  	accordion_trigger.find('.active').removeClass('active');   
		  	$(this).removeClass('inactive');
		  	$(this).addClass('active');
	 	}
		event.preventDefault();
	});
}

/* ==================================================
   Toggle
================================================== */

BRUSHED.toggle = function(){
	var accordion_trigger_toggle = $('.accordion-heading.togglize');
	
	accordion_trigger_toggle.delegate('.accordion-toggle','click', function(event){
		if($(this).hasClass('active')){
			$(this).removeClass('active');
		   	$(this).addClass('inactive');
		}
		else{
		  	$(this).removeClass('inactive');
		  	$(this).addClass('active');
	 	}
		event.preventDefault();
	});
}

/* ==================================================
   Tooltip
================================================== */

BRUSHED.toolTip = function(){ 
    $('a[data-toggle=tooltip]').tooltip();
}


/* ==================================================
	Init
================================================== */

BRUSHED.slider();

$(document).ready(function(){
	Modernizr.load([
	{
		test: Modernizr.placeholder,
		nope: '_include/js/placeholder.js', 
		complete : function() {
				if (!Modernizr.placeholder) {
						Placeholders.init({
						live: true,
						hideOnFocus: false,
						className: "yourClass",
						textColor: "#999"
						});    
				}
		}
	}
	]);
	
	// Preload the page with jPreLoader
	$('body').jpreLoader({
		splashID: "#jSplash",
		showSplash: true,
		showPercentage: true,
		autoClose: true,
		splashFunction: function() {
			$('#circle').delay(250).animate({'opacity' : 1}, 500, 'linear');
		}
	});
	
	BRUSHED.nav();
	BRUSHED.mobileNav();
	BRUSHED.listenerMenu();
	BRUSHED.menu();
	BRUSHED.goSection();
	BRUSHED.goUp();
	BRUSHED.filter();
	BRUSHED.fancyBox();
	BRUSHED.contactForm();
	BRUSHED.tweetFeed();
	BRUSHED.scrollToTop();
	BRUSHED.utils();
	BRUSHED.accordion();
	BRUSHED.toggle();
	BRUSHED.toolTip();
});

$(window).resize(function(){
	BRUSHED.mobileNav();
});

});



</script>
<!-- End Js -->

</body>
</html>