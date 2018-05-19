function EmailTemplateManagement(opts) {
    var options = opts;

    var elements = {
        languageOpts: $('#languageOpts'),
        templateOpts: $('#templateOpts'),
        templateContents: $('#templateContents'),
        updateEmailForm: $('#updateEmailForm'),
        reloadEmailContents: $('#reloadEmailContents'),
        templatePath: $('#templatePath'),
        updateSuccess: $('#updateSuccess'),
        updateFailed: $('#updateFailed'),


        editEmailSection: $('#editEmailSection')
    };

    EmailTemplateManagement.prototype.init = function () {

        $(".save").click(function () {
            $(this).closest('form').submit();
        });

        $(".cancel").click(function () {
            $(this).closest('.dialog').dialog("close");
        });

        elements.languageOpts.on('change', function (e) {
            document.location = options.scriptUrl + '?lang=' + elements.languageOpts.val();
        });

        elements.templateOpts.on('change', function (e) {
            var templateName = elements.templateOpts.val();
            if (templateName == '') {
                elements.editEmailSection.addClass('no-show');
            }
            else {
                elements.templatePath.val(templateName);
                ajaxGet(options.scriptUrl + '?dr=template&lang=' + elements.languageOpts.val() + '&tn=' + templateName, null, loadTemplate);
            }
        });

        elements.reloadEmailContents.on('click', function(e){
            e.preventDefault();
            var templateName = elements.templateOpts.val();
            ajaxGet(options.scriptUrl + '?dr=originalTemplate&lang=' + elements.languageOpts.val() + '&tn=' + templateName, null, loadTemplate);
        });

        ConfigureAsyncForm(elements.updateEmailForm, null, updatedEmail);

    };

    function updatedEmail(data) {
        if (data.saveResult == true)
        {
            elements.updateSuccess.show().delay(2000).fadeOut(200);
        }
        else
        {
            elements.updateFailed.show().delay(2000).fadeOut(200);
        }
    }

    function loadTemplate(data) {
        elements.templateContents.val(data);
        elements.editEmailSection.removeClass('no-show');
    }
}