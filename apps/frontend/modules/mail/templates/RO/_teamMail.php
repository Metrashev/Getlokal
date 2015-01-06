<p>Name: <?php echo htmlspecialchars($user_data['name']) ?></p>
<p>Email: <?php echo $user_data['email']?></p>
<?php if ($user_data['phone']): ?>
    <p>Phone number: <?php echo $user_data['phone']; ?></p>
<?php endif; ?>
<p>Message:</p>
<p>
    "<?php echo strip_tags(nl2br($user_data['message']), '<br>'); ?>"
</p>
