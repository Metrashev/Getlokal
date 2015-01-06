<?php if (isset($eventsList) && count($eventsList)) : ?>
    <ul>
        <?php foreach ($eventsList as $event) : ?>
            <li><a class="events" href="javascript:;" id="eventId_<?php echo $event->getId() ?>" title="<?php echo $event->getTitle(); ?>"><?php echo $event->getTitle(); ?></a></li>
        <?php endforeach; ?>
    </ul>

    <script type="text/javascript">
        $(function() {
            $('.autocompleteEventsList a.events').click('live', function(){
                $('input[name="eventId"]').val($(this).attr('id'));
                $('input[name="eventsAutocomplete"]').val('');
                $('.autocompleteEventsResult').html('<p>' + $(this).html() + '</p>');
                $('.autocompleteEventsList').html('');
                $('.status_event_scroll').hide();
            });
        });
    </script>
<?php else : ?>
    <?php echo __('No events were found!', null, 'status') ?>
<?php endif; ?>

