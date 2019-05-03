<?php
    require_once '../Controller/Verify.php';
    //Connexion a la base de données
    require_once '../Model/Config.php';
    $DB = Connexion();
if(!empty($_POST))
{
    // Gestion des erreurs
    $Erreur = array();
    
    if(empty($_POST['Login_']) || !preg_match('/^[a-zA-Z0-9_]+$/',$_POST['Login_'])){
        $Erreur['Login_'] = "Le champs Login est vide ou invalide";
    }
    else{
        $Requete = ("SELECT id_user FROM Users WHERE Login_ = ?");
        $Prepare = $DB ->prepare($Requete);
        $Prepare->execute([$_POST['Login_']]);
        $Resultat = $Prepare->fetch();
            if($Resultat){
                $Erreur['Login_'] = "Ce Login est deja utilisé";
            }
    }
    if(empty($_POST['Email_']) || !filter_var($_POST['Email_'], FILTER_VALIDATE_EMAIL)){
        $Erreur['Email_'] = "Le champs Email est vide ou invalide";
    }
    else{
        $Requete = ("SELECT id_user FROM Users WHERE Email_ = ?");
        $Prepare = $DB ->prepare($Requete);
        $Prepare->execute([$_POST['Email_']]);
        $Resultat = $Prepare->fetch();
            if($Resultat){
                $Erreur['Email_'] = "Cet Email est deja utilisé";
            }
    }
    if(empty($_POST['Password_'])){
        $Erreur['Password_'] = "Vous n'avez pas entrez de mot de passe";
    }
    if(empty($Erreur)){
    $Requete =("INSERT INTO Users SET Login_ = ? , Email_ = ? , Password_ = ?, Validation_token = ?");
    $Prepare = $DB ->prepare($Requete);
    $password = password_hash($_POST['Password_'],PASSWORD_BCRYPT);
    $token = Tokken_Validation(14);
    $Prepare->execute([$_POST['Login_'], $_POST['Email_'], $password, $token]);
    $user_id = $DB->lastInsertId();
    mail($_POST['Email_'],'Confirmation de votre Compte',"Cliquez sur le lien suivant pour activer votre compte \n\nhttp://localhost/Appli/Controller/Confirm.php?id=$user_id&token=$token");
    header('location:../index.php');
    exit();
    }

}
?> 
<!DOCTYPE html>
<html lang="fr">

<head>
    <!-- Required meta tags-->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="au theme template">
    <meta name="author" content="Hau Nguyen">
    <meta name="keywords" content="au theme template">

    <!-- Title Page-->
    <title>Register</title>

    <!-- Fontfaces CSS-->
    <link href="../Assets/css/font-face.css" rel="stylesheet" media="all">
    <link href="../Assets/vendor/font-awesome-4.7/css/font-awesome.min.css" rel="stylesheet" media="all">
    <link href="../Assets/vendor/font-awesome-5/css/fontawesome-all.min.css" rel="stylesheet" media="all">
    <link href="../Assets/vendor/mdi-font/css/material-design-iconic-font.min.css" rel="stylesheet" media="all">

    <!-- Bootstrap CSS-->
    <link href="../Assets/vendor/bootstrap-4.1/bootstrap.min.css" rel="stylesheet" media="all">

    <!-- Main CSS-->
    <link href="../Assets/css/theme.css" rel="stylesheet" media="all">

</head>

<body class="animsition">
    <div class="page-wrapper">
        <div class="page-content--bge5">
            <div class="container">
                <div class="login-wrap">
                    <div class="login-content">
                        <div class="login-logo">
                            <a href="#">
                                <img src="../Assets/images/icon/logo.png" alt="CoolAdmin">
                            </a>
                        </div>
                        <div class="login-form">
                        <?php if(!empty($Erreur)):?>
                            <div class="">
                                <p> Erreurs </p>
                                <ul class="list-group">
                                    <?php foreach($Erreur as $error):?>
                                    <li class="list-group-item list-group-item-danger"> <?= $error; ?> </li>
                                    <?php endforeach;?>
                                </ul>
                            </div>
                        <?php endif;?>
                            <form action="" method="post">
                                <div class="form-group">
                                    <label> Login </label>
                                    <input class="au-input au-input--full" type="text" name="Login_" placeholder="Votre Login">
                                </div>
                                <div class="form-group">
                                    <label> Email </label>
                                    <input class="au-input au-input--full" type="email" name="Email_" placeholder="Votre Adresse Email">
                                </div>
                                <div class="form-group">
                                    <label> Mot de passe </label>
                                    <input class="au-input au-input--full" type="password" name="Password_" placeholder="Votre mot de passe">
                                </div>
                                <div class="login-checkbox">
                                    <label>
                                        <input type="checkbox" name="aggree">J'accepte votre politique de confidentialité
                                    </label>
                                </div>
                                <button class="au-btn au-btn--block au-btn--green m-b-20" type="submit"> S'inscrire </button>
                            </form>
                            <div class="register-link">
                                <p>
                                    Deja inscrit ?
                                    <a href="../index.php"> Se Connecter </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Jquery JS-->
    <script src="../Assets/vendor/jquery-3.2.1.min.js"></script>
    <!-- Bootstrap JS-->
    <script src="../Assets/vendor/bootstrap-4.1/popper.min.js"></script>
    <script src="../Assets/vendor/bootstrap-4.1/bootstrap.min.js"></script>
    <!-- Main JS-->
    <script src="../Assets/js/main.js"></script>

</body>

</html>
<!-- end document-->