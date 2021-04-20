{include file='globalheader.tpl' HideNavBar=true}

<div id="page-monitor-display">
    {if $Enabled}
    <div id="monitor-display-configuration">
        <a href="#" data-toggle="collapse" data-target="#configuration-options"
           title="{translate key=ChangeConfiguration}"><i class="fa fa-cog"></i></a>

        <div class="collapse" id="configuration-options">
            <div class="row">
                <div class="col-xs-3">
                    <div class="form-group">
                        <label for="schedules">{translate key=Schedule}</label>
                        <select class="form-control" title="{translate key=Schedules}" id="schedules">
                            {foreach from=$Schedules item=schedule}
                                <option value="{$schedule->GetId()}"
                                        {if $schedule->GetIsDefault()}selected="selected"{/if}>{$schedule->GetName()}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>
                <div class="col-xs-3">
                    <div class="form-group">
                        <label for="resources">{translate key=Resource}</label>
                        <select class="form-control" title="{translate key=Resource}" id="resources">
                            <option selected="selected" value="-1">-- {translate key=AllResources} --</option>
                            {foreach from=$Resources item=resource}
                                <option value="{$resource->GetId()}">{$resource->GetName()}</option>
                            {/foreach}
                        </select>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="form-group">
                        <label for="format">{translate key=Format}</label>
                        <select class="form-control" title="{translate key=Format}" id="format">
                            <option selected="selected" value="1">{translate key=Grid}</option>
                            <option value="2">{translate key=List}</option>
                        </select>
                    </div>
                </div>

                <div class="col-xs-3">
                    <div class="form-group">
                        <label for="days">{translate key=NumberOfDaysVisible}</label>
                        <select class="form-control" title="{translate key=NumberOfDaysVisible}" id="days">
                            <option selected="selected" value="1">1</option>
                            <option value="2">2</option>
                            <option value="3">3</option>
                            <option value="4">4</option>
                            <option value="5">5</option>
                            <option value="6">6</option>
                            <option value="7">7</option>
                        </select>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="monitor-display-schedule">

    </div>
    {else}
        <div class="alert alert-danger">To enable the monitor display, set view.schedules to true in your application configuration</div>
    {/if}
</div>


{include file="javascript-includes.tpl"}
{jsfile src="ajax-helpers.js"}
{jsfile src="monitor-display.js"}

<script type="text/javascript">

    $(function () {
        var monitorDisplay = new MonitorDisplay( {
            resourcesUrl: '{$smarty.server.SCRIPT_NAME}?dr=resources&sid=',
            scheduleUrl:  '{$smarty.server.SCRIPT_NAME}?dr=schedule&sid=[sid]&rid=[rid]&format=[format]&d=[days]'
        });
        monitorDisplay.init();
    });
</script>

{include file='globalfooter.tpl'}
