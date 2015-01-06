/* Bulgarian initialisation for the jQuery UI date picker plugin. */
/* Written by Petar Todorov. */
jQuery(function($){
    $.datepicker.regional['bg'] = {
        closeText: 'затвори',
        prevText: '&#x3c;назад',
        nextText: 'напред&#x3e;',
        nextBigText: '&#x3e;&#x3e;',
        currentText: 'днес',
        monthNames: ['Януари','Февруари','Март','Април','Май','Юни',
            'Юли','Август','Септември','Октомври','Ноември','Декември'],
        monthNamesShort: ['Яну','Фев','Мар','Апр','Май','Юни',
            'Юли','Авг','Сеп','Окт','Нов','Дек'],
        dayNames: ['Неделя','Понеделник','Вторник','Сряда','Четвъртък','Петък','Събота'],
        dayNamesShort: ['Нед','Пон','Вто','Сря','Чет','Пет','Съб'],
        dayNamesMin: ['Нд','Пн','Вт','Ср','Чт','Пт','Сб'],
        weekHeader: 'Wk',
        dateFormat: 'mm/dd/yy',
        firstDay: 1,
        isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
    $.datepicker.setDefaults($.datepicker.regional['bg']);
});
