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
  <section id="contenu">
    <form action="visualiser_calendrier_eleve.php" method="post">
		<h1>Consultation du calendrier d'un élève</h1>
		<?php
			// Ajout des variables de connection à la base de données
			include_once "config_bdd.php";
			// Connection BDD
			$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
			
			// Création de la requête pour récupérer tous les élèves
			$query = "";
			$result = mysqli_query($connect, "SELECT * FROM `eleves` ORDER BY `nom` ASC");
			echo "<select name='id_eleve'>";
			while($raw=mysqli_fetch_array($result, MYSQL_NUM))
			{
				echo "<option value='$raw[0]'>$raw[1] $raw[2]</option>";
			}
			echo "</select>";
		?>
	  <br />
      <input type="submit" value="Consulter" />
    </form>
</section>
</body>
</html>
