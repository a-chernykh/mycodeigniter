ALTER TABLE `users` ADD `is_active` tinyint(1) NOT NULL DEFAULT '0' AFTER `password_salt`;
