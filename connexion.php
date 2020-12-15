
<?php 
    
    session_start();
    
    
    
    
    if (isset($_POST["email"]) && isset($_POST["password"])) {
        $password = htmlspecialchars($_POST['password']);
        $email = htmlspecialchars($_POST['email']);
        try {
            $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
        } catch (Exception $e) {
            die('error on db' . $e->getMessage());
        }
        $query = $database->prepare('SELECT id FROM user WHERE email LIKE :email AND password LIKE :password' );
        $query->execute([
                        'email' => $email,
                        'password' => $password,
                        ]);
        $userId = $query->fetchAll();
        if (isset($userId) && count($userId) > 0) {
            $_SESSION['email'] = '$email';
            header('Location: accueil.php');die;
        } else {
            echo "Erreur d'authentification, verifiez votre email ainsi que votre mot de passe.";
        } 
    }
    
    
    
    
    
    
    ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport">
    <title>Document</title>

</head>
<body>	
    <h2>CONNEXION : </h2>
    <form action='#' method='POST'>
        <label>email</label>
        <input type='text' name='email' >
        <label>password</label>
        <input type='password' name='password' >

        <input type='submit' name='submit'>

        <br><br>
    </form>	

</body>
</html>



