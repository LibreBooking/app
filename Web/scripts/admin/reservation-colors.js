function ReservationColorManagement(opts) {
    var elements = {
        deleteRuleId: $('#deleteRuleId'),
        attributeOption: $('#attributeOption'),

        colorDialog: $('#colorDialog'),
        colorValue: $('#reservationColor'),
        colorForm: $('#colorForm'),

        addDialog: $('#add-rule-dialog'),
        addForm: $('#addForm'),
        deleteDialog: $('#deleteDialog'),
        deleteForm: $('#deleteForm')
    };

    ReservationColorManagement.prototype.init = function () {
        $(".cancel").click(function () {
            $(this).closest('.modal').modal("close");
        });

        $(".delete").click(function () {
            elements.deleteRuleId.val($(this).attr('ruleId'));
            elements.deleteDialog.modal('open');
        });

        elements.attributeOption.on('change', function(){
            var attrId = '#attribute' + elements.attributeOption.val();
            $('.attribute-option').addClass('no-show');
            $(attrId).find('input').val('');
            $(attrId).find('select').val('');
            $(attrId).removeClass('no-show');
            $('select').formSelect();
        });

        $('#add-rule-prompt-btn').click(function() {
            elements.attributeOption.trigger('change');
            elements.addDialog.modal('open');
        });

        ConfigureAsyncForm(elements.addForm);
        ConfigureAsyncForm(elements.deleteForm);
    };
}