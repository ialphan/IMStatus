#IMStatus
Get the instant messenger status(online, offline) of the specified user for a specific service (AIM, Facebook, GTalk, ICQ, Skype, YAHOO) in PHP.

<br>
##Supported IM Services
*	**getAIMStatus($screenName)** for AIM where **$screenName** is the screenname.
*	**getFacebookStatus($appID, $appSecret)** for Facebook where **$appID** is the application id and **$appSecret** is the application secret. It requires: 
	* Application to be created,
	* user_online_presence (chat status) as permission to be granted, 
	* Login using the app's settings.
*	**getGTalkStatus($screenName, $password)** for GTalk where **$screenName** is the GTalk handle (e.g. abc@gmail.com) and **$password** is the password for that handle.
*	**getICQStatus($icqNumber)** for ICQ where **$icqNumber** is the ICQ number.
*	**getSkypeStatus($userName)** for Skype where **$userName** is the username.
*	**getYAHOOStatus($userName)** for YAHOO where **$userName** is the username.

<br>
##Usage
Call the desired service's function with required parameter(s).

<br>

	Ex. getAIMStatus(AlphanGunaydin);

	This will print out:
	AIM: <Online | Offline>
	
	
![screenshot][1]

[1]: screenshot_0.1.png "Screenshot"

<br>
##Language
PHP.

<br>
##History

**v0.1 - 2014-02-21**

  * Initial commit.
  * Added README.md.
