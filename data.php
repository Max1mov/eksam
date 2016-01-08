<?php
	// siia lisame auto nr märgite vormi
	//laeme funktsiooni failis
	require_once("functions.php");
	
	//kontrollin, kas kasutaja ei ole sisseloginud
	if(!isset($_SESSION["id_from_db"])){
		// suunan login lehele
		header("Location: login.php");
	}
	
	//login välja, aadressireal on ?logout=1
	if(isset($_GET["logout"])){
		//kustutab kõik sessiooni muutujad
		session_destroy();
		
		header("Location: login.php");
		
	}
	
	$teema_name = $seletus = $teema_name_error = $seletus_error = "";
	
	// et ei ole tühjad
	// clean input
	// salvestate
	
	if(isset($_POST["create"])){

		if ( empty($_POST["teema_name"]) ) {
			$teema_name_error = "See väli on kohustuslik";
		}else{
			$teema_name = cleanInput($_POST["teema_name"]);
		}

		if ( empty($_POST["seletus"]) ) {
			$seletus_error = "See väli on kohustuslik";
		} else {
			$seletus = cleanInput($_POST["seletus"]);
		}

		if(	$teema_name_error == "" && $seletus_error == ""){
			
			// functions.php failis käivina funktsiooni
			// msq on message funktsioonist mis tagasi saadame
			$msg = createPostName($teema_name, $seletus);
			
			if($msg != ""){
				//salvestamine õnnestus
				// teen tühjaks input value'd
				$teema_name = "";
				$seletus = "";
								
				echo $msg;
				
			}
			
		}

    } // create if end
	
	function cleanInput($data) {
		$data = trim($data);
		$data = stripslashes($data);
		$data = htmlspecialchars($data);
		return $data;
	  }
	
	
	
?>

<p>
	Tere, <?=$_SESSION["user_email"];?>
	<a href="?logout=1"> Logi välja</a>
</p>

 <h2>Lisa POST</h2>
  <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="post" >
  	<label for="teema_name" >auto nr</label><br>
	<input id="teema_name" name="teema_name" type="text" value="<?=$teema_name; ?>"> <?=$teema_name_error; ?><br><br>
  	<label>tekst</label><br>
	<input name="seletus" type="text" value="<?=$seletus; ?>"> <?=$seletus_error; ?><br><br>
  	<input type="submit" name="create" value="Salvesta">
  </form>