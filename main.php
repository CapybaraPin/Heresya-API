<?php 

include '../api/database.php';

if (isset($_GET["pseudo"])){
	$pseudo = htmlspecialchars($_GET["pseudo"]);
	
	if ($pseudo != null){
		
		$player = $bdd->query('SELECT * FROM users WHERE pseudo = "' .$pseudo. '"');
		
		 while($p = $player->fetch()) {
		 
			 $id = $p['id'];
			 
			 if (!empty($p['id'])){
				 
				// Récupération des informations
				$pseudo = $p['pseudo'];
				$isban = $p['isban'];
				$isadmin = $p['isadmin'];
				 
				$res = $bdd->query('SELECT count(*) AS nb FROM forms WHERE user_id= "'. $id .'"');
				$data = $res->fetch();
				$nb_forms = $data['nb'];
				 
				
				$json = file_get_contents("http://45.000.000.40:3000/economyTop?type=money&top=10&sort=descending");
				$data = json_decode($json, true);
					
				foreach ($data as $pseudo_get => $money_get) {
									
					if($pseudo_get == $pseudo){
						$money = $money_get;
					}				
				}
				 
				$json = file_get_contents("http://45.000.000.40:3000/VoteTop?type=vote&top=10&sort=descending");
				$data = json_decode($json, true);
					
				foreach ($data as $pseudo_get => $vote_get) {
									
					if($pseudo_get == $pseudo){
						$votes = $vote_get;
					}				
				}
				 
				 
				// Affichage des informations
				 
				echo "<b>ID :</b>". $id . "<br>";
				 
				echo "<b>Pseudo :</b>" . $pseudo . "<br><br>";
				 
				if ($isadmin == 1){
					echo "<b>Priviléges :</b> Administrateur <br>";
				}else{
					echo "<b>Privilèges :</b> Aucun <br>";
				}
				 
				if ($isban == 1){
					echo "<b>Sanctions :</b> Banni <br>";
				}else{
					echo "<b>Sanctions :</b> Aucune <br>";
				}
				 
				echo "<br><br><b>Nombre de demande de recrutement :</b> " . $nb_forms;
				echo "<br><b>Argent :</b> 0" . $money ."$";
				echo "<br><b>Votes :</b> " . $votes ." votes";
				 
			 }else{
			 	echo "Erreur : Ce joueur n'existe pas.";
			 }
		 }
				
	}else{
		$error_message = "Erreur : Aucun pseudo n'est inscrit.";
	}
}else{
	$error_message = "Erreur : Echec de l'interection.";
}

echo $error_message;

?>
