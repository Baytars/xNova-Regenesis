<br />
<br />
<form action="" method="post">
  <table width="438">
    <tbody>
	    <tr>
      <th colspan="2" class="c">{lg_registry}</th>
    </tr>
    <tr>
      <td colspan="2" class="b"><div align="center">{servername}</div>
      </td>
    </tr>
      <tr>
        <td colspan="2" class="c"><div align="center"><b>{lg_necessary_info}</b></div></td>
      </tr>
      <tr>
        <th>{lg_username}</th>
        <th><input name="username" size="20" maxlength="20"
          type="text"
          onkeypress=" if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"
          /> </th>
      </tr>
      <tr>
        <th>{lg_password}</th>
        <th><input name="password" size="20" maxlength="20" type="password"
          onkeypress=" if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"
          /> </th>
      </tr>
      <tr>
        <th>{lg_email}</th>
        <th><input name="email" size="20" maxlength="40" type="text"
          onkeypress=" if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"
          /> </th>
      </tr>
      <tr>
        <th>{lg_mother_planet}</th>
        <th><input name="planet" size="20" maxlength="20" type="text"
          onkeypress=" if (event.keyCode==60 || event.keyCode==62) event.returnValue = false; if (event.which==60 || event.which==62) return false;"
          /> </th>
      </tr>
      <tr>
        <th>{lg_sex}</th>
        <th>
          <select name="sex">
            <option value="" selected="selected">{lg_undefined}</option>
            <option value="M">{lg_male}</option>
            <option value="F">{lg_female}</option>
          </select>
           </th>
      </tr>
      <tr>
        <th>{lg_language}</th>
        <th>
          <select name="language">
            <option value="es" selected="selected">{es}</option>
            <option value="en">{en}</option>
            <option value="fr">{fr}</option>
			<option value="pt">{pt}</option>
			<option value="tr">{tr}</option>
          </select>
           </th>
      </tr>
	  <!-- START BLOCK : recaptcha -->	
      <tr>
        <th colspan="2" align="center">
          <br />
          <div align="center">
          <script type="text/javascript" src="http://api.recaptcha.net/challenge?k={rec_publickey}">
          </script>
          <noscript>
          <iframe src="http://api.recaptcha.net/noscript?k={rec_publickey}" width="500"></iframe>
          <img src="http://api.recaptcha.net/noscript?k={rec_publickey}" alt="" />
          <textarea name="recaptcha_challenge_field" rows="3" cols="40" tabindex="12"></textarea>
		  <input type="hidden" name="recaptcha_response_field" value="manual_challenge" />
          </noscript>
          </div>
        </th>
      </tr>
	  <!-- END BLOCK : recaptcha -->
	  <!-- START BLOCK : captcha -->	
      <tr>
        <th>
          <div align="center"><img id="captcha" src="class/securimage/securimage_show.php" alt="CAPTCHA Image" /><br />
		  <a href="#" onclick="document.getElementById('captcha').src = 'class/securimage/securimage_show.php?' + Math.random(); return false">{lg_reload_captcha}</a>
          </div>
        </th>
		<th>
          <div align="center"><input type="text" name="captcha_code" size="10" maxlength="6" />
          </div>
        </th>
      </tr>
	  <!-- END BLOCK : captcha -->
      <tr>
        <th colspan="2"><input name="rgt" type="checkbox" />{lg_accept_tac}<a href="#" onClick="f('rules.php', '');" accesskey="c">{lg_rules}</a> {lg_and} <a href="#" onClick="f('rules.php?mode=tac', '');" accesskey="c">{lg_tac}</a></th>
      </tr>
      <tr>
        <th colspan="2" >
          <input name="submit" type="submit" value="{lg_register}" /></th>
      </tr>
    </tbody>
  </table>
</form>

<script language="JavaScript">
function f(target_url,win_name) {
  var new_win = window.open(target_url,win_name,'resizable=yes,scrollbars=yes,menubar=no,toolbar=no,width=550,height=280,top=0,left=0');
  new_win.focus();
}
</script>