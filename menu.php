<header>
    <ul id="menu">
		<li><a href="accueil.php" >Accueil</a></li>
		
		<li><a href="#" >Elèves</a>
			<ul>
				<li><a href="ajout_eleve.php" >Ajouter un élève</a></li>
				<li><a href="consultation_eleve.php" >Consulter un élève</a></li>
				<li><a href="inscription_eleve.php" >Inscrire un élève</a></li>
				<li><a href="visualisation_calendrier_eleve.php" >Visualiser le calendrier d'un élève</a></li>
				<li><a href="statistique_eleve.php" >Visualiser les statistiques d'un élève</a></li>
			</ul>
		</li>
		<li><a href="#" >Thèmes</a>
			<ul>
				<li><a href="ajout_theme.php" >Ajouter un thème</a></li>
				<li><a href="suppression_theme.php" >Supprimer un thème</a></li>
			</ul>
			
		<li><a href="#" >Séances</a>
			<ul>
				<li><a href="ajout_seance.php" >Ajouter une séance</a></li>
				<li><a href="validation_seance.php" >Valider une séance</a></li>
				<li><a href="suppression_seance.php" >Supprimer une séance</a></li>
			</ul>
		</li>
    </ul>
</header>

<script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript">
    $(function() {
      if ($.browser.msie && $.browser.version.substr(0,1)<7)
      {
        $('li').has('ul').mouseover(function(){
            $(this).children('ul').show();
            }).mouseout(function(){
            $(this).children('ul').hide();
            })
      }
    });        
</script>