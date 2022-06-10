$(function () {

    if ($('.adminAccounts').length == 0) {
        return false;
    }

    /**
     * Add
     */
    (function () {

        const $popup = $('.js__adminAccountsPopupAdd');

        $('.js__adminAccountsAdd').click(function () {
            $popup.fadeIn();
        });

        $('.js__adminAccountsPopupAddClose').click(function () {
            $popup.fadeOut();
        });

        $('.js__adminAccountsSubmit').click(function () {
            const data = {
                login         : $('.js__adminAccountsLogin').val(),
                password      : $('.js__adminAccountsPassword').val(),
                proxy_ip      : $('.js__adminAccountsProxyIp').val(),
                proxy_login   : $('.js__adminAccountsProxyLogin').val(),
                proxy_password: $('.js__adminAccountsProxyPassword').val(),
            };

            $.ajax({
                type     : 'POST',
                url      : '/ajax/account/add',
                dataType : 'json',
                data     : {'data': $.b64.encode(JSON.stringify(data))},
                success  : function (response) {
                    if (response.error) {
                        alert(response.error.message);
                        return false;
                    }

                    location.reload();
                },
            });
        });

    })();

    /**
     * Delete
     */
    (function () {

        const $popup = $('.js__adminAccountsPopupDelete');

        $('.js__adminAccountsDelete').click(function () {
            $('.js__adminAccountsDeleteAccept').data('id', $(this).data('id'));
            $popup.fadeIn();
        });

        $('.js__adminAccountsDeleteDecline').click(function () {
            $popup.fadeOut();
        });

        $('.js__adminAccountsPopupDeleteClose').click(function () {
            $popup.fadeOut();
        });

        $('.js__adminAccountsDeleteAccept').click(function () {
            const data = {
                'id': $(this).data('id'),
            };

            $.ajax({
                type     : 'POST',
                url      : '/ajax/account/delete',
                dataType : 'json',
                data     : {'data': $.b64.encode(JSON.stringify(data))},
                success  : function (response) {
                    if (response.error) {
                        return alert(response.error.message);
                    }

                    location.reload();
                },
            });
        });

    })();


    /**
     * Disable
     */
    $('.js__adminAccountsSwitchStatus').click(function () {
       const data = {
           'id' : $(this).data('id'),
       };
       const action = $(this).data('action');

       if(action === 'enable') {
           $.ajax({
               type     : 'POST',
               url      : '/ajax/account/enable',
               dataType : 'json',
               data     : {'data': $.b64.encode(JSON.stringify(data))},
               success  : function (response) {
                   if (response.error) {
                       return alert(response.error.message);
                   }

                   location.reload();
               },
           });
       } else {
           $.ajax({
               type     : 'POST',
               url      : '/ajax/account/disable',
               dataType : 'json',
               data     : {'data': $.b64.encode(JSON.stringify(data))},
               success  : function (response) {
                   if (response.error) {
                       return alert(response.error.message);
                   }

                   location.reload();
               },
           });
       }
    });
});
