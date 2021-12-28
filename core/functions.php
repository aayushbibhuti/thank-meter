<?php 
	require ("configuration.php");
	require ("spamchecker.php");
	
	//Database
	function getDbConnection ($number) {
		if ($numer = 2) {
			$db = mysqli_connect(db_host, db_user, db_pass, db_database2);
			if (!$db) { return false; }
			return $db;
		} else {
			$db = mysqli_connect(db_host, db_user, db_pass, db_database);
			if (!$db) { return false; }
			return $db;
		}
	}
	//End of Database 

	//Remove Tags Funcs
	function removeTags($str) {
		$str = preg_replace("#<(.*)/(.*)>#iUs", "", $str);
		return $str;
	}
	//End of Remve Tags Funcs
	
	//Get IP Address
	function getIPAddress() {
		if (isset($_SERVER["HTTP_CF_CONNECTING_IP"])) {
			return $_SERVER["HTTP_CF_CONNECTING_IP"];
		} else {
			return $_SERVER["REMOTE_ADDR"];
		}
	}
	//End of Get IP Address 
	
	//Database Connection Checker 
	function isDBOffline($adaptor) {
		if (!$adaptor) { return true; }
		if ($adaptor == "connection") {
			if (getDbConnection(1) == false) {
				return true;
			} else {
				return false;
			}
		} elseif ($adaptor == "connection2") {
			if (getDbConnection(2) == false) {
				return true;
			} else {
				return false;
			}
		}
	}
	//End of Database Connection Checker 

	
	//Get Player Cache Data
	function getPlayerCacheDataToImg ($playername) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'CIT_API');
		curl_setopt($ch, CURLOPT_URL, "http://aayushbibhuti.com/api/ab.php?search&name=".$playername);
		$data = curl_exec($ch);
		curl_close($ch);
		$array = json_decode($data, true);
		if(isset($array['_ERROR']) && $array['_ERROR'] == '004:Not found!') {
			return false;
		} elseif (isset($array['COUNT_RESULTS']) && $array['COUNT_RESULTS'] == 1) {
			$random = mt_rand(1,2);
			if ($random == 1) {
				return "Money: $".number_format($array['RESULTS'][0]['cash'])." | PlayTime: ".number_format($array['RESULTS'][0]['playtime'])."H | "."Occupation: ".$array['RESULTS'][0]['occupation'];
			} elseif ($random == 2) {
				return "Group: ".$array['RESULTS'][0]['gang']." | Squad: ".$array['RESULTS'][0]['squad']." | "."Country: ".$array['RESULTS'][0]['country'];
			}

		} elseif (isset($array['COUNT_RESULTS']) && $array['COUNT_RESULTS'] > 1) {
			$random = mt_rand(1,2);
			if ($random == 1) {
				return "Money: $".number_format($array['RESULTS'][0]['cash'])." | PlayTime: ".number_format($array['RESULTS'][0]['playtime'])."H | "."Occupation: ".$array['RESULTS'][0]['occupation'];
			} elseif ($random == 2) {
				return "Group: ".$array['RESULTS'][0]['gang']." | Squad: ".$array['RESULTS'][0]['squad']." | "."Country: ".$array['RESULTS'][0]['country'];
			}
		} else {
			return false;
		}
	}
	//End of Get Player Cache Data 
	
	//Get player information from API or Cache
	function getPlayerInfo ($nickname, $for, $autosave = false, $tmid = 0, $group = false, $squad = false) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'CIT_API');
		
		if ($group != false && $squad != false) {
			curl_setopt($ch, CURLOPT_URL, "http://aayushbibhuti.com/api/ab.php?search&name=$nickname&squad=$squad&group=$group");
		} elseif ($group != true && $squad != false) {
			curl_setopt($ch, CURLOPT_URL, "http://aayushbibhuti.com/api/ab.php?search&name=$nickname&squad=$squad");
		} elseif ($group != false && $squad != true) {
			curl_setopt($ch, CURLOPT_URL, "http://aayushbibhuti.com/api/ab.php?search&name=$nickname&group=$group");
		} else {
			curl_setopt($ch, CURLOPT_URL, "http://aayushbibhuti.com/api/ab.php?search&name=$nickname");
		}
		
		$data = curl_exec($ch);
		curl_close($ch);
		$array = json_decode($data, true);
		
		if(isset($array['_ERROR']) && $array['_ERROR'] == '004:Not found!') {
			
			if ($autosave == true) {
				$tmid = mysqli_real_escape_string (getDbConnection(1), $tmid);
				$getDB = mysqli_query(getDbConnection(1),"SELECT ID,cache_player FROM users WHERE id=$tmid");
				if (mysqli_num_rows($getDB) > 0){
					$getArray = mysqli_fetch_array($getDB);
					$cache = $getArray['cache_player'];
					$array = json_decode($cache, true);
					return $array['RESULTS'][0][$for];
				}
				return false;
			}
			
		} elseif (isset($array['COUNT_RESULTS']) && $array['COUNT_RESULTS'] == 1) {
			
			if ($autosave == true) {
				$tmid = mysqli_real_escape_string (getDbConnection(1), $tmid);
				$data = mysqli_real_escape_string(getDbConnection(1), $data);
				mysqli_query(getDbConnection(1),"UPDATE users SET cache_player='$data' WHERE id=$tmid");
				mysqli_query(getDbConnection(1),"UPDATE users SET since_online='".time()."' WHERE id=$tmid");
			}
			return $array['RESULTS'][0][$for];
			
		} elseif (isset($array['COUNT_RESULTS']) && $array['COUNT_RESULTS'] > 1) {
			return false;
		}
	}
	//End of Get player information from API or Cache
	
	//Is Player online 
	function isPlayerOnline ($playername) {
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_USERAGENT, 'CIT_API');
		curl_setopt($ch, CURLOPT_URL, "http://aayushbibhuti.com/api/ab.php?search&name=".$playername);
		$data = curl_exec($ch);
		curl_close($ch);
		$array = json_decode($data, true);
		if(isset($array['_ERROR']) && $array['_ERROR'] == '004:Not found!')
		return "Offline";
		else if(isset($array['COUNT_RESULTS']) && $array['COUNT_RESULTS'] == 1)
		return "Online";
		else if(isset($array['COUNT_RESULTS']) && $array['COUNT_RESULTS'] > 1)
		return "Online";
		else
		return "Error";
	}
	//End of is player online 
	
	//Image Outline 
	function imagettftextoutline(&$im,$size,$angle,$x,$y,&$col,&$outlinecol,$fontfile,$text,$width) {
		for ($xc=$x-abs($width);$xc<=$x+abs($width);$xc++) {
				for ($yc=$y-abs($width);$yc<=$y+abs($width);$yc++) {
						$text1 = imagettftext($im,$size,$angle,$xc,$yc,$outlinecol,$fontfile,$text);
				}
		}
		$text2 = imagettftext($im,$size,$angle,$x,$y,$col,$fontfile,$text);
	}
	//End of Image Outline 
	
	
	//Check Maintenance
	function checkMaintenance() {
		if (isDBOffline("connection") == true) { return false; }
		$getDB = mysqli_query(getDbConnection(1), "SELECT * FROM settings WHERE id='3'");
		if(mysqli_num_rows($getDB) > 0){
			$getArray2 = mysqli_fetch_array($getDB);
			$hoz2 = $getArray2['value'];
			if ($hoz2 == "true") {
				return true;
			} else {
				return false;
			}
		}
	}
	//End of Check Maintenance 
	
	//Thank Meter Data (OverAll)
	function getGlobalStatistics ($type) {
		if (isDBOffline("connection") == true) { return false; }
		if ($type == "members"){
			$result = mysqli_query(getDbConnection(1), "SELECT * FROM users");
			$rows = mysqli_fetch_array($result);
			$addersss = 0;
			$howmany = 0;
			while($row = mysqli_fetch_array($result)) {
				if ($row["isBanned"] == "true" || $row["isBanned"] == "delete") {
					$lozl = 0;
				} else {
					$addersss = $row['thanksmeter']+$addersss;
					$howmany++;
				}
			}
			return $howmany+1;
		} elseif ($type == "comments") {
			$result = mysqli_query(getDbConnection(1),"SELECT * FROM comment");
			$rows = mysqli_fetch_array($result);
			$addersss = 0;
			$howmany = 0;
			while($row = mysqli_fetch_array($result)) {
				$howmany++;
			}
			return number_format($howmany+1);
		}
	}
	//End of Thank Meter Data (OverAll)
	
	//Statistics Record 
	function statisticsUpdate($type) {
		if (isDBOffline("connection2") == true) { return false; }
		if ($type == "page") {
			$getDB1 = mysqli_query(getDbConnection(2),"SELECT * FROM settings WHERE id='1'");
			if(mysqli_num_rows($getDB1) > 0){
				$getArray1 = mysqli_fetch_array($getDB1);
				$hoz = $getArray1['value'];
				$hozz = 1 + intval($hoz);
				mysqli_query(getDbConnection(2),"UPDATE settings SET value='".$hozz."' WHERE id='1'");
				return true;
			}
		} elseif ($type == "image") {
			$getDB1 = mysqli_query(getDbConnection(2),"SELECT * FROM settings WHERE id='2'");
			if(mysqli_num_rows($getDB1) > 0){
				$getArray1 = mysqli_fetch_array($getDB1);
				$hoz = $getArray1['value'];
				$hozz = 1 + intval($hoz);
				mysqli_query(getDbConnection(2),"UPDATE settings SET value='".$hozz."' WHERE id='2'");
				return true;
			}
		} else {
			return false;
		}
	}
	//End of Statistics Record
	
	//Emoji Features
	function emojifeature ($text) {
		$text = str_replace(":)", "<img src='/_include/img/emojis/smiley.gif' height='16' wieght='16'>", $text);
		$text = str_replace(";)", "<img src='/_include/img/emojis/wink.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":D", "<img src='/_include/img/emojis/cheesy.gif' height='16' wieght='16'>", $text);
		$text = str_replace(";D", "<img src='/_include/img/emojis/grin.gif' height='16' wieght='16'>", $text);
		$text = str_replace(">:(", "<img src='/_include/img/emojis/agnry.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":(", "<img src='/_include/img/emojis/sad.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":o", "<img src='/_include/img/emojis/shocked.gif' height='16' wieght='16'>", $text);
		$text = str_replace("8)", "<img src='/_include/img/emojis/cool.gif' height='16' wieght='16'>", $text);
		$text = str_replace("???", "<img src='/_include/img/emojis/huh.gif' height='16' wieght='16'>", $text);
		$text = str_replace("::)", "<img src='/_include/img/emojis/rolleyes.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":P", "<img src='/_include/img/emojis/tongue.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":P", "<img src='/_include/img/emojis/tongue.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":-[", "<img src='/_include/img/emojis/embarrased.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":-X", "<img src='/_include/img/emojis/lipsrsealed.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":-/", "<img src='/_include/img/emojis/undecided.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":-*", "<img src='/_include/img/emojis/kiss.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":'(", "<img src='/_include/img/emojis/cry.gif' height='16' wieght='16'>", $text);
		$text = str_replace("<3", "<img src='/_include/img/emojis/love.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":fp:", "<img src='/_include/img/emojis/fp.gif' height='16' wieght='16'>", $text);
		$text = str_replace(":thumb:", "<img src='/_include/img/emojis/thumb.png' height='16' wieght='16'>", $text);
		
		return $text;
	}
	//End of Emoji Features 
	
	//Number Format 
	function format($number) {
		$prefixes = 'kMGTPEZY';
		if ($number >= 1000) {
			$log1000 = floor(log10($number)/3);
			return floor($number/pow(1000, $log1000)).$prefixes[$log1000-1];
		}
		return $number;
	}
	//End of Number Format
	
	//Data Encryption 
	function encrypt_decrypt($action, $string) {
		$output = false;

		$encrypt_method = "AES-256-CBC";
		$secret_key = 'This is my secret key';
		$secret_iv = 'This is my secret iv';

		// hash
		$key = hash('sha256', $secret_key);

		// iv - encrypt method AES-256-CBC expects 16 bytes - else you will get a warning
		$iv = substr(hash('sha256', $secret_iv), 0, 16);

		if( $action == 'encrypt' ) {
			$output = openssl_encrypt($string, $encrypt_method, $key, 0, $iv);
			$output = base64_encode($output);
		}
		else if( $action == 'decrypt' ){
			$output = openssl_decrypt(base64_decode($string), $encrypt_method, $key, 0, $iv);
		}

		return $output;
	}
	//End of Data Encryption 
	
	//Duration
	function duration($start){
	$end = time();
    $timestamp = $end - $start;
    $years = floor($timestamp / (60 * 60 * 24 * 360));
    $timestamp %= (60 * 60 * 24 * 360);

    $months = floor($timestamp / (60 * 60 * 24 * 30));
    $timestamp %= (60 * 60 * 24 * 30);

    $weeks = floor($timestamp / (60 * 60 * 24 * 7));
    $timestamp %= (60 * 60 * 24 * 7);

    $days = floor($timestamp / (60 * 60 * 24));
    $timestamp %= (60 * 60 * 24);

    $hours = floor($timestamp / (60 * 60));
    $timestamp %= (60 * 60);

    $mins = floor($timestamp / 60);
    $secs = $timestamp % 60;
	
    if($years >= 6)
        return $years."Y";
    elseif($years >= 1)
        return $years."Y";
    elseif($months >= 7)
        return $months."M";
    elseif($months >= 1)
        return $months."M";
    elseif($weeks >= 3)
        return $weeks."W";
    elseif($weeks >= 1)
        return $weeks."W";
    elseif($days >= 4)
        return $days."D";
    elseif($days >= 1)
        return $days."D";
    elseif($hours >= 7)
        return $hours."H";
    elseif($hours >= 1)
        return $hours."H";
    elseif($mins >= 16)
        return $mins."S";
    elseif($mins >= 1)
        return $mins."S";
    else
        return $secs."S";
	}
	//End of Duration 
?>