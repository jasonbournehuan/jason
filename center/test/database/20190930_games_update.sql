update `center`.`center_games` set  hot = 0;
UPDATE `center`.`center_games` SET `hot`='1' WHERE (`id`='130'  OR
`id`='692'  OR `id`='570'  OR `id`='695'  OR `id`='116' OR `id`='321' OR `id`='794' OR `id`='127' OR `id`='132' OR `id`='714' OR `id`='154' OR `id`='133' OR `id`='142' OR `id`='131' OR `id`='789' OR `id`='784' OR `id`='129' OR `id`='125' OR `id`='124' OR `id`='137' OR `id`='134' OR `id`='361' OR `id`='145' OR `id`='93' OR `id`='92');
UPDATE `center`.`center_games` SET `paixu`= `center_games`.id;