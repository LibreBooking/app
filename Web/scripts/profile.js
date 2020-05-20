function Profile() {
    var elements = {
        form: $('#form-profile')
    };

    Profile.prototype.init = function (messages) {

        wireUpValidation(messages);

        elements.form.bind('onValidationFailed', onValidationFailed);

        var opts = {
            onBeforeSubmit: onBeforeSubmit,
            validationSummary: $('#validationErrors')
        };

        ConfigureAsyncForm(elements.form, defaultSubmitCallback, successHandler, null, opts);
    };

    var defaultSubmitCallback = function (form) {
        return form.attr('action') + "?action=" + form.attr('ajaxAction');
    };

    function onValidationFailed(event, data) {
        elements.form.find('button').removeAttr('disabled');
        hideModal();
        $('#validationErrors').removeClass('hidden');
    }

    function successHandler(response) {
        hideModal();
        $('#profileUpdatedMessage').removeClass('hidden');
    }

    function onBeforeSubmit(formData, jqForm, opts) {
        if (!elements.form.valid()) {
            return false;
        }

        $('#profileUpdatedMessage').addClass('hidden');

        $.blockUI({message: $('#wait-box')});

        return true;
    }

    function hideModal() {
        $.unblockUI();

        var top = $("#profile-box").scrollTop();
        $('html, body').animate({scrollTop: top}, 'slow');
    }

    function wireUpValidation(messages) {
        elements.form.validate({
            messages: messages,
            errorElement: 'div',
            errorPlacement: function (error, element) {
                var placement = $(element).data('error');
                if (placement) {
                    $(placement).append(error);
                } else {
                    error.insertAfter(element);
                }
            }
        });
    }
}