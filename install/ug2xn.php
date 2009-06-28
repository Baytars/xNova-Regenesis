<?php

// UGAMELA 2 XNOVA - DATABASE MODIFICATOR
// Version: 0.5
// Created by e-Zobar
// XNova (c) Copyright 2008

$querys = array(
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_end_stay` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_target_owner` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}fleets` ADD COLUMN `fleet_group` int (11) NOT NULL DEFAULT '0';",

"ALTER TABLE `{{prefix}}messages` MODIFY `message_from` varchar(48) character set latin1 default NULL;",
"ALTER TABLE `{{prefix}}messages` MODIFY `message_subject` varchar(48) character set latin1 default NULL;",

"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_builds`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_tech`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_fleet`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_builds2`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_tech2`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_fleet2`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_builds_old`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_tech_old`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_fleet_old`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_points`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_planets`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `points_points_old`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `rank`;",
"ALTER TABLE `{{prefix}}users` DROP COLUMN `rank_old`;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `mnl_buildlist` INT (11) NOT NULL;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `expedition_tech` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `mnl_expedition` INT( 11 ) NOT NULL;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_geologue` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_amiral` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_ingenieur` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_technocrate` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `rpg_points` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `lvl_minier` int(11) NOT NULL default '1';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `lvl_raid` int(11) NOT NULL default '1';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `xpraid` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `xpminier` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `banaday` int(11) default NULL;",
"ALTER TABLE `{{prefix}}users` ADD COLUMN `user_agent` text character set latin1 NOT NULL;",
"ALTER TABLE `{{prefix}}users` MODIFY `lang` varchar(8) character set latin1 NOT NULL default 'fr';",

"CREATE TABLE `{{prefix}}annonce` (
`id` int(11) NOT NULL auto_increment,
`user` text collate latin1_general_ci NOT NULL,
`galaxie` int(11) NOT NULL,
`systeme` int(11) NOT NULL,
`metala` bigint(11) NOT NULL,
`cristala` bigint(11) NOT NULL,
`deuta` bigint(11) NOT NULL,
`metals` bigint(11) NOT NULL,
`cristals` bigint(11) NOT NULL,
`deuts` bigint(11) NOT NULL,
PRIMARY KEY  (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=latin1 COLLATE=latin1_german1_ci AUTO_INCREMENT=5;",

"ALTER TABLE `{{prefix}}planets` DROP COLUMN `b_building_queue`;",
"ALTER TABLE `{{prefix}}planets` DROP COLUMN `unbau`;",
"ALTER TABLE `{{prefix}}planets` ADD COLUMN `last_jump_time` int(11) NOT NULL default '0';",
"ALTER TABLE `{{prefix}}planets` MODIFY `b_building_id` text character set latin1 NOT NULL;",

"CREATE TABLE `{{prefix}}statpoints` (
`id_owner` int(11) NOT NULL,
`id_ally` int(11) NOT NULL,
`stat_type` int(2) NOT NULL,
`stat_code` int(11) NOT NULL,
`tech_rank` int(11) NOT NULL,
`tech_old_rank` int(11) NOT NULL,
`tech_points` bigint(20) NOT NULL,
`tech_count` int(11) NOT NULL,
`build_rank` int(11) NOT NULL,
`build_old_rank` int(11) NOT NULL,
`build_points` bigint(20) NOT NULL,
`build_count` int(11) NOT NULL,
`defs_rank` int(11) NOT NULL,
`defs_old_rank` int(11) NOT NULL,
`defs_points` bigint(20) NOT NULL,
`defs_count` int(11) NOT NULL,
`fleet_rank` int(11) NOT NULL,
`fleet_old_rank` int(11) NOT NULL,
`fleet_points` bigint(20) NOT NULL,
`fleet_count` int(11) NOT NULL,
`total_rank` int(11) NOT NULL,
`total_old_rank` int(11) NOT NULL,
`total_points` bigint(20) NOT NULL,
`total_count` int(11) NOT NULL,
`stat_date` int(11) NOT NULL,
KEY `TECH` (`tech_points`),
KEY `BUILDS` (`build_points`),
KEY `DEFS` (`defs_points`),
KEY `FLEET` (`fleet_points`),
KEY `TOTAL` (`total_points`)
) ENGINE=MyISAM;",

"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_builds`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_fleet`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_tech`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_builds_old`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_fleet_old`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_tech_old`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_members_points`;",
"ALTER TABLE `{{prefix}}alliance` DROP COLUMN `ally_points_fleet2`;",

"CREATE TABLE `{{prefix}}chat` (
`messageid` int(5) unsigned NOT NULL auto_increment,
`user` varchar(255) NOT NULL default '',
`message` text NOT NULL,
`timestamp` int(11) NOT NULL default '0',
PRIMARY KEY  (`messageid`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;",

"DROP TABLE `{{prefix}}admin_acl`;",

"DROP TABLE `{{prefix}}admin_modules`;",

"INSERT INTO `{{prefix}}config` (`config_name`, `config_value`) VALUES
('Fleet_Cdr', '30'),
('Defs_Cdr', '30'),
('game_disable', '0'),
('close_reason', ''),
('BuildLabWhileRun', '0'),
('LastSettedGalaxyPos', '1'),
('LastSettedSystemPos', '9'),
('LastSettedPlanetPos', '1'),
('urlaubs_modus_erz', '1'),
('forum_url', 'http://www.xnova.fr/forum'),
('OverviewNewsFrame', '1'),
('OverviewNewsText', 'Vous avez correctement mis votre serveur UGamela sous XNova!'),
('OverviewExternChat', '0'),
('OverviewExternChatCmd', ''),
('OverviewBanner', '0'),
('OverviewClickBanner', '');",
"UPDATE `{{prefix}}config` SET `config_value`='XNova' WHERE `config_name`='COOKIE_NAME';",
"UPDATE `{{prefix}}config` SET `config_value`='XNova' WHERE `config_name`='game_name';"
);

if (isset($_GET['step']))
    $step    = intval($_GET['step']);
else
    $step    = 1;
    $phpself = $_SERVER['PHP_SELF'];

if ($step == 1) {
?>

<html>
<head>
<title>UGamela 2 XNova</title>
<style type="text/css">
body,td,th {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #CCCCCC;}
body {margin-top: 50px;background-color: #000033;}
a {font-size: 12px; color: #66FFFF;}
a:link {text-decoration: none; color: #CCFFCC;}
a:visited {text-decoration: none; color: #CCFFCC;}
a:hover {text-decoration: none; color: #CCFFCC;}
a:active {text-decoration: none; color: #CCFFCC;}
.Style1 {font-size: 16px; font-weight: bold;}
</style>
</head>
<body>
<table width="600" align="center" style="border-style: dashed; border-color: #CCCCCC; border-width: 1px;">
<tr><td align="center" height="50px"><span class="Style1">UGamela to XNova </span></td></tr>
<tr><td align="center">Va a cambiar su base de datos para que sea compatible con el proyecto XNova.<br>
El servidor de ugamela y el de XNova no son totalmente compatibles<br>
tiene que modificarse. Para continuar es necesario que compruebe que:<br>
- Disponer de una copia de su base de datos reciente (por si tiene problemas en la instalacion).<br>
- Disponer de un XNova actualizado (<a href="http://new-xnova.es/foro">New XNova Esp</a>).<br>
- Ser consciente de los riesgos del cambio de version.</td></tr>
<tr><td height="50px" align="center"><a href="<?php echo $phpself; ?>?step=<?php echo ($step + 1); ?>">Continuar con la configuracion</a></td></tr>
</table>
</body>
</html>

<?php
}
elseif ($step == 2) {
?>

<html>
<head>
<title>UGamela 2 XNova</title>
<style type="text/css">
body,td,th {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #CCCCCC;}
body {margin-top: 50px;background-color: #000033;}
a {font-size: 12px; color: #66FFFF;}
a:link {text-decoration: none; color: #CCFFCC;}
a:visited {text-decoration: none; color: #CCFFCC;}
a:hover {text-decoration: none; color: #CCFFCC;}
a:active {text-decoration: none; color: #CCFFCC;}
.Style1 {font-size: 16px; font-weight: bold;}
</style></head>
<body>
<?php if ($_GET['error'] == 1) { ?>
<script> alert('Imposible conexion a la base de datos!'); </script>
<?php } elseif ($_GET['error'] == 2) { ?>
<script> alert('Permisos de config.php tienen que estar en 777!'); </script>
<?php } ?>
<table width="600" align="center" style="border-style: dashed; border-color: #CCCCCC; border-width: 1px;">
<tr><td align="center" height="50px"><span class="Style1">UGamela a XNova </span></td></tr>
<tr><td height="110" align="center">Por favor, rellene este formulario con los datos de su config.php.<br>
 Si realiza algun cambio puede no funcionar la transferencia!<br><br>
<form action="<?php echo $phpself; ?>?step=<?php echo ($step + 1); ?>" method="post">
<table width="367" border="0" cellspacing="0" cellpadding="0">
<tr><td width="231">Direccion del servidor SQL:</td>
    <td width="150"><input type="text" name="host" value="localhost" size="25"></td></tr>
<tr><td>Nombre de la base de datos: </td>
    <td><input type="text" name="db" value="" size="25"></td></tr>
<tr><td>Prefijo de la tabla: </td>
    <td><input type="text" name="prefix" value="game_" size="25"></td></tr>
<tr><td>Usuario DB:</td>
    <td><input type="text" name="user" value="" size="25"></td></tr>
<tr><td>Contrase&Ntilde;a: </td>
    <td><input type="password" name="passwort" value="" size="25"></td></tr>
</table>
<br>
<input type="submit" name="send" value="Valider">
</form></td></tr>
</table>
</body>
</html>

<?php
}
elseif ($step == 3) {

$host       = $_POST['host'];
$user       = $_POST['user'];
$pass       = $_POST['passwort'];
$prefix     = $_POST['prefix'];
$db         = $_POST['db'];

$connection = @mysql_connect($host, $user, $pass);

if (!$connection) {
    header("Location: ?step=2&error=1");
    exit();
}

$dbselect   = @mysql_select_db($db);

if (!$dbselect) {
    header("Location: ?step=2&error=2");
    exit();
}

$zufall = mt_rand(1000, 1234567890);
$dz = fopen("../config.php", "w");

if (!$dz) {
    header("Location: ?step=2&error=2");
    exit();
}

fwrite($dz, "<"."?"."p"."h"."p  //config.php :: XNova server

if(!defined(\"INSIDE\")){ die(\"attemp hacking\");}
	\$dbsettings = Array(
		\"server\"        => \"".$host."\", /"."/ MySQL server name. (Default: localhost)
		\"user\"          => \"".$user."\", /"."/ MySQL username.
		\"pass\"          => \"".$pass."\", /"."/ MySQL password.
		\"name\"          => \"".$db."\", /"."/ MySQL database name.
		\"prefix\"        => \"".$prefix."\", /"."/ Prefix for table names.
		\"secretword\"    => \"XNova".$zufall."\"); /"."/ Secret word used when hashing information for cookies.


?".">");
fclose($dz);

function doquery($query, $p) {
    $query = str_replace("{{prefix}}", $p, $query);
    $return = mysql_query($query) or die("MySQL Fehler: <b>".mysql_error()."</b>");

    return $return;
}

foreach ($querys as $query) {
    doquery($query, $prefix);
}

?>

<html>
<head>
<title>UGamela 2 XNova</title>
<style type="text/css">
body,td,th {font-family: Verdana, Arial, Helvetica, sans-serif; font-size: 12px; color: #CCCCCC;}
body {margin-top: 50px;background-color: #000033;}
a {font-size: 12px; color: #66FFFF;}
a:link {text-decoration: none; color: #CCFFCC;}
a:visited {text-decoration: none; color: #CCFFCC;}
a:hover {text-decoration: none; color: #CCFFCC;}
a:active {text-decoration: none; color: #CCFFCC;}
.Style1 {font-size: 16px; font-weight: bold;}
</style>
</head>
<body>
<table width="600" align="center" style="border-style: dashed; border-color: #CCCCCC; border-width: 1px;">
<tr><td align="center" height="50px"><span class="Style1">UGamela to XNova </span></td></tr>
<tr><td align="center">Felicidades, sus datos de UGamela fueron modificados para hacerlos compatibles con XNova. <br>
Su archivo config.php, ha sido modificado con la información de su base de datos.<br>
El servidor esta listo para su uso. 

Tras la instalación, modificar las siguientes lineas de los ficheros:<br>
En el fichero reg.php<br>
176	$siteurlactivationlink = 'http://tu server/s1/activate.php?hash='.base64_encode($_POST['character']).'&stamp='.base64_encode($NewUser['id']).'&mode=reg';<br>
En el fichero options.php<br>
31	$siteurlactivationlink = 'http://tuserver/s1/activate.php?hash='.base64_encode($user['username']).'&stamp='.base64_encode($NewUser['id']).'&mode=options';<br>
Donde pone "http://tuserver/s1/" colocar la URL a tu servidor.<br>
Borrar el "directorio install" de la raiz del servidor.<br>
</td>
</tr><tr><td height="50px" align="center"><a href="../login.php"> Ir al servidor con XNova </a></td></tr>
</table>
</body>
</html>

<?php
}
else {
   header("Location: ".$phpself);
   exit();
}
?>