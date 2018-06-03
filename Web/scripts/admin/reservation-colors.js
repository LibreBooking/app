function ReservationColorManagement(opts) {
    var elements = {
        deleteRuleId: $('#deleteRuleId'),
        attributeOption: $('#attributeOption'),

        colorDialog: $('#colorDialog'),
        colorValue: $('#reservationColor'),
        colorForm: $('#colorForm'),

        addDialog: $('#addDialog'),
        addForm: $('#addForm'),
        deleteDialog: $('#deleteDialog'),
        deleteForm: $('#deleteForm')
    };

    ReservationColorManagement.prototype.init = function () {
        $(".save").click(function () {
            $(this).closest('form').submit();
        });

        $(".cancel").click(function () {
            $(this).closest('.modal').modal("hide");
        });

        $(".delete").click(function () {
            elements.deleteRuleId.val($(this).attr('ruleId'));
            elements.deleteDialog.modal('show');
        });

        $('#addRuleButton').click(function (e) {
            var attrId = '#attribute' + elements.attributeOption.val();
            $('#attributeFillIn').empty();
            $('#attributeFillIn').append($(attrId).clone().removeClass('hidden'));
            elements.addDialog.modal('show');
        });

        ConfigureAsyncForm(elements.addForm);
        ConfigureAsyncForm(elements.deleteForm);
    };
}