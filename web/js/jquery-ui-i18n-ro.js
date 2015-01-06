/* Romanian initialisation for the jQuery UI date picker plugin.*/
/* Written by Petar Todorov. */
jQuery(function($){
        $.datepicker.regional['ro'] = {
                closeText: 'Închide',
                prevText: '&laquo; Luna precedentă',
                nextText: 'Luna următoare &raquo;',
                currentText: 'Azi',
                monthNames: ['Ianuarie','Februarie','Martie','Aprilie','Mai','Iunie',
                'Iulie','August','Septembrie','Octombrie','Noiembrie','Decembrie'],
                monthNamesShort: ['Ian', 'Feb', 'Mar', 'Apr', 'Mai', 'Iun',
                'Iul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                dayNames: ['Duminică', 'Luni', 'Marţi', 'Miercuri', 'Joi', 'Vineri', 'Sâmbătă'],
                dayNamesShort: ['Dum', 'Lun', 'Mar', 'Mie', 'Joi', 'Vin', 'Sâm'],
                dayNamesMin: ['Du','Lu','Ma','Mi','Jo','Vi','Sâ'],
                weekHeader: 'Săpt',
                dateFormat: 'mm/dd/yy',
                firstDay: 1,
                isRTL: false,
                showMonthAfterYear: false,
                yearSuffix: ''};
        $.datepicker.setDefaults($.datepicker.regional['ro']);
});
