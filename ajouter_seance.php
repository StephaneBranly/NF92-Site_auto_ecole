<?php
	// Récupération des variables du _POST
	if(isset($_POST['effectif'])) {$effectif = $_POST['effectif'];}
	if(isset($_POST['jour_seance'])) {$jour_seance = $_POST['jour_seance'];}
	if(isset($_POST['mois_seance'])) {$mois_seance = $_POST['mois_seance'];}
	if(isset($_POST['annee_seance'])) {$annee_seance = $_POST['annee_seance'];}
	if(isset($_POST['id_theme'])) {$id_theme = $_POST['id_theme'];}
	
	$resultat_operation = "404";
	$reussite=0;
	// Vérification des variables récupérées
	if(empty($effectif) || empty($jour_seance) || empty($mois_seance) || empty($annee_seance))
		{$resultat_operation = "Un champ est vide";}
	elseif(!is_numeric($jour_seance) || $jour_seance<=0 || $jour_seance>=32)
		{$resultat_operation = "Jour non valide";}
	elseif(!is_numeric($mois_seance) || $mois_seance<=0 || $mois_seance>=13)
		{$resultat_operation = "Mois non valide";}
	elseif(!is_numeric($annee_seance))
		{$resultat_operation = "Année non valide";}
	elseif(!is_numeric($effectif) || $effectif<1)
		{$resultat_operation = "Effectif non valide";}
	elseif(!is_numeric($id_theme))
		{$resultat_operation = "ID du thème non valide";}
	elseif(!checkdate ($mois_seance , $jour_seance ,$annee_seance))
		{$resultat_operation = "Date non valide";}
	else
	{
		// Récupération de la date du jour mise dans $inscription
		date_default_timezone_set('Europe/Paris');
		$inscription = date("Y\-m\-d");

		// Comparaison des dates pour vérifier qu'elle la séance est future
		$date_seance=$annee_seance."-".$mois_seance."-".$jour_seance;
		$interval = strtotime($date_seance) - strtotime($inscription);
		
		// Ajout des variables de connection à la base de données
		include_once "config_bdd.php";
		// Connection BDD
		$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
		
		// Création de la requête pour récupérer le thème demandé
		$result = mysqli_query($connect, "SELECT * FROM themes WHERE idtheme=$id_theme");
		$compteur=0;
		$supprime=1;
		while($raw=mysqli_fetch_array($result, MYSQL_NUM))
		{
			$supprime=$raw[2];
			$compteur++;
		}
		
		if($interval<0)
		{$resultat_operation = "Date de séance non valide";}
		elseif($compteur!=1)
		{$resultat_operation = "ID du thème non valide dans la bdd";}
		elseif($supprime==1)
		{$resultat_operation = "Le thème est un thème supprimé";}
		else
		{
			// Création de la requête pour compter le nombre de séances avec le même ID_thème ET le même jour
			$result = mysqli_query($connect, "SELECT COUNT(*) FROM seances WHERE idtheme=$id_theme AND DateSeance='$date_seance'");
			$raw=mysqli_fetch_array($result, MYSQL_NUM);
			if($raw[0]!=0)
				{$resultat_operation = "Il y a déjà une séance à ce jour ($date_seance) et avec le thème d'ID $id_theme";}
			else
			{
				// Création de la requête d'ajout
				$query = "insert into seances values (NULL, '$date_seance', '$effectif', '$id_theme')";
				$result = mysqli_query($connect, $query);
				if(!$result) { $resultat_operation = "<br>pas bon".mysql_error($connect); }
				else{ $resultat_operation = "Ajout de la séance correctement effectué"; $reussite=1;}
				mysqli_close($connect);
			}
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
			{ echo "<div id='statut_ech'>".$resultat_operation."<br/><a href='ajout_seance.php'>Retour à la saisie</a></div>" ; }
	?>
	
	</section>
</body>
</html>
  
  
  
