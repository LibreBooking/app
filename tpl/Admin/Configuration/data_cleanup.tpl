{include file='globalheader.tpl' }

<div id="page-data-cleanup" class="admin-page">
    <h1>{translate key=DataCleanup}</h1>

    <div class="well">
        <div class="badge">{$ReservationCount} reservations</div>
        <div class="form-group">
            <label for="reservationDeleteDate">Delete reservations before</label>
            <input type="text" id="reservationDeleteDate" class="form-control input-sm inline-block dateinput"
                   value="{formatdate date=$DeleteDate}"/>
            <input type="hidden" id="formattedReservationDeleteDate" value="{formatdate date=$DeleteDate key=system}"/>
        </div>
        {delete_button id='deleteReservations'}
    </div>

    <div class="well">
        <div class="badge">{$DeletedReservationCount} deleted reservations</div>
        <div class="form-group">

        </div>
        {delete_button id='purgeReservations' key=Purge}
    </div>

    <div class="well">
        <div class="badge">{$BlackoutsCount} blackouts</div>

        <div class="form-group">
            <label for="blackoutDeleteDate"> Delete blackouts before</label>
            <input type="text" id="blackoutDeleteDate" class="form-control input-sm inline-block dateinput"
                   value="{formatdate date=$DeleteDate}"/>
            <input type="hidden" id="formattedBlackoutDeleteDate" value="{formatdate date=$DeleteDate key=system}"/>
        </div>

        {delete_button id='deleteBlackouts'}

    </div>

    <div class="well">
        <div class="badge">{$UserCount} users</div>

        <div class="form-group">
            <label for="userDeleteDate">Permanently delete users who have not logged in since</label>
            <input type="text" id="userDeleteDate" class="form-control input-sm inline-block dateinput"
                   value="{formatdate date=$DeleteDate}"/>
            <input type="hidden" id="formattedUserDeleteDate" value="{formatdate date=$DeleteDate key=system}"/>
        </div>

        {delete_button id='deleteUsers'}

    </div>

    <div class="modal fade" id="deleteReservationsDialog" tabindex="-1" role="dialog"
         aria-labelledby="deleteReservationsDialogLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteReservationsForm" method="post" ajaxAction="deleteReservations">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="deleteReservationsDialogLabel">{translate key=Delete}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <div>{translate key=DeleteWarning}</div>
                            <div>
                                <strong><span id="deleteReservationCount"></span></strong> reservations will be deleted
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
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="purgeReservationsDialogLabel">{translate key=Delete}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <div>{translate key=DeleteWarning}</div>
                            <div>
                                <strong>{$DeletedReservationCount}</strong> reservations will be purged
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
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="deleteBlackoutDialogLabel">{translate key=Delete}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <div>{translate key=DeleteWarning}</div>
                            <div>
                                <strong><span id="deleteBlackoutCount"></span></strong> blackouts will be deleted
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

    <div class="modal fade" id="deleteUsersDialog" tabindex="-1" role="dialog"
         aria-labelledby="deleteUsersDialogLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteUsersForm" method="post" ajaxAction="deleteUsers">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="deleteUsersDialogLabel">{translate key=Delete}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            <div>{translate key=DeleteWarning}</div>
                            <div>
                                <strong><span id="deleteUserCount"></span></strong> users will be deleted
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

{control type="DatePickerSetupControl" ControlId="reservationDeleteDate" AltId="formattedReservationDeleteDate" DefaultDate=$DeleteDate}
{control type="DatePickerSetupControl" ControlId="blackoutDeleteDate" AltId="formattedBlackoutDeleteDate" DefaultDate=$DeleteDate}
{control type="DatePickerSetupControl" ControlId="userDeleteDate" AltId="formattedUserDeleteDate" DefaultDate=$DeleteDate}

<script type="text/javascript">
    $(document).ready(function () {
        $('#deleteReservations').click(function (e) {
            $('#formDeleteReservationDate').val($('#formattedReservationDeleteDate').val());
            ajaxGet('{$smarty.server.SCRIPT_NAME}?dr=getReservationCount&date=' + $('#formattedReservationDeleteDate').val(), null, function(data){
                $('#deleteReservationCount').text(data.count);
                $('#deleteReservationsDialog').modal('show');
            })
        });

        $('#purgeReservations').click(function (e) {
            $('#purgeReservationsDialog').modal('show');
        });

        $('#deleteBlackouts').click(function (e) {
            $('#formDeleteBlackoutDate').val($('#formattedBlackoutDeleteDate').val());
            ajaxGet('{$smarty.server.SCRIPT_NAME}?dr=getBlackoutCount&date=' + $('#formattedBlackoutDeleteDate').val(), null, function(data){
                $('#deleteBlackoutCount').text(data.count);
                $('#deleteBlackoutDialog').modal('show');
            })
        });

        $('#deleteUsers').click(function (e) {
            $('#formDeleteUserDate').val($('#formattedUserDeleteDate').val());
            ajaxGet('{$smarty.server.SCRIPT_NAME}?dr=getUserCount&date=' + $('#formattedUserDeleteDate').val(), null, function(data){
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