$(document).on('input change', '.form-transferencia', function() {
    $(this).parent().find('.val-form-transferencia').html($(this).val());
});