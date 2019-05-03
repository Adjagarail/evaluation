<?php
function Connexion(){
    try{
        $DB = NULL;
        $DB = new PDO('mysql:host=localhost;dbname=Appli;charset=utf8','root','');
        $DB -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $DB -> setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
        return $DB;
    }
    catch(PDOException $e){
        die('La connexion à la base est impossible'.$e->getMessage());
    }
}
Connexion();
?>
?>