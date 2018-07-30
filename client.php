<?php
// model
class User
{
	public $username;
	public $password;
	public $email;
	public $status;
}

// create instance and set a book name
$user=new User();
$user->username="username1";
$user->password="username1";
$user->email="username1@mail.com";

// initialize SOAP client and call web service function
$client=new SoapClient('http://localhost/server/server.php?wsdl',['soap_version'=>SOAP_1_1,'trace'=>0,'cache_wsdl'=>WSDL_CACHE_NONE]);

echo "<p>Method::addUser</p>";
$resp  =$client->addUser($user);
var_dump($resp);

echo "<p>Method::activateUser</p>";
$resp  =$client->activateUser($user->username);
var_dump($resp);


echo "<p>Method::desactivateUser</p>";
$resp  =$client->desactivateUser($user->username);
var_dump($resp);

echo "<p>Method::getUser</p>";
$resp  =$client->getUser($user->username);
var_dump($resp);
