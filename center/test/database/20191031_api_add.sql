alter table `center`.`center_api` add(`wallet` decimal(14,4) not null default '0' comment '钱包');
alter table `center`.`center_api` add index wallet(wallet);
create table `center`.`center_api_log`(
                                          `id` int(11) NOT NULL AUTO_INCREMENT COMMENT '自增id',
                                          `add_time` varchar(10) default '' comment '添加时间',
                                          `api_id` int(2) not null comment 'api id',
                                          `platform_id` int(3) not null default 0 comment '平台id',
                                          `game_id` int(3) not null default 0 comment '游戏id',
                                          `site_id` int(5) not null default 0 comment '网站id',
                                          `service_id` int(5) not null default 0 comment '服务器id',
                                          `money` decimal(15,4) not null  default 0.0000 comment '操作金额',
                                          `type_id` int(1)   comment '1：增加。2：减少',
                                          primary key(`id`) using btree,
                                          index `id`(`id`) using btree,
                                          index `api_id`(`api_id`) using btree,
                                          index `platform_id`(`platform_id`) using btree,
                                          index `game_id`(`game_id`) using btree,
                                          index `site_id`(`site_id`) using btree,
                                          index `service_id`(`service_id`) using btree,
                                          index `money`(`money`) using btree,
                                          index `type_id`(`type_id`) using btree
) engine = MyISAM auto_increment = 1  character set = utf8 collate = utf8_general_ci row_format = Dynamic;