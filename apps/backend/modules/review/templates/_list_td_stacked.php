<td colspan="3">
    <?php echo __('<div style="float: left; margin-right: 10px;">%%thumb%%</div> %%approve%% id: %%id%%<br /> <strong>%%user_profile%%</strong>: %%text%% - (<strong>rating: %%rating%%</strong>)<br />  %%recomended%%<small>for %%company%% - created on %%created_at%%</small>',

            array(
                '%%id%%' => $review->getId(),
                '%%thumb%%' => get_partial('review/thumb', array('type' => 'list', 'review' => $review)),
                '%%user_profile%%' => get_partial('review/user', array('type' => 'list', 'review' => $review)),
                '%%text%%' => $review->getText(),
                '%%rating%%' => $review->getRating(),
                '%%recomended%%' => $recomended = get_partial('review/recomended', array('type' => 'list', 'review' => $review)),
                '%%approve%%' => get_partial('review/list_field_boolean', array('value' => $review->getIsPublished())),
                '%%company%%' => get_partial('review/company', array('type' => 'list', 'review' => $review)),
                '%%created_at%%' => false !== strtotime($review->getCreatedAt()) ? format_date($review->getCreatedAt(), "f") : '&nbsp;'
            ), 'messages'
        )
    ?>
</td>
