<?php
ini_set("soap.wsdl_cache_enabled","0");

class User
{
	public $username;
	public $password;
	public $email;
	
	public function setUsersStatus($username,$pstatus=0)
	{
		if( !empty($username) ){		
			$con = mysqli_connect("localhost", "root", "", "userservice");
			try {
				$sql = "update users set status=".$pstatus." where username='".$username."'";
		        $result=$con->prepare($sql);
		        $result->execute();
		} catch (Exception $e) {}
		}
		mysqli_close($con);
	return flase;
	}


	public function save($user)
	{
		if( !empty($user->username) && !empty($user->password) && !empty($user->email)
		){		
		$con = mysqli_connect("localhost", "root", "", "userservice");
		try {
			$sql = "INSERT INTO users (username, password,email) VALUES ('".$user->username."','".$user->password."','".$user->email."')";
	          $result=$con->prepare($sql);
	        $result->execute();
	        return true;
		} catch (Exception $e) {}
		}
		mysqli_close($con);
	return flase;
	}

	public function get($username)
	{
		$con = mysqli_connect("localhost", "root", "", "userservice");
		try {
			$sql = "select username,email,password from users where username='".$username."'";
	          $result=$con->query($sql);
	        $row=$result->fetch_array(MYSQLI_ASSOC);
		} catch (Exception $e) {}
		mysqli_close($con);
		return json_encode($row);
	}

}

/**
 * @method PUT
 * @param User (object)
 * @return status_code 0
 */
function addUser($user)
{	
	$usename=new User();
	$usename->save($user);
	return 0;
}


/**
 * @method POST
 * @param username (string)
 * @return status_code 0
 */
function activateUser($username)
{
	$usename=new User();
	$usename->setUsersStatus($username,true);
	return 0;
}

/**
 * @method POST
 * @param username (string)
 * @return status_code 0
 */
function desactivateUser($username)
{
	$usename=new User();
	$usename->setUsersStatus($username,0);
	return 0;
}

/**
 * @method GET
 * @param username 
 * @return User (object)
 */
function getUser($username)
{
	$usename=new User();
	return $usename->get($username);
}

$server=new SoapServer("acl.wsdl",[
	'classmap'=>[
		'user'=>'User',
	]
]);

$server->addFunction('addUser');
$server->addFunction('activateUser');
$server->addFunction('desactivateUser');
$server->addFunction('getUser');
$server->handle();