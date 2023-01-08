<{assign var="show_result" value=true}>
<{assign var="show_note" value=""}>

<{if $block.content.is_bind && !$block.content.ok_bind_val}>
    <{assign var="show_result" value=false}>
    <{if $xoops_isuser}>
        <{assign var="show_note" value=$smarty.const._MB_TADSEARCH_INCOMPATIBLE }>
    <{else}>
        <{assign var="show_note" value=$smarty.const._MB_TADSEARCH_NEED_LOGIN}>
    <{/if}>
<{/if}>

<{if $block.content.is_search && !$block.content.key_value}>
    <{assign var="show_result" value=false }>
    <{assign var="show_note" value=$smarty.const._MB_TADSEARCH_NEED_KEY_IN}>
<{/if}>

<h2 class="my"><a href="<{$xoops_url}>/modules/<{$block.mod_name}>/index.php?id=<{$block.content.id}>" data-toggle="tooltip" title="<{$block.content.uid_name}> last published in <{$block.content.update_date}>"><{$block.content.title}></a></h2>

<{if $block.content.content}>
    <div class="my-border">
        <{$block.content.content}>
    </div>
<{/if}>


<{if $show_note}>
    <div class="alert alert-warning p-3">
        <h4 class="m-0"><{$show_note}></h4>
    </div>
<{/if}>

<{if $block.content.is_search}>
    <form action="<{$xoops_url}>/modules/<{$block.mod_name}>/index.php" method="post" id="searchForm<{$block.content.id}>">
        <div class="row">
            <{foreach from=$block.content.search_form key=key item=col_form name=search_form}>
                <div class="col-lg-auto my-1">
                    <div class="input-group" data-toggle="tooltip" title="<{$col_form.placeholder}>">
                        <div class="input-group-prepend input-group-addon">
                            <span class="input-group-text" style="background-color: <{$col_form.color}>;"><{$col_form.title}></span>
                        </div>
                        <input type="text" name="key_value[<{$key}>]" class="form-control <{$col_form.require}>" placeholder="<{$col_form.placeholder}>" value="<{$block.content.key_value.$key}>">
                    </div>
                </div>
            <{/foreach}>
            <div class="col-lg-auto my-1">
                <div class="input-group">
                    <input type="hidden" name="id" value="<{$block.content.id}>">
                    <div class="input-group-append input-group-btn">
                        <button type="submit" class="btn btn-primary">
                        <i class="fa fa-search" aria-hidden="true"></i> <{$smarty.const._TAD_SEARCH}>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script language="JavaScript" type="text/javascript">
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
<{/if}>

<{if $show_result}>
    <{$block.content.BootstrapTable}>

    <table
    data-toggle="table"
    data-pagination="true"
    data-search="true"
    data-mobile-responsive="true"
    data-filter-control="true"
    data-show-search-clear-button="true">
        <thead>
            <tr>
            <{foreach from=$block.content.heads key=k item=head}>
                <{if $block.content.hide_col.$k!=1}>
                <th data-field="col-<{$k}>" data-sortable="true" <{if $filter_col.$k==1}>data-filter-control="select"<{/if}>><{$head}></th>
                <{/if}>
            <{/foreach}>
            </tr>
        </thead>
        <tbody>
        <{foreach from=$block.content.contents key=row item=data_arr}>
            <tr id="tr-id-<{$row}>" class="tr-class-<{$row}>">
            <{foreach from=$data_arr key=k item=data}>
                <{if $block.content.hide_col.$k!=1}>
                    <td id="td-id-<{$row}>-<{$k}>" class="td-class-<{$row}>-<{$k}>">
                        <{if $block.content.all_ok.$k}>
                            <{if $name_col.$k && !$xoops_isuser }>
                                <{$data|substr_replace:'O':3:3}>
                            <{elseif $data|substr:0:4 == "http"}>
                                <a href="<{$data}>" target="_blank"><{$data}></a>
                            <{elseif $data|strpos:"|http"!==false}>
                                <{assign var=link_var value="|"|explode:$data}>
                                <a href="<{$link_var.1}>" target="_blank"><{$link_var.0}></a>
                            <{else}>
                                <{$data}>
                            <{/if}>
                        <{else}>
                            <span class="text-muted"><{$smarty.const._MB_TADSEARCH_NO_VIEW_PRIVILEGES}></span>
                        <{/if}>
                    </td>
                <{/if}>
            <{/foreach}>
            </tr>
        <{/foreach}>
        </tbody>
    </table>
    <{if $block.content.is_bind && $block.content.ok_bind_val}>
        <span class="badge badge-warning bg-warning text-dark" style="font-size: 1rem; font-weight: normal;"><{$smarty.const._MB_TADSEARCH_BOUND_TO}><{$block.content.ok_bind_val}></span>
    <{/if}>
<{/if}>