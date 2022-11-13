{include file='globalheader.tpl' cssFiles="my-account.css"}

<div class="page-notification-preferences">

	{if !$EmailEnabled}
		<div class="error">{translate key=EmailDisabled}</div>
	{else}
		<div id="notification-preferences-box" class="offset-md-3 col-md-6 col-xs-12 px-5 mt-4 shadow-sm border rounded">
			<h1 class="text-center mt-2">{translate key=NotificationPreferences}</h1>

			{if $PreferencesUpdated}
				<div class="alert alert-success alert-dismissible fade show" role="alert">
					<i class="bi bi-check-circle-fill"></i>&nbsp; {translate key=YourSettingsWereUpdated}
					<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
				</div>
			{/if}

			<form id="notification-preferences-form" method="post" action="{$smarty.server.SCRIPT_NAME}">
				<div>
					<div class="notification-row">
						<div class="notification-type">
							{translate key=ReservationCreatedPreference}
						</div>

						<div class="btn-group btn-group-sm form-group" role="group" data-toggle="buttons">
							<input id="createdYes" type="radio" class="btn-check" name="{ReservationEvent::Created}" value="1"
									   {if $Created}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="createdYes"> {translate key=PreferenceSendEmail}</label>
							<input id="createdNo" type="radio" class="btn-check" name="{ReservationEvent::Created}" value="0"
									   {if !$Created}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="createdNo">{translate key=PreferenceNoEmail}</label>
						</div>
					</div>

					<div class="notification-row">
						<div class="notification-type">
							{translate key=ReservationUpdatedPreference}
						</div>

						<div class="btn-group btn-group-sm form-group" role="group" data-toggle="buttons">
							<input id="updatedYes" type="radio" class="btn-check" name="{ReservationEvent::Updated}" value="1"
									   {if $Updated}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="updatedYes">{translate key=PreferenceSendEmail}</label>
							<input id="updatedNo" type="radio" class="btn-check" name="{ReservationEvent::Updated}" value="0"
								   	 {if !$Updated}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="updatedNo">{translate key=PreferenceNoEmail}</label>
						</div>
					</div>

					<div class="notification-row">
						<div class="notification-type">
							{translate key=ReservationDeletedPreference}
						</div>

						<div class="btn-group btn-group-sm form-group" role="group" data-toggle="buttons">
							<input id="deletedYes" type="radio" class="btn-check" name="{ReservationEvent::Deleted}" value="1"
									   {if $Deleted}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="deletedYes">{translate key=PreferenceSendEmail}</label>
							<input id="deletedNo" type="radio" class="btn-check" name="{ReservationEvent::Deleted}" value="0"
									   {if !$Deleted}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="deletedNo">{translate key=PreferenceNoEmail}</label>
						</div>
					</div>

					<div class="notification-row alt">
						<div class="notification-type">
							{translate key=ReservationApprovalPreference}
						</div>

						<div class="btn-group btn-group-sm form-group" role="group" data-toggle="buttons">
							<input id="approvedYes" type="radio" class="btn-check" name="{ReservationEvent::Approved}" value="1"
									   {if $Approved}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="approvedYes">{translate key=PreferenceSendEmail}</label>
							<input id="approvedNo" type="radio" class="btn-check" name="{ReservationEvent::Approved}" value="0"
									   {if !$Approved}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="approvedNo">{translate key=PreferenceNoEmail}</label>
						</div>
					</div>

          <div class="notification-row">
            <div class="notification-type">
              {translate key=ReservationParticipationActivityPreference}
            </div>

            <div class="btn-group btn-group-sm form-group" role="group" data-toggle="buttons">
              <input id="endingYes" type="radio" class="btn-check" name="{ReservationEvent::ParticipationChanged}" value="1"
                     {if $ParticipantChanged}checked="checked"{/if}/>
              <label class="btn btn-outline-success" for="endingYes">{translate key=PreferenceSendEmail}</label>
              <input id="endingNo" type="radio" class="btn-check" name="{ReservationEvent::ParticipationChanged}" value="0"
                     {if !$ParticipantChanged}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="endingNo">{translate key=PreferenceNoEmail}</label>
            </div>
          </div>

          <div class="notification-row-alt">
            <div class="notification-type">
              {translate key=ReservationSeriesEndingPreference}
          	</div>

          	<div class="btn-group btn-group-sm form-group" role="group" data-toggle="buttons">
            	<input id="endingYes" type="radio" class="btn-check" name="{ReservationEvent::SeriesEnding}" value="1"
                     {if $SeriesEnding}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="endingYes"> {translate key=PreferenceSendEmail}</label>
          	  <input id="endingNo" type="radio" class="btn-check" name="{ReservationEvent::SeriesEnding}" value="0"
                   	 {if !$SeriesEnding}checked="checked"{/if}/>
							<label class="btn btn-outline-success" for="endingNo">{translate key=PreferenceNoEmail}</label>
          	</div>
          </div>
				</div>

				<div class="d-grid gap-2 col-3 mx-auto form-group">
					<button type="submit" class="btn btn-primary update prompt mt-4 mb-4" name="{Actions::SAVE}">
						{translate key='Update'}
					</button>
				</div>
			</form>
		</div>
	{/if}

</div>

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}
