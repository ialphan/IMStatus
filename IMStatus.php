<?php
	/* Alphan Gunaydin | ialphan.com | @ialphan */

	//	Needed for Facebook: https://developers.facebook.com/docs/reference/php/
	require_once "facebook/facebook.php";

	//	Needed for GTalk: https://code.google.com/p/xmpphp/
	require_once("XMPPHP/XMPP.php");


	//	Get AIM status.
	function getAIMStatus($screenName){
		$c = curl_init();
		$url = "http://big.oscar.aol.com/$screenName?on_url=true&off_url=false";
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_HEADER, 1);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$result	= curl_exec($c);
		curl_close($c);

		echo "AIM: " . (eregi("true", $result) ? "Online" : "Offline") . "<br>";
	}

	//	Get Facebook status.
	function getFacebookStatus($appID, $appSecret){
		$facebook = new Facebook(array(
			"appId"  => $appID,
			"secret" => $appSecret,
			"allowSignedRequest" => false
		));
		$facebook->setExtendedAccessToken();
		if($facebook->getUser()){
			$uid = $facebook->getUser();
			$query = "SELECT online_presence FROM user WHERE uid = $uid";
			$result = $facebook->api(array("method" => "fql.query", "query" => $query, "callback" => ""));

			echo "Facebook: " . ($result[0]["online_presence"] !== "offline" ? "Online" : "Offline") . "<br>";
		}else{
			//	Incase you didn't set it in your app settings.
			$loginUrl = $facebook->getLoginUrl(array(
				"scope" => "user_online_presence"
			));

			echo "Facebook: Requires initial <a href=" . $loginUrl . ">login</a><br>";
		}
	}

	//	Get GTalk status.
	function getGTalkStatus($screenName, $password){
		//	Thanks to @lwitzel for getPresence(): http://stackoverflow.com/questions/16329449/xmpphp-gtalk-status
		$connection = new XMPPHP_XMPP("talk.google.com", 5222, $screenName, $password, "xmpphp", "gmail.com", $printlog = false, $loglevel = XMPPHP_Log::LEVEL_INFO);

		if($screenName !== "XXX" || $password !== "YYY"){
			$connection->connect();
			$connection->processUntil("session_start");
			$connection->presence($status = "Controller available.");
			$connection->processTime(2);
			$roster = $connection->roster->getRoster();
			$status = $connection->roster->getPresence($screenName);

			echo "GTalk: " . (!empty($status["show"]) ? "Online" : "Offline") . "<br>";
		}else{
			//	Needed for Demo.
			echo "GTalk: Offline <br>";
		}
	}

	//	Get ICQ status.
	function getICQStatus($icqNumber){
		$c = curl_init();
		$url = "http://web.icq.com/whitepages/online?icq=" . $icqNumber;
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_HEADER, 1);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($c, CURLOPT_FOLLOWLOCATION, true);
		$result	= curl_exec($c);
		curl_close($c);

		echo "ICQ: " . (eregi("/0/online1.gif", $result) ? "Online" : "Offline") . "<br>";
	}

	//	Get Skype status.
	function getSkypeStatus($userName){
		$c = curl_init();
  	$url = "http://mystatus.skype.com/".$userName.".xml";
  	curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_HEADER, 1);
  	curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
	  $result = curl_exec($c);
  	curl_close($c);
		preg_match('/xml:lang="NUM">(.*)</', $result, $match);

		echo "SKYPE: " . ($match[1] == "2" ? "Online" : "Offline") . "<br>";
	}

	//	Get YAHOO status.
	function getYAHOOStatus($userName){
		$c = curl_init();
		$url = "http://opi.yahoo.com/online?u=$userName&m=t";
		curl_setopt($c, CURLOPT_URL, $url);
		curl_setopt($c, CURLOPT_HEADER, 1);
		curl_setopt($c, CURLOPT_RETURNTRANSFER, 1);
		$result	= curl_exec($c);
		curl_close($c);

		echo "YAHOO: " . (strpos($result, "NOT ONLINE") ? "Offline" : "Online") . "<br>";
	}

	//	Get AIM status: replace XXX with your AIM username.
	getAIMStatus(XXX);

	//	Get Facebook status: replace XXX with your appID, YYY with your appSecret.
	//	Note: Facebook requires an 1) application to be created and 2) user_online_presence (chat status) as permission
	//	to be granted then user needs to 3) login with using the app's settings.
	getFacebookStatus(XXX, YYY);

	//	Get GTalk status: replace XXX with you GTalk handle (abc@gmail.com) and YYY with you password.
	getGTalkStatus("XXX", "YYY");

	//	Get ICQ status: replace XXX with your ICQ number.
	getICQStatus(XXX);

	//	Get Skype status: replace XXX with your Skype username.
	getSkypeStatus(XXX);

	//	Get YAHOO status: replace XXX with your YAHOO username.
	getYAHOOStatus(XXX);
?>
