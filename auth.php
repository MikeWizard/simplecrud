<?php
session_start();
require_once("user.php");
require_once("layout/template.php");

class Auth{
    protected $user;
    protected $attempt;
    protected $authentication;


    public function __construct(){
        $this->user= new User();
    }
    public function login(string $username, string $password)
    {
        $user = $this->user->getByName($username);
        if (!$user || $user["password"]!=$password) {
            header("location:index.php");
        }else{
            $_SESSION['usernameForThisSimpleCrudPRoyect'] = $username;
            $_SESSION['idForThisSimpleCrudPRoyect'] = $user['id'];
            header("location:index.php");
        }
    }
    
    public function logOut(){
        unset($_SESSION['usernameForThisSimpleCrudPRoyect']);
        unset($_SESSION['idForThisSimpleCrudPRoyect']);
        header("location:index.php");
    }

    public function checkIfLoggedIn(){
        return (isset($_SESSION['usernameForThisSimpleCrudPRoyect']));
    }

    public function loginForm(){
        if (isset($_POST["submit"])){
            if(
                (isset($_POST['username']))&&
                (isset($_POST['password']))
            ){
                $u=$_POST['username'];
                $p=$_POST['password'];
                $this->login($u,$p);
            }else{}
        }else{

        $layout = new Template();
        $fields=[
            ['name'=>'username','type'=>'text'],
            ['name'=>'password','type'=>'password']
        ];
        $layout->setHeader("LOGIN");
        $layout->addForm('user',null,'insert',$fields);
        $layout->show();
        }
    }
}


?>
