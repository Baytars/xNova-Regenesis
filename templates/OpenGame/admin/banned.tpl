<br><br>
<h2>{adm_bn_ttle}</h2>
<form action="baneos.php?banear=ban" method="post">
<input type="hidden" name="mode" value="banit">
<table width="409">
<tr>
	<td class="c" colspan="2">{adm_bn_plto}</td>
</tr><tr>
	<th width="129">{adm_bn_name}</th>
	<th width="268"><input name="name" type="text" size="25" value="{ban}" /></th>
</tr><tr>
	<th>{adm_bn_reas}</th>
	<th><select name="why">
    <option value="multicuenta">Multicuenta</option>
    <option value="insultar">Insultar</option>
    <option value="intercambio">Intercambio</option>
    <option value="amenazas">Amenazas</option>
    <option value="bugUsing">BugUsing</option>
    <option value="pushing">Pushing</option>
    <option value="bashing">Bashing</option>
    <option value="mastiempo">Mas Tiempo</option>
    <option value="otro">Otro</option>
    </select></th>
</tr><tr>
	<td class="c" colspan="2">{adm_bn_time}</td>
</tr><tr>
	<th>{adm_bn_days}</th>
	<th><input name="days" type="text" value="0" size="5" /></th>
</tr><tr>
	<th>{adm_bn_hour}</th>
	<th><input name="hour" type="text" value="0" size="5" /></th>
</tr><tr>
	<th>{adm_bn_mins}</th>
	<th><input name="mins" type="text" value="0" size="5" /></th>
</tr><tr>
	<th>{adm_bn_secs}</th>
	<th><input name="secs" type="text" value="0" size="5" /></th>
</tr><tr>
	<th colspan="2"><input type="submit" value="{adm_bn_bnbt}" /></th>
</tr>
</table>
</form>