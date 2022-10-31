<{assign var="show_result" value=true}>
<{assign var="show_note" value=""}>

<{if $is_bind && !$ok_bind_val}>
    <{assign var="show_result" value=false }>
    <{if $xoops_isuser}>
        <{assign var="show_note" value=$smarty.const._MD_TADSEARCH_INCOMPATIBLE }>
    <{else}>
        <{assign var="show_note" value=$smarty.const._MD_TADSEARCH_NEED_LOGIN}>
    <{/if}>
<{/if}>


<{if $is_search && !$key_value}>
    <{assign var="show_result" value=false }>
    <{assign var="show_note" value=$smarty.const._MD_TADSEARCH_NEED_KEY_IN}>
<{/if}>

<div class="row">
    <div class="col-lg-6">
        <h2 class="my">
        <span data-toggle="tooltip" title="<{$uid_name}> last published in <{$update_date}>"><{$title}></span>
        </h2>
    </div>
    <div class="col-lg-6 text-right text-end">
        <{if $smarty.session.tad_search_adm}>
            <a href="javascript:tad_search_destroy_func(<{$id}>);" class="btn btn-sm btn-danger" data-toggle="tooltip" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-times" aria-hidden="true"></i></a>
            <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?op=tad_search_create&id=<{$id}>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil" aria-hidden="true"></i> <{$smarty.const._TAD_EDIT}></a>
            <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?op=tad_search_add" class="btn btn-sm btn-primary" data-toggle="tooltip" title="<{$smarty.const._TAD_ADD}>"><i class="fa fa-plus" aria-hidden="true"></i> <{$smarty.const._TAD_ADD}></a>
            <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/excel_export.php?id=<{$id}>" class="btn btn-sm btn-success" data-toggle="tooltip" title="<{$smarty.const._MD_TADSEARCH_EXPORT_EXCEL}>"><i class="fa fa-file-excel-o " aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_EXPORT_EXCEL}></a>
        <{/if}>
        <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/" class="btn btn-sm btn-info" data-toggle="tooltip" title="<{$smarty.const._TAD_TO_MOD}>"><i class="fa fa-home" aria-hidden="true"></i> <{$smarty.const._TAD_TO_MOD}></a>
    </div>
</div>

<{if $content}>
    <div class="my-border">
        <{$content}>
    </div>
<{/if}>

<{if $show_note}>
    <div class="alert alert-warning p-3">
        <h3 class="m-0"><{$show_note}></h3>
    </div>
<{/if}>

<{if $is_search}>
<form action="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php" method="post" id="searchForm<{$id}>">
    <div class="row">
        <{foreach from=$search_form key=key item=col_form name=search_form}>
            <div class="col-md-auto my-1">
                <div class="input-group" data-toggle="tooltip" title="<{$col_form.placeholder}>">
                    <div class="input-group-prepend input-group-addon">
                        <span class="input-group-text" style="background-color: <{$col_form.color}>;"><{$col_form.title}></span>
                    </div>
                    <input type="text" name="key_value[<{$key}>]" class="form-control <{$col_form.require}>" placeholder="<{$col_form.placeholder}>" value="<{$key_value.$key}>">
                </div>
            </div>
        <{/foreach}>
        <div class="col-md-auto my-1">
            <div class="input-group">
                <input type="hidden" name="id" value="<{$id}>">
                <div class="input-group-append input-group-btn">
                    <button type="submit" class="btn btn-primary">
                    <i class="fa fa-search" aria-hidden="true"></i> <{$smarty.const._TAD_SEARCH}>
                    </button>
                </div>
            </div>
        </div>
    </div>
</form>
<{/if}>

<{if $show_result}>
    <{$BootstrapTable}>

    <table
    data-toggle="table"
    data-pagination="true"
    data-search="true"
    data-mobile-responsive="true"
    data-title="<{$title}>"
    data-filter-control="true"
    data-show-search-clear-button="true">
        <thead>
            <tr>
            <{foreach from=$heads key=k item=head}>
                <{if $hide_col.$k!=1}>
                <th data-field="col-<{$k}>" data-sortable="true"  <{if $filter_col.$k==1}>data-filter-control="select"<{/if}>><{$head}></th>
                <{/if}>
            <{/foreach}>
            </tr>
        </thead>
        <tbody>
        <{foreach from=$contents key=row item=data_arr}>
            <tr id="tr-id-<{$row}>" class="tr-class-<{$row}>">
            <{foreach from=$data_arr key=k item=data}>
                <{if $hide_col.$k!=1}>
                    <td id="td-id-<{$row}>-<{$k}>" class="td-class-<{$row}>-<{$k}>">
                        <{if $all_ok.$k}>
                            <{if $name_col.$k && !$xoops_isuser }>
                                <{$data|substr_replace:'O':3:3}>
                            <{elseif $data|substr:0:4 == "http"}>
                                <a href="<{$data}>" target="_blank"><{$data}></>
                            <{else}>
                                <{$data}>
                            <{/if}>
                        <{else}>
                            <span class="text-muted"><{$smarty.const._MD_TADSEARCH_NO_VIEW_PRIVILEGES}></span>
                        <{/if}>
                    </td>
                <{/if}>
            <{/foreach}>
            </tr>
        <{/foreach}>
        </tbody>
    </table>

    <{if $is_bind && $ok_bind_val}>
        <span class="badge badge-warning bg-warning text-dark" style="font-size: 1rem; font-weight: normal;"><{$smarty.const._MD_TADSEARCH_BOUND_TO}><{$ok_bind_val}></span>
    <{/if}>

<{/if}>
