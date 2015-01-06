CREATE OR REPLACE VIEW `sphinx_search` AS
    select distinct
        `C`.`id` AS `id`,
        unix_timestamp(`C`.`created_at`) AS `date_added`,
        group_concat(`CT`.`title` SEPARATOR ' ') AS `title`,
        `C`.`city_id` AS `city_id`,
        `CI`.`county_id` AS `county_id`,
        concat(`C`.`description`,
                ' ',
                `C`.`description_en`) AS `description`,
        `CL`.`longitude` AS `longitude`,
        `CL`.`latitude` AS `latitude`,
        radians(`CL`.`latitude`) AS `lat_rad`,
        radians(`CL`.`longitude`) AS `lng_rad`,
        `C`.`score` AS `score`,
        `C`.`average_rating` AS `star_rating`,
        `C`.`country_id` AS `country_id`,
        `C`.`sector_id` AS `sector_id`,
        `C`.`classification_id` AS `classification_id`,
        if(isnull(`AD`.`id`), 0, 1) AS `is_ppp`,
        `TR`.`user_id` AS `tr_user_id`,
        if(((`TRSF`.`first_name` is not null)
                or (`TRSF`.`last_name` is not null)),
            concat_ws(' ',
                    `TRSF`.`first_name`,
                    `TRSF`.`last_name`),
            `TRSF`.`username`) AS `tr_u_name`,
        `TRSF`.`username` AS `TR_u_username`,
        `TR`.`text` AS `tr_review`,
        `C`.`updated_at` AS `updated_at`,
        (select
                count(0)
            from
                (`company_offer` `CO`
                join `ad_service_company` `ADC` ON (((`CO`.`company_id` = `ADC`.`company_id`)
                    and (`ADC`.`ad_service_id` = 13))))
            where
                (((isnull(`ADC`.`active_to`)
                    and (`ADC`.`crm_id` is not null))
                    or ((`ADC`.`active_to` >= now())
                    and isnull(`ADC`.`crm_id`)))
                    and (`CO`.`company_id` = `C`.`id`)
                    and (`CO`.`active_from` <= now())
                    and (`CO`.`active_to` >= (now() - interval 7 day)))) AS `offer_count`
    from
        ((((((`company` `C`
        join `company_location` `CL` ON ((`CL`.`id` = `C`.`location_id`)))
        left join `city` `CI` ON ((`CI`.`id` = `C`.`city_id`)))
        left join `review` `TR` ON ((`C`.`review_id` = `TR`.`id`)))
        left join `company_translation` `CT` ON ((`CT`.`id` = `C`.`id`)))
        left join `sf_guard_user` `TRSF` ON ((`TR`.`user_id` = `TRSF`.`id`)))
        left join `ad_service_company` `AD` ON (((`AD`.`company_id` = `C`.`id`)
            and (`AD`.`ad_service_id` = 11)
            and (`AD`.`active_from` <= now())
            and (`AD`.`status` = 'active')
            and ((isnull(`AD`.`active_to`)
            and (`AD`.`crm_id` is not null))
            or ((`AD`.`active_to` >= now())
            and isnull(`AD`.`crm_id`))))))
    where
        (`C`.`status` = 0)
GROUP BY `C`.`id`