jQuery(document).ready(function ($) {

    // Load input fields for remote connection credentials via AJAX
    $('#local, #remote').on('click', function (e) {
        var val = e.target;

            $.ajax({
                url: riff_vars_26.ajaxurl,
                type: 'POST',
                datatype: 'json',
                data: {
                    action: 'riffchart_remote_credentials',
                    connection: val.value
                },
                success: function (ret) {
                    $('#remote_data').html('');
                    $('#remote_data').append(ret);
                }
            });
    });
});

