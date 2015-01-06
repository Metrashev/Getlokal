CREATE TABLE pilot_video (id BIGINT AUTO_INCREMENT, name VARCHAR(255), youtube_key VARCHAR(255), image_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX image_id_idx (image_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE pilot_vote (id BIGINT AUTO_INCREMENT, user_id BIGINT, video_id BIGINT, created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, INDEX user_id_idx (user_id), INDEX video_id_idx (video_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE city_translation (id BIGINT, name VARCHAR(255) NOT NULL, lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE company_translation (id BIGINT, title VARCHAR(255) NOT NULL, description TEXT, content TEXT, lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE county_translation (id BIGINT, name VARCHAR(255) NOT NULL, lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE county (id BIGINT AUTO_INCREMENT, municipality VARCHAR(60), region VARCHAR(60), country_id BIGINT NOT NULL, slug VARCHAR(255) NOT NULL, INDEX country_id_idx (country_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE sector_translation (id BIGINT, rank INT, title VARCHAR(255) NOT NULL, slug VARCHAR(255), description LONGTEXT, page_title VARCHAR(255), meta_description LONGTEXT, lang CHAR(2), PRIMARY KEY(id, lang)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;
CREATE TABLE sector (id BIGINT AUTO_INCREMENT, is_active TINYINT(1) DEFAULT '1', created_at DATETIME NOT NULL, updated_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = INNODB;

ALTER TABLE pilot_video ADD CONSTRAINT pilot_video_image_id_image_id FOREIGN KEY (image_id) REFERENCES image(id) ON DELETE CASCADE;
ALTER TABLE pilot_vote ADD CONSTRAINT pilot_vote_video_id_pilot_video_id FOREIGN KEY (video_id) REFERENCES pilot_video(id) ON DELETE CASCADE;
ALTER TABLE pilot_vote ADD CONSTRAINT pilot_vote_user_id_sf_guard_user_id FOREIGN KEY (user_id) REFERENCES sf_guard_user(id) ON DELETE CASCADE;
ALTER TABLE city_translation ADD CONSTRAINT city_translation_id_city_id FOREIGN KEY (id) REFERENCES city(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE company_translation ADD CONSTRAINT company_translation_id_company_id FOREIGN KEY (id) REFERENCES company(id) ON UPDATE CASCADE ON DELETE CASCADE;
ALTER TABLE county_translation ADD CONSTRAINT county_translation_id_county_id FOREIGN KEY (id) REFERENCES county(id) ON UPDATE CASCADE ON DELETE CASCADE;

INSERT INTO `pilot_video` (`id`, `name`, `youtube_key`, `image_id`, `created_at`, `updated_at`) VALUES
(1, 'Ana', 'gMOFrVqmzHk', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),
(2, 'George', 'gMOFrVqmzHk', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00'),

(3, 'Oana', 'gMOFrVqmzHk', NULL, '0000-00-00 00:00:00', '0000-00-00 00:00:00');

UPDATE  `pilot_video` SET  `youtube_key` =  'cAixm1qMnpo' WHERE  `pilot_video`.`id` =1;
UPDATE  `pilot_video` SET  `youtube_key` =  'rXF_UdTbhWs' WHERE  `pilot_video`.`id` =2;
UPDATE  `pilot_video` SET  `youtube_key` =  'YvICg9hwd1g' WHERE  `pilot_video`.`id` =3;


ALTER TABLE `company_location`
ADD COLUMN `processed` TINYINT(1) NULL AFTER `geocode`;


ALTER TABLE `article_image` ADD INDEX(`code`);

ALTER TABLE  `article` ADD  `publish_on` DATETIME NULL AFTER  `status` ,
ADD INDEX (  `publish_on` ) ;


-- HU translations
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (1, 'Rendezvények & Kultúra', 'rendezveny-kultura', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (2, 'Mûvészet és oktatás',  'muveszet-oktatas', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (3, 'Családi', 'csaladi', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (4, 'Divat', 'divat', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (5,  'Zene', 'zene', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (6, 'Városom', 'varosom', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (7, 'Helyszínek', 'helyszinek', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (8, 'Utazás', 'utazas', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (9, 'Sport', 'sport', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (10, 'Szolgáltatások', 'szolgáltatasok', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (11, 'Helyi hírek', 'helyi hirek', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (12, 'Tech', 'tech', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (13, 'Könyv értékelés', 'konyv-ertekeles', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (14, 'Vicces', 'vicces', 'hu', 1);
INSERT INTO `category_article_translation` (`id`, `title`, `slug`, `lang`, `is_active`) VALUES (16 ,'Film', 'film', 'hu', 1);

INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(1, 'Szolgáltatás', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(2, 'Gyermekbarát', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(3, 'Helyszín', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(5, 'termékek', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(9, 'Hangulat', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(10, 'Jó érték', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(13, 'felszerelés', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(15, 'étel', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(16, 'Ital', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(17, 'különleges alkalmakra', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(19, 'Választás', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(20, 'Változatosság ', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(21, 'Romantikus', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(22, 'Üzleti', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(34, 'lehetõségek', 1, 'hu');
INSERT INTO `feature_translation` (`id`, `name`, `is_active`, `lang`) VALUES(41, 'minõség', 1, 'hu');
 
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (1, 'Ingyenes parkoló', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (2, 'Fizetõs / utcai parkolá', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (3, 'Hitelkártyák ', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (4, 'Privát események', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (5, 'Esküvõ', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (6, 'önkiszolgáló', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (7, 'szabadtéri helyek', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (8, 'beltéri helyek', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (9, 'WiFi ', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (10, 'Szállítás', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (11, 'Akadálymentesített', 1, 'hu');
INSERT INTO `feature_company_translation` (`id`, `name`, `is_active`, `lang`) VALUES (12, 'Gyermekbarát', 1, 'hu');


INSERT INTO `category_translation` (`id`, `title`, `slug`, `is_active`, `lang`) VALUES (1, 'Koncert & Zene', 'koncert-zene', 1, 'hu');
INSERT INTO `category_translation` (`id`, `title`, `slug`, `is_active`, `lang`) VALUES (2, 'Mûvészet', 'muveszet', 1, 'hu');
INSERT INTO `category_translation` (`id`, `title`, `slug`, `is_active`, `lang`) VALUES (3, 'Mozi és színház', 'mozi-es-szinhaz', 1, 'hu');
INSERT INTO `category_translation` (`id`, `title`, `slug`, `is_active`, `lang`) VALUES (4, 'Étel', 'etel', 1, 'hu');
INSERT INTO `category_translation` (`id`, `title`, `slug`, `is_active`, `lang`) VALUES (5, 'Divat', 'divat', 1, 'hu');
INSERT INTO `category_translation` (`id`, `title`, `slug`, `is_active`, `lang`) VALUES (6, 'Fesztiválok és vásárok', 'fesztivalok-es-vasarok', 1, 'hu');
INSERT INTO `category_translation` (`id`, `title`, `slug`, `is_active`, `lang`) VALUES (7, 'Sport', 'sport', 1, 'hu');
INSERT INTO `category_translation` (`id`, `title`, `slug`, `is_active`, `lang`) VALUES (8, 'Éjszakai élet', 'ejszakai-elet', 1, 'hu');
INSERT INTO `category_translation` (`id`, `title`, `slug`, `is_active`, `lang`) VALUES (9, 'Család, gyerek', 'csalad-gyerek', 1, 'hu');
INSERT INTO `category_translation` (`id`, `title`, `slug`, `is_active`, `lang`) VALUES (10, 'Helyi események', 'helyi-esemenyek', 1, 'hu');
