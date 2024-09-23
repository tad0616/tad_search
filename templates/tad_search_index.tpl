<{if $smarty.session.single_mode == 0}>
<{$toolbar|default:''}>
<{/if}>

<{if $now_op|default:false}>
    <{include file="$xoops_rootpath/modules/$tad_search_dirname/templates/op_`$now_op`.tpl"}>
<{/if}>

<script language="JavaScript" type="text/javascript">
    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });
</script>