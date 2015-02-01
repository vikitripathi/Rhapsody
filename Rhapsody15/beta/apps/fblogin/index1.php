<?php
/*	FACEBOOK LOGIN BASIC - PHP SDK V4.0
 *	file 			- index.php
 * 	Developer 		- Abhishek Dutt
 *	Website			- http://rhapsody.org.in/apps/fblogin/ 
*/

define('FACEBOOK_SDK_V4_SRC_DIR', 'lib/Facebook/');
require __DIR__ . 'autoload.php';


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
	
	//1.Stat Session
	 session_start();

	 //check if users wants to logout
	 if(isset($_REQUEST['logout'])){
	 	unset($_SESSION['fb_token']);
	 }

	//2.Use app id,secret and redirect url
	 $app_id = '1613642472203244';
	 $app_secret = '87217cc5a128ebecd1311860fa88e529';
	 $redirect_url='http://rhapsody.org.in/beta/apps/fblogin/index1.php';
	 
	 //3.Initialize application, create helper object and get fb sess
	 FacebookSession::setDefaultApplication($app_id,$app_secret);
	 $helper = new FacebookRedirectLoginHelper($redirect_url);
	 $sess = $helper->getSessionFromRedirect();
	 //if the page is open first time by the viewer ,
	 // it would be a null value else some session value

	 //check if fb session exists
	 if(isset($_SESSION['fb_token'])){
	 	$sess=new FacebookSession($_SESSION['fb_token']);
	 }

	 $logout='http://rhapsody.org.in/beta/apps/fblogin/index1.php?logout=True';

	 //4. if fb session exists echo name 
	 	if(isset($sess)){
	 	//store the token in php session 
	 	$_SESSION['fb_token']=$sess->getToken();	
	 	//create request object,execute and capture response
		$request = new FacebookRequest($sess, 'GET', '/me');//me for self login
		// from response get graph object
		$response = $request->execute();
		$graph = $response->getGraphObject(GraphUser::className());
		// use graph object methods to get user details
		$name= $graph->getName();//graph  object to get name
		$id=$graph->getId();//facebook id
		$email=$graph->getProperty('email');

		echo "hi $name <br>";
		echo "your email is $email <br><Br>";
		//store the token in php session so that we need not authenticate again the same user for every refresh
		//to logout simply remove the token from the session 
		echo "<a href='".$logout."'><button>Logout</button></a>";
	}else{
		//else echo login using helper class or have a button show of login
		echo '<a href='.$helper->getLoginUrl().'>Login with facebook</a>';
	}



?>