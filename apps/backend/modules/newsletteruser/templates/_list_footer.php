<script type="text/javascript" >
  function export_csv(){    var csv_field = document.getElementById('csv').value = true;
    document.forms[0].submit();
  }
</script>
<input type="button" value="Export to CSV" onclick="export_csv()" />
<input type="button" value="Export all to .TXT (tab delimited file)" onclick="javascript: document.location.href='<?php echo public_path('backend_dev.php/newsletteruser/exportToTxt') ?>'" style="" />