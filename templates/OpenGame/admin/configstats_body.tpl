<br />
<br />
<form method="post" action="">
	<br />
	<table width="80%" border="2" cellpadding="1">
    <tr>
      <th colspan="2" class="c">{lg_adm_stats}</th>
    </tr>
	<tr>
      <td class="c">{lg_adm_stat_settings}</td>
      <td class="c"><label>
        <input type="text" name="stat_settings" id="stat_settings" value="{stat_settings}" />
      </label>{lg_adm_res}</td>
    </tr>
	<tr>
      <td class="c">{lg_adm_stat_amount}</td>
      <td class="c"><label>
        <input type="text" name="stat_amount" id="stat_amount" value="{stat_amount}" />
      </label></td>
    </tr>
	<tr>
      <td class="c">{lg_adm_stat_flying}</td>
      <td class="c"><label>
	  <select name="stat_flying" id="stat_flying">
          <option value="1" {sel_sf1}>{lg_adm_yes}</option>
          <option value="0" {sel_sf0}>{lg_adm_no}</option>
      </select>
      </label></td>
    </tr>
	<tr>
      <td class="c">{lg_adm_stat_update_time}</td>
      <td class="c"><label>
        <input type="text" name="stat_update_time" id="stat_update_time" value="{stat_update_time}" />
      </label> {lg_min}</td>
    </tr>
    <tr>
      <td class="c">{lg_adm_stats_zero}</td>
      <td class="c"><label>
	  <select name="stat" id="stat">
          <option value="1" {sel_sta1}>{lg_adm_yes}</option>
          <option value="0" {sel_sta0}>{lg_adm_no}</option>
      </select>
      </label></td>
    </tr>
    <tr>
      <td class="c">{lg_adm_stats_acc_lvl}</td>
      <td class="c"><label>
        <input type="text" name="stat_level" id="stat_level" value="{stat_level}" />
      </label></td>
    </tr>
	
    <tr>
      <td colspan="2" class="a"><label>
        <input type="submit" name="save" value="{lg_adm_save}" />
      </label></td>
    </tr>
  </table>
  <br />
</form>