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
	if(isset($_POST['nom'])) {$nom = chop($_POST['nom']);}
	if(isset($_POST['prenom'])) {$prenom = chop($_POST['prenom']);}
	if(isset($_POST['jour_bday'])) {$jour_bday = $_POST['jour_bday'];}
	if(isset($_POST['mois_bday'])) {$mois_bday = $_POST['mois_bday'];}
	if(isset($_POST['annee_bday'])) {$annee_bday = $_POST['annee_bday'];}
	
	
	$resultat_operation = "404";
	$reussite=0;
	// Vérification des variables récupérées
	if(empty($nom) || empty($prenom) || empty($jour_bday) || empty($mois_bday) || empty($annee_bday))
		{$resultat_operation = "Un champ est vide";}
	elseif(!is_numeric($jour_bday) || $jour_bday<=0 || $jour_bday>=32)
		{$resultat_operation = "Jour non valide";}
	elseif(!is_numeric($mois_bday) || $mois_bday<=0 || $mois_bday>=13)
		{$resultat_operation = "Mois non valide";}
	elseif(!is_numeric($annee_bday) || $annee_bday<1900 || $annee_bday>=2019)
		{$resultat_operation = "Année non valide";}
	elseif(strlen($prenom)>30)
		{$resultat_operation = "Prénom non valide";}
	elseif(strlen($nom)>30)
		{$resultat_operation = "Nom non valide";}
	elseif(!checkdate ($mois_bday , $jour_bday ,$annee_bday))
		{$resultat_operation = "Date d'anniversaire non valide";}
	else{
		// Récupération de la date du jour mise dans $inscription
		date_default_timezone_set('Europe/Paris');
		$inscription = date("Y\-m\-d");

		$date_bday=$annee_bday."-".$mois_bday."-".$jour_bday;
		
		// Vérification que la date d'anniversaire est bien antérieure à aujourd'hui
		$interval = strtotime($date_bday) - strtotime($inscription);
		if($interval>=0)
		{$resultat_operation = "Date de naissance non valide";}
		else
		{	
			// Ajout des variables de connection à la base de données
			include_once "config_bdd.php";
			// Connection BDD
			$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
			
			// Création de la requête d'ajout
			$query = "insert into eleves values (NULL, '$nom', '$prenom', '$date_bday', '$inscription')";
			$result = mysqli_query($connect, $query);
			if(!$result) { $resultat_operation = "<br>pas bon".mysql_error($connect); }
			else{ $resultat_operation = "Ajout de l'élève correctement effectué"; $reussite=1;}
			mysqli_close($connect);
		}
	}
?>

	<?php
		if($reussite) // Réussite de l'ajout
			{  echo "<div id='statut_reu'>".$resultat_operation."</div>"; }
		else          // Un soucis à empéché l'ajout
			{ echo "<div id='statut_ech'>".$resultat_operation."<br/><a href='ajout_eleve.php'>Retour à la saisie</a></div>" ; }
	?>
	
	</section>
</body>
</html>
  
  
  
