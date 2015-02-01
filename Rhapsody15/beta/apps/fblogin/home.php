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

	 // see if we have a session in $_Session[]
	if( isset($_SESSION) && isset($_SESSION['token']))
	{
	    // We have a token, is it valid? 
	    // create new session from the stored access_token
	    $session = new FacebookSession($_SESSION['token']); 
	    // validate the access_token and ensure its validity
	    try
	    {
	       if(!$session->Validate($app_id ,$app_secret))
	       	$session='';
	    }
	    catch( FacebookAuthorizationException $ex)
	    {
	        // Session is not valid any more, get a new one.
	        $session ='';
	    }		
	}


	// if no session is found
	if ( !isset( $session ) || $session === null )
	{
		try {
		  $session = $helper->getSessionFromRedirect();
		  // process the response from Facebook with the getSessionFromRedirect() method,
		  // which returns a FacebookSession
		} catch( FacebookRequestException $ex ) {
		  // When Facebook returns an error
			echo $ex;
		} catch( Exception $ex ) {
		  // When validation fails or other local issues
			echo $ex;	
		}
	}


	//use of GET variable
	//$logout='http://rhapsody.org.in/beta/apps/fblogin/index.php?logout=True';

	// if it were a new session or the session got created as a result of "if no session found" either way
// set the tokens to bring about session management in terms of remembering and validating the token
	if ( isset( $session ) ) {
		//LOGGED in


		  // set the PHP Session 'token' to the current session token
	    $_SESSION['token'] = $session->getToken();

	    // graph api request for user data
	  $request = new FacebookRequest( $session, 'GET', '/me' );
	  $response = $request->execute();
	  // get response
	  $graphObject = $response->getGraphObject(GraphUser::className());
	  // use graph object methods to get user details
		$name= $graphObject->getName();//graph  object to get name
		$id=$graphObject->getId();//facebook id
		$email=$graphObject->getProperty('email');


		$request = new FacebookRequest($session,'GET','/me/picture',array (
      'redirect' => false,
      'height' => '150',
      'type' => 'normal',
      'width' => '150',
      )
    );
		 $response = $request->execute();
    $graph_user_pic = $response->getGraphObject(GraphUser::className());

    	echo '<br /><img src="'.$graph_user_pic->getProperty('url').'"/></td><td>';
		echo "hi $name <br>";
		echo "your email is $email <br><Br>";
	  // print data
	  
	  //echo '<pre>' . print_r( $graphObject, 1 ) . '</pre>';

	    // SessionInfo 
	    $info = $session->getSessionInfo();  
	    // getAppId
	    //echo "Appid: " . $info->getAppId() . "<br />"; 
	    // session expire data
	    $expireDate = $info->getExpiresAt()->format('Y-m-d H:i:s');
	    //echo 'Session expire time: ' . $expireDate . "<br />"; 
	    // session token
	    echo 'Session Token: ' . $session->getToken() . "<br />"; 
	    echo '<br /><a href="' . $helper->getLogoutUrl( $session, 'http://rhapsody.org.in/beta/apps/fblogin/index.php') . '">Logout</a>';
	    //echo "<a href='".$logout."'><button>Logout</button></a>";
	} else {
	  // show login url (use in facebook signup button)
	//Generate the login URL to redirect visitors to with the getLoginUrl() method	
	  echo '<a href="' . $helper->getLoginUrl(array( 'email', 'user_friends' )) . '">Login</a>';
	  echo "Hi !!! <br>
	  		It lloks that you are not logged in <br>
	  		please log in to avail the features our app!!";
	}




?>