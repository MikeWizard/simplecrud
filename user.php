<?php
include("connection.php");
include("layout/template.php");
class User{
    private $table="users";
    private $connection=null;


    public function __construct(){
        $this->connection=Database::getInstance();
        
    }
    public function getAll(){
        $query="SELECT * FROM users";
        $result=$this->connection->query($query);
        // print_r($result-> fetch_all());
        return $result-> fetch_all(MYSQLI_ASSOC);

    }

    public function getById($id){
        $id=$this->connection->real_escape_string($id);
        if (is_numeric($id)){
            $query="SELECT * FROM users where id='".$id."'";
            $result=$this->connection->query($query);
            return $result->fetch_assoc();
        }
    }public function getByName($username){
        $username=$this->connection->real_escape_string($username);
        $query="SELECT * FROM users where username='".$username."'";
        $result=$this->connection->query($query);
        return $result->fetch_assoc();
    }

    //Commands
    public function insert(){
        if (isset($_POST["submit"])){
            $name=$this->connection->real_escape_string($_POST["username"]);
            $password=$this->connection->real_escape_string($_POST["password"]);
            $existingUser=$this->getByName($name);
            if($existingUser){
                $this->list("User '".$name."' already exists!");
            }else{
                $query="INSERT INTO users(username,password) VALUES ('".$name."','".$password."')";
                $this->connection->query($query);
                $this->list("User '".$name."' succesfully created!");
            }
        }
    }
    public function update($id){
        $id=$this->connection->real_escape_string($id);
        if ((is_numeric($id)) && (isset($_POST["submit"]))){
            $username=$this->connection->real_escape_string($_POST["username"]);
            $password=$this->connection->real_escape_string($_POST["password"]);
            $query="UPDATE users SET username='".$username."',password='".$password."' WHERE id= '".$id."'";
            $this->connection->query($query);
        }
        $this->list("User '".$username."' succesfully edited!");

    }
    public function delete($id){
        $id=$this->connection->real_escape_string($id);
        if($id!=$_SESSION['idForThisSimpleCrudPRoyect']){
            $user=$this->getById($id);
            if (is_numeric($id)){
                $query="DELETE FROM users WHERE id= '".$id."'";
                $this->connection->query($query);
            }
            $this->list("User '".$user["username"]."' succesfully deleted!");
        }else{
            $this->list("User '".$_SESSION['usernameForThisSimpleCrudPRoyect']."' cannot be deleted!");

        }
    }


    //Views


    public function create(){
        $layout = new Template();
        $fields=[
            ['name'=>'username','type'=>'text'],
            ['name'=>'password','type'=>'password']
        ];
        $layout->setHeader("Create Users");
        $layout->addForm('user',null,'insert',$fields);
        $layout->show();
    }


    public function edit($id){
        $id=$this->connection->real_escape_string($id);
        if (is_numeric($id)){
            $user= $this->getById($id);
            $layout = new Template();
            $fields=[
                ['name'=>'username','type'=>'text','value'=>$user['username']],
                ['name'=>'password','type'=>'password','value'=>$user['password']]
            ];
            $layout->setHeader("Edit user: ".$user["username"]);
            $layout->addForm('user',$id,'update',$fields);
            $layout->addLink('user','list',"Go back");
            $layout->show();
        }
    }



    public function list($message=""){
        $layout = new Template();
        $fields=[
            ['name'=>'username','type'=>'text'],
            ['name'=>'password','type'=>'password']
        ];
        $layout->setHeader("List Users");
        $layout->addAlert($message);
        $columns=['id','name','password','actions'];
        $users=$this->getAll();
        $layout->addLink('user','create',"Create","button");
        $layout->addList('user',$columns,$users);
        $layout->show();
    }

}

?>