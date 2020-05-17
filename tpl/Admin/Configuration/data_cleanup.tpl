{include file='globalheader.tpl' }

<div id="page-data-cleanup" class="admin-page">

    <div class="default-box col s12 m8 offset-m2">
        <h1 class="page-title">{translate key=DataCleanup}</h1>

        <div class="card">
            <div class="card-content">
                <span class="card-title">
                    <span>{$ReservationCount} {translate key=Reservations}</span>
                </span>

                <div class="input-field">
                    <label for="reservationDeleteDate">{translate key=DeleteReservationsBefore}</label>
                    <input type="text" id="reservationDeleteDate" class="form-control input-sm inline-block dateinput"
                           value="{formatdate date=$DeleteDate}"/>
                    <input type="hidden" id="formattedReservationDeleteDate"
                           value="{formatdate date=$DeleteDate key=system}"/>
                </div>
            </div>
            <div class="card-action">
                {delete_button id='deleteReservations'}
                {if $DeletedReservationCount > 0}
                    {delete_button id='purgeReservations' key=Purge} {$DeletedReservationCount} {translate key=DeletedReservations}
                {/if}
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <span class="card-title">{$BlackoutsCount} {translate key=ManageBlackouts}</span>
                <div class="input-field">
                    <label for="blackoutDeleteDate">{translate key=DeleteBlackoutsBefore}</label>
                    <input type="text" id="blackoutDeleteDate" class="form-control input-sm inline-block dateinput"
                           value="{formatdate date=$DeleteDate}"/>
                    <input type="hidden" id="formattedBlackoutDeleteDate"
                           value="{formatdate date=$DeleteDate key=system}"/>
                </div>
            </div>
            <div class="card-action">
                {delete_button id='deleteBlackouts'}
            </div>
        </div>

        <div class="card">
            <div class="card-content">
                <span class="card-title">{$UserCount} {translate key=Users}</span>
                <div class="input-field">
                    <label for="userDeleteDate">{translate key=PermanentlyDeleteUsers}</label>
                    <input type="text" id="userDeleteDate" class="form-control input-sm inline-block dateinput"
                           value="{formatdate date=$DeleteDate}"/>
                    <input type="hidden" id="formattedUserDeleteDate" value="{formatdate date=$DeleteDate key=system}"/>
                </div>
            </div>
            <div class="card-action">
                {delete_button id='deleteUsers'}
            </div>
        </div>
    </div>

    <div class="modal modal-fixed-header modal-fixed-footer" id="deleteReservationsDialog" tabindex="-1" role="dialog"
         aria-labelledby="deleteReservationsDialogLabel" aria-hidden="true">

        <form id="deleteReservationsForm" method="post" ajaxAction="deleteReservations">
            <div class="modal-header">
                <h4 class="modal-title left" id="deleteReservationsDialogLabel">{translate key=Delete}</h4>
                 {close_modal}
            </div>
            <div class="modal-content">
                <div class="card warning">
                    <div class="card-content">
                        <div>{translate key=DeleteWarning}</div>
                        <div>
                            <strong> <span id="deleteReservationCount"></span></strong> {translate key=ReservationsWillBeDeleted}
                        </div>
                        <input type="hidden" {formname key=BEGIN_DATE} id="formDeleteReservationDate"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {delete_button submit=true}
                {indicator}
            </div>
        </form>
    </div>

    <div class="modal modal-fixed-header modal-fixed-footer" id="purgeReservationsDialog" tabindex="-1" role="dialog"
         aria-labelledby="purgeReservationsDialogLabel" aria-hidden="true">
        <form id="purgeReservationsForm" method="post" ajaxAction="purge">
            <div class="modal-header">
                <h4 class="modal-title left" id="purgeReservationsDialogLabel">{translate key=Delete}</h4>
                 {close_modal}
            </div>
            <div class="modal-content">
                <div class="card warning">
                    <div class="card-content">
                        <div>{translate key=DeleteWarning}</div>
                        <div>
                            <strong>{$DeletedReservationCount}</strong> {translate key=ReservationsWillBePurged}
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {delete_button submit=true}
                {indicator}
            </div>
        </form>
    </div>

    <div class="modal modal-fixed-header modal-fixed-footer" id="deleteBlackoutDialog" tabindex="-1" role="dialog"
         aria-labelledby="deleteBlackoutDialogLabel" aria-hidden="true">
        <form id="deleteBlackoutsForm" method="post" ajaxAction="deleteBlackouts">
            <div class="modal-header">
                <h4 class="modal-title left" id="deleteBlackoutDialogLabel">{translate key=Delete}</h4>
                 {close_modal}
            </div>
            <div class="modal-content">
                <div class="card warning">
                    <div class="card-content">
                        <div>{translate key=DeleteWarning}</div>
                        <div>
                            <strong><span
                                        id="deleteBlackoutCount"></span></strong> {translate key=BlackoutsWillBeDeleted}
                        </div>
                        <input type="hidden" {formname key=BEGIN_DATE} id="formDeleteBlackoutDate"/>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {delete_button submit=true}
                {indicator}
            </div>
        </form>
    </div>

    <div class="modal modal-fixed-header modal-fixed-footer" id="deleteUsersDialog" tabindex="-1" role="dialog"
         aria-labelledby="deleteUsersDialogLabel" aria-hidden="true">
        <form id="deleteUsersForm" method="post" ajaxAction="deleteUsers">
            <div class="modal-header">
                <h4 class="modal-title left" id="deleteUsersDialogLabel">{translate key=Delete}</h4>
                 {close_modal}
            </div>
            <div class="modal-content">
                <div class="card warning">
                    <div class="card-content">
                        <div>{translate key=DeleteWarning}</div>
                        <div>
                            <strong><span id="deleteUserCount"></span></strong> {translate key=UsersWillBeDeleted}
                        </div>
                    </div>
                    <input type="hidden" {formname key=BEGIN_DATE} id="formDeleteUserDate"/>
                </div>
            </div>
            <div class="modal-footer">
                {cancel_button}
                {delete_button submit=true}
                {indicator}
            </div>
        </form>
    </div>

    {include file="javascript-includes.tpl"}
    {jsfile src="js/moment.min.js"}
    {jsfile src="ajax-helpers.js"}

    {control type="DatePickerSetupControl" ControlId="reservationDeleteDate" AltId="formattedReservationDeleteDate" DefaultDate=$DeleteDate}
    {control type="DatePickerSetupControl" ControlId="blackoutDeleteDate" AltId="formattedBlackoutDeleteDate" DefaultDate=$DeleteDate}
    {control type="DatePickerSetupControl" ControlId="userDeleteDate" AltId="formattedUserDeleteDate" DefaultDate=$DeleteDate}

    <script type="text/javascript">
        $(document).ready(function () {
            $('div.modal').modal();

            $('#deleteReservations').click(function (e) {
                $('#formDeleteReservationDate').val($('#formattedReservationDeleteDate').val());
                ajaxGet('{$smarty.server.SCRIPT_NAME}?dr=getReservationCount&date=' + $('#formattedReservationDeleteDate').val(), null, function (data) {
                    $('#deleteReservationCount').text(data.count);
                    $('#deleteReservationsDialog').modal('open');
                })
            });

            $('#purgeReservations').click(function (e) {
                $('#purgeReservationsDialog').modal('open');
            });

            $('#deleteBlackouts').click(function (e) {
                $('#formDeleteBlackoutDate').val($('#formattedBlackoutDeleteDate').val());
                ajaxGet('{$smarty.server.SCRIPT_NAME}?dr=getBlackoutCount&date=' + $('#formattedBlackoutDeleteDate').val(), null, function (data) {
                    $('#deleteBlackoutCount').text(data.count);
                    $('#deleteBlackoutDialog').modal('open');
                })
            });

            $('#deleteUsers').click(function (e) {
                $('#formDeleteUserDate').val($('#formattedUserDeleteDate').val());
                ajaxGet('{$smarty.server.SCRIPT_NAME}?dr=getUserCount&date=' + $('#formattedUserDeleteDate').val(), null, function (data) {
                    $('#deleteUserCount').text(data.count);
                    $('#deleteUsersDialog').modal('open');
                })
            });

            ConfigureAsyncForm($('#deleteReservationsForm'));
            ConfigureAsyncForm($('#purgeReservationsForm'));
            ConfigureAsyncForm($('#deleteBlackoutsForm'));
            ConfigureAsyncForm($('#deleteUsersForm'));
        });
    </script>
</div>
{include file='globalfooter.tpl'}