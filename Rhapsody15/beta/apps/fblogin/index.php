<?php
/*	FACEBOOK LOGIN BASIC - PHP SDK V4.0
 *	file 			- index.php
 * 	Developer 		- Abhishek Dutt
 *	Website			- http://rhapsody.org.in/apps/fblogin/ 
*/

	//1.Stat Session
session_start();
 

//require_once 'autoload.php';


// define('FACEBOOK_SDK_V4_SRC_DIR', 'lib/Facebook/');
// require __DIR__ . 'autoload.php';



set_include_path(get_include_path() . PATH_SEPARATOR . 'lib');
/* INCLUSION OF LIBRARY FILEs*/
	require_once( 'lib/Facebook/FacebookSession.php');
	require_once( 'lib/Facebook/FacebookRequest.php' );
	require_once( 'lib/Facebook/FacebookResponse.php' );
	require_once( 'lib/Facebook/FacebookSDKException.php' );
	require_once( 'lib/Facebook/FacebookRequestException.php' );
	require_once( 'lib/Facebook/FacebookRedirectLoginHelper.php');
	require_once( 'lib/Facebook/FacebookAuthorizationException.php' );
	require_once( 'lib/Facebook/GraphObject.php' );
	require_once( 'lib/Facebook/GraphUser.php' );
	require_once( 'lib/Facebook/GraphSessionInfo.php' );
	require_once( 'lib/Facebook/Entities/AccessToken.php');
	require_once( 'lib/Facebook/HttpClients/FacebookCurl.php' );
	require_once( 'lib/Facebook/HttpClients/FacebookHttpable.php');
	require_once( 'lib/Facebook/HttpClients/FacebookCurlHttpClient.php');


/* USE NAMESPACES */
	
	use Facebook\FacebookSession;
	use Facebook\FacebookRedirectLoginHelper;
	use Facebook\FacebookRequest;
	use Facebook\FacebookResponse;
	use Facebook\FacebookSDKException;
	use Facebook\FacebookRequestException;
	use Facebook\FacebookAuthorizationException;
	use Facebook\GraphObject;
	use Facebook\GraphUser;
	use Facebook\GraphSessionInfo;
	use Facebook\FacebookHttpable;
	use Facebook\FacebookCurlHttpClient;
	use Facebook\FacebookCurl;



/*PROCESS*/
	

	 //check if users wants to logout
	 // if(isset($_REQUEST['logout'])){
	 // 	unset($_SESSION['token']);
	 // }

	//2.Use app id,secret and redirect url
	 $app_id = '1613642472203244';
	 $app_secret = '87217cc5a128ebecd1311860fa88e529';
	 $redirect_url='http://rhapsody.org.in/beta/apps/fblogin/home.php';
	 
	 //3.Initialize application, create helper object and get fb sess
	 FacebookSession::setDefaultApplication($app_id,$app_secret);

	// Use one of the helper classes to get a FacebookSession object.
	//   FacebookRedirectLoginHelper
	//   FacebookCanvasLoginHelper		
	//   FacebookJavaScriptLoginHelper
	// or create a FacebookSession with a valid access token:

	 $helper = new FacebookRedirectLoginHelper($redirect_url);

	
	  echo '<a href="' . $helper->getLoginUrl(array( 'email', 'user_friends' )) . '">Login</a>';
	  echo "Hi !!! <br>
	  		It lloks that you are not logged in <br>
	  		please log in to avail the features our app!!";
	



?>