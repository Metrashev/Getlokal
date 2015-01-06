SELECT 
IF(f1.answer = 1, 'Bere', IF(f1.answer = 2, 'Vin', IF(f1.answer = 3, 'Cocktail-uri', IF(f1.answer = 4, 'Long drinks', IF(f1.answer = 5, 'Shot-uri', IF(f1.answer = 6, 'Nu beau alcool', '')))))) drink,
IF(f2.answer = 0, 'Rock', IF(f2.answer = 1, 'Indie', IF(f2.answer = 2, '80s music', IF(f2.answer = 3, 'Dubstep', IF(f2.answer = 4, 'Punk', IF(f2.answer = 5, 'Nu prea dansez', '')))))) dance,
IF(f3.answer = 0, 'Cu gașca de prieteni vechi', IF(f3.answer = 1, 'Cu iubitul/ iubita', IF(f3.answer = 2, 'Cu colegii de la munca/ scoala', IF(f3.answer = 3, 'Singur - îmi fac prieteni rapid', IF(f3.answer = 4, 'Cu cine se nimerește', IF(f3.answer = 5, 'Nu prea ies în oraș', '')))))) friends,
f4.answer place, up.birthdate, sf.first_name, sf.last_name, sf.email_address, c.name, co.title, ct.title
FROM facebook_game f1
INNER JOIN facebook_game f2 ON f2.uid = f1.uid AND f2.question = 'dance'
INNER JOIN facebook_game f3 ON f3.uid = f1.uid AND f3.question = 'friends'
INNER JOIN facebook_game f4 ON f4.uid = f1.uid AND f4.question = 'place_name'
INNER JOIN facebook_game f5 ON f5.uid = f1.uid AND f5.question = 'place_id'
INNER JOIN company co ON co.id = f5.answer
INNER JOIN classification cc ON cc.id = co.classification_id
INNER JOIN classification_translation ct ON ct.id = cc.id AND ct.lang = 'ro'
INNER JOIN user_profile up ON up.id = f1.user_id
INNER JOIN sf_guard_user sf ON sf.id = up.id
LEFT JOIN city c ON c.id = up.city_id
WHERE f1.game = 'gl_ro_party_name' AND f1.question = 'drink';




  
INSERT INTO classification_sector
(classification_id, sector_id)
 SELECT 
classification.id, temp_class.sector_id
FROM temp_class
INNER JOIN classification  ON 
classification.ned_id = temp_class.ned_id






UPDATE classification
SET sector_id = 	( SELECT temp_class.sector_id
FROM temp_class
WHERE classification.ned_id = temp_class.ned_id and temp_class.is_primary=1)
WHERE EXISTS
  ( SELECT temp_class.sector_id
FROM temp_class
WHERE  classification.ned_id = temp_class.ned_id and temp_class.is_primary=1)





insert into getlokal.company_classification (company_id, classification_id)
select gc.id, gcl.id
from getlokal.company gc inner join 
 getlokal3.company gc3 on gc.external_id=gc3.guid
 inner join getlokal.classification  gcl
 on gcl.external_id=gc3.classifier_guid
 
 
UPDATE company
SET classification_id = 	( SELECT company_classification.classification_id
FROM company_classification
WHERE company_classification.company_id = company.id )
WHERE EXISTS
  ( SELECT  company_classification.classification_id
FROM company_classification
WHERE company_classification.company_id = company.id)





UPDATE company
SET sector_id = 	( SELECT temp_class.sector_id
FROM temp_class
WHERE temp_class.classification_id = company.classification_id  and temp_class.is_primary=1)
WHERE EXISTS
  ( SELECT temp_class.sector_id
FROM temp_class
WHERE temp_class.classification_id = company.classification_id  and temp_class.is_primary=1)



INSERT INTO city (`id`, `name`, `slug`, `county_id`, `is_default`, `lat`, `lng`, `old_id`) 
  SELECT NULL, city, city_en, 71, 0, '', '', NULL FROM `zk_db` GROUP BY city;
  
UPDATE zk_db z INNER JOIN city c ON c.name = z.city SET z.city_id = c.id;

UPDATE zk_db SET lat = LEFT(geo, LOCATE('&', geo));
UPDATE zk_db SET lng = RIGHT(geo, LENGTH(geo) - LOCATE('&', geo));

UPDATE zk_db SET temp = lat;
UPDATE zk_db SET lat = lng, lng = temp;

INSERT INTO company 
(`id`, `external_id`, `title`, `title_en`, `description`, `description_en`, `email`, `phone`, `website_url`, `city_id`, `location_id`, `image_id`, `sector_id`, `classification_id`, `review_id`, `company_type`, `company_number`, `parent_external_id`, `is_validated`, `status`, `number_of_reviews`, `average_rating`, `is_address_modified`, `facebook_url`, `registration_no`, `updated_crm`, `date_mod_crm`, `created_by`, `score`, `country_id`, `created_at`, `updated_at`, `slug`, `last_modified_by`)
SELECT null, id, name, name_en, '','', email, CONCAT(phone_prefix, phone), url, city_id, NULL, NULL, NULL, NULL, NULL, '', '', '', 1, 1, 0, 0,0,'','','','',NULL, 0, 3, now(), now(), CONCAT(slugify(name_en), '_', id), NULL FROM `zk_db`

INSERT INTO company_classification
  SELECT
   NULL, ccc.id,c.id
  FROM `zk_db` t
  INNER JOIN company c ON c.external_id = t.id
  INNER JOIN `matched classifications` cc ON cc.external_id = t.class_1
  INNER JOIN getlokal.classification ccc ON ccc.id = cc.id;
  
UPDATE company c SET c.classification_id = (SELECT classification_id FROM company_classification cc WHERE cc.company_id = c.id LIMIT 1) WHERE c.classification_id IS NULL;

UPDATE company c INNER JOIN classification cc ON c.classification_id = cc.id SET c.sector_id = cc.sector_id;
UPDATE company c INNER JOIN company_location cc ON c.id = cc.company_id SET c.location_id = cc.id;

INSERT INTO company_location 
(`id`, `company_id`, `accuracy`, `is_active`, `user_id`, full_address, full_address_en, `latitude`, `longitude`, `created_at`, `updated_at`)
SELECT
NULL, c.id, 1, 1, NULL, address, address_en, lat, lng, now(), now()
FROM `TABLE 80` t
INNER JOIN company c ON c.external_id = t.id;

INSERT INTO county SELECT * FROM mk_import.county WHERE country_id = 3;
INSERT INTO city SELECT * FROM mk_import.city WHERE county_id = 71;

INSERT IGNORE INTO company (`id`, `external_id`, `title`, `title_en`, `description`, `description_en`, `email`, `phone`, `website_url`, `city_id`, `location_id`, `image_id`, `sector_id`, `classification_id`, `review_id`, `company_type`, `company_number`, `parent_external_id`, `is_validated`, `status`, `number_of_reviews`, `average_rating`, `is_address_modified`, `facebook_url`, `registration_no`, `updated_crm`, `date_mod_crm`, `created_by`, `score`, `country_id`, `created_at`, `updated_at`, `slug`, `last_modified_by`) SELECT cc.`id`, `external_id`, `title`, `title_en`, `description`, `description_en`, `email`, `phone`, `website_url`, `city_id`, `location_id`, `image_id`, `sector_id`, `classification_id`, `review_id`, `company_type`, `company_number`, `parent_external_id`, `is_validated`, `status`, `number_of_reviews`, `average_rating`, `is_address_modified`, `facebook_url`, `registration_no`, `updated_crm`, `date_mod_crm`, `created_by`, `score`, `country_id`, `created_at`, `updated_at`, cc.`slug`, `last_modified_by` FROM mk_import.company cc INNER JOIN city c ON c.id = city_id;

INSERT IGNORE INTO company_classification SELECT NULL, cc.classification_id , company_id FROM mk_import.company_classification cc INNER JOIN company c ON c.id = company_id;

INSERT INTO company_location 
(id, `company_id`, `accuracy`, `is_active`, `user_id`, `location_type`, `street_type_id`, `street_number`, `street`, `neighbourhood`, `building_no`, `entrance`, `floor`, `appartment`, `postcode`, `zoom`, `latitude`, `longitude`, `created_at`, `updated_at`, `full_address`, `full_address_en`)
SELECT NULL, `company_id`, `accuracy`, `is_active`, `user_id`, `location_type`, `street_type_id`, `street_number`, `street`, `neighbourhood`, `building_no`, `entrance`, `floor`, `appartment`, `postcode`, `zoom`, `latitude`, `longitude`, `created_at`, `updated_at`, `full_address`, `full_address_en` FROM mk_import.company_location;


INSERT INTO export SELECT username, email_address, sf.id, 'new_user' FROM sf_guard_user sf INNER JOIN user_profile up ON up.id = sf.id WHERE sf.created_at > '2012-06-11 00:00:00' AND sf.created_at < '2012-06-18 00:00:00' AND up.country_id = 2;

INSERT INTO export SELECT username, email_address, c.slug, 'review' FROM review r INNER JOIN company c ON c.id = r.company_id INNER JOIN user_profile up ON up.id = r.user_id INNER JOIN sf_guard_user sf ON sf.id = up.id WHERE r.created_at > '2012-06-11 00:00:00' AND r.created_at < '2012-06-18 00:00:00' AND c.country_id = 2;

INSERT INTO export SELECT username, email_address, c.slug, 'image' FROM company_image ci INNER JOIN company c ON c.id = ci.company_id INNER JOIN image r ON ci.image_id = r.id INNER JOIN user_profile up ON up.id = r.user_id INNER JOIN sf_guard_user sf ON sf.id = up.id WHERE r.created_at > '2012-06-11 00:00:00' AND r.created_at < '2012-06-18 00:00:00' AND c.country_id = 2;

INSERT INTO export SELECT username, email_address, c.slug, 'new_company' FROM page_admin pa INNER JOIN page p ON p.id = pa.page_id INNER JOIN company c ON c.id = p.foreign_id INNER JOIN user_profile up ON up.id = pa.user_id INNER JOIN sf_guard_user sf ON sf.id = up.id WHERE c.created_at > '2012-06-11 00:00:00' AND c.created_at < '2012-06-18 00:00:00' AND c.country_id = 2;


INSERT INTO export SELECT '', '', c.slug, 'new_company' FROM company c WHERE c.created_at > '2012-06-11 00:00:00' AND c.created_at < '2012-06-18 00:00:00' AND c.country_id = 2;



SELECT * FROM company c INNER JOIN company_location l ON c.location_id = l.id INNER JOIN page p ON p.foreign_id = c.id INNER JOIN page_admin pa ON pa.page_id = p.id WHERE c.country_id = 2;

SELECT * FROM company c INNER JOIN company_location l ON c.location_id = l.id INNER JOIN review r ON r.company_id = c.id WHERE c.country_id = 2 GROUP BY c.id;



INSERT INTO county (`id`, `name`, `municipality`, `region`, `country_id`)
  SELECT opstina_id, opstina_name, lokopstina_name, region_name, 4
  FROM exportLokacijeForGetLocal GROUP BY opstina_id;
  
INSERT INTO city (`id`, `name`, `name_en`, `slug`, `county_id`, `is_default`)
  SELECT grad_id, grad_name, '', slugify(grad_name), opstina_id, 0
  FROM exportLokacijeForGetLocal GROUP BY grad_id;
  
INSERT INTO company (`id`, `title`, `title_en`, `email`, `phone`, `website_url`, `city_id`, `classification_id`, sector_id, `registration_no`, `is_validated`, `status`, `country_id`, `created_at`, `updated_at`, `slug`)
  SELECT egl.id, title, title_en, email, phone, website_url, city_id, `classification id 1`, ca.sector_id, registration_no, 1, 0, 4, now(), now(), title
   FROM exportDataForGetLocal egl INNER JOIN classification ca ON ca.id = `classification id 1`;
   
INSERT INTO company_location (`id`, `company_id`, `accuracy`, `is_active`, `user_id`, `location_type`, `street_type_id`, `street_number`, `street`, `neighbourhood`, `building_no`, `entrance`, `floor`, `appartment`, `postcode`, `zoom`, `latitude`, `longitude`, `created_at`, `updated_at`)
  SELECT NULL, id, 0, 1, NULL, NULL, NULL, street_number, street, neighbourhood, building_no, entrance, floor, apartment, postcode, 0, latitude, longitude, now(), now()
   FROM exportDataForGetLocal;
   
INSERT INTO company_detail
  (`id`, `company_id`, `mon_from`, `mon_to`, `created_at`, `updated_at`)
  SELECT NULL, id, REPLACE(LEFT(`working hours`, LOCATE('-', `working hours`) -1),':',''), REPLACE(RIGHT(`working hours`, LOCATE('-', `working hours`) -1),':',''), now(), now()
    FROM exportDataForGetLocal;
    
UPDATE `company_detail` SET 
  `tue_from` = `mon_from`, 
  `wed_from` = `mon_from`, 
  `thu_from` = `mon_from`, 
  `fri_from` = `mon_from`, 
  `sat_from` = `mon_from`, 
  `sun_from` = `mon_from`, 
  `tue_to` = mon_to,
  `wed_to` = mon_to,
  `thu_to` = mon_to,
  `fri_to` = mon_to,
  `sat_to` = mon_to,
  `sun_to` = mon_to;
  
INSERT INTO company_classification 
  SELECT NULL, `classification id 1`, id FROM exportDataForGetLocal;
INSERT INTO company_classification 
  SELECT NULL, `classification id 2`, id FROM exportDataForGetLocal WHERE `classification id 2` IS NOT NULL;
INSERT INTO company_classification 
  SELECT NULL, `classification id 3`, id FROM exportDataForGetLocal WHERE `classification id 3` IS NOT NULL;
INSERT INTO company_classification 
  SELECT NULL, `classification id 4`, id FROM exportDataForGetLocal WHERE `classification id 4` IS NOT NULL;
INSERT INTO company_classification 
  SELECT NULL, `classification id 5`, id FROM exportDataForGetLocal WHERE `classification id 5` IS NOT NULL;
  
TRUNCATE temp;
INSERT INTO temp SELECT id, COUNT(*) cnt FROM `company` GROUP BY slug HAVING cnt > 1;
UPDATE company c INNER JOIN temp t ON t.id = c.id SET slug = CONCAT(slug, '_', t.count);


UPDATE county SET id = id + 75 ORDER BY id DESC;
UPDATE city SET id = id + 50100, county_id = county_id + 75;

UPDATE company SET id = id + 242119, city_id = city_id + 50100;
UPDATE company_location SET company_id = company_id + 242119;
UPDATE company_classification SET company_id = company_id + 242119;
UPDATE company_detail SET company_id = company_id + 242119;

DELETE FROM company WHERE city_id NOT IN (SELECT id FROM city);
DELETE FROM company_detail WHERE company_id NOT IN (SELECT id FROM company);
DELETE FROM company_classification WHERE company_id NOT IN (SELECT id FROM company);
DELETE FROM company_location WHERE company_id NOT IN (SELECT id FROM company);

INSERT INTO getlokal_new.county SELECT * FROM county;
INSERT INTO getlokal_new.city SELECT * FROM city;
INSERT INTO getlokal_new.company_detail SELECT NULL, `company_id`, `mon_from`, `mon_to`, `tue_from`, `tue_to`, `wed_from`, `wed_to`, `thu_from`, `thu_to`, `fri_from`, `fri_to`, `sat_from`, `sat_to`, `sun_from`, `sun_to`, `content`, `content_en`, `confirmed`, `last_modified_by`, `created_at`, `updated_at` FROM `company_detail`
INSERT INTO getlokal_new.company_classification SELECT NULL, `classification_id`, `company_id` FROM `company_classification` WHERE 1;
INSERT INTO getlokal_new.sector_translation SELECT * FROM `sector_translation` WHERE 1;
INSERT INTO getlokal_new.company (`id`, `external_id`, `title`, `title_en`, `description`, `description_en`, `email`, `phone`, `phone1`, `phone2`, `website_url`, `city_id`, `location_id`, `image_id`, `sector_id`, `classification_id`, `review_id`, `company_type`, `company_number`, `parent_external_id`, `is_validated`, `status`, `number_of_reviews`, `average_rating`, `is_address_modified`, `googleplus_url`, `facebook_url`, `foursquare_url`, `twitter_url`, `registration_no`, `updated_crm`, `date_mod_crm`, `created_by`, `score`, `country_id`, `date_last_modified_by`, `last_modified_by`, `referer`, `old_slug`, `cover_image_id`, `created_at`, `updated_at`, `slug`, `last_click`, `facebook_id`) SELECT c.* FROM company c INNER JOIN city ci ON ci.id = c.city_id;
UPDATE company c INNER JOIN company_location cl ON cl.company_id = c.id SET c.location_id = cl.id WHERE c.location_id IS NULL;
INSERT INTO getlokal_new.company_location SELECT NULL, `company_id`, `accuracy`, `is_active`, `user_id`, `location_type`, `street_type_id`, `street_number`, `street`, `neighbourhood`, `building_no`, `entrance`, `floor`, `appartment`, `postcode`, `zoom`, `latitude`, `longitude`, `created_at`, `updated_at`, `full_address`, `full_address_en`, `address_info`, `address_info_en`, `sublocation`  FROM `company_location` WHERE 1

1 => 'Blvd', 2 => 'Qtr', 3 => 'N\'hood', 4 => 'Area', 5 => 'Sq.', 6 => 'Str.', 7 => 'PO Box', 8 => 'Zone', 10 => 'Cal', 11 => 'Prel', 14 => 'Drum', 15 => 'Int', 16 => 'Fdt', 17 => 'Şos', 18 => 'Al' 

SELECT
  CONCAT(
  IF(cl.street_type_id = 6, 'Strada ', 
  IF(cl.street_type_id = 10,'Calea ', 
  IF(cl.street_type_id = 5, 'Piata ', 
  IF(cl.street_type_id = 14,'Drumul ',
  IF(cl.street_type_id = 15,'Intrarea ',
  IF(cl.street_type_id = 18,'Aleea ',
  IF(cl.street_type_id = 1, 'Bulevardul ',
  IF(cl.street_type_id = 17,'Soseaua ', 'Strada ')))))))), cl.street, IF(cl.street_number != '', CONCAT(' nr. ', cl.street_number), ''),
  ', ', ci. name, ', ', co.name, ', ', cn.name) as addr1,
  ste.title as category1_en,
  st.title as category1, c.id, c.title as  name, co.name as province, ci.name as city, cl.latitude, cl.longitude, CONCAT('http://www.getlokal.ro/ro/', ci.slug, '/', c.slug) as link, 
  CONCAT('+4',c.phone) as  main_phone
FROM  `company` c
INNER JOIN company_location cl ON cl.id = c.location_id
INNER JOIN city ci ON ci.id = c.city_id
INNER JOIN county co ON co.id = ci.county_id
INNER JOIN country cn ON cn.id = co.country_id
INNER JOIN sector_translation st ON st.id = c.sector_id AND st.lang = 'ro'
INNER JOIN sector_translation ste ON ste.id = c.sector_id AND ste.lang = 'en'
WHERE c.country_id =2
AND c.status =0
AND c.phone IS NOT NULL AND char_length(phone) = 10 AND cl.street != '' AND cl.street IS NOT NULL;

UPDATE `company` SET phone = '' WHERE country_id = 2 AND CHAR_LENGTH(phone) < 10 