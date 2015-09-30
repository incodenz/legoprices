
DROP TABLE IF EXISTS `user`;

CREATE TABLE IF NOT EXISTS `user` (
  `id` INT(11) NOT NULL AUTO_INCREMENT,
  `email` VARCHAR(90) NOT NULL,
  `first_name` VARCHAR(90) NOT NULL,
  `last_name` VARCHAR(90) DEFAULT NULL,
  `auth_key` VARCHAR(32) NULL DEFAULT NULL,
  `password_hash` VARCHAR(255) NULL DEFAULT NULL,
  `password_reset_token` VARCHAR(255) NULL DEFAULT NULL,
  `password_reset_token_created` TIMESTAMP NULL DEFAULT NULL,
  `status_id` TINYINT(4) NULL DEFAULT NULL,
  `created_at` TIMESTAMP NULL DEFAULT NULL,
  `updated_at` TIMESTAMP NULL DEFAULT NULL,
  `role_id` TINYINT(2) NOT NULL,
  PRIMARY KEY (`id`),
  UNIQUE INDEX `id_UNIQUE` (`id` ASC),
  UNIQUE INDEX `email_UNIQUE` (`email` ASC))
  ENGINE = InnoDB;