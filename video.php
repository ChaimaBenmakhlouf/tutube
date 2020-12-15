<?php 

	if (isset($_GET['videoId'])) {
		session_start();
	$id = $_GET['videoId'];	
	
	try {
        	$database = new PDO('mysql:host=127.0.0.1;dbname=tutube;charset=utf8', 'root', 'root'); 

		} catch (Exception $e) {

        	die('error on db' . $e->getMessage());
    	}

	    $query = $database->prepare('SELECT * FROM video WHERE id = :id');
	    
	    $query->execute([
	    	'id' => $id,
	    ]);
	     $videos = $query->fetchAll();
	     

	   
	     if (!empty($videos)) {
	     	$video = $videos[0];
	     	echo '<iframe width="875" height="410" src="' .  $video['url'] . '"></iframe>';
	     	if(isset($_SESSION['email'])) {
			echo '<b><a href="delete.php?videoId="' . $id . '">Supprimer video</a></b> ';


			} 
			echo "<br>";
	     	echo $video['title'] . "<br>";
	     	echo $video['description'] . "<br>". "<br>";
	     }
	     if (isset($_SESSION['email'])) {
	     	echo 
	     	"<form action='#' method='POST'>
				<label>title</label>
				<input type='text'  name='title' size= '50' value='" . $video['title'] .

				"' ><br><br>
				<label>url</label>
				<input type='text' name='url'  size= '50' value='" .  $video['url'] . "'><br><br>
				<label>description</label>
				<input type='text' name='description'  size= '50' value='" .  $video['description'] . "'><br><br>
				<input type='submit' name='submit'>

		
		</form>	
		";

		$youtubeRegex = "#.*youtube\.com/watch\?v=#";
		$youtubeEmbedRegex = "#.*youtube\.com/embed/#";
		$isValid= false;

		if (isset($_POST['submit']) && isset($_POST['title']) && isset($_POST['url']) && isset($_POST['description'])) {
			
		$title = htmlspecialchars($_POST['title']);
		$url = htmlspecialchars($_POST['url']);
		$description = htmlspecialchars($_POST['description']);
		if (preg_match($youtubeRegex, $url)) {
		$url = preg_replace($youtubeRegex, "", $url);
		
		$url = "https://www.youtube.com/embed/".$url;
		   $isValid = true; 	
		   


		    } else if (preg_match($youtubeEmbedRegex, $url)) {
		    	$isValid = true;
		    } else {
		    	$isValid = false;
		    }

		    
		    if ($isValid == true) {
		    	 $query = $database->prepare('UPDATE video SET url= :url, title= :title, description= :description WHERE id = :id');
	    
	    $query->execute([
	    	'id' => $id,
	    	'description' => $description,
	    	'url' => $url,
	    	'title' => $title,

	    ]);
	     header('Location: accueil.php');die;
		    }

	     }	 
}
	
}
 ?>
