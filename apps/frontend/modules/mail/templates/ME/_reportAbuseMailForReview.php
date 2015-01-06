<?php

$sReviewUrl = $company->getUri(ESC_RAW);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
    <head>
        <title></title>
        <style type="text/css">
            body{
                margin: 0px;
                padding: 0px;
                font-family: Arial, Helvetica, sans-serif;
            }
            h1 {
                font-size: 23px;
                text-align: center;
            }
            table{
                border: #999999 solid 1px;
                
            }
            td{
                margin: 0px;
                padding: 4px;
                border-bottom: #999999 solid 1px;
                border-right: #999999 solid 1px;
            }
            
        </style>
    </head>
    
    <body>
        <h1><?php echo($subTitle); ?></h1>
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td align="right">Korisnik: </td>
                <td><?php echo($name); ?></td>
            </tr>
            <tr>
                <td align="right">E-mail korisnika:</td>
                <td><?php echo($email); ?></td>
            </tr>
            <tr>
                <td align="right">Company Name</td>
                <td><?php echo $company->getCompanyTitle('me'); ?></td>
            </tr>
            <tr>
                <td align="right">Naziv firme (EN)</td>
                <td><?php echo $company->getCompanyTitleByCulture('en') ; ?></td>
            </tr>
            
			<!-- VIj kak e napraven linka v _result_item_detail.php в Search
			
			<tr>
                <td align="right">Линк към мненията:</td>
                <td><?php echo(link_to("See all posts about company", $sReviewUrl)); ?></td>
            </tr> -->
            <tr>
                <td align="right">Review ID:</td>
                <td><?php echo($recordID); ?></td>
            </tr>
            <tr>
                <td align="right">Vrsta zloupotrebe:</td>
                <td><?php echo($abuseTypeIDReference); ?></td>
            </tr>
            <tr>
                <td align="right">Poruka od korisnika: </td>
                <td><?php echo($message); ?></td>
            </tr>
            <tr>
                <td align="right">Pregled informacija:</td>
                <td style="padding: 0px; margin: 0px;">
                    <table>
                        <tr>
                            <td align="right">Review Type:</td>
                            <td><?php echo($sReviewType); ?></td>
                        </tr>
                        
                        <tr>
                            <td align="right">Pregled teksta:</td>
                            <td><?php echo($review->getText()); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Pregled autora: </td>
                            <td><?php echo($sAutorName); ?> </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>