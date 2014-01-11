<?php
	define('ANNUAIRE', true);
	define('PATH', "./");
	require("../" . 'common.php');
	mysql_query("SET NAMES UTF8");
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
	<a href="./link.php" class="return_link">Retour</a>
		<div id="top_middle_page"></div>
		<div id="middle_middle_page">
			<div id="content">
			<?php
			if (isset($_SESSION['MUS_ID']))
			{
				if (isset($_POST['Checker']))
				{					
					// sélection d'un catégorie
					if (isset($_POST['select_cat']))
					{
						if (($_POST['liste_cat']) > 0)
						{
							$extension = " AND C.CAT_ID = '" . intval($_POST['liste_cat']) . "'";							
						}
						else echo "<H1>Aucune fiche disponible</H1>";  
					}
					// voir toutes les fiches
					if (isset($_POST['consult_fiches']))
					{
						$extension = "";
					}
					$result = get_sql_result("SELECT F.FICHE_ID, F.FICHE_LIB, F.FICHE_DESC, C.CAT_LIB FROM FICHE F, CATEGORIE C WHERE C.CAT_ID = F.CAT_ID AND C.MUS_ID = '" . $_SESSION['MUS_ID'] . "'" . $extension, $mysql_link);						
					if (isset($result))
					{
						if (mysql_num_rows($result) == 0)
							echo "<H1>Aucune fiche disponible</H1>"; 
					}
				}				
			}
			?>			
			<form method="post" action="consultation.php">
			<input type="hidden" name="Checker" value="Check">
				<fieldset>
				<legend>CONSULTATION</legend>
					<table>
						<tr>
							<td><input type="submit" value="Voir toutes les fiches" name="consult_fiches"/></td>
						</tr>
						<tr>
							<td><br><br>ou<br><br></td>
						</tr>
						<tr>
						<td><label for="fichbycat">par cat&eacute;gorie</label></td>
						<td><select name="liste_cat" id="liste_cat"> 
						<?php
						$result2 = get_sql_result("SELECT CAT_ID, CAT_LIB FROM categorie WHERE MUS_ID = " . $_SESSION['MUS_ID'] . " ORDER BY CAT_LIB", $mysql_link);
						if (isset($result2))
						{
							if (mysql_num_rows($result2) == 0)
								echo '<option value="0">Aucune Cat&eacute;gorie</option><br/>';
							else
							{
								while ($donnees2 = mysql_fetch_array($result2, MYSQL_ASSOC))
								{
									echo '<option value="'.$donnees2['CAT_ID'].'">'.$donnees2['CAT_LIB'].'</option><br/>';						
								}					
							}
						}		
						?>
						</select></td>
						<td><input type="submit" value="Afficher" name="select_cat"/></td>
						</tr>
					</table>				
				</fieldset>
			</div>
			</form>
			<div class="liste">
				<table>					
					<tr class="trth">
						<th width=50px>Id</th>
						<th width=150px>Libell&eacute;</th>
						<th width=300px>Description</th>
						<th width=200px>Cat&eacute;gorie</th>						
					</tr>
					<?php
					if (isset($result))
					{
						while ($donnees = mysql_fetch_array($result, MYSQL_ASSOC))
						{						
					?>
						<tr>
						<td width=50px><?php echo intval($donnees['FICHE_ID']);?></td>
						<td width=100px><?php echo $donnees['FICHE_LIB'];?></td>
						<td width=300px><?php echo $donnees['FICHE_DESC'];?></td>
						<td width=200px><?php echo $donnees['CAT_LIB'] ;?></td>											
						</tr>
					<?php
						}
					}
					?>				
			</table>
		</div>			
		</div>
		</div>
	</div>
	<div id="bottom_middle_page"></div>
	<div id="bottom_page"><p>yann.tanquerel@gmail.com</p></div>
</body>
</html>