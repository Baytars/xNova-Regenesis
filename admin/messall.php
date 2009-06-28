<?php

define('INSIDE'  , true);
define('INSTALL' , false);
define('IN_ADMIN', true);

$ugamela_root_path = './../';
include($ugamela_root_path . 'extension.inc');
include($ugamela_root_path . 'common.' . $phpEx);

if($user['authlevel']!="1"&$user['authlevel']!="2"&$user['authlevel']!="3"&$user['authlevel']!="0"){ header("Location: login.php");}   


if ($user['authlevel'] >= 0) {   

   if ($_POST && $_GET['mode'] == "change")    {
      if ($user['authlevel'] == 3) //  administrator
      {             
       $kolor = 'yellow';             
       $ranga = 'Administrador';         
      }
     
     elseif ($user['authlevel'] == 2) // operador
     {             
      $kolor = 'skyblue';             
      $ranga = 'Opérador';         
     }   
   
     elseif ($user['authlevel'] == 1) // moderador
     {             
      $kolor = 'yellow';             
      $ranga = 'Modérador';   
      }       
       // Tout est OK donc on peut ecrir un message a tout les joueurs
      if ((isset($_POST["tresc"]) && $_POST["tresc"] != '') && (isset($_POST["temat"]) && $_POST["temat"] != '')) {             
         $sq      = doquery("SELECT * FROM {{table}}", "users");
         $Time    = time();             
         $From    = "<font color=\"". $kolor ."\">". $ranga ." ".$user['username']."</font>";             
         $Subject = "<font color=\"". $kolor ."\">". $_POST['temat'] ."</font>";             
         $Message = "<font color=\"". $kolor ."\"><b>". $_POST['tresc'] ."</b></font>";         
         $summery=0;   
         
       while ($u = mysql_fetch_array($sq)) {               
          SendSimpleMessage ( $u['id'], $user['id'], $Time, 1, $From, $Subject, $Message);
            $_POST['tresc'] = str_replace(":name:",$u['username'],$_POST['tresc']);
         }   
       //
       message("<font color=\"lime\">Su mensaje ha sido enviado!</font>", "Enviado", "../overview." . $phpEx, 3);         
      }
     else
     {
     
      message("Usted n \ 'no se especifica el tema! "," Error ", "../overview." . $phpEx, 3);
     }       
    }
    else
   {         
    $parse = $game_config;
    $parse['dpath'] = $dpath;         
    $parse['debug'] = ($game_config['debug'] == 1) ? " checked='checked'/":'';         
    $page .= parsetemplate(gettemplate('admin/messall_body'), $parse);         
    display($page, '', false,'', true);       
   }   
}

else
  {       
   message($lang['sys_noalloaw'], $lang['sys_noaccess']);   
  }
?>