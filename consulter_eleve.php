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
		// Ajout des variables de connection à la base de données
		include_once "config_bdd.php";
		// Connection BDD
		$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
		// Création de la requête pour récupérer la ligne de l'élève selectionné
		$query = "";
		$result = mysqli_query($connect, "SELECT * FROM `eleves` WHERE ideleve=$id_eleve");
		echo "<table>";
		while($raw=mysqli_fetch_array($result, MYSQL_NUM))
		{
			echo "<tbody>
					<tr><td>id</td><td>$raw[0]</td></tr>
					<tr><td>Nom</td><td>$raw[1]</td></tr>
					<tr><td>Prénom</td><td>$raw[2]</td></tr>
					<tr><td>Date de naissance</td><td>$raw[3]</td></tr>
					<tr><td>Date d'inscription</td><td>$raw[4]</td></tr></tbody>";
		}
		echo "</table>";
		$reussite=1;
		$resultat_operation = "Fiche élève affichée";
	}
?>

  
	<?php
		if($reussite) // Réussite de l'ajout
			{ echo "<div id='requete'>".$query."</div>"; 
			 echo "<div id='statut_reu'>".$resultat_operation."<br/><a href='consultation_eleve.php'>Retour à la saisie</a></div>"; }
		else          // Un soucis à empéché l'ajout
			{ echo "<div id='statut_ech'>".$resultat_operation."<br/><a href='consultation_eleve.php'>Retour à la saisie</a></div>" ; }
	?>
	
	</section>
</body>
</html>
  
  
  
