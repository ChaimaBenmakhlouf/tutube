<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>document</title>
</head>
<body>
    <h2>INSCRIPTION : </h2>
    <form action='#' method='POST'>
        <label>email</label>
        <input type='text' name='email' >
        <label>password</label>
        <input type='password' name='password' >
        <label>pseudo</label>
        <input type='text' name='pseudo' >
        <input type='submit' name='submit'>

        <br><br>
    </form>

</body>
</html>

<?php
    
    
    
    $emailPattern= '/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/';
    if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["pseudo"])) {
        $password = htmlspecialchars($_POST['password']);
        $email = htmlspecialchars($_POST['email']);
        $pseudo = htmlspecialchars($_POST['pseudo']);
        
        if (preg_match($emailPattern, $email) == 1) {
            try {
                $database = new PDO('mysql:host=localhost;dbname=tutube;charset=utf8', 'root', 'root');
            } catch (Exception $e) {
                die('error on db' . $e->getMessage());
            }
            
            $query = $database->prepare('INSERT INTO user (email, password, pseudo) VALUES (:email, :password, :pseudo)');
            
            $query->execute( ['email' => $email,
                            'password' => $password,
                            'pseudo' => $pseudo,
                            
                            ]);
            header('Location: accueil.php');die;
        }
    }
    
    
    ?>
