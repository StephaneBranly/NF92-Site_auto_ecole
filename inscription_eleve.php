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
    <form action="inscrire_eleve.php" method="post">
		<h1>Inscription d'un élève à une séance</h1>
		<?php
			// Récupération de la date du jour mise dans $inscription
			date_default_timezone_set('Europe/Paris');
			$inscription = date("Y\-m\-d");

			// Ajout des variables de connection à la base de données
			include_once "config_bdd.php";
			// Connection BDD
			$connect = mysqli_connect($dbhost,$dbuser,$dbpass,$dbname) or die ('Error connecting to my sql');
			
			// Création de la requête pour récupérer toutes les séances ayant une date future
			$result = mysqli_query($connect, "SELECT * FROM `seances` WHERE DATEDIFF( `DateSeance` , '$inscription' )>=0");
			echo "<label for='id_seance'>Séance : </label>";
			echo "<select name='id_seance'>";
			while($raw=mysqli_fetch_array($result, MYSQL_NUM))
			{
				echo "<option value='$raw[0]'>";
				// Récupération de la ligne du thème pour avoir le nom du thème
				$result2 = mysqli_query($connect, "SELECT * FROM `themes` WHERE idtheme='$raw[3]'");
				while($raw2=mysqli_fetch_array($result2, MYSQL_NUM))
				{
					echo"$raw[1] : $raw2[1]</option>";
				}
			}
			echo "</select><br/>";
			
			// Création de la requête pour récupérer tous les élèves
			$result = mysqli_query($connect, "SELECT * FROM `eleves` ORDER BY `nom` ASC");
			echo "<label for='id_eleve'>Elève : </label>";
			echo "<select name='id_eleve'>";
			while($raw=mysqli_fetch_array($result, MYSQL_NUM))
			{
				echo "<option value='$raw[0]'>$raw[1] $raw[2]</option>";
				
			}
			echo "</select>";
		?>
	  <br />
      <input type="submit" value="Inscrire à la séance" />
    </form>
</section>
</body>
</html>
