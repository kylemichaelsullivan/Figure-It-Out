////////////////////////////////// YOUR CUSTOM JS HERE //////////////////////////////////

jQuery(document).ready(($) => {
	// set selector variables
	const container = '#main-content';
	const toggle = '#ncc-more-info';
	const loading = '#loading';
	const message = '#fio-message';
	const form = '#figure-it-out';
	const inputs = ['first_name', 'last_name', 'email_address'];

	// move FIO form to bottom of container
	const $form = $(form);
	$form.remove();
	$(container).append($form);

	// add code to show form (and obscure background)
	const showForm = () => {
		$(container).addClass('fio-open');
		$(form).fadeIn();
		$('#first_name').focus();
	};

	// add code to hide form (and restore background)
	const hideForm = () => {
		$(container).removeClass('fio-open');
		$(form).fadeOut();
		$(loading).fadeOut();
		$(message).fadeOut();
	};

	// hide form when clicking anything not the form
	$('html').on('click', (e) => {
		if (!$(form).is(e.target) && $(form).has(e.target).length === 0) {
			hideForm();
		}
	});

	// reset form (after submission)
	const resetForm = () => {
		inputs.forEach((input) => $(`#${input}`).val(''));
		$('#gdpr_consent').prop('checked', false);
	};

	$(toggle).on('click', (e) => {
		e.preventDefault();
		e.stopPropagation();
		showForm();
	});

	// hide form when Escape key is pressed
	$(document).on('keydown', (e) => {
		if (e.key === 'Escape') hideForm();
	});

	// form submission
	$('#fio-form').on('submit', function (e) {
		e.preventDefault();
		const first_name = $('#first_name').val();
		const last_name = $('#last_name').val();
		const email_address = $('#email_address').val();
		$(loading).show();

		$.ajax({
			type: 'POST',
			url: fio.ajaxurl,
			data: {
				action: 'submit_fio_form',
				first_name: first_name,
				last_name: last_name,
				email_address: email_address,
			},
			success: function (response) {
				if (response === 'success') {
					$(message).text('Your information has been submitted successfully.');
					setTimeout(resetForm, 3500);
				} else {
					$(message).text(
						'There was a problem submitting your information. Please try again.'
					);
				}

				setTimeout(() => $(loading).fadeOut(), 500);
				setTimeout(() => $(message).fadeIn(), 750);
				setTimeout(hideForm, 3000);
			},
			error: function (response) {
				alert(
					'There was a problem submitting your information. Please try again.'
				);
				console.error(response);
			},
		});
	});
});
