<?php
    
    if(isset($_GET['videoId'])) {
        try {
            $database = new PDO('mysql:host=127.0.0.1;dbname=tutube;charset=utf8', 'root', 'root');
        } catch (Exception $e) {
            die('error on db' . $e->getMessage());
        }
        
        $query = $database->prepare('DELETE FROM video WHERE id = :id');
        $query->execute([
                        'id' => htmlspecialchars($_GET['videoId'])
                        ]);
    }
    header('Location: accueil.php');die;
    
?>
