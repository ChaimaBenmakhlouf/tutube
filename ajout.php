<?php
    $formInformations = "";
    $youtubeRegex = "#.*youtube\.com/watch\?v=#";
    if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['title']) && isset($_POST['url']) && isset($_POST['description'])) {
        
        if ( strlen($_POST['title']) > 0 && strlen($_POST['url']) > 0 && strlen($_POST['description']) > 0) {
            $title = htmlspecialchars($_POST['title']);
            $url = htmlspecialchars($_POST['url']);
            $description = htmlspecialchars($_POST['description']);
            if (preg_match($youtubeRegex, $url)) {
                $url = preg_replace($youtubeRegex, "", $url);
                
                $url = "https://www.youtube.com/embed/".$url;
                
                
                try {
                    $database = new PDO('mysql:host=127.0.0.1;dbname=tutube;charset=utf8', 'root', 'root'); 
                    
                } catch (Exception $e) {
                    
                    die('error on db' . $e->getMessage());
                }
                
                $query = $database->prepare('INSERT INTO video (url, description, title) VALUES (:url, :description, :title)');
                
                $query->execute([
                                'description' => $description,
                                'url' => $url,
                                'title' => $title,
                                
                                ]);
                
                header('Location: accueil.php');die;
            } else {
                $formInformations = "Champs pas valide";
            }
        }
    }
    
    
    ?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Document</title>
</head>
<body>
    <h2>AJOUT DE VIDEO</h2>
    <form action="" method="POST">
        <label for="user">title</label>
        <input type="text" name="title" id="title">
        <label for="url">url</label>
        <input type="text" name="url" id="url">	
        <label for="description">description</label>
        <input type="text" name="description" id="description">	
        <input type="submit" name="créer">
    </form>

    <div>
        <b><?php $formInformations ?></b>
    </div>

</body>
</html>
