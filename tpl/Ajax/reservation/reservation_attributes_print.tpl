{if $Attributes|default:array()|count > 0}
	{foreach from=$Attributes item=attribute name=attributes}
		 "{$attribute->Id()}" :
		[ "{$attribute->Type()}" ,
		"{$attribute->Label()|escape:'json'}" ,
		{if $attribute->Type() eq '5'}
			"{formatdate date=$attribute->Value() key=embedded_datetime}" ] {if $smarty.foreach.attributes.last}{else},{/if}
		{else}
			"{$attribute->Value()|escape:'json'}" ] {if $smarty.foreach.attributes.last}{else},{/if}
		{/if}
	{/foreach}
{/if}
}
