<h4><span id="totalUsers">{$Users|count}</span> {translate key=Users} <span class="no-show user-permission-spinner"><i class="fa fa-spinner fa-spin"></i></span> </h4>
{foreach from=$Users item=u}
    {cycle values='row0,row1' assign=rowCss}
    <div class="{$rowCss} form-group">
        <label for="permission{$u->Id}">{fullname first=$u->First last=$u->Last}</label>
        <select class="change-permission-type pull-right form-control input-sm inline-block" style="width:auto;" id="permission{$u->Id}" data-user-id="{$u->Id}">
            <option value="{ResourcePermissionType::None}" class="none" {if $u->PermissionType == ResourcePermissionType::None}selected="selected"{/if}>{translate key=None}</option>
            <option value="{ResourcePermissionType::Full}" class="full" {if $u->PermissionType == ResourcePermissionType::Full}selected="selected"{/if}>{translate key=FullAccess}</option>
            <option value="{ResourcePermissionType::View}" class="view" {if $u->PermissionType == ResourcePermissionType::View}selected="selected"{/if}>{translate key=ViewOnly}</option>
        </select>
        <div class="clearfix"></div>
        <input type="hidden" class="id" value="{$u->Id}"/>
    </div>
{/foreach}