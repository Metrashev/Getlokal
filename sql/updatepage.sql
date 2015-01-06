INSERT INTO `page`(`id`, `is_public`, `url_alias`, `foreign_id`, `country_id`, `type`, `created_at`, `updated_at`) 
SELECT NULL,1, username, user_profile.id, country_id, 1, now(), now() 
FROM user_profile
inner join sf_guard_user on sf_guard_user.id = user_profile.id
where user_profile.id not in (SELECT foreign_id from page where type=1);


Update `activity` inner join review on
review.id= activity.action_id and activity.type= 1
inner join page on
review.company_id = page.foreign_id  and page.type=2
set activity.page_id = page.id;



Update `activity` inner join image on
image.id= activity.action_id and activity.type= 2 and image.type='company'
inner join company_image on company_image.image_id =image.id
inner join page on
company_image.company_id = page.foreign_id  and page.type=2
set activity.page_id = page.id;


Update `activity` inner join image on
image.id= activity.action_id and activity.type= 2 and image.type='video'
inner join company_image on company_image.image_id =image.id
inner join page on
company_image.company_id = page.foreign_id  and page.type=2
set activity.page_id = page.id;


Update `activity` inner join image on
image.id= activity.action_id and activity.type= 2 and image.type='user'
inner join page on
image.user_id = page.foreign_id  and page.type=1
set activity.page_id = page.id;


Update `activity` inner join follow_page on
follow_page.id= activity.action_id and activity.type= 6
set activity.page_id = follow_page.page_id;
