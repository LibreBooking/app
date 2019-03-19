function Registration() {
    var elements = {
        form: $('#form-register')
    };

    Registration.prototype.init = function (messages) {

        wireUpValidation(messages);

        elements.form.bind('onValidationFailed', onValidationFailed);

        var opts = {
            onBeforeSubmit: onBeforeSubmit,
            validationSummary: $('#validationErrors')
        };

        ConfigureAsyncForm(elements.form,
            defaultSubmitCallback,
            successHandler,
            null,
            opts);
    };

    var defaultSubmitCallback = function (form) {
        return form.attr('action') + "?action=" + form.attr('ajaxAction');
    };

    function onValidationFailed(event, data) {
        elements.form.find('button').removeAttr('disabled');
        refreshCaptcha();
        hideModal();
    }

    function successHandler(response) {
        if (response && response.url) {
            window.location = response.url;
        } else {
            onValidationFailed();
            $('#registrationError').removeClass('hidden');
        }
    }

    function onBeforeSubmit(formData, jqForm, opts) {
        if (!elements.form.valid()){
            return false;
        }

        $('#profileUpdatedMessage').hide();

        $.blockUI({message: $('#modalDiv')});

        return true;
    }

    function hideModal() {
        $.unblockUI();

        var top = $("#registration-box").scrollTop();
        $('html, body').animate({scrollTop: top}, 'slow');
    }

    function refreshCaptcha() {
        var captchaImg = $('#captchaImg');
        if (captchaImg.length > 0) {
            var src = captchaImg.attr('src') + '?' + Math.random();
            captchaImg.attr('src', src);
            $('#captchaValue').val('');
        } else if (window.grecaptcha) {
            grecaptcha.reset();
        }
    }

    function wireUpValidation(messages) {
        elements.form.validate({
            messages: messages,
            errorElement : 'div',
            errorPlacement: function(error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error)
                } else {
                    error.insertAfter(element);
                }
            }
        });
    }
}