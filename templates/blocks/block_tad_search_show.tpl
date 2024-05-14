<{foreach from=$block.content key=var_name item=var_val}>
    <{assign var=$var_name value=$var_val}>
<{/foreach}>

<{includeq file="$xoops_rootpath/modules/`$block.mod_name`/templates/sub_tad_search_show.tpl"
 tad_search_dirname=$block.mod_name table_id="block_table`$block.id`" show_tools=false from_block=true}>