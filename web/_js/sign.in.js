$(document).ready(function() {
    $('#openModal').addClass('shown');
    window.location.href= '#openModal'
    $('#openModal .close').click(function(){
        setTimeout(function(){$('#openModal').removeClass('shown');}, 1000);
    });
});