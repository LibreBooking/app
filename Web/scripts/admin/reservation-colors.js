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
        // $(".save").click(function () {
        //     $(this).closest('form').submit();
        // });

        $(".cancel").click(function () {
            $(this).closest('.modal').modal("close");
        });

        $(".delete").click(function () {
            elements.deleteRuleId.val($(this).attr('ruleId'));
            elements.deleteDialog.modal('open');
        });

        // $('#addRuleButton').click(function (e) {
        //     var attrId = '#attribute' + elements.attributeOption.val();
        //     $('#attributeFillIn').empty();
        //     $('#attributeFillIn').append($(attrId).clone().removeClass('hidden'));
        //     elements.addDialog.modal('open');
        // });

        elements.attributeOption.on('change', function(){
            var attrId = '#attribute' + elements.attributeOption.val();
            $('.attribute-option').addClass('no-show');
            $(attrId).find('input').val('');
            $(attrId).find('select').val('');
            $(attrId).removeClass('no-show');
            $('select').formSelect();
            // $('#attributeFillIn').empty();
            // $('#attributeFillIn').append($(attrId).clone().removeClass('hidden'));

        });

        $('#add-rule-prompt-btn').click(function() {
            elements.attributeOption.trigger('change');
            elements.addDialog.modal('open');
        });

        ConfigureAsyncForm(elements.addForm);
        ConfigureAsyncForm(elements.deleteForm);
    };
}