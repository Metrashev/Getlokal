<script>
    $(document).ready(function () {
        setInterval(function () {
            $.getJSON('<?php echo url_for('keepalive'); ?>');
        }, 300000); // every 5 minutes
    });
</script>