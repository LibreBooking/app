{include file='globalheader.tpl' }

<div class="page-notification-preferences">
	{if !$EmailEnabled}
		<div class="alert alert-danger text-center">
			<i class="bi bi-exclamation-triangle-fill fs-5"></i> {translate key=EmailDisabled}
		</div>
	{else}
		<div id="notification-preferences-box" class="default-box card shadow col- col-sm-8 mx-auto">

			<form id="notification-preferences-form" method="post" action="{$smarty.server.SCRIPT_NAME}">
				<div class="card-body mx-3">
					<h1 class="text-center border-bottom mb-3">{translate key=NotificationPreferences}</h1>
					{if $PreferencesUpdated}
						<div class="success alert alert-success">
							<i class="bi bi-check-circle-fill"></i> {translate key=YourSettingsWereUpdated}
						</div>
					{/if}
					<div class="row gy-3">
						<div class="notification-row col-12 col-sm-6">
							<div class="notification-type">{translate key=ReservationCreatedPreference}</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch"
									id="{ReservationEvent::Created}" name="{ReservationEvent::Created}"
									{if $Created}checked="checked" {/if}>
								<label class="form-check-label"
									for="{ReservationEvent::Created}">{translate key=PreferenceSendEmail}</label>
							</div>
							{*<div class="btn-group form-group" data-toggle="buttons">
								<label class="btn btn-default btn-xs {if $Created}active{/if}">
									<input id="createdYes" type="radio" name="{ReservationEvent::Created}" value="1"
										{if $Created}checked="checked" {/if} /> {translate key=PreferenceSendEmail}{$Created}
								</label>
								<label class="btn btn-default btn-xs {if !$Created}active{/if}">
									<input id="createdNo" type="radio" name="{ReservationEvent::Created}" value="0"
										{if !$Created}checked="checked" {/if} />{translate key=PreferenceNoEmail}</label>
							</div>*}
						</div>

						<div class="notification-row col-12 col-sm-6">
							<div class="notification-type">{translate key=ReservationUpdatedPreference}</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch"
									id="{ReservationEvent::Updated}" name="{ReservationEvent::Updated}"
									{if $Updated}checked="checked" {/if}>
								<label class="form-check-label"
									for="{ReservationEvent::Updated}">{translate key=PreferenceSendEmail}</label>
							</div>
							{*<div class="btn-group form-group" data-toggle="buttons">
								<label class="btn btn-default btn-xs {if $Updated}active{/if}">
									<input id="updatedYes" type="radio" name="{ReservationEvent::Updated}" value="1"
										{if $Updated}checked="checked" {/if} /> {translate key=PreferenceSendEmail}
								</label>
								<label class="btn btn-default btn-xs {if !$Updated}active{/if}">
									<input id="updatedNo" type="radio" name="{ReservationEvent::Updated}" value="0"
										{if !$Updated}checked="checked" {/if} />{translate key=PreferenceNoEmail}</label>
							</div>*}
						</div>

						<div class="notification-row col-12 col-sm-6">
							<div class="notification-type">
								{translate key=ReservationDeletedPreference}
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch"
									id="{ReservationEvent::Deleted}" name="{ReservationEvent::Deleted}"
									{if $Deleted}checked="checked" {/if}>
								<label class="form-check-label"
									for="{ReservationEvent::Deleted}">{translate key=PreferenceSendEmail}</label>
							</div>
							{*<div class="btn-group form-group" data-toggle="buttons">
								<label class="btn btn-default btn-xs {if $Deleted}active{/if}">
									<input id="deletedYes" type="radio" name="{ReservationEvent::Deleted}" value="1"
										{if $Deleted}checked="checked" {/if} /> {translate key=PreferenceSendEmail}
								</label>
								<label class="btn btn-default btn-xs {if !$Deleted}active{/if}">
									<input id="deletedNo" type="radio" name="{ReservationEvent::Deleted}" value="0"
										{if !$Deleted}checked="checked" {/if} />{translate key=PreferenceNoEmail}</label>
							</div>*}

						</div>

						<div class="notification-row alt col-12 col-sm-6">
							<div class="notification-type">
								{translate key=ReservationApprovalPreference}
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch"
									id="{ReservationEvent::Approved}" name="{ReservationEvent::Approved}"
									{if $Approved}checked="checked" {/if}>
								<label class="form-check-label"
									for="{ReservationEvent::Approved}">{translate key=PreferenceSendEmail}</label>
							</div>
							{*<div class="btn-group form-group" data-toggle="buttons">
								<label class="btn btn-default btn-xs {if $Approved}active{/if}">
									<input id="approvedYes" type="radio" name="{ReservationEvent::Approved}" value="1"
										{if $Approved}checked="checked" {/if} /> {translate key=PreferenceSendEmail}
								</label>
								<label class="btn btn-default btn-xs {if !$Approved}active{/if}">
									<input id="approvedNo" type="radio" name="{ReservationEvent::Approved}" value="0"
										{if !$Approved}checked="checked" {/if} />{translate key=PreferenceNoEmail}</label>
							</div>*}
						</div>

						<div class="notification-row col-12 col-sm-6">
							<div class="notification-type">
								{translate key=ReservationParticipationActivityPreference}
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch"
									id="{ReservationEvent::ParticipationChanged}"
									name="{ReservationEvent::ParticipationChanged}"
									{if $ParticipantChanged}checked="checked" {/if}>
								<label class="form-check-label"
									for="{ReservationEvent::ParticipationChanged}">{translate key=PreferenceSendEmail}</label>
							</div>
							{*<div class="btn-group form-group" data-toggle="buttons">
								<label class="btn btn-default btn-xs {if $ParticipantChanged}active{/if}">
									<input id="endingYes" type="radio" name="{ReservationEvent::ParticipationChanged}" value="1"
										{if $ParticipantChanged}checked="checked" {/if} />
									{translate key=PreferenceSendEmail}
								</label>
								<label class="btn btn-default btn-xs {if !$ParticipantChanged}active{/if}">
									<input id="endingNo" type="radio" name="{ReservationEvent::ParticipationChanged}" value="0"
										{if !$ParticipantChanged}checked="checked"
										{/if} />{translate key=PreferenceNoEmail}</label>
							</div>*}
						</div>

						<div class="notification-row-alt col-12 col-sm-6">
							<div class="notification-type">
								{translate key=ReservationSeriesEndingPreference}
							</div>
							<div class="form-check form-switch">
								<input class="form-check-input" type="checkbox" role="switch"
									id="{ReservationEvent::SeriesEnding}" name="{ReservationEvent::SeriesEnding}"
									{if $SeriesEnding}checked="checked" {/if}>
								<label class="form-check-label"
									for="{ReservationEvent::SeriesEnding}">{translate key=PreferenceSendEmail}</label>
							</div>
							{*<div class="btn-group form-group" data-toggle="buttons">
								<label class="btn btn-default btn-xs {if $SeriesEnding}active{/if}">
									<input id="endingYes" type="radio" name="{ReservationEvent::SeriesEnding}" value="1"
										{if $SeriesEnding}checked="checked" {/if} /> {translate key=PreferenceSendEmail}
								</label>
								<label class="btn btn-default btn-xs {if !$SeriesEnding}active{/if}">
									<input id="endingNo" type="radio" name="{ReservationEvent::SeriesEnding}" value="0"
										{if !$SeriesEnding}checked="checked" {/if} />{translate key=PreferenceNoEmail}</label>
							</div>*}
						</div>

					</div>
					<div class="form-group d-grid mt-3">
						<button type="submit" class="btn btn-primary update prompt" name="{Actions::SAVE}">
							{translate key='Update'}
						</button>
					</div>
				</div>
			</form>

		</div>
	{/if}

</div>

{include file="javascript-includes.tpl"}
{include file='globalfooter.tpl'}