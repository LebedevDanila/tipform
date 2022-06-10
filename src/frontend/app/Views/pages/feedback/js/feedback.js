$(function () {
	$('.js__feedbackSubmit').click(function () {
		const $this = $(this);
		const data  = {
			'name'    : $('.js__feedbackName').val(),
			'email'   : $('.js__feedbackEmail').val(),
			'message' : $('.js__feedbackMessage').val(),
		};

		$.ajax({
	        type     : 'POST',
	        url      : '/ajax/contacts/feedback',
	        dataType : 'json',
	        data     : {'data': $.b64.encode(JSON.stringify(data))},
	        success  : function (response) {
	            if (response.error)
	            {
	                alert(response.error.error_msg);
	                return window.location.href = '/feedback';
	            }

	            alert('Ваша заявка успешно принята');

				$this.addClass('_disabled');
	        },
	    });
	});
});
