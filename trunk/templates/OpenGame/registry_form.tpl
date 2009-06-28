<center>
<br>
<br>
<h2><font size="+3">{registry}</font><br>
{servername}</h2>
<form action="" method="post">
<table width="438">
	<tr>
		<td colspan="2" class="c"><b>{form}</b></td>
	</tr>

	<tr>
		<th width="293">{GameName}</th>
		<th width="293">
			<input name="character" size="20" maxlength="20" type="text" onKeypress="
				if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
				if (event.which==60 || event.which==62) return false;">
		</th>
	</tr>

	<tr>
		<th>{neededpass}</th>
		<th>
			<input name="passwrd" size="20" maxlength="20" type="password" onKeypress="
				if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
				if (event.which==60 || event.which==62) return false;">
		</th>
	</tr>
	<tr>
		<th>{E-Mail}</th>
		<th><input name="email" size="20" maxlength="40" type="text" onKeypress="
			if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
			if (event.which==60 || event.which==62) return false;">
		</th>
	</tr>
	<tr>
		<th>{MainPlanet}</th>
		<th>
			<input name="planet" size="20" maxlength="20" type="text" onKeypress="
				if (event.keyCode==60 || event.keyCode==62) event.returnValue = false;
				if (event.which==60 || event.which==62) return false;">
		</th>
	</tr>
	<tr>
		<th>{Sex}</th>
		<th><select name="sex">
			<option value="">{Undefined}</option>
			<option value="M">{Male}</option>
			<option value="F">{Female}</option>
			</select>
		</th>
	</tr>

	<tr>
		<th colspan="2" align="center">
			<br>
			<br>
			<div align="center">
				<script type="text/javascript"  src="http://api.recaptcha.net/challenge?k={tucodigo}"></script>
				<noscript>
					<iframe src="http://api.recaptcha.net/noscript?k={tucodigo}" width="500"></iframe>

					<img src="http://api.recaptcha.net/noscript?k={tucodigo}" alt="">
					<textarea name="recaptcha_challenge_field" rows="3" cols="40" tabindex="12"></textarea>
					<input type="hidden" name="recaptcha_response_field" value="manual_challenge">
				</noscript>
			</div>
		</th>
	</tr>

	<tr>
		<td height="20" colspan="2"></td>
	</tr>

	<tr>
		<th><input name="rgt" type="checkbox">{accept}</th>
		<th><input name="submit" type="submit" value="{signup}"></th>
	</tr>
</table>
</form>
</center>
