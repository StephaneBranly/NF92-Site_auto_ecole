<?php
	// Récupération des variables
	if(isset($_POST['nom_theme'])) {$nom_theme = $_POST['nom_theme'];}
	if(isset($_POST['description'])) {$description = $_POST['description'];}
  
	$resultat_operation = "404";
	$reussite=0;
	// Vérification des variables récupérées
	if(empty($nom_theme) || empty($description))
		{$resultat_operation = "Un champ est vide";}
	elseif(strlen($nom_theme)>30)
		{$resultat_operation = "Nom du thème non valide";}
	else
	{
		// Ajout des variables de connection à la base de données
		include_once "config_bdd.php";
		// Connection BDD
		$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
		// Création de la requête pour vérifier qu'il n'existe pas déjà un thème avec ce nom et récupérer en même temps le booléen pour savoir si la séance est supprimée
		$result = mysqli_query($connect, "SELECT * FROM `themes` WHERE nom='$nom_theme'");
		$compteur=0;
		$supprime=1;
		while($raw=mysqli_fetch_array($result, MYSQL_NUM))
		{
			$supprime=$raw[2];
			$compteur++;
		}
		if($compteur!=0 && $supprime==0)
			{$resultat_operation = "Un thème actif portant le même nom existe déjà";}
		elseif($compteur!=0 && $supprime==1)
		{
			// Création de la requête d'update si le thème doit être réactivé
			$query = "UPDATE `themes` SET `supprime` = '0' WHERE nom='$nom_theme'";
			$result = mysqli_query($connect, $query);
			if(!$result) { $resultat_operation = "<br>pas bon".mysql_error($connect); }
			else{ $resultat_operation = "Un thème supprimé portant le même nom a été retrouvé, il a été réactivé"; $reussite=1;}
		}
		else
		{
			// Création de la requête d'ajout pour ajouter le nouveau thème
			$query = "insert into themes values (NULL, '$nom_theme', FALSE, '$description')";
			$result = mysqli_query($connect, $query);
			if(!$result) { $resultat_operation = "<br>pas bon".mysql_error($connect); }
			else{ $resultat_operation = "Ajout du thème correctement effectué"; $reussite=1;}
			mysqli_close($connect);
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
			{ echo "<div id='statut_ech'>".$resultat_operation."<br/><a href='ajout_theme.php'>Retour à la saisie</a></div>" ; }
	?>
	
	</section>
</body>
</html>
