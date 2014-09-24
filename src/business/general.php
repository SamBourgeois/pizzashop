<?php
require_once '../src/business/gebruikerservice.php';
class General{
    
    /* boolean weergeven of gebruiker ingelogd is */
    public function logged_in(){
        return(isset($_SESSION['id'])) ? true : false;
    }
    
    /* Beveiliging tegen ingelogde gebruikers */
    public function logged_in_protect(){
        if($this->logged_in() === true){
            header('Location: index.php');
            exit();
        }
    }
    
    /* Beveiliging tegen niet ingelogde gebruikers */
    public function logged_out_protect(){
        if($this->logged_in() === false){
            header('Location:index.php');
            exit();
        }
    }
    
    /* Controle of gebruiker admin is */
    public function is_admin(){
        if(isset($_SESSION['id'])){
            $gebruikerservice   = new GebruikerService();
            return $gebruikerservice->is_admin($_SESSION['id']);
        }
        return false;
    }
    
    /* Beveiliging tegen niet admin gebruikers */
    public function admin_protect(){
        $this->logged_out_protect();
        if($this->is_admin() === false){
            header('Location:index.php');
            exit();
        }
    }
    
    /* Image upload */
    public function file_newpath($path, $filename){
        if($pos = strrpos($filename, '.')){
            $name = substr($filename, 0, $pos);
            $ext = substr($filename, $pos);
        }else{
            $name = $filename;
            $ext="";
        }
        
        $newpath = $path.'/'.$filename;
        $newname = $filename;
        $counter = 0;
        
        while(file_exists($newpath)){
            $newname = $name .'_'.$counter . $ext;
            $newpath = $path.'/'.$newname;
            $counter++;
        }
        return $newpath;
    }
}
?>
