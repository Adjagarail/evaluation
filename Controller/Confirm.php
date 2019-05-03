<?php
    $user_id = $_GET['id'];
    $token = $_GET['token'];
    require '../Model/Config.php';
    $DB=Connexion();

    $Requete = ("SELECT Validation_token FROM Users WHERE id_user = ?");
    $Prepare = $DB->prepare($Requete);
    $Prepare->execute([$user_id]);
    $User = $Prepare->fetch();

    if($User && $User->Validation_token == $token ){
        session_start();
        $DB->prepare('UPDATE Users SET Validation_token = NULL, Created_At = NOW() WHERE id_user = ?')->execute([$user_id]);
        $_SESSION['auth'] = $User;
        header('location:../Vue/Profil.php');
    }
    else{

    }
?>