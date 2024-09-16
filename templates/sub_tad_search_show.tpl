<{assign var="show_result" value=true}>
<{assign var="show_note" value=""}>

<{if $is_bind && !$ok_bind_val}>
    <{assign var="show_result" value=false }>
    <{if $xoops_isuser|default:false}>
        <{assign var="show_note" value=$smarty.const._MD_TADSEARCH_INCOMPATIBLE }>
    <{else}>
        <{assign var="show_note" value=$smarty.const._MD_TADSEARCH_NEED_LOGIN}>
    <{/if}>
<{/if}>

<{if $is_search && !$key_value}>
    <{assign var="show_result" value=false }>
    <{assign var="show_note" value=$smarty.const._MD_TADSEARCH_NEED_KEY_IN}>
<{/if}>
<{if $smarty.session.tad_search_adm|default:false && $show_tools|default:false || !$smarty.session.single_mode|default:false && !$from_block}>
    <div class="row">
        <div class="col-lg-6">
            <h2 class="my">
                <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?id=<{$id}>" data-toggle="tooltip" title="<{$uid_name}> last published in <{$update_date}>" class="my"><{$title}></a>
            </h2>
        </div>
        <div class="col-lg-6 text-right text-end">
            <{if $smarty.session.tad_search_adm|default:false && $show_tools|default:false}>
                <a href="javascript:tad_search_destroy_func(<{$id}>);" class="btn btn-sm btn-danger" data-toggle="tooltip" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-times" aria-hidden="true"></i></a>
                <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?op=tad_search_create&id=<{$id}>" class="btn btn-sm btn-warning" data-toggle="tooltip" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil" aria-hidden="true"></i> <{$smarty.const._TAD_EDIT}></a>
                <{if $smarty.session.tad_search_adm|default:false && $smarty.session.single_mode==0}>
                <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?op=tad_search_add" class="btn btn-sm btn-primary" data-toggle="tooltip" title="<{$smarty.const._TAD_ADD}>"><i class="fa fa-plus" aria-hidden="true"></i> <{$smarty.const._TAD_ADD}></a>
                <{/if}>
                <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/excel_export.php?id=<{$id}>" class="btn btn-sm btn-success" data-toggle="tooltip" title="<{$smarty.const._MD_TADSEARCH_EXPORT_EXCEL}>"><i class="fa fa-file-excel-o " aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_EXPORT_EXCEL}></a>
            <{/if}>

            <{if !$smarty.session.single_mode|default:false && !$from_block }>
                <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/" class="btn btn-sm btn-info" data-toggle="tooltip" title="<{$smarty.const._TAD_TO_MOD}>"><i class="fa fa-home" aria-hidden="true"></i> <{$smarty.const._TAD_TO_MOD}></a>
            <{/if}>
        </div>
    </div>
<{else}>
    <h2 class="my">
        <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?id=<{$id}>" data-toggle="tooltip" title="<{$uid_name}> last published in <{$update_date}>" class="my"><{$title}></a>
    </h2>
<{/if}>


<{if $can_view|default:false}>
    <{if $content|default:false}>
        <div class="my-border">
            <{$content}>
        </div>
    <{/if}>

    <{if $show_tools|default:false}>
        <{if $can_view|default:false}>
            <span class="mx-2 my-2"><i class="fa fa-search" aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_CAN_VIEW}></span>
        <{/if}>

        <{if $can_add|default:false}>
            <span class="mx-2 my-2"><i class="fa fa-plus-square" aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_CAN_ADD}></span>
        <{/if}>

        <{if $can_modify|default:false}>
            <span class="mx-2 my-2"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_CAN_MODIFY}></span>
        <{/if}>

        <{if $can_del|default:false}>
            <span class="mx-2 my-2"><i class="fa fa-trash-o" aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_CAN_DEL}></span>
        <{/if}>
    <{/if}>


    <{if $show_note|default:false}>

        <{if $can_modify && $show_tools}>
            <{if (isset($smarty.get.mode) && $smarty.get.mode=="edit")}>
                <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?id=<{$id}>" class="btn btn-success btn-sm my-2"><i class="fa fa-eyes" aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_VIEW_MODE}></a>
            <{else}>
                <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?id=<{$id}>&mode=edit" class="btn btn-warning btn-sm my-2"><i class="fa fa-pencil" aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_MODIFY_MODE}></a>
            <{/if}>
        <{/if}>

        <div class="alert alert-warning p-3">
            <h3 class="m-0"><{$show_note}></h3>
        </div>
    <{/if}>

    <{if $is_search|default:false}>
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

    <{if $show_result || (isset($smarty.get.mode) && $smarty.get.mode=="edit")}>
        <{$BootstrapTable}>
        <{if ($can_modify || $can_add || $my_row) && $show_tools && (isset($smarty.get.mode) && $smarty.get.mode=="edit")}>
            <{$Bootstrap3EditableCode}>
        <{/if}>

        <{if ($can_del || $can_add || $my_row) && $show_tools && (isset($smarty.get.mode) && $smarty.get.mode=="edit")}>
            <button type="button" id="del_button" class="btn btn-danger btn-sm my-2"><i class="fa fa-times" aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_DEL_DATA}></button>
        <{/if}>

        <{if $can_add && $show_tools && (isset($smarty.get.mode) && $smarty.get.mode=="edit")}>
            <button type="button" id="add_button" class="btn btn-primary btn-sm my-2"><i class="fa fa-plus-square" aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_ADD_DATA}></button>
        <{/if}>

        <{if $can_modify && $show_tools}>
            <{if (isset($smarty.get.mode) && $smarty.get.mode=="edit")}>
                <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?id=<{$id}>" class="btn btn-success btn-sm my-2"><i class="fa fa-eyes" aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_VIEW_MODE}></a>
            <{else}>
                <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?id=<{$id}>&mode=edit" class="btn btn-warning btn-sm my-2"><i class="fa fa-pencil" aria-hidden="true"></i> <{$smarty.const._MD_TADSEARCH_MODIFY_MODE}></a>
            <{/if}>
        <{/if}>



        <table
        id="<{$table_id}>"
        <{if ($can_modify || $can_add || $my_row) && $show_tools && (isset($smarty.get.mode) && $smarty.get.mode=="edit")}>
        data-editable-emptytext="<{$smarty.const._MD_TADSEARCH_EMPTY}>"
        data-editable-url="ajax.php"
        data-editable-params="{op:'update_value', id:'<{$id}>'}"<{/if}>>
        </table>


        <script>
            var data = <{$json}>;

            var $table = $('#<{$table_id}>');
            const myData = [<{','|implode:$my_row}>];

            $(function() {
                $table.bootstrapTable({
                    idField: 'pkid',
                    toggle: 'table',
                    pagination: true,
                    pageSize: 10,
                    pageList: "[5, 10, 25, 50, 100, 200, All]",
                    multipleSelectRow: true,
                    clickToSelect: true,
                    mobileResponsive: true,
                    checkOnInit: true,
                    <{if $show_search_box|default:false}>search: true,
                    <{if !$can_modify && !$my_row}>searchHighlight: true,<{/if}>
                    <{else}>search: false,<{/if}>
                    title: '<{$title}>',
                    <{if $filter_col|default:false}>
                        filterControl: true,
                    <{/if}>
                    control: true,
                    hideColumn:'pkid',
                    columns: [
                        <{if ($can_del || $can_add) && $show_tools && (isset($smarty.get.mode) && $smarty.get.mode=="edit")}>
                        {
                            field: 'state',
                            title: '',
                            checkbox: true<{if !$can_del}>,
                            formatter:function(value, row, index) {
                                if (myData.includes(row.pkid)) {
                                    return {disabled:false};
                                }
                                return {disabled: true};
                            }<{/if}>
                        },
                        <{/if}>
                        {
                            field: 'pkid',
                            title: '<{$smarty.const._MD_TADSEARCH_ID}>',
                            visible: false,
                            sortable: true,
                            editable: false,
                        },

                        <{foreach from=$heads key=k item=head}>
                            {
                                field: '<{$k}>',
                                title: '<{$head}>',
                                <{if $hide_col.$k!=1}>
                                visible: true,
                                <{else}>
                                visible: false,
                                <{/if}>
                                <{if $filter_col.$k==1}>
                                    filterControl: 'select',
                                <{/if}>
                                <{if ($can_modify || $can_add || $my_row) && $show_tools && (isset($smarty.get.mode) && $smarty.get.mode=="edit")}>
                                editable: {
                                    type: 'text'<{if !$can_modify}>,
                                    noEditFormatter: function(value, row, index) {
                                        if (myData.includes(row.pkid)) {
                                            return false;
                                        }
                                        if (value ===''){
                                            return ' ';
                                        }
                                        return value;
                                    }<{/if}>
                                },
                                <{/if}>
                                sortable: true
                            },
                        <{/foreach}>
                        ],
                    data: data
                });
            });


            <{if ($can_add || $my_row) && $show_tools && (isset($smarty.get.mode) && $smarty.get.mode=="edit")}>
                <{assign var="newID" value=$total+10}>

                $('#add_button').click(function () {
                    $.post("ajax.php",{op:'add_data', id: <{$id}>},function(pkid){
                        $table.bootstrapTable('insertRow', {
                            index: 0,
                            row: {
                                'state':'',
                                'pkid': pkid,
                                <{foreach from=$heads key=k item=head name=head_col}>
                                    <{if $hide_col.$k!=1}>
                                        '<{$k}>':'<{$smarty.const._MD_TADSEARCH_FILL}><{$head}>'<{if !$smarty.foreach.head_col.last}>,<{/if}>
                                    <{/if}>
                                <{/foreach}>
                            }
                        });
                        // 重新載入頁面
                        window.location.reload();
                    });
                });

            <{/if}>

            <{if ($can_del || $can_add || $my_row) && $show_tools}>
                $('#del_button').click(function () {
                    const myData = [<{','|implode:$my_row}>];
                    var ids = $.map($table.bootstrapTable('getSelections'), function (row) {
                        <{if $can_del|default:false}>
                            return row.pkid;
                        <{else}>
                            if (myData.includes(row.pkid)) {
                                return row.pkid;
                            }
                        <{/if}>
                    });

                    $.post("ajax.php",{op:'del_data', id: <{$id}>, ids: ids<{if $can_del|default:false}>, force: 1<{/if}>},function(){
                        $table.bootstrapTable('remove', {
                            field: 'pkid',
                            values: ids
                        });

                        // 重新載入頁面
                        window.location.reload();
                    });
                });
            <{/if}>
        </script>

        <{if $is_bind && $ok_bind_val}>
            <span class="badge badge-warning bg-warning text-dark" style="font-size: 1rem; font-weight: normal;"><{$smarty.const._MD_TADSEARCH_BOUND_TO}><{$ok_bind_val}></span>
        <{/if}>

    <{/if}>
<{else}>

    <div class="alert alert-warning">
        <h2><{$smarty.const._MD_TADSEARCH_CAN_NOT_VIEW}></h2>
    </div>
    <{$can_view}>
<{/if}>