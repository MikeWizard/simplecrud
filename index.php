<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require_once("user.php");
require_once("auth.php");
$auth=new Auth();
if(!$auth->checkIfLoggedIn()){
    $auth->loginForm();
}else{
    if(isset($_GET["module"])){
        $module=$_GET["module"];
    }
    switch($module){
        case "user":
            $entity =new User();
            break;
        default :
            $entity =new User();
    }
    $action=null;
    if(isset($_GET["action"])){
        $action=$_GET["action"];
    }
    switch($action){
        case "insert":
            $entity->insert();
            break;

        case "delete":
            if(isset($_GET["id"])){
                $id=$_GET["id"];
            }else{
                $id=null;
            }
            $entity->delete($id);
            break;
        case "update":
            if(isset($_GET["id"])){
                $id=$_GET["id"];
            }else{
                $id=null;
            }
            $entity->update($id);
            break;
        case "create":
            $entity->create();
            break;
        case "edit":
            if(isset($_GET["id"])){
                $id=$_GET["id"];
            }else{
                $id=null;
            }
            $entity->edit($id);
            break;
        case "logout":
            $auth->logOut();
        case "list":
        default:
            $entity->list();
    }

}





?>