CREATE TABLE IF NOT EXISTS `user` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT COMMENT 'id',
  `user_id` bigint(20) NOT NULL COMMENT 'user_id',
  `first_name` char(255) COLLATE utf8mb4_unicode_520_ci NOT NULL COMMENT 'userning nomi',
  `last_name` char(255) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'user familiyasi',
  `username` char(191) COLLATE utf8mb4_unicode_520_ci DEFAULT NULL COMMENT 'username',
  `created` timestamp NULL DEFAULT NULL COMMENT 'Reg bulgan vaqti',
  `updated` timestamp NULL DEFAULT NULL COMMENT 'Yangilangan',
  PRIMARY KEY (`id`) USING BTREE,
  KEY `user_id` (`user_id`)
) ENGINE=InnoDB AUTO_INCREMENT=323 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_520_ci COMMENT='Userni royxatga olamiz';
