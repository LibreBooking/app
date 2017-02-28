{*
Copyright 2011-2017 Nick Korbel

This file is part of Booked Scheduler.

Booked Scheduler is free software: you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation, either version 3 of the License, or
(at your option) any later version.

Booked Scheduler is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with Booked Scheduler.  If not, see <http://www.gnu.org/licenses/>.
*}
"{translate key='Name'}","{translate key='Status'}","{translate key='Schedule'}","{translate key='ResourceType'}","{translate key='SortOrder'}","{translate key='Location'}","{translate key='Contact'}","{translate key='Description'}","{translate key='Notes'}","{translate key='ResourceAdministrator'}","{translate key='ResourceColor'}","{translate key='ResourceMinLengthCsv'}","{translate key='ResourceMaxLengthCsv'}","{translate key='ResourceBufferTimeCsv'}","{translate key='ResourceAllowMultiDay'}","{translate key='Capacity'}","{translate key='ResourceGroups'}","{translate key='ResourceMinNoticeCsv'}","{translate key='ResourceMaxNoticeCsv'}","{translate key='ResourceRequiresApproval'}","{translate key='ResourcePermissionAutoGranted'}","{translate key='RequiresCheckInNotification'}","{translate key='AutoReleaseMinutes'}","{translate key='CreditsOffPeak'}","{translate key='CreditsPeak'}",{foreach from=$AttributeList item=attr}"{$attr->Label()}",{/foreach}

{foreach from=$Resources item=resource}
"{$resource->GetName()}","{if $resource->IsAvailable()}{translate key='Available'}{elseif $resource->IsUnavailable()}{translate key='Unavailable'}{else}{translate key='Hidden'}{/if}","{$Schedules[$resource->GetScheduleId()]}","{if $resource->HasResourceType()}{$ResourceTypes[$resource->GetResourceTypeId()]->Name()}{/if}",{$resource->GetSortOrder()|default:"0"},"{$resource->GetLocation()}","{$resource->GetContact()}","{$resource->GetDescription()}","{$resource->GetNotes()}","{$GroupLookup[$resource->GetAdminGroupId()]->Name}","{$resource->GetColor()}","{$resource->GetMinLength()}","{$resource->GetMaxLength()}","{$resource->GetBufferTime()}","{$resource->GetAllowMultiday()|default:0}","{$resource->GetMaxParticipants()}","{foreach from=$resource->GetResourceGroupIds() item=resourceGroupId name=eachGroup}{$ResourceGroupList[$resourceGroupId]->name}{if !$smarty.foreach.eachGroup.last}, {/if}{/foreach}","{$resource->GetMinNotice()}","{$resource->GetMaxNotice()}","{$resource->GetRequiresApproval()|default:0}","{$resource->GetAutoAssign()|default:0}","{$resource->IsCheckInEnabled()|default:0}","{$resource->GetAutoReleaseMinutes()}","{$resource->GetCreditsPerSlot()}","{$resource->GetPeakCreditsPerSlot()}",{foreach from=$AttributeList item=attribute}"{$resource->GetAttributeValue($attribute->Id())}",{/foreach}

{/foreach}