<?php echo form_open('users/verify', array('class' => 'validatable')) ?>
  <ul class="fields">
    <li class="clearfix"><label for="email">Email</label> <input type="text" name="verification_email" id="email" value="" class="required email" /></li>
    <li class="clearfix"><label for="password">Token</label> <input type="password" name="verification_token" id="password" value="" class="required" /></li>
  </ul>
  <ul class="buttons">
    <li><input type="submit" value="Verify" /></li>
  </ul>
<?php echo form_close() ?>
