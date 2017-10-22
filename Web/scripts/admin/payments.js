function Payments() {
    var elements = {
        updateCreditsForm: $('#updateCreditsForm'),
        updateGatewayForm: $('#updateGatewayForm')
    };

    Payments.prototype.init = function () {

        $(".save").click(function (e) {
            e.preventDefault();
            $(e.target).closest('form').submit();
        });

        $('.toggleDisabled').on('click', function (e) {
            var checkbox = $(e.target);
            var classToToggle = checkbox.attr('data-target');
            if (checkbox.is(':checked')) {
                $('.' + classToToggle).removeAttr('disabled');
            }
            else {
                $('.' + classToToggle).prop('disabled', 'disabled');
            }
        });

        ConfigureAsyncForm(elements.updateCreditsForm, defaultSubmitCallback, function () {
            showMessage('updatedCreditsMessage')
        }, function () {
        });
        ConfigureAsyncForm(elements.updateGatewayForm, defaultSubmitCallback, function () {
            showMessage('updatedGatewayMessage')
        }, function () {
        });
    };

    Payments.prototype.initGateways = function(paypalEnabled, stripeEnabled)
    {
        if (paypalEnabled) {
            $('#paypalEnabled').click();
        }
        if (stripeEnabled) {
            $('#stripeEnabled').click();
        }
    };

    var defaultSubmitCallback = function (form) {
        return form.attr('action') + "?action=" + form.attr('ajaxAction');
    };

    var showMessage = function (id) {
        $('#' + id).show().delay(2000).fadeOut(200);
    }
}