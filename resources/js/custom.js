$(document).ready(function() {
    $('#alertsDropdown').on('shown.bs.dropdown', function () {
        $.post('/notifications/mark-as-read', {
            _token: $('meta[name="csrf-token"]').attr('content')
        }).done(function() {
            $('.indicator').fadeOut();
        });
    });
}); 