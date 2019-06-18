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
	if(isset($_POST['id_eleve'])) {$id_eleve = $_POST['id_eleve'];}
	
	$resultat_operation = "404";
	$reussite=0;
	// Vérification des variables récupérées
	if(empty($id_eleve))
		{$resultat_operation = "Un champ est vide";}
	elseif(!is_numeric($id_eleve))
		{$resultat_operation = "ID de l'élève non valide";}
	else{
		// Récupération de la date du jour mise dans $dateajd
		date_default_timezone_set('Europe/Paris');
		$dateajd = date("Y\-m\-d");
		
		// Ajout des variables de connection à la base de données
		include_once "config_bdd.php";
		// Connection BDD
		$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
		
		// Création de la requête pour récupérer la ligne de l'élève selectionné
		$prenom="";
		$nom="";
		$result = mysqli_query($connect, "SELECT * FROM `eleves` WHERE ideleve=$id_eleve");
		while($raw=mysqli_fetch_array($result, MYSQL_NUM))
		{
			$prenom=$raw[2];
			$nom=$raw[1];
		}
		echo "<h1>Voici le calendrier de l'élève $nom $prenom</h1>";
		// Création de la requête pour récupérer les séances de l'élève (tab inscription) en ayant la date qui doit être future (tab séances) et en ayant le nom des thèmes (tab thèmes)
		$query = "";
		$result = mysqli_query($connect, "SELECT * FROM `inscription` INNER JOIN `seances` ON seances.idseance=inscription.idseances INNER JOIN `themes` ON seances.idtheme=themes.idtheme WHERE ideleve=$id_eleve AND DATEDIFF( `DateSeance` , '$dateajd' )>=0 ORDER BY DateSeance ASC");
		echo "<table name='calendrier'>";
		echo "<thead><tr><th>Date</th><th>Thème</th></tr></thead><tbody>";
		while($raw=mysqli_fetch_array($result, MYSQL_NUM))
		{
			echo "<tr><td>$raw[5]</td><td>$raw[9]</td></tr>";
		}
		echo "</tbody></table>";
		$reussite=1;
		$resultat_operation = "Fiche élève affichée";
	}
?>

	<?php
		if($reussite) // Réussite de l'ajout
			{ echo "<div id='requete'>".$query."</div>"; 
			 echo "<div id='statut_reu'>".$resultat_operation."<br/><a href='visualisation_calendrier_eleve.php'>Retour à la saisie</a></div>"; }
		else          // Un soucis à empéché l'ajout
			{ echo "<div id='statut_ech'>".$resultat_operation."<br/><a href='visualisation_calendrier_eleve.php'>Retour à la saisie</a></div>" ; }
	?>
	
	</section>
</body>
</html>
  
  
  
