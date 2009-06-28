<div id='leftmenu'>
<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
function togglevisible(treepart){
if (document.getElementById(treepart).style.visibility == "hidden"){
document.getElementById(treepart).style.position="";
document.getElementById(treepart).style.visibility="";
}
}
function togglevisible1(treepart){
document.getElementById(treepart).style.position="absolute";
document.getElementById(treepart).style.visibility="hidden";
}
</script>
<!-- ver hora gtm -->
<SCRIPT Language="JavaScript">
 <!-- hide from old browsers
 function gmtClock(){
    time = new Date()
    gmtMS = time.getTime() + (time.getTimezoneOffset() * 60000)
    gmtTime =  new Date(gmtMS)
    hour = gmtTime.getHours()
    minute = gmtTime.getMinutes()
    second = gmtTime.getSeconds()
    temp = "" + ((hour < 10) ? "0" : "") + hour
    temp += ((minute < 10) ? ":0" : ":") + minute
    temp += ((second < 10) ? ":0" : ":") + second
    document.clockForm.digits.value = temp
    setTimeout("gmtClock()",1000)
    }
 //-->
 </SCRIPT>
<!-- ver hora gtm -->
<body  class="style" topmargin="0" leftmargin="0" marginwidth="0" marginheight="0" ONLOAD="gmtClock()">  <!-- [ONLOAD="gmtClock()"] para ver hora gtm -->
<center>
<div id='menu'>
<table width="130" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="2" style="border-top: 1px #545454 solid"><div><center>{servername}<br>(<a href="changelog.php" target={mf}><font color=red>{XNovaRelease}</font></a>)<center></div></td>
</tr><tr>
	<td colspan="2" background="{dpath}img/bg1.gif"><center>{devlp}</center></td>
	  <strong ><a onClick="togglevisible('1')" style="cursor:s-resize;">{devlp}</a></strong> <a onClick="togglevisible1('1')" style="cursor:n-resize;">X</a>
	</center></td>
</tr></table>
        <div id="1" ><table  width="130" cellspacing="0" cellpadding="0">
	<tr> <!-- ver hora gtm -->
		<FORM NAME="clockForm">
		<FONT face="Helvetica" size=2>
		<INPUT TYPE="text" NAME="digits" SIZE=8>
		<FONT face="Helvetica" size=2 color="red">GMT</FONT>
		</FONT>
		</FORM>
	</tr> <!-- fin ver hora gtm -->
	<tr>
	<td colspan="2"><div><a href="overview.php" accesskey="g" target="{mf}">{Overview}</a></div></td>
</tr><tr>

	<td height="1px" colspan="2" style="background-color:#FFFFFF"></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php" accesskey="b" target="{mf}">{Buildings}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php?mode=research" accesskey="r" target="{mf}">{Research}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php?mode=fleet" accesskey="f" target="{mf}">{Shipyard}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="buildings.php?mode=defense" accesskey="d" target="{mf}">{Defense}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="officier.php" accesskey="o" target="{mf}">{Officiers}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="marchand.php" accesskey="m" target="{mf}">{Marchand}</a></div></td>
</tr>
</tr></table></div>
 <table  width="130" cellspacing="0" cellpadding="0">

	<td colspan="2" background="{dpath}img/bg1.gif"><center>{navig}</center></td>
	  <strong><a onClick="togglevisible('2')" style="cursor:s-resize;">{navig}</a></strong><a onClick="togglevisible1('2')" style="cursor:n-resize;"> X</a>
	</center></td>
</tr></table><div id="2" ><table  width="130" cellspacing="0" cellpadding="0"><tr>
	<td colspan="2"><div><a href="alliance.php" accesskey="a" target="{mf}">{Alliance}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="fleet.php" accesskey="t" target="{mf}">{Fleet}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="messages.php" accesskey="c" target="{mf}">{Messages}</a></div></td>
</tr></table></div><table  width="130" cellspacing="0" cellpadding="0"><tr>

	<td colspan="2" background="{dpath}img/bg1.gif"><center>{observ}</center></td>
	  <strong><a onClick="togglevisible('3')" style="cursor:s-resize;">{observ}</a></strong><a onClick="togglevisible1('3')" style="cursor:n-resize;"> X</a>
	</center></td>
</tr></table>
<div id="3" ><table  width="130" cellspacing="0" cellpadding="0"><tr>
	<td colspan="2"><div><a href="galaxy.php?mode=0" accesskey="s" target="{mf}">{Galaxy}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="imperium.php" accesskey="i" target="{mf}">{Imperium}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="resources.php" accesskey="r" target="{mf}">{Resources}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="techtree.php" accesskey="g" target="{mf}">{Technology}</a></div></td>
</tr><tr>

	<td height="1px" colspan="2" style="background-color:#FFFFFF"></td>
</tr><tr>
	<td colspan="2"><div><a href="records.php" accesskey="3" target="{mf}">{Records}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="stat.php?start={user_rank}" accesskey="k" target="{mf}">{Statistics}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="search.php" accesskey="b" target="{mf}">{Search}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="banned.php" accesskey="3" target="{mf}">{blocked}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="annonce.php" accesskey="3" target="{mf}">{Annonces}</a></div></td>
</tr></table></div><table  width="130" cellspacing="0" cellpadding="0"><tr>

	<td colspan="2" background="{dpath}img/bg1.gif"><center>{commun}</center></td>
	  <strong><a onClick="togglevisible('4')" style="cursor:s-resize;">{commun}</a></strong><a onClick="togglevisible1('4')" style="cursor:n-resize;"> X</a>
	</center></td>
</tr></table><div id="4" ><table  width="130" cellspacing="0" cellpadding="0" ><tr>
	<td colspan="2"><div><a href="#" onClick="f('buddy.php', '');" accesskey="c">{Buddylist}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="#" onClick="f('notes.php', 'Report');" accesskey="n">{Notes}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="chat.php" accesskey="a" target="{mf}">{Chat}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="{forum_url}" accesskey="1" target="{mf}">{Board}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="contact.php" accesskey="3" target="{mf}" >{Contact}</a></div></td>
</tr><tr>
      <td colspan="2"><div><a href="support.php" accesskey="3" target="{mf}">{support_system}</a></div></td>
</tr><tr>
	<td colspan="2"><div><a href="options.php" accesskey="o" target="{mf}">{Options}</a></div></td>
</tr>
	{ADMIN_LINK}
<tr>
	<td colspan="2"><div><a href="javascript:top.location.href='logout.php'" accesskey="s" style="color:red">{Logout}</a></div></td>
</tr></table></div><table  width="130" cellspacing="0" cellpadding="0"><tr>
	<td colspan="2" background="{dpath}img/bg1.gif"><center>{infog}</center></td>
	  <strong><a onClick="togglevisible('5')">{infog}</a></strong>
	</center></td>
</tr></table><div id="5" style="visibility: visible"><table  width="130" cellspacing="0" cellpadding="0">
	{server_info}</table></div><table  width="130" cellspacing="0" cellpadding="0">
<tr>
	<td colspan="2"><div><center><a href="credit.php" accesskey="T" target="{mf}">XNova Team</a><br>&copy; Copyright 2008</center></div></td>
</tr>
</table>
</div>
</center>
</body>
</div>
