{**
* 2014 Easymarketing AG
*
* NOTICE OF LICENSE
*
* This source file is subject to the Open Software License (OSL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/osl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to info@easymarketing.de so we can send you a copy immediately.
*
* @author    silbersaiten www.silbersaiten.de <info@silbersaiten.de>
* @copyright 2018 Easymarketing AG
* @license   http://opensource.org/licenses/osl-3.0.php Open Software License (OSL 3.0)
*}
<table cellspacing="0" cellpadding="0" class="table">
    <tr>
	    <th>{l s='Field name' mod='emarketing'}</th>
	    <th>{l s='Mapped to' mod='emarketing'}</th>
    </tr>

    {foreach from=$attributes item=field}
	<tr>
	    <td>{$field|escape:'htmlall':'UTF-8'}</td>
	    <td>
		<select name="attributesmapping[{$field|escape:'htmlall':'UTF-8'}][id_attribute_group]">
		    <option value="0">--{l s='Please select attribute group or feature' mod='emarketing'}--</option>

			{if isset($attributes_res['attributes'])}
				<option value="" disabled="disabled" style="font-weight: bold;">--{l s='Attributes' mod='emarketing'}--</option>
				{foreach from=$attributes_res['attributes'] item=attr key=id_attribute_group}
					<option value="{$id_attribute_group|escape:'htmlall':'UTF-8'}" {if isset($attributes_map->{$field}) && $attributes_map->{$field}->id_attribute_group == $id_attribute_group}selected="selected"{/if}>{$attr.name|escape:'htmlall':'UTF-8'}</option>
				{/foreach}
			{/if}

			{if isset($attributes_res['features'])}
				<option value="" disabled="disabled" style="font-weight: bold;">--{l s='Features' mod='emarketing'}--</option>
				{foreach from=$attributes_res['features'] item=feature key=id_feature}
					<option value="{$id_feature|escape:'htmlall':'UTF-8'}" {if isset($attributes_map->{$field}) && $attributes_map->{$field}->id_attribute_group == $id_feature}selected="selected"{/if}>{$feature.name|escape:'htmlall':'UTF-8'}</option>
				{/foreach}
			{/if}

		</select>
	    </td>
	</tr>
    {/foreach}
</table>