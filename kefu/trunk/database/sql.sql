alter table kf_questions add  column quick_id int(5) NOT NULL DEFAULT '0' COMMENT '快捷回复ID，0表示不支持快捷回复';
ALTER TABLE `kf_questions` ADD INDEX quick_id ( `quick_id` );