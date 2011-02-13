<?php echo form_open('users/authenticate', array('class' => 'validatable')) ?>
  <ul class="fields">
    <li class="clearfix"><label for="username">Username or Email</label> <input type="text" name="username_or_email" id="username_or_email" value="" class="autofocus required" minlength="2" /></li>
    <li class="clearfix"><label for="password">Password</label> <input type="password" name="password" id="password" value="" class="required" /></li>
    <li class="clearfix"><input type="checkbox" id="remember" name="remember" value="yes" /> <label for="remember">Remember me</label></li>
  </ul>
  <ul class="buttons">
    <li><input type="submit" value="Signin" /></li>
  </ul>
<?php echo form_close() ?>
