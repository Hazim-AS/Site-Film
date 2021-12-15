<?php
session_start();
if(isset($_SESSION['admin'])){
    if ($_SESSION['admin'] == 0 ) {
        header('location:Internaute.php');
    }}
else
    header('location:Index.php');
if(isset($_GET['menu']))
    $menu=$_GET['menu'];
else
    $menu="film";
echo'<div id="menu" style="display: none">'.$menu.'</div>'
?>
<html lang="fr">
<head>
    <script src="js/Affichage.js"></script>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <title>The Movie Scope</title>
    <link rel="stylesheet" href="assets/css/styles.css">
    <link rel="stylesheet" href="assets/css/navbar.css">
</head>
<body>
    <nav>
        <div class="navbar">
            <div class="logo"><a>TheMovieScope</a></div>
            <div class="nav-links">
                <ul class="links">
                    <li>
                        <a>Films</a>
                        <i class='bx bxs-chevron-down arrow  '></i>
                        <ul class="js-sub-menu sub-menu">
                            <li><button onclick="Menu_film()">Lire</button></li>
                            <li><a href="Ajout.php?action=film">Ajout</a></li>
                        </ul>
                    </li>
                    <li>
                        <a>Artistes</a>
                        <i class='bx bxs-chevron-down arrow '></i>
                        <ul class="js-sub-menu sub-menu">
                            <li><button onclick="Menu_artiste()">Lire</button></li>
                            <li><a href="Ajout.php?action=artiste">Ajout</a></li>
                        </ul>
                    </li>
                    <li>
                        <a>Genres</a>
                        <i class='bx bxs-chevron-down arrow '></i>
                        <ul class="js-sub-menu sub-menu">
                            <li><button onclick="Menu_genre()">Lire</button></li>
                            <li><a href="Ajout.php?action=genre">Ajout</a></li>
                        </ul>
                    </li>
                    <li><button onclick="Menu_internaute()">Internaute</button></li>
                    <li><a href="Profil.php">Profil</a></li>
                    <li><a href="Index.php">Déconnexion</a></li>
                </ul>
            </div>
            <div class="logo"><a><img src="assets/img/logo_TheMovieScope_HD.png" width="125" height="70" /></a></div>
        </div>

<?php
try{
    $bdd = new PDO('mysql:host=localhost;dbname=cinema','root','');
}
catch(Exception $e){
    die('Erreur de connexion : '.$e->getMessage());}

//////////////////////////////////////////////////////////Requete pour afficher les films/////////////////////////////////////////////////////////////////////////////////////////////

echo'<table id="table_film" style="display: none">';
$rep = $bdd->query('SELECT * FROM cinema.film ;');
while($donnee = $rep->fetch())
{
    if($donnee['image'] == null)
        $donnee['image'] = "assets/img/no_image_available.png";
    echo '<td><a href="Film.php?id='.$donnee["idFilm"].'"><img title="'.$donnee['titre'].'" alt="Ce film ne possède pas d\'illustration" height="200px" width="150px" src="'.$donnee['image'].'"></a><h5>'.$donnee['titre'].'</h5></td>';
}
echo'</table>';
//////////////////////////////////////////////////////////Requete pour afficher les artistes/////////////////////////////////////////////////////////////////////////////////////////////
$rep = $bdd->query('SELECT * FROM cinema.artiste;');
echo'<table id="table_artiste" style="display: none">';
while($donnee = $rep->fetch())
{
    if($donnee['image'] == null)
        $donnee['image'] = "assets/img/no_image_available.png";

    echo '<td><a href="Artiste.php?id='.$donnee["idArtiste"].'"><img title="'.$donnee['prenom']." ".$donnee['nom'].'" alt="Cet artiste ne possède pas d\'illustration" height="125px" width="100px" src="'.$donnee['image'].'"></a><h5>'.$donnee['prenom']." ".$donnee['nom'].'</h5></td>';
}
echo'</table>';

//////////////////////////////////////////////////////////Requete pour afficher les genres/////////////////////////////////////////////////////////////////////////////////////////////
$rep = $bdd->query('SELECT * FROM cinema.genre;');
echo'<table id="table_genre" style="display: none">
    <tr>
        <th>LIBELLE</th>
    </tr>';
while($donnee = $rep->fetch())
{
    echo '<tr><td>'.$donnee['libelle'].'</td>';
    echo '<td><a href="Suppression.php?id='.$donnee['idGenre'].'&genre=genre"><button>Supprimer</button></a></td>';
    echo '<td><a href="Modification.php?id='.$donnee['idGenre'].'&genre=genre&libelle='.$donnee['libelle'].'"><button>Modifier</button></a></td></tr>';
}
echo'</table>';

//////////////////////////////////////////////Requete pour afficher les internautes////////////////////////////////////////
$rep = $bdd->query('SELECT * FROM cinema.internaute;');
echo'<table id="table_internautes" style="display: none">
    <tr>
        <th>NOM</th>
        <th>PRENOM</th>
        <th>ADMIN</th>
    </tr>';
while($donnee = $rep->fetch())
{
    echo '<tr><td>'.$donnee['nom'].'</td>';
    echo '<td>'.$donnee['prenom'].'</td>';
    echo '<td>'.$donnee['admin'].'</td>';
    echo '<td><a href="Suppression.php?id='.$donnee['idInternaute'].'&genre=internautes"><button>Supprimer</button></a></td>';
    echo '<td><a href="Modification.php?id='.$donnee['idInternaute'].'&nom='.$donnee['nom'].'&prenom='.$donnee['prenom'].'&admin='.$donnee['admin'].'&genre=internautes"><button>Modifier</button></a></td></tr>';
}
echo'</table>';
?>

</body>
</nav>
<script>
    if(document.getElementById("menu").outerText==="film"){
        Menu_film();
    }

    if(document.getElementById("menu").outerText==="artiste"){
        Menu_artiste();
    }

    if(document.getElementById("menu").outerText==="genre"){
        Menu_genre();
    }

    if(document.getElementById("menu").outerText==="internautes"){
        Menu_internaute();
    }
</script>
</html>