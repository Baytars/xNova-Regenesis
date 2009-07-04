<center>
<br />
<br />
  <table>
    <tbody>
	<form method="post" action="">
      <tr>
        <th colspan="2" class="b">{lg_adm_reg_cfg}</th>
      </tr>
      <tr>
        <td class="c">{lg_adm_mail_cfg}</td>
        <td class="c">
          <select name="reg_mail" id="reg_mail">
            <option value="0" {sel_mail1}>{lg_adm_disable}</option>
            <option value="1" {sel_mail2}>{lg_adm_active}</option>
          </select>
           </td>
      </tr>
      <tr>
        <td class="c">{lg_adm_mail_act}</td>
        <td class="c">
          <select name="reg_act" id="reg_act">
            <option value="0" {sel_act1}>{lg_adm_act_auto}</option>
            <option value="1" {sel_act2}>{lg_adm_act_mail}</option>
          </select>
           </td>
      </tr>
      <tr>
        <td class="c">{lg_adm_bot}</td>
        <td class="c">
          <select name="reg_bot" id="reg_bot">
            <option value="0" {sel_bot1}>{lg_adm_disable}</option>
            <option value="recaptcha" {sel_bot2}>{lg_adm_recaptcha}</option>
            <option value="captcha" {sel_bot3}>{lg_adm_captcha}</option>
          </select>
           </td>
      </tr>
      <tr>
        <td colspan="2" class="c">{lg_adm_recaptcha_cfg}</td>
      </tr>
      <tr>
        <td class="c">{lg_adm_public}</td>
        <td class="c"><input type="text" name="rec_publickey" id="rec_publickey" value="{rec_publickey}" /></td>
      </tr>
      <tr>
        <td class="c">{lg_adm_private}</td>
        <td class="c"><input type="text" name="rec_privatekey" id="rec_privatekey" value="{rec_privatekey}" /></td>
      </tr>
      <tr>
        <td colspan="2" class="a">
          <input type="submit" name="save" value="{lg_adm_save}" /></td>
      </tr>
	  </form>
    </tbody>
  </table>
</center>