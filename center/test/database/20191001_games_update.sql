 update `center`.`center_games`  set  `status` = 2 where platform_id = 6 and type_id = 5;
 INSERT INTO `center`.`center_games`(`id`, `platform_id`, `category_id`, `game_code`, `game_name_cn`, `game_name_en`, `game_name_tw`, `pic`, `module_id`, `type_id`, `line_type`, `line`, `min_money`, `max_money`, `rtp`, `status`, `hot`, `add_time`, `query_info`, `screen`, `pc`, `wap`, `paixu`) VALUES (828, 6, 31, '', '真人大厅', 'live', NULL, '', 0, 5, 0, 0, 0.00, 0.00, 0.00, 1, 0, 20193, NULL, 2, 1, 1, 402);
UPDATE `center`.`center_games` SET `platform_id` = 11, `category_id` = 8, `game_code` = '8210', `game_name_cn` = '搏一搏（无独立入口）', `game_name_en` = NULL, `game_name_tw` = '', `pic` = NULL, `module_id` = 8210, `type_id` = 2, `line_type` = 0, `line` = 0, `min_money` = 0.00, `max_money` = 0.00, `rtp` = 0.00, `status` = 2, `hot` = 0, `add_time` = 0, `query_info` = '', `screen` = 2, `pc` = 1, `wap` = 1, `paixu` = 817 WHERE `id` = 817;