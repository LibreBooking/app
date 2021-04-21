<div class="row form-inline">
    <div id="filter">

        {if $GroupName}
        <span class="groupName">{$GroupName}</span>
        {else}
        <div>
            <div class="inline">{indicator id=loadingIndicator}</div>
            <label for="calendarFilter">{translate key="ChangeCalendar"}</label>
            <select id="calendarFilter">
                {foreach from=$filters->GetFilters() item=filter}
                    <option value="s{$filter->Id()}" class="schedule"
                            {if $filter->Selected()}selected="selected"{/if}>{$filter->Name()}</option>
                    {foreach from=$filter->GetFilters() item=subfilter}
                        <option value="r{$subfilter->Id()}" class="resource"
                                {if $subfilter->Selected()}selected="selected"{/if}>{$subfilter->Name()}</option>
                    {/foreach}
                {/foreach}
                {/if}
            </select>
            <a href="#" id="showResourceGroups">{translate key=ResourceGroups}</a>
        </div>
    </div>

    <div id="resourceGroupsContainer">
        <div id="resourceGroups"></div>
    </div>


    {if false}
        <div class="col-xs-12">
            <div class="form-group inline">
                <label for="ownerFilter">{translate key=Owner}</label>
                <input type='search' id='ownerFilter'
                       class="form-control input-sm search" {formname key=OWNER_TEXT} value="{$OwnerText}"/>
                <input {formname key=USER_ID} id="ownerId" type="hidden" value="{$OwnerId}"/>
            </div>
            {if $AllowParticipation}
                <div class="form-group inline">
                    <label for="participantFilter">{translate key=Participant}</label>
                    <input type='search' id='participantFilter'
                           class="form-control input-sm search" {formname key=PARTICIPANT_TEXT}
                           value="{$ParticipantText}"/>
                    <input {formname key=PARTICIPANT_ID} id="participantId" type="hidden" value="{$ParticipantId}"/>
                </div>
            {/if}
            <div class="inline">
                <button id="clearUserFilter" class="btn btn-link">{translate key=Reset}</button>
            </div>
        </div>
    {/if}

</div>

<script type="text/javascript">
    $(function () {
        $('#calendarFilter').select2();
    });

</script>
