$(function() {

    if ($('.adminAuth').length == 0) {
        return false;
    }

    $('.js__adminAuthSubmit').click(function () {
        const data = {
            login   : $('.js__adminAuthLogin').val(),
            password: $('.js__adminAuthPassword').val(),
        };

        $.ajax({
            type: 'POST',
            url: '/ajax/admin/auth',
            dataType: 'json',
            data: {'data': $.b64.encode(JSON.stringify(data))},
            success: function(response) {
                if (response.error) {
                    alert(response.error.message);
                    return false;
                }

                if(response.response === false) {
                    alert('Вы ввели не верные данные для входа');
                    return false;
                }

                window.location.href = '/admin';
            },
        });
    });

});
