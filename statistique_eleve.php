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
    <form action="statistique_eleve.php" method="post">
		<h1>Consultation des statistiques d'un élève</h1>
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
	
	<?php
		$reussite=0;
		// Récupération du $_POST éventuel s'il a été renseigné
		if(isset($_POST['id_eleve']))
		{
			$id_eleve = $_POST['id_eleve'];
		}
		
		if(empty($id_eleve))
		{$resultat_operation = "Aucun élève n'a été sélectionné";}
		elseif(!is_numeric($id_eleve))
		{$resultat_operation = "ID d'élève non valide";}
		else
		{
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
			echo "<h1>Voici les statistiques de l'élève $nom $prenom</h1>";
			// Création de la requête pour récupérer les moyennes (AVG) des notes (tab inscription) ayant le même thème (tab séances) en effectuant la moyenne par thème (tab thèmes)
			$query = "";
			$result = mysqli_query($connect, "SELECT nom, AVG(note) FROM `inscription` INNER JOIN `seances` ON seances.idseance = inscription.idseances INNER JOIN `themes` ON seances.idtheme = themes.idtheme WHERE ideleve =$id_eleve AND DATEDIFF( `DateSeance` , '$dateajd' ) <0 AND note!=-1 GROUP BY nom");
			echo "<table name='calendrier'>";
			echo "<thead><tr><th>Thème</th><th>Moyenne (%) </th></tr></thead><tbody>";
			while($raw=mysqli_fetch_array($result, MYSQL_NUM))
			{
				$moyenne=$raw[1]*100/40;
				echo "<tr><td>$raw[0]</td><td>$moyenne</td></tr>";
			}
			echo "</tbody></table>";
			$reussite=1;
			$resultat_operation = "Fiche élève affichée";
		}
	
	?>
	
	<?php
		if($reussite) // Réussite de l'ajout
			{ echo "<div id='requete'>".$query."</div>"; 
			 echo "<div id='statut_reu'>".$resultat_operation."<br/><a href='statistique_eleve.php'>Retour à la saisie</a></div>"; }
		else          // Un soucis à empéché l'ajout
			{ echo "<div id='statut_ech'>".$resultat_operation."<br/><a href='statistique_eleve.php'>Retour à la saisie</a></div>" ; }
	?>
</section>
</body>
</html>
