{*
Copyright 2013-2019 Nick Korbel

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

{include file='globalheader.tpl'}

<div id="page-manage-reservation-colors" class="admin-page">

    <div class="default-box col-xs-12 col-sm-8 col-sm-offset-2">
        <h1>{translate key=ReservationColors}</h1>

        <form class="form-inline" role="form">
            <div class="form-group">
                <label for="attributeOption">{translate key=Attribute}</label>
                <select class="form-control" id="attributeOption">
                    {foreach from=$Attributes item=attribute}
                        <option value="{$attribute->Id()}">{$attribute->Label()}</option>
                    {/foreach}
                </select>

                <button type="button" class="btn btn-success" id="addRuleButton">
                    <i class="fa fa-plus"></i> {translate key='AddRule'}
                </button>
            </div>
        </form>

        <div class="clearfix">&nbsp;</div>

        <table class="table" id="reservationTable">
            <thead>
            <tr>
                <th>{translate key=Attribute}</th>
                <th>{translate key=RequiredValue}</th>
                <th>{translate key=Color}</th>
                <th class="action">{translate key='Delete'}</th>
            </tr>
            </thead>
            <tbody>
            {foreach from=$Rules item=rule}
                {cycle values='row0,row1' assign=rowCss}
                <tr class="{$rowCss}">
                    <td>{$rule->AttributeName}</td>
                    <td>{$rule->RequiredValue}</td>
                    <td style="background-color:{$rule->Color}">&nbsp;</td>
                    <td class="action">
                        <a href="#" class="update delete" ruleId="{$rule->Id}"><span
                                    class="fa fa-trash icon remove fa-1x"></span></a>
                    </td>
                </tr>
            {/foreach}
            </tbody>
        </table>
    </div>

    <div class="modal fade" id="addDialog" tabindex="-1" role="dialog"
         aria-labelledby="addDialogLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="addForm" method="post" action="{$smarty.server.SCRIPT_NAME}?action=add" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="addDialogLabel">{translate key=AddReservationColorRule}</h4>
                    </div>
                    <div class="modal-body">
                        {translate key=ReservationCustomRuleAdd}

                        <div id='attributeFillIn' class='inline-block'></div>
                        <div id="color" class="inline-block">
                            <label for="reservationColor" class="no-show">Reservation Color</label>
                            <input type="color" {formname key="RESERVATION_COLOR"} class="form-control required"
                                   id="reservationColor" maxlength="6"/>
                        </div>
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {add_button}
                        {indicator}
                    </div>
                </div>
            </form>
        </div>
    </div>

    <div class="modal fade" id="deleteDialog" tabindex="-1" role="dialog"
         aria-labelledby="deleteDialogLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="deleteForm" action="{$smarty.server.SCRIPT_NAME}?action=delete" method="post">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="deleteDialogLabel">{translate key=Delete}</h4>
                    </div>
                    <div class="modal-body">
                        <div class="alert alert-warning">
                            {translate key=DeleteWarning}
                        </div>
                        <input type="hidden" id="deleteRuleId" {formname key=RESERVATION_COLOR_RULE_ID} />
                    </div>
                    <div class="modal-footer">
                        {cancel_button}
                        {delete_button}
                        {indicator}
                    </div>
                </div>
            </form>
        </div>
    </div>

    {foreach from=$Attributes item=attribute}
        <div id="attribute{$attribute->Id()}"
             class="hidden">{control type="AttributeControl" attribute=$attribute searchmode=true}</div>
    {/foreach}

    {csrf_token}

</div>

{include file="javascript-includes.tpl"}

{jsfile src="ajax-helpers.js"}
{jsfile src="js/jquery.form-3.09.min.js"}
{jsfile src="ajax-form-submit.js"}
{jsfile src="admin/reservation-colors.js"}

<script type="text/javascript">
    $('document').ready(function () {
        var mgmt = new ReservationColorManagement();
        mgmt.init();
    });
</script>

{include file='globalfooter.tpl'}