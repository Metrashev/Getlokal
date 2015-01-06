

DELETE company_detail FROM company_detail inner join company on company_id =company.id where country_id=4;
DELETE company_classification FROM company_classification inner join company on company_id =company.id where country_id=4;
DELETE review FROM review inner join company on company_id =company.id where country_id=4;
DELETE image,company_image FROM image inner join company_image on image.id=company_image.image_id inner join company on company_id =company.id where company.country_id=4;

DELETE activity from activity inner join page on activity.page_id = page.id inner join company on page.foreign_id =company.id and page.type=2 where company.country_id = 4

DELETE list_page,lists from list_page inner join page on list_page.page_id = page.id 
inner join lists on lists.id= list_page.list_id
inner join company on page.foreign_id =company.id and page.type=2 where company.country_id = 4

DELETE event_page from event_page inner join page on event_page.page_id = page.id 
inner join event on event.id= event_page.event_id
inner join company on page.foreign_id =company.id and page.type=2 where company.country_id = 4

DELETE page FROM page inner join company on page.foreign_id =company.id and type=2 where company.country_id=4;
DELETE company_location FROM company_location inner join company on company_id =company.id where country_id=4;
DELETE FROM `company` where country_id=4;




 
 ///285152(next company id) 
 
UPDATE sr_company SET id = id + 285175;
UPDATE company_location SET company_id = company_id + 285175;
UPDATE company_classification SET company_id = company_id + 285175;
UPDATE company_detail SET company_id = company_id + 285175;
UPDATE company_detail_sr SET company_id = company_id + 285175;
UPDATE sr_company  SET parent_id = parent_id + 285175 where parent_id > 0;

////






INSERT INTO getlokal_new.company (`id`, `external_id`, `title`, `title_en`, `description`, `description_en`, `email`, `phone`, `phone1`, `phone2`, `website_url`, `city_id`, `location_id`, `image_id`, `sector_id`, `classification_id`, `review_id`, `company_type`, `company_number`, `parent_external_id`, `is_validated`, `status`, `number_of_reviews`, `average_rating`, `is_address_modified`, `googleplus_url`, `facebook_url`, `foursquare_url`, `twitter_url`, `registration_no`, `updated_crm`, `date_mod_crm`, `created_by`, `score`, `country_id`, `date_last_modified_by`, `last_modified_by`, `referer`, `old_slug`, `cover_image_id`, `created_at`, `updated_at`, `slug`, `last_click`, `facebook_id`, parent_id)  SELECT c.* FROM sr_company c INNER JOIN city ci ON ci.id = c.city_id;

INSERT INTO getlokal_new.company_detail SELECT NULL, `company_id`, `mon_from`, `mon_to`, `tue_from`, `tue_to`, `wed_from`, `wed_to`, `thu_from`, `thu_to`, `fri_from`, `fri_to`, `sat_from`, `sat_to`, `sun_from`, `sun_to`, `content`, `content_en`, `confirmed`, `last_modified_by`, `created_at`, `updated_at` FROM `company_detail`

INSERT INTO getlokal_new.company_classification SELECT NULL, `classification_id`, `company_id` FROM `company_classification` WHERE 1;

INSERT INTO getlokal_new.company_location SELECT NULL, `company_id`, `accuracy`, `is_active`, `user_id`, `location_type`, `street_type_id`, `street_number`, `street`, `neighbourhood`, `building_no`, `entrance`, `floor`, `appartment`, `postcode`, `zoom`, `latitude`, `longitude`, `created_at`, `updated_at`, `full_address`, `full_address_en`, `address_info`, `address_info_en`, `sublocation`  FROM `company_location` WHERE 1

UPDATE company c INNER JOIN company_location cl ON cl.company_id = c.id SET c.location_id = cl.id WHERE c.location_id IS NULL;

INSERT INTO page (`is_public`, `url_alias`, `foreign_id`, `country_id`, `type`, `created_at`, `updated_at`)
select 1, null, c.id, 4, 2, now(),now() FROM company c WHERE c.country_id=4

CREATE TABLE company_detail_sr (
id BIGINT NOT NULL,
company_id BIGINT NOT NULL,
internal_id  BIGINT,
full_company_name VARCHAR(255) NOT NULL, 
sr_url VARCHAR(255)
) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
 
 INSERT INTO getlokal_new.company_detail_sr SELECT * from company_detail_sr WHERE 1;



























////


Insert into gl_import_old.sr_company 
(`external_id`, `title`, `title_en`, `description`, `description_en`, `email`, `phone`, `phone1`, `phone2`, `website_url`, `city_id`, `location_id`,  `sector_id`, `classification_id`,  `company_type`,  `is_validated`, `status`,  `googleplus_url`, `facebook_url`, `foursquare_url`, `twitter_url`, `registration_no`, `country_id`, `created_at`, `updated_at`, `slug`, `last_click`, `facebook_id`,  `parent_id`)
select
 egl.id, title, title_en, null, null,
email, phone, phone1, phone2,website_url, city_id, 
null, ca.sector_id, classification_id, company_type,
1,0 , googleplus_url, facebook_url, 
foursquare_url, twitter_url, registration_no, 4,
now(),now(), null, now(), facebook_id,
 parent_id
 FROM gl_import_old.new_company egl 
 INNER JOIN getlokal_new.classification ca ON ca.id = egl.classification_id;