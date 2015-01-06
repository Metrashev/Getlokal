SELECT
    C.id, C.title, C.title_en,
    IFNULL(C.classification_id, (SELECT id FROM classification ORDER BY RAND() LIMIT 1)),
    IFNULL(C.sector_id, (SELECT id FROM sector ORDER BY RAND() LIMIT 1)),
    C.phone, 'Helsinki', Co.name, C.email, C.website_url,
    C.foursquare_url, C.twitter_url, C.facebook_url, C.facebook_id,
    C.company_type, C.registration_no, CL.location_type,
    CL.street_type_id, CL.street_number, CL.street,
    CL.neighbourhood, CL.building_no, CL.entrance, CL.floor,
    CL.appartment, CL.postcode, CL.full_address, CL.address_info,
    CL.accuracy, CL.latitude, CL.longitude,

    -- dummy
    DATE_FORMAT(NOW(), "%Y-%m-%d"),
    DATE_FORMAT(NOW(), "%Y-%m-%d"),
    'OY',
    'Osakeyhtiö',
    '81210',
    '8444',
    '2012',
    '516918000',
    '2012'
    'Kyllä',
    'Vahvat yritykset',
    'Osoitelähde: Suomen Asiakastieto Oy, Myyntioptimi. Puh. 010 270 7000'

    INTO OUTFILE '/tmp/companies.csv'
    FIELDS TERMINATED BY ','
    ENCLOSED BY '"'
    LINES TERMINATED BY '\n'
FROM
    company C
    INNER JOIN city Ci ON (C.city_id = Ci.id)
    INNER JOIN county Co ON (Co.id = Ci.county_id)
    INNER JOIN company_location CL ON (CL.company_id = C.location_id)
limit 100000;


SELECT * from city where name = 'Bucuresti';

select distinct referer from company;