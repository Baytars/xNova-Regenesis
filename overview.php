<?php

/**
 * overview.php
 *
 * @version 1
 * @copyright 2008 By Chlorel for XNova
 */

define('INSIDE'  , true);
define('INSTALL' , false);

$ugamela_root_path = './';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

// blocking non-users
if ($IsUserChecked == false) {
	includeLang('login');
	message($lang['Login_Ok'], $lang['log_numbreg']);
}

	$lunarow = 	 doquery("SELECT * FROM {{table}} WHERE `id_owner` = '".$planetrow['id_owner']."' AND `galaxy` = '".$planetrow['galaxy']."' AND `system` = '".$planetrow['system']."' AND  `planet` = '".$planetrow['planet']."' AND `planet_type`='3'", 'planets', true);
	if (empty($lunarow)) { unset($lunarow); }

	CheckPlanetUsedFields ($lunarow);

	$mode = $_GET['mode'];
	$pl = mysql_escape_string($_GET['pl']);
	$_POST['deleteid'] = intval($_POST['deleteid']);

	includeLang('resources');
	includeLang('overview');

	switch ($mode) {
		case 'renameplanet':
			// -----------------------------------------------------------------------------------------------
         if ($_POST['action'] == $lang['namer']) {
            // Reponse au changement de nom de la planete
            $UserPlanet     = CheckInputStrings ( $_POST['newname'] );
            $newname        = mysql_escape_string(strip_tags(trim( $UserPlanet )));
//INICIO FIX Caracteres alfanuméricos en el nombre de planetas
               if (preg_match("/[^A-z0-9 _\-]/", $newname) == 1) {
               message('Has introducido alg&uacute;n car&aacute;cter ilegal. Solo se puede introducir caracteres alfanum&eacute;ricos.','Error');
               }
//FIN DEL FIX
				if ($newname != "") {
					// Deja on met jour la planete qu'on garde en memoire (pour le nom)
					$planetrow['name'] = $newname;
					// Ensuite, on enregistre dans la base de données
					doquery("UPDATE {{table}} SET `name` = '".$newname."' WHERE `id` = '". $user['current_planet'] ."' LIMIT 1;", "planets");
				}

			} elseif ($_POST['action'] == $lang['colony_abandon']) {
				// Cas d'abandon d'une colonie
				// Affichage de la forme d'abandon de colonie
				$parse                   = $lang;
				$parse['planet_id']      = $planetrow['id'];
				$parse['galaxy_galaxy']  = $galaxyrow['galaxy'];
				$parse['galaxy_system']  = $galaxyrow['system'];
				$parse['galaxy_planet']  = $galaxyrow['planet'];
				$parse['planet_name']    = $planetrow['name'];

				$page                   .= parsetemplate(gettemplate('overview_deleteplanet'), $parse);

				// On affiche la forme pour l'abandon de la colonie
				display($page, $lang['rename_and_abandon_planet']);

			} elseif ($_POST['kolonieloeschen'] == 1 && $_POST['deleteid'] == $user['current_planet']) {
				// Controle du mot de passe pour abandon de colonie
            if (md5($_POST['pw']) == $user["password"] && $user['id_planet'] != $user['current_planet']) {
//INICIO FIX Abandonar colonias (función recomendada)
				include_once($ugamela_root_path . 'includes/functions/AbandonColony.' . $phpEx);
				if (CheckFleets($planetrow)){
					$strMessage = "No se puede abandonar la colonia, hay flotas en movimiento";
					message($strMessage, $lang['colony_abandon'], 'overview.php?mode=renameplanet',3);
				}
				AbandonColony($user,$planetrow);
                $QryUpdateUser = "UPDATE {{table}} SET ";
                $QryUpdateUser .= "`current_planet` = `id_planet` ";
                $QryUpdateUser .= "WHERE ";
                $QryUpdateUser .= "`id` = '" . $user['id'] . "' LIMIT 1";
                doquery($QryUpdateUser, "users");
                // Tout s'est bien passé ! La colo a été effacée !!
                message($lang['deletemessage_ok'] , $lang['colony_abandon'], 'overview.php',3);
//FIN DEL FIX
				} elseif ($user['id_planet'] == $user["current_planet"]) {
					// Et puis quoi encore ??? On ne peut pas effacer la planete mere ..
					// Uniquement les colonies crées apres coup !!!
					message($lang['deletemessage_wrong'], $lang['colony_abandon'], 'overview.php?mode=renameplanet');

				} else {
					// Erreur de saisie du mot de passe je n'efface pas !!!
					message($lang['deletemessage_fail'] , $lang['colony_abandon'], 'overview.php?mode=renameplanet');

				}
			}

			$parse = $lang;

			$parse['planet_id']     = $planetrow['id'];
			$parse['galaxy_galaxy'] = $galaxyrow['galaxy'];
			$parse['galaxy_system'] = $galaxyrow['system'];
			$parse['galaxy_planet'] = $galaxyrow['planet'];
			$parse['planet_name']   = $planetrow['name'];

			$page                  .= parsetemplate(gettemplate('overview_renameplanet'), $parse);

			// On affiche la page permettant d'abandonner OU de renomme une Colonie / Planete
			display($page, $lang['rename_and_abandon_planet']);
			break;

		default:
		 // --- Gestion des messages ----------------------------------------------------------------------
         $Have_new_message = "";
         if($user['new_message'] >= 1)  {
            $Have_new_message .= "<tr>";
            $Have_new_message .= "<th colspan=4><a href=messages.$phpEx>";
            $m = pretty_number($user['new_message']);
            $Have_new_message .= str_replace('%m', $m, $lang['Have_new_messages']);
            $Have_new_message .= "</a></th>";
            $Have_new_message .= "</tr>";
         }

         // -----------------------------------------------------------------------------------------------
			// --- Gestion Officiers -------------------------------------------------------------------------
			// Passage au niveau suivant, ajout du point de compétence et affichage du passage au nouveau level
			$XpMinierUp  = $user['lvl_minier'] * 50;
			$XpRaidUp    = $user['lvl_raid']   * 10;
			$XpMinier    = $user['xpminier'];
			$XPRaid      = $user['xpraid'];

			$LvlUpMinier = $user['lvl_minier'] + 1;
			$LvlUpRaid   = $user['lvl_raid']   + 1;

            if( ($LvlUpMinier + $LvlUpRaid) <= 100 ) {
				if ($XpMinier >= $XpMinierUp) {
					$QryUpdateUser  = "UPDATE {{table}} SET ";
					$QryUpdateUser .= "`lvl_minier` = '".$LvlUpMinier."', ";
					$QryUpdateUser .= "`rpg_points` = `rpg_points` + 1 ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '". $user['id'] ."';";
					doquery( $QryUpdateUser, 'users');
					$HaveNewLevelMineur  = "<tr>";
					$HaveNewLevelMineur .= "<th colspan=4><a href=officier.$phpEx>". $lang['Have_new_level_mineur']."</a></th>";
				}
				if ($XPRaid >= $XpRaidUp) {
					$QryUpdateUser  = "UPDATE {{table}} SET ";
					$QryUpdateUser .= "`lvl_raid` = '".$LvlUpRaid."', ";
					$QryUpdateUser .= "`rpg_points` = `rpg_points` + 1 ";
					$QryUpdateUser .= "WHERE ";
					$QryUpdateUser .= "`id` = '". $user['id'] ."';";
					doquery( $QryUpdateUser, 'users');
					$HaveNewLevelMineur  = "<tr>";
					$HaveNewLevelMineur .= "<th colspan=4><a href=officier.$phpEx>". $lang['Have_new_level_raid']."</a></th>";
				}
			}
			// -----------------------------------------------------------------------------------------------

			// --- Gestion des flottes personnelles ---------------------------------------------------------
			// Toutes de vert vetues
			$OwnFleets       = doquery("SELECT * FROM {{table}} WHERE `fleet_owner` = '". $user['id'] ."';", 'fleets');
			$Record          = 0;
			while ($FleetRow = mysql_fetch_array($OwnFleets)) {
				$Record++;

				$StartTime   = $FleetRow['fleet_start_time'];
				$StayTime    = $FleetRow['fleet_end_stay'];
				$EndTime     = $FleetRow['fleet_end_time'];

				// Flotte a l'aller
				$Label = "fs";
				if ($StartTime > time()) {
					$fpage[$StartTime] = BuildFleetEventTable ( $FleetRow, 0, true, $Label, $Record );
				}

				// flotas que ya llegaron a destino
                if ( ($FleetRow['fleet_mission'] <> 4) && ($FleetRow['fleet_mission'] <> 10) ) {
						// flota estacionada
						$Label = "ft";
                    if ($StayTime > time()) {
                        $fpage[$StayTime] = BuildFleetEventTable ($FleetRow, 1, true, $Label, $Record);
                    }
                    // flota regresando
						$Label = "fe";
                    if ($EndTime > time()) {
                        $fpage[$EndTime] = BuildFleetEventTable ($FleetRow, 2, true, $Label, $Record);
                    }
                }
			} // End While

			// -----------------------------------------------------------------------------------------------

			// --- Gestion des flottes autres que personnelles ----------------------------------------------
			// Flotte ennemies (ou amie) mais non personnelles
			$OtherFleets     = doquery("SELECT * FROM {{table}} WHERE `fleet_target_owner` = '".$user['id']."';", 'fleets');

			$Record          = 2000;
			while ($FleetRow = mysql_fetch_array($OtherFleets)) {
				if ($FleetRow['fleet_owner'] != $user['id']) {
					if ($FleetRow['fleet_mission'] != 8) {
						$Record++;
						$StartTime = $FleetRow['fleet_start_time'];
						$StayTime  = $FleetRow['fleet_end_stay'];

						if ($StartTime > time()) {
							$Label = "ofs";
							$fpage[$StartTime] = BuildFleetEventTable ( $FleetRow, 0, false, $Label, $Record );
						}
						if ($FleetRow['fleet_mission'] == 5) {
							// Flotte en stationnement
							$Label = "oft";
							if ($StayTime > time()) {
								$fpage[$StayTime] = BuildFleetEventTable ( $FleetRow, 1, false, $Label, $Record );
							}
						}
					}
				}
			}

			// -----------------------------------------------------------------------------------------------

			// --- Gestion de la liste des planetes ----------------------------------------------------------
			// Planetes ...
			$planets_query = doquery("SELECT * FROM {{table}} WHERE id_owner='{$user['id']}'", "planets");
			$Colone  = 1;
			$Coloneshow = 0;
			$AllPlanets = "<tr style=\"background-color: transparent;\">";
			while ($UserPlanet = mysql_fetch_array($planets_query)) {
				if ($UserPlanet["id"] != $user["current_planet"] && $UserPlanet['planet_type'] != 3) {
					$Coloneshow++;
 					$AllPlanets .= "<th style=\"background-color: transparent;\">". $UserPlanet['name'] ."<br>";
					$AllPlanets .= "<a href=\"?cp=". $UserPlanet['id'] ."&re=0\" title=\"". $UserPlanet['name'] ."\"><img src=\"". $dpath ."planeten/small/s_". $UserPlanet['image'] .".jpg\" height=\"50\" width=\"50\"></a><br>";
					$AllPlanets .= "<center>";

					if ($UserPlanet['b_building'] != 0) {
						UpdatePlanetBatimentQueueList ( $UserPlanet, $user );
						if ( $UserPlanet['b_building'] != 0 ) {
							$BuildQueue      = $UserPlanet['b_building_id'];
							$QueueArray      = explode ( ";", $BuildQueue );
							$CurrentBuild    = explode ( ",", $QueueArray[0] );
							$BuildElement    = $CurrentBuild[0];
							$BuildLevel      = $CurrentBuild[1];
							$BuildRestTime   = pretty_time( $CurrentBuild[3] - time() );
							$AllPlanets     .= '' . $lang['tech'][$BuildElement] . ' (' . $BuildLevel . ')';
							$AllPlanets     .= "<br><font color=\"#7f7f7f\">(". $BuildRestTime .")</font>";
						} else {
							CheckPlanetUsedFields ($UserPlanet);
							$AllPlanets     .= $lang['Free'];
						}
					} else {
						$AllPlanets    .= $lang['Free'];
					}
					$AllPlanets .= "</center></th>";
					if ($Coloneshow > 4) {
					$AllPlanets .= "</tr><tr>";
					$Coloneshow =0;
					}
				}
			}
			$AllPlanets .= "</tr>";
			// -----------------------------------------------------------------------------------------------

			$parse                         = $lang;

			// -----------------------------------------------------------------------------------------------
			// News Frame ...
			// External Chat Frame ...
			// Banner ADS Google (meme si je suis contre cela)
			if ($game_config['OverviewNewsFrame'] == '1')
			{
				$pattern = array();
				$replace = array();

				// The different fonts (bold, italics, colors, etc ...)
				$pattern[] = "#\[a=(https?|ftp|news)(.+)\](.+)\[/a\]#isU";
				$replace[] = "<a href=\"$1$2\" target=\"_blank\">$3</a>";

				$pattern[] = "#\[b\](.+)\[/b\]#isU";
				$replace[] = "<b>$1</b>";

				$pattern[] = "#\[i\](.+)\[/i\]#isU";
				$replace[] = "<i>$1</i>";

				$pattern[] = "#\[u\](.+)\[/u\]#isU";
				$replace[] = "<u>$1</u>";

				$pattern[] = "#\[c=(blue|yellow|green|pink|red|orange)\](.+)\[/c\]#isU";
				$replace[] = "<font color=\"$1\">$2</font>";

				// Smileys with their shortcuts
				$pattern[] = "#:c#isU";
				$replace[] = "<img src=\"images/smileys/cry.png\" align=\"absmiddle\" title=\":c\" alt=\":c\">";

				$pattern[] = "#(?!http):/(?!/)#isU";
				$replace[] = "<img src=\"images/smileys/confused.png\" align=\"absmiddle\" title=\":/\" alt=\":/\">";

				$pattern[] = "#o0#isU";
				$replace[] = "<img src=\"images/smileys/dizzy.png\" align=\"absmiddle\" title=\"o0\" alt=\"o0\">";

				$pattern[] = "#\^\^#isU";
				$replace[] = "<img src=\"images/smileys/happy.png\" align=\"absmiddle\" title=\"^^\" alt=\"^^\">";

				$pattern[] = "#:D#isU";
				$replace[] = "<img src=\"images/smileys/lol.png\" align=\"absmiddle\" title=\":D\" alt=\":D\">";

				$pattern[] = "#:\|#isU";
				$replace[] = "<img src=\"images/smileys/neutral.png\" align=\"absmiddle\" title=\":|\" alt=\":|\">";

				$pattern[] = "#:\)#isU";
				$replace[] = "<img src=\"images/smileys/smile.png\" align=\"absmiddle\" title=\":)\" alt=\":)\">";

				$pattern[] = "#:o#isU";
				$replace[] = "<img src=\"images/smileys/omg.png\" align=\"absmiddle\" title=\":o\" alt=\":o\">";

				$pattern[] = "#:p#isU";
				$replace[] = "<img src=\"images/smileys/tongue.png\" align=\"absmiddle\" title=\":p\" alt=\":p\">";

				$pattern[] = "#:\(#isU";
				$replace[] = "<img src=\"images/smileys/sad.png\" align=\"absmiddle\" title=\":(\" alt=\":(\">";

				$pattern[] = "#;\)#isU";
				$replace[] = "<img src=\"images/smileys/wink.png\" align=\"absmiddle\" title=\";)\" alt=\";)\">";

				$pattern[] = "#:s#isU";
				$replace[] = "<img src=\"images/smileys/shit.png\" align=\"absmiddle\" title=\":s\" alt=\":s\">";

				$pattern[] = "#xnova#";
				$replace[] = "<a href=\"http://new-xnova.es/\">XNova</a>"; // xnova.fr dont work

				$msg = preg_replace($pattern, $replace, stripslashes($game_config['OverviewNewsText']));

				$parse['NewsFrame'] = "<tr><th>". $lang['ov_news_title'] ."</th><th colspan=\"3\">". $msg ."</th></tr>";
			}
			if ($game_config['OverviewExternChat'] == '1') {
				$parse['ExternalTchatFrame'] = "<tr><th colspan=\"4\">". stripslashes( $game_config['OverviewExternChatCmd'] ) ."</th></tr>";
			}
			if ($game_config['OverviewClickBanner'] != '') {
				$parse['ClickBanner'] = stripslashes( $game_config['OverviewClickBanner'] );
			}
			
			$parse['test_class_function'] = $test->testfunction('Hello Work My Test Class in Testfunction :)');
			// --- gestion de firma --
			/*if ($game_config['ForumBannerFrame'] == '0') {
				$BannerURL = "".dirname($_SERVER["HTTP_REFERER"])."/scripts/createbanner.php?id=".$user['id']."";

                $parse['bannerframe'] = "<th colspan=\"4\"><img src=\"scripts/createbanner.php?id=".$user['id']."\"><br>".$lang['InfoBanner']."<br><input name=\"bannerlink\" type=\"text\" id=\"bannerlink\" value=\"[img]".$BannerURL."[/img]\" size=\"62\"></th></tr>";
            }*/
			// --- Gestion de l'affichage d'une lune ---------------------------------------------------------
				if (!empty($lunarow) && $planetrow['planet_type'] != 3) {
				$parse['moon_img'] = "<a href=\"?cp={$lunarow['id']}&re=0\" title=\"{$UserPlanet['name']}\"><img src=\"{$dpath}planeten/{$lunarow['image']}.jpg\" height=\"50\" width=\"50\"></a>";
				$parse['moon'] = $lunarow['name'];
			} else {
				$parse['moon_img'] = "";
				$parse['moon'] = "";
			}
			// Moon END

			$parse['planet_name']          = $planetrow['name'];
			$parse['planet_diameter']      = pretty_number($planetrow['diameter']);
			$parse['planet_field_current'] = $planetrow['field_current'];
			$parse['planet_field_max']     = CalculateMaxPlanetFields($planetrow);
			$parse['planet_temp_min']      = $planetrow['temp_min'];
			$parse['planet_temp_max']      = $planetrow['temp_max'];
			$parse['galaxy_galaxy']        = $planetrow['galaxy'];
			$parse['galaxy_planet']        = $planetrow['planet'];
			$parse['galaxy_system']        = $planetrow['system'];
			$StatRecord = doquery("SELECT * FROM {{table}} WHERE `stat_type` = '1' AND `stat_code` = '1' AND `id_owner` = '". $user['id'] ."';", 'statpoints', true);

			$parse['user_points']          = pretty_number( $StatRecord['build_points'] );
			$parse['user_fleet']           = pretty_number( $StatRecord['fleet_points'] );
			$parse['player_points_tech']   = pretty_number( $StatRecord['tech_points'] );
			$parse['user_defs']            = pretty_number( $StatRecord['defs_points'] );
			$parse['total_points']         = pretty_number( $StatRecord['total_points'] );;

			$parse['user_rank']            = $StatRecord['total_rank'];
			$ile = $StatRecord['total_old_rank'] - $StatRecord['total_rank'];
			if ($ile >= 1) {
				$parse['ile']              = "<font color=lime>+" . $ile . "</font>";
			} elseif ($ile < 0) {
				$parse['ile']              = "<font color=red>-" . $ile . "</font>";
			} elseif ($ile == 0) {
				$parse['ile']              = "<font color=lightblue>" . $ile . "</font>";
			}
			$parse['u_user_rank']          = $StatRecord['total_rank'];
			$parse['user_username']        = $user['username'];

			if (count($fpage) > 0) {
				ksort($fpage);
				foreach ($fpage as $time => $content) {
					$flotten .= $content . "\n";
				}
			}

			$parse['fleet_list']  = $flotten;
			$parse['energy_used'] = $planetrow["energy_max"] - $planetrow["energy_used"];

			$parse['Have_new_message']      = $Have_new_message;
			$parse['Have_new_level_mineur'] = $HaveNewLevelMineur;
			$parse['Have_new_level_raid']   = $HaveNewLevelRaid;
			$parse['time']                  = date("D M d H:i:s", time());
			$parse['dpath']                 = $dpath;
			$parse['planet_image']          = $planetrow['image'];
			$parse['anothers_planets']      = $AllPlanets;
			//INICO FIX  TOTAL USUARIOS
			$MaxUsers = doquery ("SELECT COUNT(*) AS `count` FROM {{table}} WHERE `db_deaktjava` = '0' OR `db_deaktjava` = '1';", 'users', true);
			$parse['max_users'] = $MaxUsers['count'];
			//FIN FIX TOTAL USUARIOS

			$parse['metal_debris']          = pretty_number($galaxyrow['metal']);
			$parse['crystal_debris']        = pretty_number($galaxyrow['crystal']);
			if (($galaxyrow['metal'] != 0 || $galaxyrow['crystal'] != 0) && $planetrow[$resource[209]] != 0) {
				$parse['get_link'] = " (<a href=\"quickfleet.php?mode=8&g=".$galaxyrow['galaxy']."&s=".$galaxyrow['system']."&p=".$galaxyrow['planet']."&t=2\">". $lang['type_mission'][8] ."</a>)";
			} else {
				$parse['get_link'] = '';
			}

			if ( $planetrow['b_building'] != 0 ) {
				UpdatePlanetBatimentQueueList ( $planetrow, $user );
				if ( $planetrow['b_building'] != 0 ) {
					$BuildQueue = explode (";", $planetrow['b_building_id']);
					$CurrBuild  = explode (",", $BuildQueue[0]);
					$RestTime   = $planetrow['b_building'] - time();
					$PlanetID   = $planetrow['id'];
					$Build  = InsertBuildListScript ( "overview" );
					$Build .= $lang['tech'][$CurrBuild[0]] .' ('. ($CurrBuild[1]) .')';
					$Build .= "<br /><div id=\"blc\" class=\"z\">". pretty_time( $RestTime ) ."</div>";
					$Build .= "\n<script language=\"JavaScript\">";
					$Build .= "\n	pp = \"". $RestTime ."\";\n";  // temps necessaire (a compter de maintenant et sans ajouter time() )
					$Build .= "\n	pk = \"". 1 ."\";\n";          // id index (dans la liste de construction)
					$Build .= "\n	pm = \"cancel\";\n";           // mot de controle
					$Build .= "\n	pl = \"". $PlanetID ."\";\n";  // id planete
					$Build .= "\n	t();\n";
					$Build .= "\n</script>\n";

					$parse['building'] = $Build;
				} else {
					$parse['building'] = $lang['Free'];
				}
			} else {
				$parse['building'] = $lang['Free'];
			}
			// Rajout d'une barre pourcentage
			// Calcul du pourcentage de remplissage
		 $parse['case_pourcentage'] = floor($planetrow["field_current"] / CalculateMaxPlanetFields($planetrow) * 100) . $lang['o/o'];
         // Barre de remplissage
         $parse['case_barre'] = floor($planetrow["field_current"] / CalculateMaxPlanetFields($planetrow) * 100) * 4.0;
         // Couleur de la barre de remplissage
         if ($parse['case_barre'] > (100 * 4.0)) {
            $parse['case_barre'] = 400;
            $parse['case_barre_barcolor'] = '#C00000';
         } elseif ($parse['case_barre'] > (80 * 4.0)) {
            $parse['case_barre_barcolor'] = '#C0C000';
         } else {
            $parse['case_barre_barcolor'] = '#00C000';
         }
            //Mode Améliorations
			$parse['xpminier']= $user['xpminier'];
			$parse['xpraid']= $user['xpraid'];
			$parse['lvl_minier'] = $user['lvl_minier'];
			$parse['lvl_raid'] = $user['lvl_raid'];

			$LvlMinier = $user['lvl_minier'];
			$LvlRaid = $user['lvl_raid'];

			$parse['lvl_up_minier'] = $LvlMinier * 50;
			$parse['lvl_up_raid']   = $LvlRaid * 10;

//'{(time()-15*60)}'
			//Compteur de Membres en lign
			$OnlineUsers = mysql_fetch_row(doquery("SELECT COUNT(*) FROM {{table}} WHERE onlinetime>=" .(time()-15*60),"users"));
			$parse['NumberMembersOnline'] = $OnlineUsers[0];
			$page = parsetemplate(gettemplate('overview_body'), $parse);
			display($page, $lang['Overview']);
			break;
	}

?>
