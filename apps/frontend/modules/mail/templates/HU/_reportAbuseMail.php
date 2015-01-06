
<?php // $sReviewUrl = $companyInfo->getUri(ESC_RAW); ?>
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
        <table cellpadding="0" cellspacing="0">
            <tr>
                <td align="right">Content type:</td>
                <td><?php echo($reportAbuse->getType()); ?></td>
            </tr>
            <tr>
                <td align="right">Sender: </td>
                <td><?php echo($reportAbuse->getName()); ?></td>
            </tr>
            <tr>
                <td align="right">Sender's e-mail:</td>
                <td><?php echo($reportAbuse->getEmail()); ?></td>
            </tr>

        <?php if($reportAbuse->getType() == 'review' || $reportAbuse->getType() == 'image'): ?>
            <tr>
                <td align="right">Company Name</td>
                <td><?php echo($companyInfo->getCompanyTitle('hu')); ?></td>
            </tr>
            <tr>
                <td align="right">Company Name (EN)</td>
                <td><?php echo($companyInfo->getCompanyTitleByCulture('en')); ?></td>
            </tr>
			<tr>
                <td align="right">Link to company:</td>
                <td><?php echo(link_to_company($companyInfo, array('absolute' => true))); ?></td>
            </tr>

        <?php elseif ($reportAbuse->getType() == 'comment'): ?>
            <tr>
                <td align="right">Object Type:</td>
                <td>
                <?php switch ($activityInfo->getType()) {
                    case 3:
                        echo('Event');
                        $object = 'Event';

                        break;
                    case 4:
                        echo('List');
                        $object = 'List';
                        break;
                    default:
                        echo('Other');
                        $object = 'Other';
                        break;
                }?>
                </td>
            </tr>
            <tr>
                <td align="right"><?php echo($object.' '.'ID')?></td>
                <td><?php echo($activityInfo->getActionId()); ?></td>
            </tr>
            <tr>
                <td align="right"><?php echo($object.' '.'Name:')?></td>
                <td><?php echo($activityInfo->getCaption()); ?></td>
            </tr>
        <?php endif; ?>
            <tr>
                <td align="right"><?php echo(ucfirst($reportAbuse->getType()).' '.'ID:')?></td>
                <td><?php echo($reportAbuse->getObjectId()); ?></td>
            </tr>
            <tr>
                <td align="right">Abuse Type:</td>
                <td>
                <?php switch ($reportAbuse->getOffence()) {
                    case 1:
                        echo('Illegal');
                        break;
                    case 2:
                        echo('Offensive');
                        break;
                    case 3:
                        echo('Copyright');
                        break;
                    case 4:
                        echo('Incorrect');
                        break;
                    case 5:
                        echo('Other');
                        break;

                }?>
                <?php // echo($reportAbuse->getOffence()); ?></td>
            </tr>
            <tr>
                <td align="right">Message from Sender: </td>
                <td><?php echo($reportAbuse->getBody()); ?></td>
            </tr>
            <tr>
                <td align="right"><?php echo(ucfirst($reportAbuse->getType()).' '.'Information:')?></td>
                <td style="padding: 0px; margin: 0px;">
                    <table>
                        <tr>
                            <td align="right"><?php echo(ucfirst($reportAbuse->getType()).' '.'Text:')?></td>
                            <td><?php echo($reportObject); ?></td>
                        </tr>
                        <tr>
                            <td align="right"><?php echo(ucfirst($reportAbuse->getType()).' '.'Author:')?></td>
                            <td><?php echo($author->getFirstName().' '.$author->getLastName()); ?> </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </body>
</html>