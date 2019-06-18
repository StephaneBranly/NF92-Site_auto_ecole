<?php
	// Récupération des variables du _POST
	if(isset($_POST['id_seance'])) {$id_seance = $_POST['id_seance']; }
	if(isset($_POST['id_eleve'])) {$id_eleve = $_POST['id_eleve'];}
	
	$resultat_operation = "404";
	$reussite=0;
	
	// Vérification des variables récupérées
	if(empty($id_seance) || empty($id_eleve))
		{$resultat_operation = "Un champ est vide";}
	elseif(!is_numeric($id_seance))
		{$resultat_operation = "ID de la séance non valide";}
	elseif(!is_numeric($id_eleve))
		{$resultat_operation = "ID de l'élève non valide";}
	else
	{
		// Récupération de la date du jour mise dans $inscription
		date_default_timezone_set('Europe/Paris');
		$inscription = date("Y\-m\-d");
		
		// Ajout des variables de connection à la base de données
		include_once "config_bdd.php";
		// Connection BDD
		$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
		
		$effectif_seance=0;
		$eleve_deja_inscrit=false;
		// Création de la requête pour récupérer la séance demandée
		$result = mysqli_query($connect, "SELECT * FROM `seances` WHERE idseance=$id_seance");
		while($raw=mysqli_fetch_array($result, MYSQL_NUM))
		{
			$effectif_seance=$raw[2];
			// Comparaison des dates pour vérifier qu'elle la séance est future
			if(strtotime($raw[1]) - strtotime($inscription)<0)
			{$resultat_operation = "La séance est déjà passée";}
			else
			{
				// Création de la requête pour vérifier que l'effectif de la séance n'est pas dépassé et que l'élève n'est pas déjà inscrit
				$result2 = mysqli_query($connect, "SELECT * FROM `inscription` WHERE idseances=$id_seance");
				$compteur=0;
				while($raw2=mysqli_fetch_array($result2, MYSQL_NUM))
				{
					if($raw2[2]==$id_eleve)
					{$eleve_deja_inscrit=true;}
					$compteur++;
				}
				if($eleve_deja_inscrit==true)
				{$resultat_operation = "L'élève est déjà inscrit à la séance";}
				elseif($compteur>=$effectif_seance)
				{$resultat_operation = "La séance est déjà remplie";}
				else
				{
					// Création de la requête d'ajout pour inscrire l'élève à la séance demandée
					$query = "insert into inscription values (NULL, '$id_seance', '$id_eleve', '-1')";
					$result3 = mysqli_query($connect, $query);
					if(!$result3) { $resultat_operation = "<br>pas bon".mysql_error($connect); }
					else{ $resultat_operation = "L'inscription a correctement été effectuée"; $reussite=1;}
					mysqli_close($connect);
				}
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
			 echo "<div id='statut_reu'>".$resultat_operation."<br/><a href='inscription_eleve.php'>Retour à la saisie</a></div>"; }
		else          // Un soucis à empéché l'ajout
			{ echo "<div id='statut_ech'>".$resultat_operation."<br/><a href='inscription_eleve.php'>Retour à la saisie</a></div>" ; }
	?>
	
	</section>
</body>
</html>
  
  
  
