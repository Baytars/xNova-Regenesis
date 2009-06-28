function wrt(s,p1,p2){

  document.write("<center>");
  document.write("<form action=\"galaxia.php?session=" + s + "\" method=post id=galaxy_form>");

document.write("<input type=\"hidden\" name=\"session\" value=\"" + s + "\">");
document.write("<input type=\"hidden\" id=\"auto\" value=\"dr\">");

document.write("<table border=0> <tr><td> <table> <tr><td class=c colspan=3>Galaxia</td></tr> <tr>");
document.write("<td class=l><input type=button name=ml value=\"<-\" onClick=\"galaxy_submit('ml')\"></td>");
document.write("<td class=l><input type=text name=p1 value=" + p1 + " size=5 maxlength=3></td>");
document.write("<td class=l><input type=button name=mr value=\"->\" onClick=\"galaxy_submit('mr')\"></td> </tr> </table></td><td><table> <tr><td class=c colspan=3>Sistema solar</td></tr><tr><td class=l><input type=button name=xl value=\"<-\" onClick=\"galaxy_submit('xl')\"></td><td class=l><input type=text name=p2 value=" +  p2 + " size=5 maxlength=3></td>");
document.write("<td class=l><input type=button name=xr value=\"->\" onClick=\"galaxy_submit('xr')\"></td> </tr> </table> </td></tr> <tr><td colspan=2 align=center> <input type=submit value=Ver></td></tr></table>"); 


}

function wrt2(s,p1,p2){
document.write(" <table width=470> <tr> <td class=c colspan=3>Sistema solar " +  p1 + ":" + p2 + " </td></tr> <tr> <th>Planeta</th> <th>Nombre</th> <th>Accion</th> </tr>");
}



function wrtg(s,ss,b,p1,p2,a){
s=s.replace(/#1/g,'<tr><th>');
s=s.replace(/#2/g,'</th><th>');
s=s.replace(/#3/g,'</th>');


s=s.replace(/#8/g,'<th> <a href=\"fleet.php?fstate=3&type=Spionage&gesver2=1&ladekap2=5&s=10&c210='+a+'&ft1='+p1+'&ft2='+p2+'&ft3=');
s=s.replace(/#9/g,'\"><img src=\"http://80.237.203.119/ogame/game/img/e.gif\" border=0 alt=\"'+a+' Mandar sonda\">    </a>');
s=s.replace(/#b/g,'<a href=\"galaxy.php?mode=1&p1='+p1+'&p2='+p2+'&ft3=');
s=s.replace(/#c/g,'\"><img src=\"http://ogame.org/ogame/game/img/r.gif\" border=0 alt=\"Ataque con misiles\">    </a>');


s=s.replace(/#4/g,'<a href=\"messages.php?mode=write&id=');
s=s.replace(/#5/g,'\"><img src=\"http://80.237.203.119/ogame/game/img/m.gif\" border=0 alt=\"Escribir un mensaje\"></a><a href=\"buddy.php?a=2&u=');
s=s.replace(/#X/g,'\"><img src=\"http://80.237.203.119/ogame/game/img/b.gif\" border=0 alt=\"Peticion de amigo\"></a>');
s=s.replace(/#6/g,'</th>');
s=s.replace(/#7/g,'<th>');
s=s.replace(/#a/g,'</th><th></th>');
document.write(s);
document.write('<tr><td class=c colspan=3>( '+b+' Planeta poblado )</th></tr></table> (*) Actividad en el planeta &nbsp;&nbsp;&nbsp;(g) Usuario bloqueado<br>(i) 2 semanas inactivo&nbsp;&nbsp;&nbsp;    (I) 4 semanas inactivo<br><font color=#ffa0a0>Fuerte<font color=#ffffff> &nbsp;&nbsp;&nbsp; <font color=#a0ffa0>Debil<font color=#ffffff>&nbsp;&nbsp;&nbsp <font color=#0000ff>Modo vacaciones<font color=#ffffff>');
document.write('</center> </body> </html>');

}

function galaxy_submit(value) {
 document.getElementById('auto').name = value;
 document.getElementById('galaxy_form').submit();
}


