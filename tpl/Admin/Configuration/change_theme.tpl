{*
Copyright 2013-2015 Nick Korbel

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
{include file='globalheader.tpl' cssFiles='css/admin.css,scripts/css/colorbox.css'}

<h1>{translate key=LookAndFeel}</h1>

<div id="successMessage" style="display:none;" class="success">
    {translate key=ThemeUploadSuccess}
</div>

<div class="validationSummary error" id="validationErrors">
	<ul>
		{async_validator id="logoFileExt"}
		{async_validator id="cssFileExt"}
		{async_validator id="logoFile"}
		{async_validator id="cssFile"}
	</ul>
</div>

<form id="elementForm" action="{$smarty.server.SCRIPT_NAME}" ajaxAction="update" method="post">
    <h4>{translate key="Logo"} (*.png, *.gif, *.jpg)</h4>
    <input type="file" {formname key=LOGO_FILE} size="100"/> <a href="#" class="clearInput">{html_image src="cross-button.png"}</a><br/><br/>

    <h4>{translate key="CssFile"} (*.css)</h4>
    <input type="file" {formname key=CSS_FILE} size="100"/> <a href="#" class="clearInput">{html_image src="cross-button.png"}</a><br/><br/>
    <button type="button" class="button update" name="{Actions::SAVE}" id="saveButton">
        {html_image src="disk-black.png"} {translate key='Update'}
    </button>
</form>

<div id="modalDiv" style="display:none;text-align:center; top:15%;position:relative;">
    <h3>{translate key=Working}</h3>
{html_image src="reservation_submitting.gif"}
</div>

{jsfile src="admin/edit.js"}
{jsfile src="js/jquery.form-3.09.min.js"}
{jsfile src="js/ajaxfileupload.js"}
{jsfile src="js/jquery.colorbox-min.js"}
{jsfile src="ajax-form-submit.js"}

<script type="text/javascript">
	$('document').ready(function(){
		$('#elementForm').bindAjaxSubmit($('#saveButton'), $('#successMessage'), $('#modalDiv'));

		$('.clearInput').click(function(e){
			e.preventDefault();
			$(this).prev('input').val('');
		});
    });

</script>

{include file='globalfooter.tpl'}