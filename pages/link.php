<?php 
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Annuaire Mus&eacute;e</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="../css/style.css" />
</head>

<body>
	<div id="haut">	
	<div id ="Logo_NS"><a href="../index.php"><img src="../images/logo_ns.jpg"/></a></div>
	<div id ="Titre">Annuaire <?php echo $_SESSION['MUS_NAME'];?></div>
	</div>
	<div id="milieu">
	<a href="../index.php" class="return_link">Retour</a>
		<div id="top_middle_page"></div>
		<div id="middle_middle_page">
			<div id="content">
			<?php
			if (isset($_SESSION['MUS_ID']))
			{
				echo "<br/><br/><br/><br/>";
				echo '<a href="./consultation.php" class="link_list">Consulter les fiches</a><br/><br/>';
				echo '<a href="./administration.php" class="link_list">Administrer l\'annuaire</a><br/><br/>';
			}			
			?>
			</div>
		</div>
		<div id="bottom_middle_page"></div>
	</div>
	<div id="bottom_page"><p>yann.tanquerel@gmail.com</p></div>	
</body>
</html>