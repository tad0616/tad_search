<{if $block|default:false}>
    <{if $block.content|default:false}>
        <{foreach from=$block.content key=var_name item=var_val}>
            <{assign var="$var_name" value=$var_val}>
        <{/foreach}>
    <{/if}>
    <{include file="$xoops_rootpath/modules/`$block.mod_name`/templates/sub_tad_search_show.tpl"
    tad_search_dirname=$block.mod_name table_id="block_table`$block.id`" show_tools=false from_block=true}>
<{/if}>