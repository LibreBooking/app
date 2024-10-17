{include file='globalheader.tpl' }

<div id="page-data-cleanup" class="admin-page">

    <div class="card shadow col-12 col-sm-8 mx-auto">
        <div class="card-body">
            <h1 class="border-bottom mb-3">{translate key=DataCleanup}</h1>

            <div class="mb-3 p-3 border rounded bg-light">
                <h5><span class="badge bg-primary">{$ReservationCount} {translate key=Reservations}</span></h5>
                <div class="input-group input-group-sm">
                    <label class="input-group-text fw-bold"
                        for="reservationDeleteDate">{translate key=DeleteReservationsBefore}</label>
                    <input type="date" id="reservationDeleteDate" class="form-control dateinput"
                        value="{formatdate date=$DeleteDate format='Y-m-d'}" />
                    <input type="hidden" id="formattedReservationDeleteDate"
                        value="{formatdate date=$DeleteDate key=system}" />
                    {delete_button id='deleteReservations'}
                </div>
            </div>

            <div class="mb-3 p-3 border rounded bg-light clearfix">
                <h5><span class="badge bg-primary">{$DeletedReservationCount} {translate key=DeletedReservations}</span>
                </h5>
                <div class="form-group">

                </div>
                {delete_button id='purgeReservations' key=Purge class='btn-sm float-end'}
            </div>

            <div class="mb-3 p-3 border rounded bg-light">
                <h5><span class="badge bg-primary">{$BlackoutsCount} {translate key=ManageBlackouts}</span></h5>

                <div class="input-group input-group-sm">
                    <label class="input-group-text fw-bold"
                        for="blackoutDeleteDate">{translate key=DeleteBlackoutsBefore}</label>
                    <input type="date" id="blackoutDeleteDate" class="form-control input-sm inline-block dateinput"
                        value="{formatdate date=$DeleteDate format='Y-m-d'}" />
                    <input type="hidden" id="formattedBlackoutDeleteDate"
                        value="{formatdate date=$DeleteDate key=system}" />
                    {delete_button id='deleteBlackouts'}
                </div>


            </div>

            <div class="mb-3 p-3 border rounded bg-light">
                <h5><span class="badge bg-primary">{$UserCount} {translate key=Users}</span></h5>

                <div class="input-group input-group-sm">
                    <label class="input-group-text fw-bold"
                        for="userDeleteDate">{translate key=PermanentlyDeleteUsers}</label>
                    <input type="date" id="userDeleteDate" class="form-control input-sm inline-block dateinput"
                        value="{formatdate date=$DeleteDate format='Y-m-d'}" />
                    <input type="hidden" id="formattedUserDeleteDate"
                        value="{formatdate date=$DeleteDate key=system}" />
                    {delete_button id='deleteUsers'}
                </div>

            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteReservationsDialog" tabindex="-1" role="dialog"
        aria-labelledby="deleteReservationsDialogLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteReservationsForm" method="post" ajaxAction="deleteReservations">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteReservationsDialogLabel">{translate key=Delete}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <div>{translate key=DeleteWarning}</div>
                            <div>
                                <strong><span id="deleteReservationCount"></span></strong>
                                {translate key=ReservationsWillBeDeleted}
                            </div>
                            <input type="hidden" {formname key=BEGIN_DATE} id="formDeleteReservationDate" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {delete_button submit=true}
                        {indicator}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="purgeReservationsDialog" tabindex="-1" role="dialog"
        aria-labelledby="purgeReservationsDialogLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="purgeReservationsForm" method="post" ajaxAction="purge">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="purgeReservationsDialogLabel">{translate key=Delete}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <div>{translate key=DeleteWarning}</div>
                            <div>
                                <strong>{$DeletedReservationCount}</strong> {translate key=ReservationsWillBePurged}
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {delete_button submit=true}
                        {indicator}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteBlackoutDialog" tabindex="-1" role="dialog"
        aria-labelledby="deleteBlackoutDialogLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteBlackoutsForm" method="post" ajaxAction="deleteBlackouts">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteBlackoutDialogLabel">{translate key=Delete}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <div>{translate key=DeleteWarning}</div>
                            <div>
                                <strong><span id="deleteBlackoutCount"></span></strong>
                                {translate key=BlackoutsWillBeDeleted}
                            </div>
                            <input type="hidden" {formname key=BEGIN_DATE} id="formDeleteBlackoutDate" />
                        </div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {delete_button submit=true}
                        {indicator}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteUsersDialog" tabindex="-1" role="dialog" aria-labelledby="deleteUsersDialogLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteUsersForm" method="post" ajaxAction="deleteUsers">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteUsersDialogLabel">{translate key=Delete}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-hidden="true"></button>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <div>{translate key=DeleteWarning}</div>
                            <div>
                                <strong><span id="deleteUserCount"></span></strong> {translate key=UsersWillBeDeleted}
                            </div>
                        </div>
                        <input type="hidden" {formname key=BEGIN_DATE} id="formDeleteUserDate" />

                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {delete_button submit=true}
                        {indicator}
                    </div>
                </div>
            </form>
        </div>
    </div>

</div>

{include file="javascript-includes.tpl"}
{jsfile src="js/moment.min.js"}
{jsfile src="ajax-helpers.js"}

{control type="DatePickerSetupControl" ControlId="reservationDeleteDate" AltId="formattedReservationDeleteDate"}
{control type="DatePickerSetupControl" ControlId="blackoutDeleteDate" AltId="formattedBlackoutDeleteDate"}
{control type="DatePickerSetupControl" ControlId="userDeleteDate" AltId="formattedUserDeleteDate"}

<script type="text/javascript">
    $(document).ready(function() {
        $('#deleteReservations').click(function(e) {
            $('#formDeleteReservationDate').val($('#formattedReservationDeleteDate').val());
            ajaxGet('{$smarty.server.SCRIPT_NAME}?dr=getReservationCount&date=' + $('#formattedReservationDeleteDate').val(), null, function (data) {
            $('#deleteReservationCount').text(data.count);
            $('#deleteReservationsDialog').modal('show');
        })
    });

    $('#purgeReservations').click(function(e) {
        $('#purgeReservationsDialog').modal('show');
    });

    $('#deleteBlackouts').click(function(e) {
    $('#formDeleteBlackoutDate').val($('#formattedBlackoutDeleteDate').val());
    ajaxGet('{$smarty.server.SCRIPT_NAME}?dr=getBlackoutCount&date=' + $('#formattedBlackoutDeleteDate').val(), null, function (data) {
    $('#deleteBlackoutCount').text(data.count);
    $('#deleteBlackoutDialog').modal('show');
    })
    });

    $('#deleteUsers').click(function(e) {
    $('#formDeleteUserDate').val($('#formattedUserDeleteDate').val());
    ajaxGet('{$smarty.server.SCRIPT_NAME}?dr=getUserCount&date=' + $('#formattedUserDeleteDate').val(), null, function (data) {
    $('#deleteUserCount').text(data.count);
    $('#deleteUsersDialog').modal('show');
    })
    });

    ConfigureAsyncForm($('#deleteReservationsForm'));
    ConfigureAsyncForm($('#purgeReservationsForm'));
    ConfigureAsyncForm($('#deleteBlackoutsForm'));
    ConfigureAsyncForm($('#deleteUsersForm'));
    });
</script>
{include file='globalfooter.tpl'}