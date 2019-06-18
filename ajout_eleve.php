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
    <form action="ajouter_eleve.php" method="post">
      <h1>Ajout d'élève</h1>
      <label for="nom">Nom : </label><input maxlength="30" id="nom" name="nom" type="text"><br />
      <label for="prenom">Prénom : </label><input maxlength="30" id="prenom" name="prenom" type="text"><br />
      <label for="birthday">Date de naissance : </label>
	  <?php
		//Création de la liste pour renseigner la date
		$liste_mois=array("Janvier", "Février", "Mars", "Avril", "Mai", "Juin", "Juillet", "Août", "Septembre", "Octobre", "Novembre", "Décembre");
		
		// Création liste jours
		echo "<select name='jour_bday' class='date'>";
		for($x=1;$x<32;$x++)
		{
			echo "<option value='".$x."'>".$x."</option>";
		}
		echo "</select>";
			
		// Création liste mois
		echo "<select name='mois_bday' class='date'>";
		$num_mois=1;
		foreach($liste_mois as $mois)
		{
			echo "<option value='".$num_mois."'>".$mois."</option>";
			$num_mois++;
		}
		echo "</select>";
			
		// Création liste années
		echo "<select name='annee_bday' class='date'>";
		for($x=1900;$x<2019;$x++)
		{
			echo "<option value='".$x."'>".$x."</option>";
		}
		echo "</select>";
	  ?>
	  <br />
      <input type="submit" value="Ajouter" />
    </form>
</section>
</body>
</html>
