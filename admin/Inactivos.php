<?php

/**
 * Inactivos.php
 *
 * @version 0.000001
 * Desarrollado por Alucard para esos jugones de Xnova
 */

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

			// Calcul de la duree de traitement (initialisation)
			$mtime        = microtime();
			$mtime        = explode(" ", $mtime);
			$mtime        = $mtime[1] + $mtime[0];
			$starttime    = $mtime;

$fecha_actual = time();
$fecha_tope   = time();
  $i = 0;
  $Tope=30;
  $Page =MuestraFormulario();
  
  if (isset($_POST['dias'])==true ) { $Tope =$_POST['dias']; }
  
  $Page .= '<center>Tope seleccionado: '.$Tope.'</center><br /><table><tr><th>Jugadores Inactivos</th><th> Tiempo desde su Ingreso(d&iacute;as) </th><th> Fecha de Ingreso </th><th> Ultimo Acceso </th><th>En Vacaciones</th><th> Baneado </th></tr>';
for ($dia=$Tope;$dia>2;$dia--) {
  
  $Page .= '<tr><td class="c" colspan="6" style="text-align:right;">Sin actividad '.$dia.' dias</td></tr>';
    $fecha1=$fecha_actual-(24*60*60*$dia);
	$fecha2 = $fecha_actual-(24*60*60*($dia+1));
      

      $query = doquery("SELECT * FROM {{table}} WHERE onlinetime <= ".$fecha1." and onlinetime >".$fecha2." ", "users");
    


while ($u = mysql_fetch_array($query)) {
$Vacaciones = "no";
$Baneado= "no";
if ($u[urlaubs_modus]==1) {

 
 $Dias =date("d",time()-($u[urlaubs_modus_time]-172800));
 $Vacas++;
 $Vacaciones = "<a href='#' onmouseover=\"return overlib('<table border=1 width=200><tr><td align=left><font color=white>Inicio Vacaciones: <font></td><td  align=right><font color=white>".date("d/m/Y",($u[urlaubs_modus_time]-172800))."<font></td></tr><tr><td>Tiempo en vacaciones</td><td align=right>".$Dias."</td></tr></table>');\" onmouseout=\"return nd();\" >Si</a>";



}
if ($u[bana]==1) {$Baneado="<b>SI</b>";$Ban++;}


$DesdeIngreso=date("d",time()-$u[register_time]);
$Page .="<tr><td style='text-align:center;'>".$u[username]."</td><td style='text-align:center;'>".$DesdeIngreso."</td><td style='text-align:center;'>".date("d/m/Y",$u[register_time])."</td><td style='text-align:center;'>".date("d/m/Y",$u[onlinetime])."</td><td align='center'>".$Vacaciones."</td><td align='center'>".$Baneado."</td></tr>";
$i++;
}


}

$Page .="<tr><th class='b' colspan='6' align='center'><table><tr><td align='right'>Inactivos </td><td align='right'>".($i-$Vacas-$Ban)."</td></tr><tr><td align='right'> En Vaciones </td><td align='right'>".$Vacas."</td></tr><tr><td align='right'> Baneados </td><td align='right'>".$Ban."</td></tr><tr><td align='right'>Total </td><td align='right'>".$i."</tr></td></th></tr></table><br />";

			// Calcul de la duree de traitement (calcul)
			$mtime        = microtime();
			$mtime        = explode(" ", $mtime);
			$mtime        = $mtime[1] + $mtime[0];
			$endtime      = $mtime;
			$totaltime    = ($endtime - $starttime);
	$Page .= "<br /><center>Generado en: ".$totaltime."</center>";		
		
display( $Page, '', false, '', true);


function MuestraFormulario() {
$formulario =  '<form name"Inactivos" method="POST" action="Inactivos.php">';
$formulario .= '<table border="1"><tr><td>Inactivos en menos de </td><td><select name="dias">';
$formulario .= '<option >30</option><option >29</option><option >28</option><option >27</option><option >26</option>';
$formulario .= '<option >25</option><option >24</option><option >23</option><option >22</option><option >21</option>';
$formulario .= '<option >22</option><option >21</option><option >20</option><option >19</option><option >18</option>';
$formulario .= '<option >17</option><option >16</option><option >15</option><option >14</option><option >13</option>';
$formulario .= '<option >12</option><option >11</option><option >10</option><option >9</option><option >8</option>';
$formulario .= '<option >7</option><option >6</option><option >5</option><option >4</option><option >3</option></select>';
$formulario .= ' dias</td><td><input name="Env" type="submit"  value="Enviar" /></td></tr></table><br />';

return $formulario;
}
?>