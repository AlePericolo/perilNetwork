<?php
/**
 * Created by PhpStorm.
 * User: alessandro
 * Date: 22/11/17
 * Time: 15.17
 */

require_once '../../../conf/conf.php';
require_once '../../../src/lib/pdo.php';
require_once '../../../src/lib/functions.php';
require_once '../../../src/function/functionLogin.php';

require_once '../../../src/model/Login.php';

function effettuaLogin($request){

    $pdo = connettiPdo();
    $login =  new Login($pdo);

    $id = $login->findIdByUsernamePassword($request->login->username, md5(SALT.$request->login->password));

    if($id){
        setLoginElementsInSession($id, $request->login->username, $request->login->password);
        return true;
    }else{
        return false;
    }
}

ob_start();
session_start();
$postdata = file_get_contents("php://input");
$request = json_decode($postdata);
$function = $request->function;
$r = $function($request);
echo $r;