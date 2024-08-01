{extends file="Reservation/view.tpl"}

{block name=header}
	{include file='globalheader.tpl' TitleKey='EditReservationHeading'}
{/block}

{block name=reservationHeader}
	{translate key="EditReservationHeading"}
{/block}

{block name=deleteButtons}
	<div class="btn-group">
		<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
			{translate key=More} <span class="caret"></span>
		</button>

		<ul class="dropdown-menu" role="menu">
			<li>
				{assign var=icsUrl value="{$Path}export/{Pages::CALENDAR_EXPORT}?{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}"}
				<a href="{$icsUrl}" download="{$icsUrl}">
					<span class="fa fa-calendar"></span>
					{translate key=AddToOutlook}</a>
			</li>
			<li><a href="#" class="btnPrint">
					<span class="fa fa-print"></span>
					{translate key='Print'}</a>
			</li>
			<li><a href="#" class="btnPDF">
					<span class="fa fa-file-pdf-o"></span>
					PDF</a>
			</li>
		</ul>
	</div>

    <div id="deleteButtonPrompt" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="updateButtonsLabel">{translate key=Reject}</h4>
                </div>
                <div class="modal-body">
                    <div>{translate key=DeleteReminderWarning}</div>
                    <div>
                        <label for="deleteReason">{translate key=Reason} ({translate key=Optional})</label>
                        <textarea id="deleteReason" class="deleteReason form-control"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    {cancel_button class="cancelDelete cancel"}
                    {delete_button class="confirmDelete delete save" key=Reject}
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="updateButtons" tabindex="-1" role="dialog" aria-labelledby="updateButtonsLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title" id="updateButtonsLabel">{translate key=ApplyUpdatesTo}</h4>
                </div>
                <div class="modal-body">
                    <div id="deleteRecurringButtons" class="no-show margin-bottom-15">
                        <div>{translate key=DeleteReminderWarning}</div>
                        <div>
                            <label for="deleteReasonRecurring">{translate key=Reason} ({translate key=Optional})</label>
                            <textarea class="deleteReasonRecurring form-control"></textarea>
                        </div>
                    </div>
                    <button type="button" class="btn btn-success save btnUpdateThisInstance">
                        <span class="fa fa-check"></span>
                        {translate key='ThisInstance'}
                    </button>
                    <button type="button" class="btn btn-success save btnUpdateAllInstances">
                        <span class="fa fa-check-square"></span>
                        {translate key='AllInstances'}
                    </button>
                    <button type="button" class="btn btn-success save btnUpdateFutureInstances">
                        <span class="fa fa-check-square-o"></span>
                        {translate key='FutureInstances'}
                    </button>
                    <button type="button" class="btn btn-default">
                        {translate key='Cancel'}
                    </button>
                </div>
            </div>
        </div>
    </div>

{/block}

{block name=submitButtons}
	<a href="{$SCRIPT_NAME}?{QueryStringKeys::REFERENCE_NUMBER}={$ReferenceNumber}&update=1&{QueryStringKeys::REDIRECT}={$ReturnUrl|escape:url}" class="btn btn-default" id="btnApprovalUpdate">
		<span class=""></span>
		{translate key='Update'}
	</a>
    <button type="button" class="btn btn-danger {if $IsRecurring}delete prompt{else}triggerDeletePrompt delete prompt-single{/if}">
        <span class="fa fa-remove"></span>
        {translate key='Reject'}
    </button>
    <button type="button" class="btn btn-success" id="btnApprove">
		<span class="glyphicon glyphicon-ok-circle"></span>
		{translate key='Approve'}
	</button>
{/block}

{block name="ajaxMessage"}
	{translate key=UpdatingReservation}...
	<br/>
{/block}
