<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
  <title><?php echo $title ?></title>
  <meta name="description" content="<?php echo $meta_description ?>">
  <meta name="keyword" content="<?php echo $meta_keywords ?>">
  <link rel="stylesheet" href="/css/application.css" type="text/css" media="screen" title="no title" charset="utf-8">
  <script src="/js/jquery-1.5.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="/js/jquery.validate.min.js" type="text/javascript" charset="utf-8"></script>
  <script src="/js/application.js" type="text/javascript" charset="utf-8"></script>
</head>
<body>
<div id="header">
  <?php if (!is_logged_in()) : ?>
  <?php echo anchor('register', 'Register') ?> | <?php echo anchor('signin', 'Signin') ?>
  <?php else : ?>
  <?php echo current_user()->email; ?>
  <?php endif; ?>
</div>
<?php if (!empty($error)) : ?>
<div id="error"><?php echo $error; ?></div>
<?php endif; ?>
<?php if (!empty($notice)) : ?>
<div id="notice"><?php echo $notice; ?></div>
<?php endif; ?>
<div id="content">