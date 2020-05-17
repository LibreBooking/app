{*
Copyright 2013-2020 Nick Korbel

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

	<div class="col s12 m8 offset-m2">
		<div>
			<div class="right">
				<button class="add-link add-rule-prompt btn btn-flat waves-effect waves-light" id="add-rule-prompt-btn">{translate key="AddRule"}
					<span class="fas fa-plus-circle icon add"></span>
				</button>
			</div>
			<h1 class="page-title underline">{translate key=ReservationColors}</h1>
		</div>

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

	<div class="modal modal-fixed-header modal-fixed-footer" id="add-rule-dialog" tabindex="-1" role="dialog"
		 aria-labelledby="addDialogLabel" aria-hidden="true">
		<form id="addForm" method="post" action="{$smarty.server.SCRIPT_NAME}?action=add" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="addDialogLabel">{translate key=AddReservationColorRule}</h4>
				 {close_modal}
			</div>
			<div class="modal-content">
				<div class="input-field">
					<label for="attributeOption" class="active">{translate key=Attribute}</label>
					<select class="" id="attributeOption" {formname key=ATTRIBUTE_ID}>
                        {foreach from=$Attributes item=attribute}
							<option value="{$attribute->Id()}">{$attribute->Label()}</option>
                        {/foreach}
					</select>
				</div>
				<span>When the attribute value is</span>
				<div id="attribute-list">
                    {foreach from=$Attributes item=attribute}
						<div id="attribute{$attribute->Id()}"
							 class="attribute-option">{control type="AttributeControl" attribute=$attribute searchmode=true}</div>
                    {/foreach}
				</div>
				<span>The reservation color will be</span>
				<div id="color" class="input-field">
					<label for="reservationColor" class="no-show">Reservation Color</label>
					<input type="color" {formname key="RESERVATION_COLOR"} class="form-control required"
						   id="reservationColor" maxlength="6"/>
				</div>
			</div>
			<div class="modal-footer">
                {cancel_button}
                {add_button submit=true}
                {indicator}
			</div>
		</form>
	</div>

	<div class="modal modal-fixed-header modal-fixed-footer" id="deleteDialog" tabindex="-1" role="dialog"
		 aria-labelledby="deleteDialogLabel" aria-hidden="true">
		<form id="deleteForm" action="{$smarty.server.SCRIPT_NAME}?action=delete" method="post">
			<div class="modal-header">
				<h4 class="modal-title left" id="deleteDialogLabel">{translate key=Delete}</h4>
				 {close_modal}
			</div>
			<div class="modal-content">
				<div class="alert alert-warning">
                    {translate key=DeleteWarning}
				</div>
				<input type="hidden" id="deleteRuleId" {formname key=RESERVATION_COLOR_RULE_ID} />
			</div>
			<div class="modal-footer">
                {cancel_button}
                {delete_button submit=true}
                {indicator}
			</div>
		</form>
	</div>

    {csrf_token}


    {include file="javascript-includes.tpl"}

    {jsfile src="ajax-helpers.js"}
    {jsfile src="js/jquery.form-3.09.min.js"}
    {jsfile src="ajax-form-submit.js"}
    {jsfile src="admin/reservation-colors.js"}

	<script type="text/javascript">
		$('document').ready(function () {
			var mgmt = new ReservationColorManagement();
			mgmt.init();

			$('.modal').modal();
		});
	</script>
</div>

{include file='globalfooter.tpl'}