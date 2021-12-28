<?php 
error_reporting(0);
header("Content-Type: image/png");
require ("core/functions.php");
$font = "fonts/default.ttf";

$ip = getIPAddress();

if (isset($_GET['u'])){
	$user = $_GET['u'];
} else {
	$user = null;
}

$imagecontainer = imagecreatetruecolor(450,80);
imagesavealpha($imagecontainer, true);
$alphacolor = imagecolorallocatealpha($imagecontainer, 0,0,0,127);
imagefill($imagecontainer,0,0,$alphacolor);

$color = imagecolorallocate($imagecontainer, 255, 255, 255);
$black = imagecolorallocate($imagecontainer, 255, 255, 255);
$blacks = imagecolorallocate($imagecontainer, 0, 0, 0);
$online = imagecolorallocate($imagecontainer, 0, 255, 0);
$offline = imagecolorallocate($imagecontainer, 255, 0, 0);

if (isDBOffline("connection") == true) {
	$background = imagecreatefrompng('img_contents/error901.png');
	imagecopyresampled($imagecontainer, $background, 0, 0, 0, 0,450,80,450,80);
	imagepng($imagecontainer);
	imagedestroy($imagecontainer);
	return;
}

if(checkMaintenance() == true) {
	imagettftextoutline( $imagecontainer, 15, 0, 10, 30, $offline, $color, $font, "Mainteance", 1);
	imagettftextoutline( $imagecontainer, 15, 0, 10, 50, $offline, $color, $font, "Reason:", 1);
	imagettftextoutline( $imagecontainer, 15, 0, 10, 70, $offline, $color, $font, getMaintenanceReason(), 1);
	imagepng($imagecontainer);
	imagedestroy($imagecontainer);
	return;
}

if (isset($_GET['u'])){
	$getname = mysqli_query(getDbConnection(1),"SELECT * FROM users");
	$getDB = mysqli_query(getDbConnection(1),"SELECT * FROM users WHERE (smallname='".$user."' OR ID='".$user."') ");
				
	if(mysqli_num_rows($getDB) > 0){
		$getArray = mysqli_fetch_array($getDB);
		$idzers = $getArray['ID'];
		$smallname = $getArray['smallname'];
		$igname = $getArray['igname'];
		$name = $getArray['name'];
		$meter = $getArray['thanksmeter'];
		$image_metersize = $getArray['image_metersize'];
		$x_meterpos = $getArray['x_meterpos'];
		$y_meterpos = $getArray['y_meterpos'];
		$x_onoffpos = $getArray['x_onoffpos'];
		$y_onoffpos = $getArray['y_onoffpos'];
		$size_onlineoff = $getArray['size_onlineoff'];
		$isBanned = $getArray['isBanned'];
		$since_online = $getArray['since_online'];
		$fss = $getArray['font'];
		$ip_used = $getArray['ip_used'];
		$cacheplrdata = $getArray['cache_player'];
		$showstatsonsig = $getArray['showstatsonsig'];

		 if ($isBanned == "true") {
			$background = imagecreatefrompng('img_contents/error902.png');
			imagecopyresampled($imagecontainer, $background, 0, 0, 0, 0,450,80,450,80);
			imagepng($imagecontainer);
			return;
		} elseif ($isBanned == "delete") {
			$background = imagecreatefrompng('img_contents/error900.png');
			imagecopyresampled($imagecontainer, $background, 0, 0, 0, 0,450,80,450,80);
			imagepng($imagecontainer);
			return;
		}

		$mfont = '/fonts/default.ttf';
		$x_name = 70;
		$y_name = 45;
		
		$fileimage ="local_data/".$smallname;
		$isGroup = "false";

		$ggcokkie = $_COOKIE[$idzers."_anticheat"];
		if(strpos($ip_used, $ip) == true  || $ggcokkie == "true"){
			$background = imagecreatefrompng("$fileimage/false.png");
		} else {
			$background = imagecreatefrompng("$fileimage/true.png");
		}

		imagecopyresampled($imagecontainer, $background, 0, 0, 0, 0,450,80,450,80);
		
		if ($showstatsonsig == "true") {
		
			$random = mt_rand(1,2);
			$autogen = array();
			$autogen["name"] = getPlayerInfo($igname, "name", true, $idzers);
			$autogen["gang"] = getPlayerInfo($igname, "gang", true, $idzers);
			$autogen["squad"] = getPlayerInfo($igname, "squad", true, $idzers);
			$autogen["playtime"] = getPlayerInfo($igname, "playtime", true, $idzers);
			$autogen["cash"] = getPlayerInfo($igname, "cash", true, $idzers);
			$autogen["wanted"] = getPlayerInfo($igname, "wanted", true, $idzers);
			$autogen["occupation"] = getPlayerInfo($igname, "occupation", true, $idzers);
			$autogen["country"] = getPlayerInfo($igname, "country", true, $idzers);
			
			if ($random == 1) {
				$valuea =  "Money: $".number_format($autogen["cash"])." | PlayTime: ".number_format($autogen["playtime"])."H | "."Occupation: ".$autogen["occupation"];
			} elseif ($random == 2) {
				$valuea = "Group: ".$autogen['gang']." | Squad: ".$autogen['squad']." | "."Country: ".$autogen["country"];
			} else {
				$valuea = "None";
			}
			imagettftextoutline( $imagecontainer, 9, 0, 12, 21, $black, $blacks, $font, $valuea, 1);
			
		}
		
		if (isPlayerOnline ($igname) == "Online") {
			imagettftextoutline( $imagecontainer, $size_onlineoff, 0, $x_onoffpos, $y_onoffpos, $online, $blacks, $font, isPlayerOnline ($igname), 1);
		} else {
			imagettftextoutline( $imagecontainer, $size_onlineoff, 0, $x_onoffpos, $y_onoffpos, $offline, $blacks, $font, duration($since_online)." Ago", 1);
		}
		imagettftextoutline( $imagecontainer, $image_metersize, 0, $x_meterpos, $y_meterpos, $black, $blacks, $font, $meter, 1);
	} else {
		$background = imagecreatefrompng('img_contents/error900.png');
		imagecopyresampled($imagecontainer, $background, 0, 0, 0, 0,450,80,450,80);
	}
}
$imagessss = imagepng($imagecontainer);
imagedestroy($imagecontainer);

?>
