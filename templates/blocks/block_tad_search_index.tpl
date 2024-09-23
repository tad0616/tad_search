<{if $block.content|default:false}>
    <ul class="vertical_menu">
        <{foreach from=$block.content item=data}>
            <li>
                <a href="<{$xoops_url}>/modules/<{$block.mod_name}>/index.php?id=<{$data.id}>"><{$data.title}></a>
            </li>
        <{/foreach}>
    </ul>
<{/if}>