<h4><span id="totalGroups">{$Groups|count}</span> {translate key=Groups} <span class="no-show group-permission-spinner"><i class="fa fa-spinner fa-spin"></i></span> </h4>
{foreach from=$Groups item=g}
    {cycle values='row0,row1' assign=rowCss}
    <div class="{$rowCss} form-group">
        <label for="permission{$g->Id}">{$g->Name}</label>
        <select class="change-permission-type pull-right form-control input-sm inline-block" style="width:auto;" id="permission{$g->Id}" data-group-id="{$g->Id}">
            <option value="{ResourcePermissionType::None}" class="none" {if $g->PermissionType == ResourcePermissionType::None}selected="selected"{/if}>{translate key=None}</option>
            <option value="{ResourcePermissionType::Full}" class="full" {if $g->PermissionType == ResourcePermissionType::Full}selected="selected"{/if}>{translate key=FullAccess}</option>
            <option value="{ResourcePermissionType::View}" class="view" {if $g->PermissionType == ResourcePermissionType::View}selected="selected"{/if}>{translate key=ViewOnly}</option>
        </select>
        <div class="clearfix"></div>
        <input type="hidden" class="id" value="{$g->Id}"/>
    </div>
{/foreach}