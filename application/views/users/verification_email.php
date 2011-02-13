<html>
  <body>
    <p>Hi <?php echo $user->username; ?></p>
    
    <p>Thank you for registering at <?php $this->config->item('app_title'); ?>. To complete the process, we just need to verify that this email address - <?php echo $user->email; ?> belongs to you. Simply click the link below.</p>
    
    <p><a href="<?php echo $this->config->item('base_url'); ?>verify/<?php echo urlencode($user->email);?>/<?php echo urlencode($user->verification_code);?>">Verify Now</a></p>
    
    <?php /* <p>For more information, see our <a href="<?php echo $this->config->item('base_url');?>faq">frequently asked questions</a>.</p> */ ?>
    
    <p>Thanks,<br />
    <?php $this->config->item('app_title'); ?></p>
  </body>
</html>
