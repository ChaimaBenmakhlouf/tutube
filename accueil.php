
<?php
    session_start();
    
    try {
        $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
    } catch (Exception $e) {
        die('error on db' . $e->getMessage());
    }
    
    $query = $database->prepare('SELECT * FROM video');
    $query->execute();
    $videos = $query->fetchAll();
    
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Document</title>
</head>
<body>

    <h2>TUTUBE : </h2>

    <?php foreach ($videos as $video) : ?>
    <br><br>
    <?php echo $video['title']; ?>
    <br><br>
    <iframe width="875" height="410" src="<?php echo $video['url']; ?>"></iframe>
    <b><a href="video.php?videoId=<?php echo $video['id'];?>">Voir video</a></b>
    <?php
        if(isset($_SESSION['email'])) {
            $id = $video['id'];
            echo '<b><a href="delete.php?videoId="' . $id . '">Supprimer video</a></b>';
        } 
    ?>	
    <?php endforeach; ?>

    <ul>
        <li>
            <a href="ajout.php"> Ajouter une video</a>
            <?php 
    
                if (isset($_SESSION['email'])) {
                    echo '<li><a href= deconnexion.php>Se deconnecter</a></li>';
                } else {
        
                    echo '<li><a href= connexion.php>Se connecter</a></li>';
                    echo "<li><a href='inscription.php'> S'inscrire</a></li>";
                }
    
            ?>
        </li>
    </ul>


</body>
</html>