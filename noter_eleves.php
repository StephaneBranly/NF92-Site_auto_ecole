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
	// Récupération des variables du _POST
	if(isset($_POST['id_seance'])) {$id_seance = $_POST['id_seance'];}
	$resultat_operation = "404";
	$reussite=0;
	
	// Vérification des variables récupérées
	if(empty($id_seance))
		{$resultat_operation = "Un champ est vide";}
	elseif(!is_numeric($id_seance))
		{$resultat_operation = "ID de la séance non valide";}
	else
	{
		// Ajout des variables de connection à la base de données
		include_once "config_bdd.php";
		// Connection BDD
		$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
		
		// Création de la requête pour récupérer tous les élèves inscrits à la séance
		$result = mysqli_query($connect, "SELECT * FROM inscription WHERE idseances=$id_seance");
		while($raw=mysqli_fetch_array($result, MYSQL_NUM))
		{
			// Récupération de manière dépendante par à rapport aux inscriptions à la séance des ID_élèves afin de récupérer les nbr_erreurs inscrits en $_POST[ID_élève]
			$reussite=0;
			$nom_variable="ideleve_".$raw[2];
			if(isset($_POST[$nom_variable]))
			{
				$note_eleve = 40-$_POST[$nom_variable];
			}
			if(empty($note_eleve))
				{$resultat_operation = "La note de l'élève avec ID $raw[2] n'a pas été trouvée";}
			elseif(!is_numeric($note_eleve) or $note_eleve<0 or $note_eleve>40)
				{$resultat_operation = "La note de l'élève avec ID $raw[2] est incorrecte";}
			else
			{
				// Mise à jour des notes de l'élève dans la table inscription
				$query = "UPDATE inscription SET note=$note_eleve WHERE ideleve=$raw[2] AND idseances=$id_seance";
				$result2 = mysqli_query($connect, $query);
				if(!$result2) { $resultat_operation = "<br>pas bon".mysql_error($connect); }
				else
				{ 
					$reussite=1;
					$resultat_operation = "La note de l'élève avec ID $raw[2] a été mise à jour";
				}
			}
			if($reussite) // Réussite de l'ajout
			{ 
				echo "<div id='statut_reu'>".$resultat_operation."</div>"; }
			else          // Un soucis à empéché l'ajout
			{ 	echo "<div id='statut_ech'>".$resultat_operation."</div>"; }

		}
		$resultat_operation = "Notes enregistrées";
		
	}
?>

	<?php
		if(!$reussite) // Réussite de l'ajout
			{ 
		 echo "<div id='statut_ech'>".$resultat_operation."<br/><a href='validation_seance.php'>Retour à la saisie</a></div>" ; }
	?>
	
	</section>
</body>
</html>
  
  
  
