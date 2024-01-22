{include file='globalheader.tpl' InlineEdit=true Owl=true}

<div id="page-manage-resources" class="admin-page">
	<div>
		<h1>{translate key='Resources'}</h1>
	</div>

    <div class="panel panel-default filterTable" id="filter-resources-panel">
		<form id="filterForm" class="horizontal-list" role="form" method="get">
			<div class="panel-heading"><span
						class="glyphicon glyphicon-filter"></span> {translate key="Filter"} {showhide_icon}
			</div>
			<div class="panel-body">

                {assign var=groupClass value="col-xs-12 col-sm-4 col-md-3"}

				<div class="form-group {$groupClass}">
					<label for="filterResourceName" class="no-show">{translate key=Resource}</label>
					<input type="text" id="filterResourceName" class="form-control" {formname key=RESOURCE_NAME}
						   value="{$ResourceNameFilter}" placeholder="{translate key=Name}"/>
					<span class="searchclear glyphicon glyphicon-remove-circle" ref="filterResourceName"></span>
				</div>
				<div class="form-group {$groupClass}">
					<label for="filterScheduleId" class="no-show">{translate key=Schedule}</label>
					<select id="filterScheduleId" {formname key=SCHEDULE_ID} class="form-control">
						<option value="">{translate key=AllSchedules}</option>
                        {object_html_options options=$AllSchedules key='GetId' label="GetName" selected=$ScheduleIdFilter}
					</select>
				</div>

				<div class="form-group {$groupClass}">
					<label for="filterResourceType" class="no-show">{translate key=ResourceType}</label>
					<select id="filterResourceType" class="form-control" {formname key=RESOURCE_TYPE_ID}>
						<option value="">{translate key=AllResourceTypes}</option>
                        {object_html_options options=$ResourceTypes key='Id' label="Name" selected=$ResourceTypeFilter}
					</select>
				</div>
				<div class="form-group {$groupClass}">
					<label for="resourceStatusIdFilter" class="no-show">{translate key=ResourceStatus}</label>
					<select id="resourceStatusIdFilter" style="width:auto;" class="form-control inline" {formname key=RESOURCE_STATUS_ID}>
						<option value="">{translate key=AllResourceStatuses}</option>
						<option value="{ResourceStatus::AVAILABLE}">{translate key=Available}</option>
						<option value="{ResourceStatus::UNAVAILABLE}">{translate key=Unavailable}</option>
					</select>
                    {*  NOT WORKING
					<label for="resourceReasonIdFilter" class="no-show">{translate key=Reason}</label>
					<select id="resourceReasonIdFilter" style="width:auto;" class="form-control inline" {formname key=RESOURCE_STATUS_REASON_ID}>
						<option value="">-</option>
					</select>
                    *}
				</div>
				<div class="form-group {$groupClass}">
					<label for="filterCapacity" class="no-show">{translate key=MinimumCapacity}</label>
					<input type="number" min="0" id="filterCapacity" class="form-control" {formname key=MAX_PARTICIPANTS}
						   value="{$CapacityFilter}" placeholder="{translate key=MinimumCapacity}"/>
					<span class="searchclear glyphicon glyphicon-remove-circle" ref="filterCapacity"></span>
				</div>
				<div class="form-group {$groupClass}">
					<label for="filterRequiresApproval" class="no-show">{translate key=ResourceRequiresApproval}</label>
					<select id="filterRequiresApproval" class="form-control" {formname key=REQUIRES_APPROVAL}
							title="{translate key='ResourceRequiresApproval'}">
						<option value="">{translate key='ResourceRequiresApproval'}</option>
                        {html_options options=$YesNoOptions selected=$RequiresApprovalFilter}
					</select>
				</div>
				<div class="form-group {$groupClass}">
					<label for="filterAutoAssign" class="no-show">{translate key=ResourcePermissionAutoGranted}</label>
					<select id="filterAutoAssign" class="form-control" {formname key=AUTO_ASSIGN} title="{translate key='ResourcePermissionAutoGranted'}">
						<option value="">{translate key='ResourcePermissionAutoGranted'}</option>
                        {html_options options=$YesNoOptions selected=$AutoPermissionFilter}
					</select>
				</div>
				<div class="form-group {$groupClass}">
					<label for="filterAllowMultiDay" class="no-show">{translate key=ResourceAllowMultiDay}</label>
					<select id="filterAllowMultiDay" class="form-control" {formname key=ALLOW_MULTIDAY} title="{translate key=ResourceAllowMultiDay}">
						<option value="">{translate key=ResourceAllowMultiDay}</option>
                        {html_options options=$YesNoOptions selected=$AllowMultiDayFilter}
					</select>
				</div>
				<div class="clearfix"></div>
                {foreach from=$AttributeFilters item=attribute}
                    {control type="AttributeControl" idPrefix="search" attribute=$attribute searchmode=true class="customAttribute filter-customAttribute{$attribute->Id()} {$groupClass}"}
                {/foreach}

			</div>
			<div class="panel-footer">
                {filter_button id="filter" class="btn-sm"}
                {reset_button id="clearFilter" class="btn-sm"}
			</div>
		</form>
	</div>

    {pagination pageInfo=$PageInfo showCount=true}

	<div id="globalError" class="error no-show"></div>

    {if !empty($Resources)}
        <div class="panel panel-default admin-panel" id="list-resources-panel">
            <div class="panel-body no-padding" id="resourceList" style="margin-top:20px">
                {foreach from=$Resources item=resource}
                    {assign var=id value=$resource->GetResourceId()}
                    <div class="resourceDetails" data-resourceId="{$id}">
                        <div class="col-xs-12 col-sm-5">
                            <input type="hidden" class="id" value="{$id}"/>

                            <div class="col-sm-3 col-xs-6 resourceImage">
                                <div class="margin-bottom-25">
                                    {if $resource->HasImage()}
                                        <div class="owl-carousel owl-theme">
                                            <div class="item">
                                                <img src="{resource_image image=$resource->GetImage()}" alt="Resource Image" class="image"/>
                                            </div>
                                            {foreach from=$resource->GetImages() item=image}
                                                <div class="item">
                                                    <img src="{resource_image image=$image}" alt="Resource Image" class="image"/>
                                                </div>
                                            {/foreach}
                                        </div>
                                        <br/>
                                    {else}
                                        <div class="noImage"><span class="fa fa-image"></span></div>
                                    {/if}
                                </div>
                                <div>
                                    {translate key=ResourceColor}
                                    <input class="resourceColorPicker" type="color"
                                        value='{if $resource->HasColor()}{$resource->GetColor()}{else}#ffffff{/if}'
                                        alt="{translate key=ResourceColor}"
                                        title="{translate key=ResourceColor}"/>
                                </div>
                            </div>

                            <div class="col-sm-9 col-xs-6">
                                <div>
                                <span class="title resourceName" data-type="text" data-pk="{$id}"
                                    data-name="{FormKeys::RESOURCE_NAME}">{$resource->GetName()}</span>
                                </div>
                                <div>
                                    {translate key='Status'}
                                    {if $resource->IsAvailable()}
                                        {html_image src="status.png"}
                                        <b>{translate key='Available'}</b>
                                    {elseif $resource->IsUnavailable()}
                                        {html_image src="status-away.png"}
                                        <b>{translate key='Unavailable'}</b>
                                    {else}
                                        {html_image src="status-busy.png"}
                                        <b>{translate key='Hidden'}</b>
                                    {/if}

                                    {if array_key_exists($resource->GetStatusReasonId(),$StatusReasons)}
                                        <span class="statusReason">{$StatusReasons[$resource->GetStatusReasonId()]->Description()}</span>
                                    {/if}
                                </div>

                                <div>
                                    {translate key='Schedule'}
                                    <span class="propertyValue scheduleName"
                                        data-type="select" data-pk="{$id}" data-value="{$resource->GetScheduleId()}"
                                        data-name="{FormKeys::SCHEDULE_ID}">{$Schedules[$resource->GetScheduleId()]->GetName()}</span>
                                </div>

                                <div>
                                    {translate key='ResourceType'}
                                    <span class="propertyValue resourceTypeName"
                                        data-type="select" data-pk="{$id}" data-value="{$resource->GetResourceTypeId()}"
                                        data-name="{FormKeys::RESOURCE_TYPE_ID}">
                                        {if $resource->HasResourceType()}
                                            {$ResourceTypes[$resource->GetResourceTypeId()]->Name()}
                                        {else}
                                            {translate key='NoResourceTypeLabel'}
                                        {/if}
                                    </span>
                                </div>
                                <div>
                                    {translate key=SortOrder}
                                    <span class="propertyValue sortOrderValue"
                                        data-type="number" data-pk="{$id}" data-name="{FormKeys::RESOURCE_SORT_ORDER}">
                                        {$resource->GetSortOrder()|default:"0"}
                                    </span>
                                </div>
                                <div>
                                    {translate key='Location'}
                                    <span class="propertyValue locationValue"
                                        data-type="text" data-pk="{$id}" data-value="{$resource->GetLocation()}"
                                        data-name="{FormKeys::RESOURCE_LOCATION}">
                                        {if $resource->HasLocation()}
                                            {$resource->GetLocation()}
                                        {else}
                                            {translate key='NoLocationLabel'}
                                        {/if}
                                    </span>
                                </div>
                                <div>
                                    {translate key='Contact'}
                                    <span class="propertyValue contactValue"
                                        data-type="text" data-pk="{$id}" data-value="{$resource->GetContact()}"
                                        data-name="{FormKeys::RESOURCE_CONTACT}">
                                        {if $resource->HasContact()}
                                            {$resource->GetContact()}
                                        {else}
                                            {translate key='NoContactLabel'}
                                        {/if}
                                    </span>
                                </div>
                                <div>
                                    {translate key='Description'}
                                    {if $resource->HasDescription()}
                                        {assign var=description value=$resource->GetDescription()}
                                    {else}
                                        {assign var=description value=''}
                                    {/if}
                                    {strip}
                                        <div class="descriptionValue"
                                            data-type="textarea" data-pk="{$id}" data-value="{$description|escape}"
                                            data-name="{FormKeys::RESOURCE_DESCRIPTION}">
                                            {if $resource->HasDescription()}
                                                {$description}
                                            {else}
                                                {translate key='NoDescriptionLabel'}
                                            {/if}
                                        </div>
                                    {/strip}
                                </div>
                                <div>
                                    {translate key='Notes'}
                                    {if $resource->HasNotes()}
                                        {assign var=notes value=$resource->GetNotes()}
                                    {else}
                                        {assign var=notes value=''}
                                    {/if}
                                    {strip}
                                        <div class="notesValue"
                                            data-type="textarea" data-pk="{$id}" data-value="{$notes|escape}"
                                            data-name="{FormKeys::RESOURCE_NOTES}">
                                            {if $resource->HasNotes()}
                                                {$notes}
                                            {else}
                                                {translate key='NoNotesLabel'}
                                            {/if}
                                        </div>
                                    {/strip}
                                </div>
                                <div>
                                    {translate key='ResourceAdministrator'}
                                    <span class="propertyValue resourceAdminValue"
                                        data-type="select" data-pk="{$id}" data-value="{$resource->GetAdminGroupId()}"
                                        data-name="{FormKeys::RESOURCE_ADMIN_GROUP_ID}">{$ResourceAdminGroup[$resource->GetAdminGroupId()]->Name}</span>
                                </div>
                                
                            </div>

                        </div>


                        <div class="col-xs-12 col-sm-7">
                            <div class="col-sm-6 col-xs-12">
                                <h5 class="inline">{translate key=Duration}</h5>

                                <div class="durationPlaceHolder">
                                    {include file="Admin/Resources/manage_resources_duration.tpl" resource=$resource}
                                </div>

                                {if $CreditsEnabled}
                                    <div>
                                        <h5 class="inline">{translate key='Credits'}</h5>

                                        <div class="creditsPlaceHolder">
                                            {include file="Admin/Resources/manage_resources_credits.tpl" resource=$resource}
                                        </div>
                                    </div>
                                {/if}

                                <div style="margin-top: 10px;">
                                    <h5 class="inline">{translate key='Capacity'}</h5>

                                    <div class="capacityPlaceHolder">
                                        {include file="Admin/Resources/manage_resources_capacity.tpl" resource=$resource}
                                    </div>
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <h5 class="inline">{translate key=Access}</h5>

                                <div class="accessPlaceHolder">
                                    {include file="Admin/Resources/manage_resources_access.tpl" resource=$resource}
                                </div>
                            </div>

                            <div class="col-sm-6 col-xs-12">
                                <h5 class="inline">{translate key='PermissionType'}</h5>
                                <div class="resourcePermissionTypePlaceHolder">
                                    {if $ResourcePermissionTypes[$resource->GetId()] == 0}
                                        {translate key=FullAccess}
                                    {else}
                                        {translate key=ViewOnly}
                                    {/if}
                                </div>
                            </div>


                            <div class="col-sm-6 col-xs-12" style="margin-top:10px">
                                <h5 class="inline">{translate key='ResourceGroups'}</h5>
                                <div class="resourceGroupsPlaceHolder">
                                    {if $resource->GetResourceGroupIds()|default:array()|count == 0}
                                        {translate key=None}
                                    {/if}
                                    {foreach from=$resource->GetResourceGroupIds() item=resourceGroupId name=eachGroup}
                                        <span class="resourceGroupId" data-value="{$resourceGroupId}">{$ResourceGroup[$resourceGroupId]->name}</span>{if !$smarty.foreach.eachGroup.last}, {/if}
                                    {/foreach}
                                </div>
                                <div class="clearfix">&nbsp;</div>
                            </div>
                            
                            <div class="col-sm-6 col-xs-12">&nbsp;</div>
                            

                        </div>

                        <div class="clearfix"></div>
                        <div class="customAttributes">
                            {if $AttributeList|default:array()|count > 0}
                                {foreach from=$AttributeList item=attribute}
                                    {include file='Admin/InlineAttributeEdit.tpl' id=$id attribute=$attribute value=$resource->GetAttributeValue($attribute->Id())}
                                {/foreach}
                            {/if}
                        </div>
                        <div class="clearfix"></div>
                    </div>
                {/foreach}
            </div>
        </div>
    {else}
		<h3 style="text-align:center">{translate key='NoResourcesToView'}</h3>
    {/if}

    {csrf_token}

    {include file="javascript-includes.tpl" InlineEdit=true Owl=true Clear=true}
    {jsfile src="ajax-helpers.js"}
    {jsfile src="autocomplete.js"}
    {jsfile src="js/tree.jquery.js"}
    {jsfile src="admin/resource.js"}
    {jsfile src="dropzone.js"}

	<script type="text/javascript">

		$(document).ready(function () {
		    $('#filter-resources-panel').showHidePanel();

			$(".owl-carousel").owlCarousel({
				items: 1
			});
		});

	</script>
</div>

{pagination pageInfo=$PageInfo showCount=true}

{include file='globalfooter.tpl'}
