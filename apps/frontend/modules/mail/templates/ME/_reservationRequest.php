Email: <?php echo $user_data['email'] ?></br>

<?php if (isset($user_data['name']) && $user_data['name']): ?>
    Name: <?php echo $user_data['name'] ?></br>
<?php endif; ?>

Phone: <?php echo $user_data['phone'] ?></br>

Start date: <?php echo $user_data['start_date'] ?></br>

<?php if (isset($user_data['time']) && $user_data['time']): ?>
    Time: <?php echo $user_data['time'] ?></br>
<?php endif; ?>

<?php if (isset($user_data['people']) && $user_data['people']): ?>
    Number of people: <?php echo $user_data['people'] ?></br>
<?php endif; ?>

<?php if (isset($user_data['end_date']) && $user_data['end_date']): ?>
    End date: <?php echo $user_data['end_date'] ?></br>
<?php endif; ?>

<?php if (isset($user_data['nights']) && $user_data['nights']): ?>
    Number of nights: <?php echo $user_data['nights'] ?></br>
<?php endif; ?>

<?php if (isset($user_data['about']) && $user_data['about']): ?>
    Message: <?php echo $user_data['about'] ?></br>
<?php endif; ?>