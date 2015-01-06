-- --------------------------------------------------------------------------------
-- Routine DDL
-- Note: comments before and after the routine body will not be stored by the server
-- --------------------------------------------------------------------------------
DELIMITER $$

CREATE DEFINER=`stoycho`@`95.111.50.161` PROCEDURE `sphinx_companies_active`(start_id BIGINT, end_ID BIGINT, lang VARCHAR(3))
BEGIN
select
		cast(concat('1', `C`.`id`) as unsigned) AS `id`,
		cast(concat('1', `C`.`id`) as unsigned) AS `att_id`,
        `C`.`id` AS `doc_id`,
        unix_timestamp(`C`.`created_at`) AS `date_added`,
        `C`.`country_id` AS `country_id`,
        `CI`.`county_id` AS `county_id`,
        `C`.`city_id` AS `city_id`,
        `CL`.`longitude` AS `longitude`,
        `CL`.`latitude` AS `latitude`,
        radians(`CL`.`latitude`) AS `lat_rad`,
        radians(`CL`.`longitude`) AS `lng_rad`,
        `C`.`score` AS `score`,
        `C`.`average_rating` AS `star_rating`,
        `C`.`sector_id` AS `sector_id`,
        `C`.`classification_id` AS `classification_id`,
        `TR`.`text` AS `inComp_review`,
        '' AS `reviewText`,
        0 AS `reviewsCount`,
        '' AS `imageText`,
        0 AS `imageCount`,
        '' AS `videoText`,
        0 AS `videoCount`,
		COALESCE(`offrCntTab`.`offersCnt`, 0) AS `offer_count`,
		/*'' AS `description`,
		0 AS `descriptionCount`,
		'' AS `detail_description`,
		0 AS `detail_descriptionCount`,*/
		COALESCE(ads.is_ppp, 0, 1) AS `is_ppp`,
		COALESCE(`ct`.`title`, `cten`.`title`) AS `localizedTitle`,
		CONCAT(COALESCE(`ct`.`title`, ''), ' ', COALESCE(`cten`.`title`, '')) AS `searchTitle`,
		/*if(clear_duplicated_spaces(COALESCE(`ct`.`title`, '',  `ct`.`title`)) = clear_duplicated_spaces(`cten`.`title`), `cten`.`title`, concat(COALESCE(`ct`.`title`, '',  `ct`.`title`), ' ',`cten`.`title`) ) AS `searchTitle`, */
		TRIM(BOTH ', ' FROM concat(TRIM(CONCAT(COALESCE(`CL`.`street`, ''),  ' ', COALESCE(`CL`.`street_number`, ''))), ', ', COALESCE(`CL`.`neighbourhood`, ''))) AS `address`
    from
        `company` `C`
        join `company_location` `CL` ON `C`.`location_id` = `CL`.`id`
        join `city` `CI` ON `C`.`city_id` = `CI`.`id`
		left join `company_translation` `ct` ON `C`.`id` = `ct`.`id` AND `ct`.`lang` = lang
		left join `company_translation` `cten` ON `C`.`id` = `cten`.`id` AND `cten`.`lang` = 'en'
        left join `review` `TR` ON `C`.`review_id` = `TR`.`id`
		left join (
			SELECT  DISTINCT company_id AS cid, 1 AS is_ppp
			FROM ad_service_company adc
			WHERE ad_service_id = 11
						AND status = 'active'
						AND (active_to IS NULL and crm_id IS NOT NULL) OR (active_to >= now() and crm_id IS NULL)
			) as ads ON `C`.`id` = ads.cid
		left join (
			select
                `CO`.`company_id`, count(0) as `offersCnt`
            from
                (`company_offer` `CO`
                join `ad_service_company` `ADC` ON (((`CO`.`company_id` = `ADC`.`company_id`)
                    and (`ADC`.`ad_service_id` = 13))))
            where
                (((isnull(`ADC`.`active_to`)
                    and (`ADC`.`crm_id` is not null))
                    or ((`ADC`.`active_to` >= now())
                    and isnull(`ADC`.`crm_id`)))
                    and (`CO`.`active_from` <= now())
                    and (`CO`.`active_to` >= (now() - interval 7 day)))
			GROUP BY `CO`.`company_id`) as offrCntTab ON `C`.`id` = `offrCntTab`.`company_id`
    where
         `C`.`status` = 0 AND `C`.`id` >= start_id AND `C`.`id` <= end_ID;
END