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
		// Récupération de la date du jour mise dans $inscription
		date_default_timezone_set('Europe/Paris');
		$inscription = date("Y\-m\-d");
		
		// Ajout des variables de connection à la base de données
		include_once "config_bdd.php";
		// Connection BDD
		$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
		
		// Création de la requête pour récupérer toutes les personnes inscrites (tab inscription) d'une séance demandée (tab séances) avec les noms et prénoms des élèves (tab élèves)
		$result = mysqli_query($connect, "SELECT * FROM `seances` INNER JOIN `inscription` ON inscription.idseances=seances.idseance INNER JOIN `eleves` ON inscription.ideleve=eleves.ideleve WHERE idseances=$id_seance");
		echo "<form action='noter_eleves.php' method='post'>";
		echo "<table id='validation_seance'>";
		echo "<thead><tr><th>Elève</th><th>Nombre de fautes</th></th></thead><tbody>";
		while($raw=mysqli_fetch_array($result, MYSQL_NUM))
		{
			// Comparaison des dates pour vérifier qu'elle la séance est passée
			if(strtotime($raw[1]) - strtotime($inscription)>0)
			{$resultat_operation = "La séance n'est pas encore passée";}
			else
			{
				$nombre_fautes=40-$raw[7];
				if($nombre_fautes>40)
				{ $nombre_fautes=0; }
				echo "<tr><td>$raw[9] $raw[10]</td><td><input type='number' name='ideleve_$raw[6]' value ='$nombre_fautes' min='0' max='40'/></td></tr>";
				$resultat_operation = "Tableau affiché";
				$reussite=1;
				echo "<input name='id_seance' value='$id_seance' type='hidden'/>";	
			}
		}
		echo "</tbody></table>";
		echo "<input type='submit' value='Valider séance' />";
		echo "</form>";
	}
?>

	<?php
		if($reussite) // Réussite de l'ajout
			{ 
			 echo "<div id='statut_reu'>".$resultat_operation."</div>"; }
		else          // Un soucis à empéché l'ajout
			{ echo "<div id='statut_ech'>".$resultat_operation."<br/><a href='validation_seance.php'>Retour à la saisie</a></div>" ; }
	?>
	
	</section>
</body>
</html>
  
  
  
