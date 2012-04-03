{*
Copyright 2011-2012 Nick Korbel

This file is part of phpScheduleIt.

phpScheduleIt is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

phpScheduleIt is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with phpScheduleIt.  If not, see <http://www.gnu.org/licenses/>.
*}
<div id="resourceDetailsPopup" style="padding: 20px; overflow:hidden:">
	<div style="display:inline-block; vertical-align:top; width: 350px;">
		<ul>
			<li>{translate key=Description}
				{if $description neq ''}
					{$description|html_entity_decode|url2link|nl2br}
				{else}
					{translate key=NoDescriptionLabel}
				{/if}
			</li>
			<li>
				{translate key=Notes}
				{if $notes neq ''}
					{$notes|html_entity_decode|url2link|nl2br}
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
	<div style="display:inline-block;">
		<img src="{$imageUrl}" alt="Resource" />
	</div>
{/if}
</div>