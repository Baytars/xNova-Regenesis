<br />
<br />
<script src="../scripts/jquery.js" type="text/javascript"></script>
<script type='text/javascript'>
function mostrar(idDetalle)
{
	if ($("div#"+idDetalle).is(":hidden"))
	{
		$("div#" + idDetalle).show(300);
	}
	else
	{
		$("div#" + idDetalle).hide("slow");
	}
}
function ocultar(idDetalle)
{
		$("div#" + idDetalle).hide("slow");
}
</script>
<script>
$(document).ready(function(){
	$("div#2").hide();
	$("div#3").hide();
   $("#o1").click(function(event){
    event.preventDefault();
    mostrar(1);
	ocultar(2);
	ocultar(3);
	});
   $("#o2").click(function(event){
    event.preventDefault();
    mostrar(2);
	ocultar(1);
	ocultar(3);
   });
   $("#o3").click(function(event){
    event.preventDefault();
    mostrar(3);
	ocultar(2);
	ocultar(1);
   });
});
</script>
<form method="post" action="">
	<table width="80%" border="2" cellpadding="1">
	<tr>
      <th colspan="2" class="b">{lg_adm_title}
	</th>
    <tr>
      <td colspan="2" class="a">
	  <input href="#" type="button"  id="o1" value="{lg_adm_general}" />
	  <input href="#" type="button"  id="o2" value="{lg_adm_game_settings}" />  
	 <input href="#" type="button"   id="o3" value="{lg_adm_game_oth_info}" /> 
	 </td>
    </tr>
    <tr>
      <td colspan="2" class="a"><label>
        <input type="submit" name="save" value="{lg_adm_opt_btn_save}" />
      </label></td>
    </tr>
	</table>
	<div id="1">
  <table width="80%" border="2" cellpadding="1">
    <tr>
      <th colspan="2" class="b">{lg_adm_general}
	  </th>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_name}</td>
      <td class="c"><label>
        <input type="text" name="game_name" id="game_name" value="{game_name}" />
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_forum}</td>
      <td class="c"><input type="text" name="forum_url" id="forum_url" value="{forum_url}" /></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_disable}</td>
      <td class="c"><label>
	  <select name="game_disable" id="game_disable">
          <option value="1" {sel_gd1}>{lg_adm_yes}</option>
          <option value="0" {sel_gd0}>{lg_adm_no}</option>
      </select>
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_close_reason}</td>
      <td class="c"><label>
        <textarea name="close_reason" id="close_reason" cols="45" rows="5">{close_reason}</textarea>
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_debug}</td>
      <td class="c"><label>
	  <select name="debug" id="debug">
          <option value="1" {sel_deb1}>{lg_adm_yes}</option>
          <option value="0" {sel_deb0}>{lg_adm_no}</option>
      </select>
      </label></td>
    </tr>
	</table>
	<br />
	</div>
	<div id="2">
	<table width="80%" border="2" cellpadding="1">
    <tr>
      <th colspan="2" class="b">{lg_adm_game_settings}</th>
    </tr>
	
	<tr>
      <td colspan="2" class="c">{lg_adm_speed}</td>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_gspeed}</td>
      <td class="c"><label>
        <input type="text" name="game_speed" id="game_speed" value="{game_speed}" />
      /2500</label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_fspeed}</td>
      <td class="c"><label>
        <input type="text" name="fleet_speed" id="fleet_speed" value="{fleet_speed}" />
      /2500</label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_pspeed}</td>
      <td class="c"><label>
        <input type="text" name="resource_multiplier" id="resource_multiplier" value="{resource_multiplier}" />
      </label></td>
    </tr>
	<tr>
      <td colspan="2" class="c">{lg_adm_game_pla}</td>
    </tr>
    <tr>
      <td class="c">{lg_adm_initial}</td>
      <td class="c"><label>
        <input type="text" name="initial_fields" id="initial_fields" value="{initial_fields}" />
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_base_inc}{Metal}:</td>
      <td class="c"><label>
        <input type="text" name="metal_basic_income" id="metal_basic_income" value="{metal_basic_income}" />
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_base_inc}{Crystal}:</td>
      <td class="c"><label>
        <input type="text" name="crystal_basic_income" id="crystal_basic_income" value="{crystal_basic_income}" />
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_base_inc}{Deuterium}:</td>
      <td class="c"><label>
        <input type="text" name="deuterium_basic_income" id="deuterium_basic_income" value="{deuterium_basic_income}" />
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_base_inc}{Energy}:</td>
      <td class="c"><label>
        <input type="text" name="energy_basic_income" id="energy_basic_income" value="{energy_basic_income}" />
      </label></td>
    </tr>
    <tr>
      <td colspan="2" class="c">{lg_adm_attack}</td>
    </tr>
    <tr>
      <td class="c">{lg_adm_attack_disabled}</td>
      <td class="c"><label>
	  <select name="attack_disabled" id="attack_disabled">
          <option value="1" {sel_att1}>{lg_adm_yes}</option>
          <option value="0" {sel_att0}>{lg_adm_no}</option>
      </select>
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_attack_block_time}</td>
      <td class="c"><label>
        <input type="text" name="AtakBlockTime" id="AtakBlockTime" value="{hour}" />
       {lg_adm_hours}</label></td>
    </tr>
	</table>
	</div>
	<div id="3">
	<table width="80%" border="2" cellpadding="1">
	<tr>
      <th colspan="2" class="b">{lg_adm_game_oth_info}</th>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_news}</td>
      <td class="c"><label>
	  <select name="OverviewNewsFrame" id="OverviewNewsFrame">
          <option value="1" {sel_new1}>{lg_adm_yes}</option>
          <option value="0" {sel_new0}>{lg_adm_no}</option>
      </select>
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_announce}</td>
      <td class="c"><label>
        <textarea name="OverviewNewsText" id="OverviewNewsText" cols="45" rows="5">{NewsTextVal}</textarea>
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_adds}</td>
      <td class="c"><label>
	  <select name="OverviewBanner" id="OverviewBanner">
          <option value="1" {sel_ban1}>{lg_adm_yes}</option>
          <option value="0" {sel_ban0}>{lg_adm_no}</option>
      </select>
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_adds_code}</td>
      <td class="c"><label>
        <textarea name="OverviewClickBanner" id="OverviewClickBanner" cols="45" rows="5">{GoogleAdVal}</textarea>
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_chat}</td>
      <td class="c"><label><select name="OverviewExternChat" id="OverviewExternChat">
          <option value="1" {sel_cha1}>{lg_adm_yes}</option>
          <option value="0" {sel_cha0}>{lg_adm_no}</option>
      </select>
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_game_chat_code}</td>
      <td class="c"><label>
        <textarea name="OverviewExternChatCmd" id="OverviewExternChatCmd" cols="45" rows="5">{ExtTchatVal}</textarea>
      </label></td>
    </tr>
  </table>
  </div>
  <br />
</form>