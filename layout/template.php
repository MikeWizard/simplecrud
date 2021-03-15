<?php

class Template{
    
    private $header;
    private $content;
    private $footer;

    public function __construct(){
        $this->header='<html><head>
        
        
        <title>CRUD</title>
        
        <link rel="stylesheet" href="styles.css">
        </head><body>
        <div class="navbar"><a href="'.$_SERVER['PHP_SELF']."?action=logout".'">Logout</a></div>
        <div class="main">';
        $this->content="";
        $this->footer="</body></html>";
    }
    public function addAlert($message){
        $alert="<h2 clas='alert'>".$message."</h2>";
        $this->content.=$alert;
    }
    public function setHeader($screen){
        $header="<header>\n";
        
        $header.="<h1 class='title'>CRUD - ".$screen."</h1>\n";
        $header.="</header>\n";
        $this->header.=$header;
    }
    public function addLink($entity_type,$action,$text,$class=""){
        $link="";
        $link="<a href='".$_SERVER['PHP_SELF']."?module=".$entity_type."&action=".$action."' class='".$class."'>".$text."</a>";
        $this->content.=$link;
    }
    public function addForm($entity_type,$entity_id,$action,$controls){
        $form="<form action ='".$_SERVER['PHP_SELF']."?module=".$entity_type."&action=".$action."&id=".$entity_id."' method='post'>\n";
        foreach($controls as $key=>$control){
            $value='';
            if(isset($control['value'])){
                $value=$control['value'];
            }
            $form.="<input type='".$control['type']."' name='".$control['name']."' value='".$value."'>";
        }
        $form.="<input type='submit' value='Submit' name='submit' class='button'/>";
        $form.="</form>";
        $this->content.=$form;
    }

    public function addList($entity_type,$columns,$elements){
        if(
            (count($columns)>0) &&
            (count($elements)>0) &&
            (count($columns)-1==count($elements[0]))
        ){
            
            $list="<table><tr>";
            foreach($columns as $key=>$value){
                $list.="<th>".$value."</th>";
            }
            $list.="</tr>";
            foreach($elements as $key=>$row){
                $list.="<tr>";
                foreach($row as $k=>$value){
                    $list.="<td>".$value."</td>";
                }
                $actions="<a href='".$_SERVER['PHP_SELF']."?module=".$entity_type."&action=edit&id=".$row['id']."'>edit</a>&nbsp;";
                $actions.="<a href='".$_SERVER['PHP_SELF']."?module=".$entity_type."&action=delete&id=".$row['id']."'>delete</a>";
                $list.="<td>".$actions."</td>";
                $list.="</tr>";
            }

        }else{
            $list= "columns count error";
        }

        $this->content.=$list;
    }

    public function setFooter(){
        $footer="</div><footer>foooter</footer>";
        $this->footer=$footer.$this->footer;
    }
    public function show(){
        echo $this->header.$this->content.$this->footer;
    }

}


?>

