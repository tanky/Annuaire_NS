<?php
session_start();
?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
	<title>Annuaire Mus&eacute;e</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link rel="stylesheet" media="screen" type="text/css" title="Design" href="./css/style.css" />
</head>

<body>
	<div id="haut">
	<div id ="Logo_NS"><img src="./images/logo_ns.jpg"/></div>
	<div id ="Titre">S&eacute;lection du mus&eacute;e</div>
	</div>
	<div id="milieu">
		<div id="top_middle_page"></div>
		<div id="middle_middle_page">
			<div id="content">
				<?php
					define('ANNUAIRE', true);
					define('PATH', "./");
					require("./" . 'common.php');
					$result = get_sql_result("SELECT MUS_ID, MUS_NAME FROM musee ORDER BY MUS_NAME", $mysql_link);
					
					if  (isset($_POST['Checker']))
					{							
						if (isset($_POST['creer_musee'])) 
						{
							if (!empty($_POST['nom_musee']))
							{
								$nom_musee = $_POST['nom_musee'];
								$result2 = get_sql_result("SELECT MUS_ID FROM musee WHERE Mus_Name LIKE '" . $nom_musee . "'", $mysql_link);
								if (mysql_num_rows($result2) == 0)																				
								{
									$insert = 'INSERT INTO musee(Mus_Name) VALUES ("' . $nom_musee . '")';					
									if (mysql_query($insert) != null)
									{
										echo "<H1> Le mus&eacute;e a &eacute;t&eacute; cr&eacute;&eacute; </H1>";
										echo die( '<meta http-equiv="refresh" content="2;" />');
									}
									else
										echo "<H1> Probl&egrave;me lors de la cr&eacute;ation du mus&eacute;e </H1>";
								}
								else
								{
									unset($_POST['nom_musee']);
									echo "<H1>Ce nom de mus&eacute;e existe. Merci de le s&eacute;lectionner.</H1>"; 
								}
							}
							else 
								echo "<H1> Veuillez saisir un nom de mus&eacute;e </H1>";
						}
						else if (isset($_POST['select_musee']))
							{				
								$_SESSION['MUS_ID'] = $_POST['liste_musee'];
								$result2 = get_sql_result("SELECT MUS_NAME FROM musee WHERE Mus_Id = " . intval($_POST['liste_musee']), $mysql_link);
								$donnees = mysql_fetch_array($result2, MYSQL_ASSOC);
								$_SESSION['MUS_NAME'] = $donnees['MUS_NAME'];		
								echo '<meta http-equiv="refresh" content="0; url=./pages/link.php"/>';
								mysql_close($mysql_link);
							}
					}
				?>
				<form method="post" action="index.php">
					<input type="hidden" name="Checker" value="Check">
					<tr>
						<tr>
							<td><br><br><br></td>
						</tr>
						<td><label for="liste_musee">S&eacute;lectionner un mus&eacute;e dans la liste : </label> </td>
						<td><select name="liste_musee" id="liste_musee" style="width:300"> 
						<?php		
						if (isset($result))
						{
							if (mysql_num_rows($result) == 0)
								echo '<option>Aucun Mus&eacute;e</option><br/>';
							else
							{
								while ($donnees = mysql_fetch_array($result, MYSQL_ASSOC))
								{
									echo '<option value="'.$donnees['MUS_ID'].'">'.$donnees['MUS_NAME'].'</option><br/>';						
								}					
							}
						}		
						?>
						</select></td>
						<td><input type="submit" value="Valider" name="select_musee"/></td>
					</tr>
					<tr>
						<td><br><br>ou<br><br></td>
					</tr>
					<tr>
						<td><label for="nom_musee">cr&eacute;er un nouveau mus&eacute;e:</label></td>
						<td><input type="text" name="nom_musee" id="nom_musee" size="45"/></td>
						<td><input type="submit" value="cr&eacute;er" name="creer_musee"/></td>
					</tr>
				</form>	
			</div>
		</div>
	</div>
	<div id="bottom_middle_page"></div>
	<div id="bottom_page"><p>yann.tanquerel@gmail.com</p></div>
</body>
</html>