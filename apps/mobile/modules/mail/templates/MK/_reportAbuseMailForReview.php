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
                <td align="right">Испраќач: </td>
                <td><?php echo($name); ?></td>
            </tr>
            <tr>
                <td align="right">Е-меил на испраќач:</td>
                <td><?php echo($email); ?></td>
            </tr>
            <tr>
                <td align="right">Име на компанија</td>
                <td><?php echo $company->getTitle(); ?></td>
            </tr>
            <tr>
                <td align="right">Име на компанија (EN)</td>
                <td><?php echo $company->getCompanyTitleByCulture('en') ; ?></td>
            </tr>
            
			<!-- VIj kak e napraven linka v _result_item_detail.php в Search
			
			<tr>
                <td align="right">Линк към мненията:</td>
                <td><?php echo(link_to("See all posts about company", $sReviewUrl)); ?></td>
            </tr> -->
            <tr>
                <td align="right">ID на мислење:</td>
                <td><?php echo($recordID); ?></td>
            </tr>
            <tr>
                <td align="right">Вид на злоупотреба:</td>
                <td><?php echo($abuseTypeIDReference); ?></td>
            </tr>
            <tr>
                <td align="right">Порака од испраќач: </td>
                <td><?php echo($message); ?></td>
            </tr>
            <tr>
                <td align="right">Информација за мислење:</td>
                <td style="padding: 0px; margin: 0px;">
                    <table>
                        <tr>
                            <td align="right">Тип:</td>
                            <td><?php echo($sReviewType); ?></td>
                        </tr>
                        
                        <tr>
                            <td align="right">Текст:</td>
                            <td><?php echo($review->getText()); ?></td>
                        </tr>
                        <tr>
                            <td align="right">Автор: </td>
                            <td><?php echo($sAutorName); ?> </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>