<?php
    $mode = false;
    $module = $sf_request->getParameter('module');
    $action = $sf_request->getParameter('action');
    $controller = compact('module', 'action');

    $disabled = array(
        array('module' => 'user'),
        array('module' => 'companySettings'),
        array('module' => 'company', 'action' => 'show'),
        array('module' => 'company', 'action' => 'addCompany'),
        array('module' => 'getweekend'),
    );
    foreach ($disabled as $d) {
        if (count(array_intersect($d, $controller)) == count($d)) {
            $mode = true;
            break;
        }
    }
?>

<script type="text/javascript">
<!--//--><![CDATA[//><!--
var pp_gemius_identifier = 'cjWVhg7KJTRvUWJu7hwFPcUXzQAZwZtWQqVCNXX9HJ3.27';

<?php if (isset($mode) && $mode): ?>
    var pp_gemius_mode = 1;
<?php endif; ?>

// lines below shouldn't be edited
function gemius_pending(i) { window[i] = window[i] || function() {var x = window[i+'_pdata'] = window[i+'_pdata'] || []; x[x.length]=arguments;};};
gemius_pending('gemius_hit'); gemius_pending('gemius_event'); gemius_pending('pp_gemius_hit'); gemius_pending('pp_gemius_event');
(function(d,t) {try {var gt=d.createElement(t),s=d.getElementsByTagName(t)[0],l='http'+((location.protocol=='https:')?'s':''); gt.setAttribute('async','async');
gt.setAttribute('defer','defer'); gt.src=l+'://garo.hit.gemius.pl/xgemius.js'; s.parentNode.insertBefore(gt,s);} catch (e) {}})(document,'script');
//--><!]]>
</script>
