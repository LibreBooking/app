{include file='globalheader.tpl' cssFiles='css/admin.css'}

<h1>{translate key=ManageReminders}</h1>

<table class="list">
    <tr>
        <th class="id">&nbsp;</th>
        <th>{translate key='ReminderUser'}</th>
        <th>{translate key='ReminderAddress'}</th>
        <th>{translate key='ReminderMessage'}</th>
        <th>{translate key='ReminderSendtime'}</th>
        <th>{translate key='ReminderRefNumber'}</th>
        <th>{translate key='Actions'}</th>
    </tr>
{foreach from=$reminders item=reminder}
    {cycle values='row0,row1' assign=rowCss}
    <tr class="{$rowCss}">
        <td class="id"><input type="hidden" class="id" value="{$reminder->ReminderId()}"/></td>
        <td>{$reminder->UserId()}</td>
        <td>{$reminder->Address()}</td>
        <td>{$reminder->Message()}</td>
        <td>{$reminder->SendTime()}</td>
        <td>{$reminder->RefNumber()}</td>
        <td align="center"> <a href="#" class="update delete">{translate key='Delete'}</a></td>
    </tr>
{/foreach}
</table>

<input type="hidden" id="activeId" />

<div id="deleteDialog" class="dialog" style="display:none;" title="{translate key=Delete}">
    <form id="deleteForm" method="post">
        <div class="error" style="margin-bottom: 25px;">
            <h3>{translate key=DeleteWarning}</h3>
            <div>{translate key=DeleteReminderWarning}</div>
        </div>
        <button type="button" class="button save">{html_image src="cross-button.png"} {translate key='Delete'}</button>
        <button type="button" class="button cancel">{html_image src="slash.png"} {translate key='Cancel'}</button>
    </form>
</div>

<div class="admin" style="margin-top:30px">
    <div class="title">
    {translate key=AddReminder}
    </div>
    <div>
        <div id="addResults" class="error" style="display:none;"></div>
        <form id="addForm" method="post">
            <table>
                <tr>
                    <th>{translate key='ReminderMessage'}</th>
                    <th>{translate key='ReminderAddress'}</th>
                    <th>{translate key='ReminderSendtimeDate'}</th>
                    <th>{translate key='ReminderSendtimeTime'}</th>
                    <th>{translate key='ReminderSendtimeAMPM'}</th>
                    <th>&nbsp;</th>
                </tr>
                <tr>
                    <td>
                        <input type="text" id="reminderMessage" class="textbox" style="width:250px" {formname key=REMINDER_MESSAGE} />
                    </td>
                    <td>
                        <input type="text" id="reminderAddress" class="textbox" style="width:250px" {formname key=REMINDER_ADDRESS} />
                    </td>
                    <td>
                        <input type="text" id="reminderSendtimeDate" class="textbox" style="width:150px" {formname key=REMINDER_DATE} />
                    </td>
                    <td>
                        <input type="text" id="reminderSendtimeTime" class="textbox" style="width:200px" {formname key=REMINDER_TIME} />
                    </td>
                    <td>
                        <select class="textbox" id="reminderSendtimeAMPM" {formname key=REMINDER_TIME_AMPM}>
                            <option value="AM">AM</option>
                            <option value="PM">PM</option>
                        </select>
                    </td>
                    <td>
                        <button type="button" class="button save">{html_image src="plus-button.png"} {translate key=AddReminder}</button>
                    </td>
                </tr>
            </table>
        </form>
    </div>
</div>

{control type="DatePickerSetupControl" ControlId="reminderSendtimeDate" AltId="formattedSendtime"}
{control type="DatePickerSetupControl" ControlId="reminderEditSendtimeDate" AltId="formattedEditSendtime"}

{html_image src="admin-ajax-indicator.gif" class="indicator" style="display:none;"}

<script type="text/javascript" src="{$Path}scripts/admin/edit.js"></script>
<script type="text/javascript" src="{$Path}scripts/admin/reminder.js"></script>
<script type="text/javascript" src="{$Path}scripts/js/jquery.form-3.09.min.js"></script>

<script type="text/javascript">
    $(document).ready(function() {

        var actions = {
            add: '{ManageReminderActions::Add}',
            edit: '{ManageReminderActions::Change}',
            deleteReminder: '{ManageReminderActions::Delete}'
        };

        var reminderOptions = {
            submitUrl: '{$smarty.server.SCRIPT_NAME}',
            saveRedirect: '{$smarty.server.SCRIPT_NAME}',
            actions: actions
        };

        var reminderManagement = new ReminderManagement(reminderOptions);
        reminderManagement.init();

    {foreach from=$reminders item=reminder}
        reminderManagement.addReminder('{$reminder->ReminderId()}', '{$reminder->UserId()}', '{$reminder->Message()}', '{$reminder->Address()}', '{$reminder->SendTime()}', '{$reminder->RefNumber()}');
    {/foreach}

    });

</script>
{include file='globalfooter.tpl'}