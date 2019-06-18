<?php
	// Récupération des variables du _POST
	if(isset($_POST['id_theme'])) {$id_theme = $_POST['id_theme'];}
	
	$resultat_operation = "404";
	$reussite=0;
	// Vérification des variables récupérées
	if(empty($id_theme))
		{$resultat_operation = "Un champ est vide";}
	elseif(!is_numeric($id_theme))
		{$resultat_operation = "ID du thème non valide";}
	else{
		// Récupération de la date du jour mise dans $dateajd
		date_default_timezone_set('Europe/Paris');
		$dateajd = date("Y\-m\-d");
		
		// Ajout des variables de connection à la base de données
		include_once "config_bdd.php";
		// Connection BDD
		$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
		
		// Création de la requête pour faire une UPDATE et supprimer le thème demandé
		$query = "UPDATE `themes` SET `supprime` = '1' WHERE `idtheme`=$id_theme";
		$result = mysqli_query($connect, $query);
		if(!$result) { $resultat_operation = "<br>pas bon".mysql_error($connect); }
		else
		{ 
			// Création de la requête pour récupérer les séances et connaître sa date
			$result2 = mysqli_query($connect, "SELECT * FROM `seances` WHERE idtheme=$id_theme");
			while($raw2=mysqli_fetch_array($result2, MYSQL_NUM))
			{
				// Comparaison des dates pour vérifier que la séance est future
				if(strtotime($raw2[1]) - strtotime($dateajd)>=0)
				{
					// Création de la requête pour la suppression de la séance
					$query3 = "DELETE FROM `seances` WHERE `idseance` = $raw2[0]";
					$result3 = mysqli_query($connect, $query3);
					// Création de la requête pour la suppression des inscriptions à la séance
					$query4 = "DELETE FROM `inscription` WHERE `idseances` = $raw2[0]";
					$result4 = mysqli_query($connect, $query4);
				}
			}
			$resultat_operation = "Thème supprimé, séances supprimées et désinscriptions faites"; $reussite=1;
		}
	}
?>
<html>
<head>
  <meta charset="UTF-8">
  <link href="style.css" rel="stylesheet" media="all" type="text/css">
</head>

<body>
	<?php
		// Ajout du menu
		include_once "menu.php";
	?>
	<section id="contenu">
	<?php
		if($reussite) // Réussite de l'ajout
			{ echo "<div id='requete'>".$query."</div>"; 
			 echo "<div id='statut_reu'>".$resultat_operation."</div>"; }
		else          // Un soucis à empéché l'ajout
			{ echo "<div id='statut_ech'>".$resultat_operation."<br/><a href='consultation_eleve.php'>Retour à la saisie</a></div>" ; }
	?>
	
	</section>
</body>
</html>
  
  
  
