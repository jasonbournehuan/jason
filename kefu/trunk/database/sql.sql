alter table kf_questions add  column quick_id int(5) NOT NULL DEFAULT '0' COMMENT '��ݻظ�ID��0��ʾ��֧�ֿ�ݻظ�';
ALTER TABLE `kf_questions` ADD INDEX quick_id ( `quick_id` );