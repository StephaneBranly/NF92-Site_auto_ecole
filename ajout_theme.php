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
    <form action="ajouter_theme.php" method="post">
      <h1>Ajout d'un thème</h1>
      <label for="nom_theme">Nom du thème : </label><input maxlength="30" id="nom_theme" name="nom_theme" type="text"><br />
      <label for="description">Description : </label><textarea id="description" name="description" type="text"></textarea><br />
	  <br/>
      <input type="submit" value="Ajouter" />
    </form>
</section>
</body>
</html>
