<script type="text/javascript" >
  function export_csv(){    var csv_field = document.getElementById('csv').value = true;
    document.forms[0].submit();
    document.getElementById('csv').value = false;
  }
</script>
<input type="button" value="Export to CSV" onclick="export_csv()" />