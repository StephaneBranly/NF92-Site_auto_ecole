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
    <form action="ajouter_seance.php" method="post">
		<h1>Ajout d'une séance</h1>
		<label for="date_seance">Date de la séance : </label>
		<?php
		//Création de la liste pour renseigner la date
		$liste_mois=array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
		
		// Récupération de la date du jour mise dans $aujourdhui
		date_default_timezone_set('Europe/Paris');
		$aujourdhui = date("Y\-m\-d");
		// Séparation dans un tableau date[]
		$date = explode("-", $aujourdhui);
		
		// Création liste jours
		echo "<select name='jour_seance' class='date'>";
		for($x=1;$x<32;$x++)
		{
			echo "<option value='".$x."'";
			if($x==$date[2]) // Activation par défaut du jour actuel
			{ echo "selected"; }
			echo ">".$x."</option>";
		}
		echo "</select>";
			
		// Création liste mois
		echo "<select name='mois_seance' class='date'>";
		$num_mois=1;
		foreach($liste_mois as $mois)
		{
			echo "<option value='".$num_mois."'";
			if($num_mois==$date[1]) // Activation par défaut du mois actuel
			{ echo "selected"; }
			echo">".$mois."</option>";
			$num_mois++;
		}
		echo "</select>";
			
		// Création liste années
		echo "<select name='annee_seance' class='date'>";
		for($x=2000;$x<2100;$x++)
		{
			echo "<option value='".$x."'";
			if($x==$date[0]) // Activation par défaut de l'année actuelle
			{ echo "selected"; }
			echo ">".$x."</option>";
		}
		echo "</select>";
	  ?>
	  <br /><label for="effectif">Effectif : </label><input min="1" value="1" id="effectif" name="effectif" type="number"><br />
	  <?php
		// Ajout des variables de connection à la base de données
		include_once "config_bdd.php";
		$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
		
		// Création de la requête pour récupérer tous les thèmes actifs
		$result = mysqli_query($connect, "SELECT * FROM themes WHERE supprime=0 ORDER BY nom ASC");
		echo "<label for='id_theme'>Thème : </label>";
		echo "<select name='id_theme'>";
		while($raw=mysqli_fetch_array($result, MYSQL_NUM))
		{
			echo "<option value='$raw[0]'>$raw[1] : $raw[3]</option>";
		}
		echo "</select>";
	?>
	  <br />
      <input type="submit" value="Enregistrer séance" />
    </form>
</section>
</body>
</html>
