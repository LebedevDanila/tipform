$(function() {

    if ($('.favorites').length == 0) {
        return false;
    }
    
    // удаление новости
    $('.js__favoritesItemDelete').click(function(event) {
        event.preventDefault();
    
        const $this = $(this);
        const data  = {
            'username' : $this.data('username'),
        };
    
        $.ajax({
            type: 'POST',
            url: '/ajax/favorites/delete',
            dataType: 'json',
            data: {'data': $.b64.encode(JSON.stringify(data))},
            success: function(response) {
                if (response.error) {
                    return alert(response.error.error_text);
                }
    
                if ($('.account').length > 1) {
                    $this.parent().remove();
                } else {
                    location.reload();
                }
            },
        });
    });
    
});
    