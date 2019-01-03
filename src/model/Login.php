<?php
/**
* Developed by: Alessandro Pericolo
* Date: 29/11/2018
* Time: 17:02
* Version: 0.1
**/

require_once 'LoginModel.php';

class Login extends LoginModel {

/*CONSTRUCTOR*/
function __construct(PDO $pdo){
	parent::__construct($pdo);
}

    function findIdByUsernamePassword($username, $password){

        $query = "SELECT id FROM login WHERE username = ? AND password = ?";

        return $this->createResultValue($query, array($username, $password));
    }

    function countUsersByUsernamePassword($username, $password){

        $query = "SELECT COUNT(id) FROM login WHERE username = ? and password = ?";

        return $this->createResultValue($query, array($username, $password));
    }

} //close Class Login