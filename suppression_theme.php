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
	<form action="supprimer_theme.php" method="post">
		<h1>Suppression d'un thème</h1>
		<?php
			// Ajout des variables de connection à la base de données
			include_once "config_bdd.php";
			// Connection BDD
			$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
			
			// Création de la requête pour récupérer tous les thèmes non supprimés
			$query = "";
			$result = mysqli_query($connect, "SELECT * FROM `themes` WHERE supprime=0 ORDER BY `nom` ASC");
			echo "<select name='id_theme'>";
			while($raw=mysqli_fetch_array($result, MYSQL_NUM))
			{
				echo "<option value='$raw[0]'>$raw[1]</option>";
			}
			echo "</select>";
		?>
	  <br />
	  <input type="submit" value="Supprimer" />
	</form>
</section>
</body>
</html>





