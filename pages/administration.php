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
					// Création d'une fiche
					if (isset($_POST['creer_fich']))
					{
						if (!empty($_POST['lib_fich']))
						{
							if (!empty($_POST['desc_fich']))
							{
								if (($_POST['fiche_cat']) > 0)
								{
									$Lib_Fich = $_POST['lib_fich'];
									$Desc_Fich = $_POST['desc_fich'];
									$Cat_ID = $_POST['fiche_cat'];								
									$insert = 'INSERT INTO fiche(Fiche_Lib, Fiche_Desc, Cat_ID, Mus_ID) VALUES ("' . $Lib_Fich . '", "' . $Desc_Fich . '", "' . $Cat_ID . '", "' . $_SESSION['MUS_ID'] . '")';									
									if (mysql_query($insert) != null)
									{
										echo "<H1> La fiche a &eacute;t&eacute; cr&eacute;&eacute;e </H1>";
										echo die( '<meta http-equiv="refresh" content="2;" />');
										mysql_close($mysql_link);
									}
									else echo "<H1> Probl&egrave;me lors de la cr&eacute;ation de la fiche</H1>";									
								} 
								else 
								{						
									echo "<H1>Merci de cr&eacute;er une cat&eacute;gorie</H1>"; 
								}
							} 
							else 
							{						
								echo "<H1>Merci de saisir une description</H1>"; 
							}
						} 
						else 
						{						
							echo "<H1>Merci de saisir un libell&eacute;</H1>"; 
						}
					} 
					else					
					{
						// modification d'une fiche
						if (isset($_POST['modif_fich']))						
						{
							// Pas de fiche
							if (($_POST['liste_fich']) == 0) 
							{
								echo "<H1>Aucune fiche a modifier</H1>"; 
							}
							else
							{
								// A implémenter
							}
						}
						else
						{
							// Suppression d'une fiche
							if (isset($_POST['supp_fich']))						
							{
								// Pas de fiche
								if (($_POST['liste_fich']) == 0) 
								{
									echo "<H1>Aucune fiche a supprimer</H1>"; 
								}
								else
								{								
									$delete2 = 'DELETE FROM fiche WHERE FICHE_ID = "' . $_POST['liste_fich'] . '"';
									if (mysql_query($delete2) != null)
									{
										echo "<H1> La fiche a &eacute;t&eacute; supprim&eacute;e </H1>";
										echo die( '<meta http-equiv="refresh" content="2;" />');
										mysql_close($mysql_link);
									} else echo "<H1> Probl&egrave;me lors de la suppression de la fiche</H1>";								
								}
							}
							else
							{
								// modification d'une catégorie
								if (isset($_POST['modif_cat']))						
								{
									// Pas de catégorie
									if (($_POST['liste_cat']) == 0) 
									{
										echo "<H1>Aucune cat&eacute;gorie a modifier</H1>"; 
									}
									else
									{
										// A implémenter
									}
								}
								else
								{
									// Création d'une catégorie
									if (isset($_POST['creer_cat']))
									{							
										if (!empty($_POST['nom_cat']))
										{
											$nom_cat = $_POST['nom_cat'];								
											// Création de la 1ère catégorie								
											if (($_POST['pere_cat']) == 0)
											{									
												$insert = 'INSERT INTO categorie(Cat_Lib, cat_BG, Cat_BD, Mus_ID) VALUES ("' . $nom_cat . '", "1", "2", "' . $_SESSION['MUS_ID'] . '")';									
												if (mysql_query($insert) != null)
												{
													echo "<H1> La cat&eacute;gorie a &eacute;t&eacute; cr&eacute;&eacute;e </H1>";
													echo die( '<meta http-equiv="refresh" content="2;" />');
													mysql_close($mysql_link);
												}
												else echo "<H1> Probl&egrave;me lors de la cr&eacute;ation de la cat&eacute;gorie</H1>";									
											} 
											else 
											// Création des autres catégories
											{							
												// Insertion par la droite dans arborescence intervallaire 									
												$Pere_ID = $_POST['pere_cat'];
												$update = 'UPDATE categorie SET CAT_BD = CAT_BD + 2 WHERE CAT_BD >= "' . $Pere_ID . '"';
												if (mysql_query($update) != null)
												{
													$update = 'UPDATE categorie SET CAT_BG = CAT_BG + 2 WHERE CAT_BG >= "' . $Pere_ID . '"';
													if (mysql_query($update) != null)
													{
														$Pere_ID_2 = $Pere_ID + 1;											
														$insert = 'INSERT INTO categorie(Cat_Lib, cat_BG, Cat_BD, Mus_ID) VALUES ("' . $nom_cat . '", "' . $Pere_ID . '", "' . $Pere_ID_2 . '", "' . $_SESSION['MUS_ID'] . '")';
														if (mysql_query($insert) != null)
														{
															echo "<H1> La cat&eacute;gorie a &eacute;t&eacute; cr&eacute;&eacute;e </H1>";
															echo die( '<meta http-equiv="refresh" content="2;" />');
															mysql_close($mysql_link);
														} else echo "<H1> Probl&egrave;me lors de la cr&eacute;ation de la cat&eacute;gorie</H1>";
													} else echo "<H1> Probl&egrave;me lors de la cr&eacute;ation de la cat&eacute;gorie</H1>";
												} else echo "<H1> Probl&egrave;me lors de la cr&eacute;ation de la cat&eacute;gorie</H1>";
											}								
										} 
										else 
										{						
											echo "<H1>Merci de saisir un nom de cat&eacute;gorie</H1>"; 
										}
									} 
									else
									{
										// Supression de catégorie
										if (isset($_POST['supp_cat']))
										{
											// Pas de catégorie
											if (($_POST['liste_cat']) == 0) 
											{
												echo "<H1>Aucune cat&eacute;gorie a supprimer"; 
											}
											else
											{
												$cat_ID = intval($_POST['liste_cat']);									
												// On vérifie qu'il n'y aucune fiche associée à la catégorie
												$result = get_sql_result("SELECT COUNT(*) FROM fiche WHERE MUS_ID = '" . $_SESSION['MUS_ID'] . "' AND CAT_ID = '"  . $cat_ID . "'", $mysql_link);
												if (isset($result))
												{
													if (mysql_num_rows($result) > 0)
														echo "<H1> Suppression impossible: Il existe des fiches associ&eacute;es a la cat&eacute;gorie</H1> ";								
													else
													{												
														// on recup les infos de la catégorie
														$result = get_sql_result("SELECT CAT_BD, CAT_BG FROM categorie WHERE MUS_ID = '" . $_SESSION['MUS_ID'] . "' AND CAT_ID = '"  . $cat_ID . "'", $mysql_link);									
														if (isset($result))
														{
															$donnees = mysql_fetch_array($result, MYSQL_ASSOC);
															$cat_BD = intval($donnees['CAT_BD']);
															$cat_BG = intval($donnees['CAT_BG']);
															$interval = $cat_BD - $cat_BG;
															// Si c'est une feuille													
															if ($interval == 1)
															{
																$delete = 'DELETE FROM categorie WHERE CAT_BG = "' . $cat_BG . '"';											
															} 
															// Si c'est un arbre
															else
															{
																$delete = 'DELETE FROM categorie WHERE CAT_BG >= "' . $cat_BG . '" AND CAT_BD <= "' . $cat_BD . '"';
															}
															if (mysql_query($delete) != null)
															{
																$interval++;
																$update = 'UPDATE categorie SET CAT_BG = CAT_BG - "' . $interval . '" WHERE  CAT_BG >= "' . $cat_BG . '"';
																if (mysql_query($update) != null)
																{												
																	$update = 'UPDATE categorie SET CAT_BD = CAT_BD - "' . $interval . '" WHERE  CAT_BD >= "' . $cat_BG . '"';
																	if (mysql_query($update) != null)
																	{
																		echo "<H1> La cat&eacute;gorie a &eacute;t&eacute; supprim&eacute;e </H1>";
																		echo die( '<meta http-equiv="refresh" content="2;" />');
																		mysql_close($mysql_link);
																	} else echo "<H1> Probl&egrave;me lors de la suppression de la cat&eacute;gorie</H1>";
																} else echo "<H1> Probl&egrave;me lors de la suppression de la cat&eacute;gorie</H1>";
															} else echo "<H1> Probl&egrave;me lors de la suppression de la cat&eacute;gorie</H1>";
														}
													}
												}
											}
										}
									}
								}
							}
						}
					}
				}
			}
			?>			
			<form method="post" action="administration.php">
			<input type="hidden" name="Checker" value="Check">
					<fieldset>
					<legend>Gestion des cat&eacute;gories</legend>	
						<tr>
						<td><label for="cat">S&eacute;lectionner une cat&eacute;gorie</label></td>
						<td><select name="liste_cat" id="liste_cat"> 
						<?php
						$result = get_sql_result("SELECT CAT_ID, CAT_LIB FROM categorie WHERE MUS_ID = " . $_SESSION['MUS_ID'] . " ORDER BY CAT_LIB", $mysql_link);
						if (isset($result))
						{
							if (mysql_num_rows($result) == 0)
								echo '<option value="0">Aucune Cat&eacute;gorie</option><br/>';								
							else
							{
								while ($donnees = mysql_fetch_array($result, MYSQL_ASSOC))
								{
									echo '<option value="'.$donnees['CAT_ID'].'">'.$donnees['CAT_LIB'].'</option><br/>';						
								}					
							}
						}		
						?>
						</select></td>
						<td><input type="submit" value="Modifier" name="modif_cat" disabled="disabled" /></td>
						<td><input type="submit" value="Supprimer" name="supp_cat"/></td>
						</tr>					
						<fieldset>
						<legend>Cr&eacute;er une cat&eacute;gorie</legend>
						<table>
						<tr>
						<td><label for="nom_cat">Nom de la cat&eacute;gorie:</label></td>						
						<td><input type="text" name="nom_cat" id="nom_cat" size="45"/></td>
						</tr>
						<tr>
						<td><label for="pere_cat">P&egrave;re de la cat&eacute;gorie:</label></td>
						<td><select name="pere_cat" id="pere_cat"> 
						<?php
						$result = get_sql_result("SELECT CAT_BD, CAT_LIB FROM categorie WHERE MUS_ID = " . $_SESSION['MUS_ID'] . " ORDER BY CAT_LIB", $mysql_link);
						if (isset($result))
						{
							if (mysql_num_rows($result) == 0)
								echo '<option value="0">Aucune Cat&eacute;gorie</option><br/>';
							else
							{
								while ($donnees = mysql_fetch_array($result, MYSQL_ASSOC))
								{
									echo '<option value="'.$donnees['CAT_BD'].'">'.$donnees['CAT_LIB'].'</option><br/>';						
								}					
							}
						}
						?>
						</select></td>
						</tr>
						<tr>
						<td><input type="submit" value="cr&eacute;er la cat&eacute;gorie" name="creer_cat"/></td>																		
						</tr>	
						</table>
						</fieldset>
					</fieldset>					
						<fieldset>
						<legend>Gestion des fiches</legend>												
							<tr>
							<td><label for="fich">S&eacute;lectionner une fiche</label></td>
							<td><select name="liste_fich" id="liste_fich"> 
							<?php
							$result = get_sql_result("SELECT FICHE_ID, FICHE_LIB, FICHE_DESC FROM fiche WHERE MUS_ID = " . $_SESSION['MUS_ID'] . " ORDER BY FICHE_LIB", $mysql_link);
							if (isset($result))
							{
								if (mysql_num_rows($result) == 0)
									echo '<option value="0">Aucune Fiche</option><br/>';
								else
								{
									while ($donnees = mysql_fetch_array($result, MYSQL_ASSOC))
									{
										echo '<option value="'.$donnees['FICHE_ID'].'">'.$donnees['FICHE_LIB'].'</option><br/>';						
									}					
								}
							}		
							?>
							</select></td>
							<td><input type="submit" value="Modifier" name="modif_fich" disabled="disabled" /></td>
							<td><input type="submit" value="Supprimer" name="supp_fich"/></td>
							</tr>
							<fieldset>
							<legend>Cr&eacute;er une fiche</legend>
							<table>
							<tr>
							<td><label for="cat">S&eacute;lectionner une cat&eacute;gorie</label></td>
							<td><select name="fiche_cat" id="fiche_cat"> 
							<?php
							$result = get_sql_result("SELECT CAT_ID, CAT_LIB FROM categorie WHERE MUS_ID = " . $_SESSION['MUS_ID'] . " ORDER BY CAT_LIB", $mysql_link);
							if (isset($result))
							{
								if (mysql_num_rows($result) == 0)
									echo '<option value = "0">Aucune Cat&eacute;gorie</option><br/>';
								else
								{
									while ($donnees = mysql_fetch_array($result, MYSQL_ASSOC))
									{
										echo '<option value="'.$donnees['CAT_ID'].'">'.$donnees['CAT_LIB'].'</option><br/>';						
									}					
								}
							}		
							?>
							</select></td>
							</tr>
							<tr>
							<td><label for="lib_fich">Libell&eacute; de la fiche:</label></td>
							<td><input type="text" name="lib_fich" id="lib_fich" size="45"/></td>
							</tr>
							<tr>
							<td><label for="desc_fich">Description de la fiche:</label></td>
							<td><input type="text" name="desc_fich" id="desc_fich" size="45"/ /></td>
							</tr>
							<td><input type="submit" value="cr&eacute;er la fiche" name="creer_fich"/></td>																		
							</tr>
							</table>
							</fieldset>
						</fieldset>

			</div>
			</form>			
		</div>
		</div>
	</div>
	<div id="bottom_middle_page"></div>
	<div id="bottom_page"><p>yann.tanquerel@gmail.com</p></div>
</body>
</html>