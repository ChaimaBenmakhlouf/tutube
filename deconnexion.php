
<?php 
    
    session_start();
    
    $_SESSION['email'] = null;
    
    header('Location: accueil.php');die;
    
?>
