alter table action_days add gallery_image varchar(200);
alter table action_days add gallery_link varchar(200);

DROP VIEW actions;

CREATE VIEW `actions`
AS SELECT
   `action_days`.`created_at` AS `day`,
   `action_days`.`start` AS `start`,
   `action_days`.`end` AS `end`,
   `action_days`.`marrow` AS `marrow`,
   `places`.`name` AS `place`,
   `schools`.`short_name` AS `school_short`,
   `schools`.`name` AS `school`,
   `places`.`address` AS `address`,
   `places`.`lat` AS `lat`,
   `places`.`lng` AS `lng`,
   `editions`.`number` AS `number`,
   `action_days`.`gallery_image` as `gallery_image`,
   `action_days`.`gallery_link` as `gallery_link`
FROM (((`action_days` join `places` on((`action_days`.`place_id` = `places`.`id`))) join `schools` on((`places`.`school_id` = `schools`.`id`))) join `editions` on((`action_days`.`edition_id` = `editions`.`id`)));
