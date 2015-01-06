#!/usr/bin/php
<?php

$_d = mysql_connect('odin.ned.bg', 'getlokal', 'gvocal') or die("Can't connect to DB");
mysql_select_db('getlokal_new', $_d);

$res = mysql_query('SELECT c.id,c.phone,c.phone1,c.phone2,c.facebook_url,c.twitter_url,c.website_url,c.email,c.description,c.number_of_reviews,c.average_rating, cl.street_number, cl.street, cl.neighbourhood, cl.building_no FROM company AS c LEFT JOIN company_location as cl ON (cl.company_id = c.id) WHERE c.status = 0');

$count = mysql_num_rows($res);
$_c = strlen($count);
$i = 1;
$updated = 0;
gc_enable();
while($row = mysql_fetch_object($res)){
    $score = 0;


    // Claimed
    $sql = "SELECT pa.id FROM page_admin AS pa
        INNER JOIN page AS p ON (p.id = pa.page_id)
        INNER JOIN company AS c ON (c.id = p.foreign_id)
        WHERE c.id = {$row->id} AND pa.status = 'approved'";
    if (mysql_num_rows(mysql_query($sql, $_d)) > 0) $score += 0.5;


    // Location address
    if (($row->street != null && $row->street) || ($row->neighbourhood != null && $row->neighbourhood && $row->building_no != null && $row->building_no)) $score += 0.1;


    // Phone
    if (($row->phone != null && $row->phone != '') || ($row->phone1 != null && $row->phone1 != '') || ($row->phone2 != null && $row->phone2 != '')) $score += 0.1;

    
    // Email
    if ($row->email != null && $row->email != '') $score += 0.1;

    
    // Website
    if ($row->facebook_url != null && $row->facebook_url != '') $score += 0.1;


    // Facebook
    if ($row->website_url != null && $row->website_url != '') $score += 0.1;


    // Twitter
    if ($row->twitter_url != null && $row->twitter_url != '') $score += 0.1;


    // Reviews
    if ($row->number_of_reviews > 0){
        $review_score = $row->number_of_reviews * 0.01;
        $score += ($review_score > 0.25) ? 0.25 : $review_score;
    }

    
    // Rating
    if($row->average_rating > 0) $score += $row->average_rating * 0.05;


    // Images
    $sql = 'SELECT count(i.id) FROM company_image ci, image i WHERE i.id=ci.image_id AND ci.company_id='.$row->id.' AND i.status = "approved" LIMIT 1';
    $_i = mysql_result(mysql_query($sql, $_d), 0);
    
    if ($_i > 0) {
        $score += ($_i * 0.01 > 0.1) ? 0.1 : ($_i * 0.01);
    }


    // PPP
    $sql = "SELECT id FROM ad_service_company
        WHERE ad_service_id=11 AND company_id = {$row->id}
        AND status = 'active' AND active_from <= ".ProjectConfiguration::nowAlt(1)."
        AND ((active_to is null AND crm_id is not null) OR (active_to >= ".ProjectConfiguration::nowAlt(1)." AND  crm_id is null)) LIMIT 1";
    if (mysql_num_rows(mysql_query($sql, $_d)) > 0) $score += 0.3;


    // Offers
    $sql = "SELECT c.id 
            FROM company_offer c 
            INNER JOIN company c2 ON c.company_id = c2.id 
            INNER JOIN ad_service_company a ON c2.id = a.company_id AND (a.ad_service_id = 13) 
            WHERE (c2.id = '{$row->id}' AND a.status = 'active' 
                AND a.active_from <= ".ProjectConfiguration::nowAlt(1)." 
                AND ((a.active_to is null AND a.crm_id is not null) OR (a.active_to >= ".ProjectConfiguration::nowAlt(1)." AND a.crm_id is null)) 
                AND c.is_active = '1' AND c.active_from <= ".ProjectConfiguration::nowAlt(1)." AND c.active_to >= ".ProjectConfiguration::nowAlt(1).")
                GROUP BY c.id";
    $_i = mysql_num_rows(mysql_query($sql, $_d));
    if ($_i > 0) $score += ($_i * 0.3 > 0.9) ? 0.9 : ($_i * 0.3);

    
    // Description
    //if ($row->description != null) $score += 0.1;


    $sql = 'UPDATE company SET score = '.$score.' WHERE id = '.$row->id;
    mysql_query($sql, $_d);
    $updated += mysql_affected_rows($_d);
    
    $proc = round(($i/$count)*100);
    $_td = round($proc/5);
    $_tm = 20 - $_td;
    
if(@$argv[1] >= 2) echo sprintf("%-70s\n",$sql);
if(@$argv[1] >= 1) echo sprintf("Done: %{$_c}d/%d [%'#{$_td}s%'-{$_tm}s] %3d%% U: %{$_c}d M: %7.02fMB\r", $i, $count, '', '', $proc, $updated, round(((memory_get_usage()/1024)/1024), 2));
    $i++;
    gc_collect_cycles();
    echo "\n";
}


mysql_close($_d);

?>
