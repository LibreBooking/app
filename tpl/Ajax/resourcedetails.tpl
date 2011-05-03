<style type="text/css">
.ui-tooltip-blue {
	min-width: 500px;
	max-width: 900px;
	max-height: 400px;
}
</style>

<div id="resourceDetails">
	<div style="float:left; width: 350px;">
		<ul>
			<li>{translate key=Description}
				{if $description neq ''}
					{$description|url2link|nl2br}
				{else}
					{translate key=NoDescriptionLabel}
				{/if}
			</li>
			<li>
				{translate key=Notes}
				{if $notes neq ''}
					{$notes|url2link|nl2br}
				{else}
					{translate key=NoNotesLabel}
				{/if}
			</li>
			<li>
				{translate key=Contact}
				{if $contactInformation neq ''}
					{$contactInformation}
				{else}
					{translate key=NoContactLabel}
				{/if}
			</li>
			<li>
				{translate key=Location}
				{if $locationInformation neq ''}
					{$locationInformation}
				{else}
					{translate key=NoLocationLabel}
				{/if}
			</li>
			<li>
				{if $minimumDuration neq ''}
					{translate key='ResourceMinLength' args=$minimumDuration}
				{else}
					{translate key='ResourceMinLengthNone'}
				{/if}
			</li>
			<li>
				{if $maximumDuration neq ''}
					{translate key='ResourceMaxLength' args=$maximumDuration}
				{else}
					{translate key='ResourceMaxLengthNone'}
				{/if}
			</li>
			<li>
				{if $requiresApproval}
					{translate key='ResourceRequiresApproval'}
				{else}
					{translate key='ResourceRequiresApprovalNone'}
				{/if}
			</li>
			<li>
				{if $autoAssign}
					{translate key='ResourcePermissionAutoGranted'}
				{else}
					{translate key='ResourcePermissionNotAutoGranted'}
				{/if}
			</li>
			<li>
				{if $minimumNotice neq ''}
					{translate key='ResourceMinNotice' args=$minimumNotice}
				{else}
					{translate key='ResourceMinNoticeNone'}
				{/if}
			</li>
			<li>
				{if $maximumNotice neq ''}
					{translate key='ResourceMaxNotice' args=$maximumNotice}
				{else}
					{translate key='ResourceMaxNoticeNone'}
				{/if}
			</li>
			<li>
				{if $allowMultiday}
					{translate key='ResourceAllowMultiDay'}
				{else}
					{translate key='ResourceNotAllowMultiDay'}
				{/if}
			</li>
			<li>
				{if $maxParticipants neq ''}
					{translate key='ResourceCapacity' args=$maxParticipants}
				{else}
					{translate key='ResourceCapacityNone'}
				{/if}
			</li>
		</ul>
	</div>

	{if $imageUrl neq ''}
		<div style="float:right; width: 320px;">
			<img src="{$imageUrl}" />
		</div>
	{/if}
</div>