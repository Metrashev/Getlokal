// used on the sfWidgetFormSelectAcMany
jQuery(function ($) {
  $('[data-ac-for]').each(function (i, elem) {
    var $elem = $(elem),
        data = $elem.data(),
        $list = $('#' + data.acFor),
        $remove = $elem.siblings('.ac-remove');

    $elem.parents('form').submit(function (e) {
      $list.find('option').attr('selected', 'selected');
    });

    $elem.autocomplete({
      source: function (request, response) {
        var exclude = [];
        $list.find('option').each(function (i, elem) {
          exclude.push($(elem).val());
        });
        request.exclude = exclude;

        $.getJSON(data.url, request, function (data) {
          response(data);
        });
      },
      select: function (e, ui) {
        e.preventDefault();
        $elem.val('');

        $list.append($('<option>').val(ui.item.id).html(ui.item.label));
      }
    });

    $remove.click(function (e) {
      e.preventDefault();
      var $selected = $list.find(':selected');
      if ($selected.length > 0) {
        if (confirm('Are you sure you want to remove ' + $selected.length + ' selected items?')) {
          $selected.remove();
        }
      }
    });
  });
});
