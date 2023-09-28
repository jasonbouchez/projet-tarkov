<?php
session_start();

// CONNEXION À LA BDD
$host = "localhost";
$dbname = "bdd2";
$username = "root";
$password = "";
$dbConnect = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
$dbConnect->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$sqlSelect = "SELECT * FROM `map`";
$stmtSelect = $dbConnect->prepare($sqlSelect);
$stmtSelect->execute();
$result = $stmtSelect->fetchAll(PDO::FETCH_ASSOC);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Escape from Tarkov</title>
    <link rel="stylesheet" href="style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
</head>
<body class="body">
<div class="container_fluid">
        <div class="column">
                
        <!-- 1er header -->



        <header class="headd">

    <section class="button">

    <h1 class='text'>ESCAPE FROM TARKOV</h1>

    <form method="POST" action="">

    <input type="text" name="identifiant" placeholder="votre identifiant" class="inscription">

    <input type="password" name="password" placeholder="votre mot de passe" class="inscription">
    <?php
        if (isset($_SESSION['data'])) {
            echo '<input type="submit" name="deconnecter" value="Déconnexion">';
            } else {
                    // Utilisateur non connecté
                    echo '<input type="submit" name="connecter" value="Connexion"><br><br>';
                }

                if (empty($_SESSION)) {
                    echo '<form method="POST" action="">
                    <input type="text" name="email"  class="inscription" placeholder="nom">
                    <input type="text" name="email"  class="inscription" placeholder="prenom">
                    <input type="text" name="nouvel_identifiant"  class="inscription"  placeholder="identifiant" > 
                    <input type="password" name="nouveau_mot_de_passe"  class="inscription"  placeholder="mots de passe">
                    <input type="submit" name="sinscrire" value="S\'inscrire"> 
                </form>';
                }
                ?>
            </form>
        </section>
    </header>
     
<!-- 2eme header -->


<header class="headeer">
     <br> 
<?php
if (!empty($_SESSION)) {
    echo '
    <form method="POST" action="" id="Myform">
        <input type="submit" name="infoos" value="infos">
        <input type="submit" name="arme" value="armes">
        <input type="submit" name="map" value="map">
        <input type="submit" name="informations" value="modding">
        
    </form>';
}
?>
<br>
</header>

<!-- debut php -->
<?php

     if(empty($_SESSION)){
        echo'<img src="image/boss.jpg" alt="" class="img-fluid">';
    }


    // Connexion utilisateur
    if (isset($_POST['connecter'])) {
        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];
        if ($identifiant === 'jasonbch' && $password === '29082003') {
            $_SESSION['data'] = [
                'identifiant' => $identifiant,
                'password' => $password
            ];
            echo "<div class='message message-success'>Bienvenue, vous êtes connecté.</div><br>";
           
            ?>
            <!-- refresh une fois connecter-->
            <?php
            header("Refresh: 1.5; URL=http:/ecff tarkov/index.php"); // Redirige après 2 secondes vers la page souhaitée
            exit();
            
        } else {
            echo "<div class='message message-error'>Nom d'utilisateur ou mot de passe incorrect.</div>";
            header("Refresh: 1.5; URL=http:/ecff tarkov/index.php"); // Redirige après 2 secondes vers la page souhaitée
            exit();
        }
    }
    
    
    // Déconnexion
    if (isset($_POST['deconnecter']) && isset($_SESSION['data'])) {
        unset($_SESSION['data']);
        header("Refresh: 1.5; URL=http:/ecff tarkov/index.php"); // Redirige après 2 secondes vers la page souhaitée
        exit();
    }
    ?>
    <?php

if (isset($_POST['infoos']) && isset($_SESSION['data'])) {
    echo '
    <div class="infooos">
    <h2 class=" titttle">Aperçu du jeu</h2>
    
    <p class=" descript">Escape from Tarkov est un jeu de tir tactique en ligne massivement multijoueur (MMO) développé par Battlestate Games. Le jeu se déroule dans la ville fictive de Tarkov, en Russie, et met l\'accent sur le réalisme et la survie.</p>
    
    <ul class=" ull">
        <li>Combat tactique intense</li>
        <li>Personnalisation des armes et de l\'équipement</li>
        <li>Économie du jeu dynamique</li>
        <li>Mode de jeu en équipe</li>
    </ul>

    <img src="image/skiff.jpg" alt="" class="img-fluid">
    
    <h2 class="brbrbr">Téléchargement</h2>
        <p class="brbrbr" >Vous pouvez télécharger Escape from Tarkov depuis le site officiel du jeu.</p>
        <a href="https://www.escapefromtarkov.com/" target="_blank" class="brbr">Télécharger le jeu</a>';
}
?>


    <!-- Cards pour les maps -->
    <?php
 if (isset($_POST['map']) && !empty($_SESSION['data'])) {
     echo '<div class="container">
             <div class="row">'; // Ouvrir le container et la ligne en dehors de la boucle
     foreach ($result as $map) {
         echo '<div class="col-4">
                 <div class="card">
                 <img src="' . htmlspecialchars($map['image']) . '" class="card-img-top" alt="Image de la carte">
                   <div class="card-body">
                     <h5 class="card-text">' . htmlspecialchars($map['nom']) . '</h5>                       
                     </div>
                 </div>
               </div>';
     }
     echo '</div>
         </div>'; // Fermer le container et la ligne en dehors de la boucle
 }
 ?>
 
 <!-- Afficher les cards pour les armes -->
 <?php

$sqlSelectArmes = "SELECT * FROM armes";
$stmtSelectArmes = $dbConnect->prepare($sqlSelectArmes);
$stmtSelectArmes->execute();
$armes = $stmtSelectArmes->fetchAll(PDO::FETCH_ASSOC);

 if (isset($_POST['arme']) && !empty($_SESSION['data'])) {
     echo '<div class="container">
             <div class="row">';
     foreach ($armes as $arme) {
         echo '<div class="col-4">
                 <div class="card" >
                 <img src="' . htmlspecialchars($arme['image']) . '" class="card-img-top" alt="Image de l\'arme">
                     <div class="card-body">
                         <p class="card-text">Type: ' . htmlspecialchars($arme['nom']) . '</p>
                     </div>
                 </div>
             </div>';
     }
     echo '</div>
         </div>';
    }
?>
<!-- afficher cardss armes modder  -->
<?php
$sqlSelectModding = "SELECT * FROM modding";
$stmtSelectModding = $dbConnect->prepare($sqlSelectModding);
$stmtSelectModding->execute();
$modding = $stmtSelectModding->fetchAll(PDO::FETCH_ASSOC);

if (isset($_POST['informations']) && !empty($_SESSION['data'])) {
    echo '<div class="container">
             <div class="row">';
    foreach ($modding as $mod) {
        echo '<div class="col-4">
                 <div class="card">
                     <img src="' . htmlspecialchars($mod['image']) . '" class="card-img-top" alt="Image de l\'arme">
                     <div class="card-body">
                         <p class="card-text">Name: ' . htmlspecialchars($mod['nom']) . '</p>
                     </div>
                 </div>
               </div>';
    }
    echo '</div>
         </div>';
}
?>

<!-- div container fermante -->
</div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm" crossorigin="anonymous"></script>
</body>
</html>