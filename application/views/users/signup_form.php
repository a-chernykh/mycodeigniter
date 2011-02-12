<?php echo form_open('users/create') ?>
<ul class="fields">
  <li class="clearfix"><label for="username">Username</label> <input type="text" name="username" id="username" value="" class="autofocus" /></li>
  <li class="clearfix"><label for="email">Email</label> <input type="text" name="email" id="email" value="" /></li>
  <li class="clearfix"><label for="password">Password</label> <input type="password" name="password" id="password" value="" /></li>
  <li class="clearfix"><label for="password_confirmation">Password confirmation</label> 
    <input type="password" name="password_confirmation" id="password_confirmation" value="" /></li>
  <li><?php echo recaptcha_get_html($this->config->item('recaptcha_public_key')) ?></li>
  <li class="clearfix"><input type="checkbox" id="accept_terms" name="accept_terms" value="yes"> <label for="accept_terms">I accept terms and conditions</label></li>
</ul>
<ul class="buttons">
  <li><input type="submit" value="Register" /></li>
</ul>
<?php echo form_close() ?>