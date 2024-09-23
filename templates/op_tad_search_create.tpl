<form action="<{$smarty.server.PHP_SELF}>" method="post" id="myForm" enctype="multipart/form-data" class="form-horizontal">

    <div class="form-group row mb-3">
        <div class="col-md-8">
            <input type="text" name="title" id="title" class="form-control validate[required]" value="<{$title|default:''}>" placeholder="<{$smarty.const._MD_TADSEARCH_TITLE}>">
        </div>

        <!--是否啟用-->
        <div class="col-md-4">
            <div class="form-check-inline checkbox-inline pt-2">
                <label class="form-check-label">
                    <input type="radio" name="enable" id="enable_1" class="form-check-input" value="1" <{if $enable == "1"}>checked="checked"<{/if}>>
                    <{$smarty.const._TAD_ENABLE}>
                </label>
            </div>
            <div class="form-check-inline checkbox-inline pt-2">
                <label class="form-check-label">
                    <input type="radio" name="enable" id="enable_0" class="form-check-input" value="0" <{if $enable == "0"}>checked="checked"<{/if}>>
                    <{$smarty.const._TAD_UNABLE}>
                </label>
            </div>
        </div>
    </div>

    <!--說明-->
    <div class="form-group row mb-3">
        <div class="col-md-12">
            <{$content_editor|default:''}>
        </div>
    </div>

    <div class="form-group row mb-3">
        <div class="col-md-12">
            <div class="vtb">
                <ul id="tad_search_sort" class="vhead">
                    <li class="w20"><{$smarty.const._MD_TADSEARCH_COL}></li>
                    <li class="w10">
                        <{$smarty.const._MD_TADSEARCH_IS_HIDE}>
                        <{include file="$xoops_rootpath/modules/tad_search/templates/sub_tip.tpl" color="success" tip=$smarty.const._MD_TADSEARCH_IS_HIDE_NOTE}>
                    </li>
                    <li class="w10">
                        <{$smarty.const._MD_TADSEARCH_IS_FILTER}>
                        <{include file="$xoops_rootpath/modules/tad_search/templates/sub_tip.tpl" color="success" tip=$smarty.const._MD_TADSEARCH_IS_FILTER_NOTE}>
                    </li>
                    <li class="w20">
                        <{$smarty.const._MD_TADSEARCH_SEARCH_BY_THIS}>
                        <{include file="$xoops_rootpath/modules/tad_search/templates/sub_tip.tpl" color="success" tip=$smarty.const._MD_TADSEARCH_SEARCH_BY_THIS_NOTE}>
                    </li>
                    <li class="w20">
                        <{$smarty.const._MD_TADSEARCH_GROUPS}>
                        <{include file="$xoops_rootpath/modules/tad_search/templates/sub_tip.tpl" color="success" tip=$smarty.const._MD_TADSEARCH_GROUPS_NOTE}>
                    </li>
                    <li class="w20">
                        <{$smarty.const._MD_TADSEARCH_FORMAT}>
                        <{include file="$xoops_rootpath/modules/tad_search/templates/sub_tip.tpl" color="success" tip=$smarty.const._MD_TADSEARCH_FORMAT_NOTE}>
                    </li>
                </ul>
                <{foreach from=$columns_arr key=col_title item=column }>
                    <ul>

                        <!--欄位-->
                        <li class="vcell ">
                            <{$col_title|default:''}> <{$smarty.const._MD_TADSEARCH_COLUMN_SETUP}>
                        </li>
                        <li class="vm w20 blank">
                            <{$col_title|default:''}>
                        </li>

                        <!--是否隱藏-->
                        <li class="vcell light">
                            <span class="vlabel"><{$smarty.const._MD_TADSEARCH_IS_HIDE}></span>
                        </li>
                        <li class="vm c w10">
                            <div class="form-check-inline checkbox-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="columns[<{$col_title|default:''}>][hide]" value="1" <{if $column.hide==1}>checked<{/if}>> <{$smarty.const._MD_TADSEARCH_HIDE}>
                                </label>
                            </div>
                        </li>

                        <!--是否篩選-->
                        <li class="vcell light">
                            <span class="vlabel"><{$smarty.const._MD_TADSEARCH_IS_FILTER}></span>
                        </li>
                        <li class="vm c w10">
                            <div class="form-check-inline checkbox-inline">
                                <label class="form-check-label">
                                    <input class="form-check-input" type="checkbox" name="columns[<{$col_title|default:''}>][filter]" value="1" <{if $column.filter==1}>checked<{/if}>> <{$smarty.const._MD_TADSEARCH_FILTER}>
                                </label>
                            </div>
                        </li>

                        <!--搜尋-->
                        <li class="vcell light">
                            <span class="vlabel"><{$smarty.const._MD_TADSEARCH_SEARCH}></span>
                        </li>
                        <li class="vm c w20">
                            <select name="columns[<{$col_title|default:''}>][search]" class="form-control">
                                <option value="" <{if $column.search == ''}>selected<{/if}>></option>
                                <option value="and same" <{if $column.search == 'and same'}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_AND_SAME}></option>
                                <option value="or same" <{if $column.search == 'or same'}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_OR_SAME}></option>
                                <option value="and like" <{if $column.search == 'and like'}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_AND_LIKE}></option>
                                <option value="or like" <{if $column.search == 'or like'}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_OR_LIKE}></option>
                                <option value="bind email" <{if $column.search == 'bind email'}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_BIND_EMAIL}></option>
                                <option value="bind name" <{if $column.search == 'bind name'}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_BIND_NAME}></option>
                                <option value="bind schoolcode" <{if $column.search == 'bind schoolcode'}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_BIND_SCHOOLCODE}></option>
                            </select>
                        </li>

                        <!--可觀看群組-->
                        <li class="vcell light">
                            <span class="vlabel"><{$smarty.const._MD_TADSEARCH_GROUPS}></span>
                        </li>
                        <li class="vm c w20">
                            <{$group_form.$col_title}>
                        </li>

                        <li class="vcell light">
                            <span class="vlabel"><{$smarty.const._MD_TADSEARCH_FORMAT}></span>
                        </li>
                        <li class="vm c w20">
                            <select name="columns[<{$col_title|default:''}>][type]" class="form-control">
                                <option value="" <{if $column.type == ''}>selected<{/if}>></option>
                                <option value="<{$smarty.const._MD_TADSEARCH_DATE}>" <{if $column.type == $smarty.const._MD_TADSEARCH_DATE}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_DATE}></option>
                                <option value="<{$smarty.const._MD_TADSEARCH_DATETIME}>" <{if $column.type == $smarty.const._MD_TADSEARCH_DATETIME}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_DATETIME}></option>
                                <option value="<{$smarty.const._MD_TADSEARCH_PHONE}>" <{if $column.type == $smarty.const._MD_TADSEARCH_PHONE}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_PHONE}></option>
                                <option value="<{$smarty.const._MD_TADSEARCH_TEXT}>" <{if $column.type == $smarty.const._MD_TADSEARCH_TEXT}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_TEXT}></option>
                                <option value="<{$smarty.const._MD_TADSEARCH_NAME}>" <{if $column.type == $smarty.const._MD_TADSEARCH_NAME}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_NAME}></option>
                            </select>
                        </li>
                    </ul>
                <{/foreach}>
            </div>
        </div>
    </div>

<div class="alert alert-warning">
    <div class="form-group row mb-3">
        <div class="col-md-auto">
            <div class="input-group mb-1">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text"><{$smarty.const._MD_TADSEARCH_DISPLAY_SEARCHBOX}></span>
                </div>
                <select name="TDC[show_search_box]" id="show_search_box" class="form-control">
                    <option value="1" <{if $show_search_box != '0'}>selected<{/if}>><{$smarty.const._YES}></option>
                    <option value="0" <{if $show_search_box == '0'}>selected<{/if}>><{$smarty.const._NO}></option>
                </select>
            </div>

            <div class="input-group mb-1">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text"><{$smarty.const._MD_TADSEARCH_DISPLAY_PKID}></span>
                </div>
                <select name="TDC[show_pkid]" id="show_pkid" class="form-control">
                    <option value="1" <{if $show_pkid != '0'}>selected<{/if}>><{$smarty.const._YES}></option>
                    <option value="0" <{if $show_pkid == '0'}>selected<{/if}>><{$smarty.const._NO}></option>
                </select>
            </div>

            <div class="input-group mb-1">
                <div class="input-group-prepend input-group-addon">
                    <span class="input-group-text"><{$smarty.const._MD_TADSEARCH_URL_MODE}></span>
                </div>
                <select name="TDC[url_mode]" id="url_mode" class="form-control">
                    <option value="full" <{if $url_mode != 'short'}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_URL_FULL}></option>
                    <option value="short" <{if $url_mode == 'short'}>selected<{/if}>><{$smarty.const._MD_TADSEARCH_URL_SHORT}></option>
                </select>
            </div>
        </div>

        <div class="col-md-auto">
            <label for="view_groups"><{$smarty.const._MD_TADSEARCH_VIEW_PERM}></label>
            <{$view_groups|default:''}>
        </div>
        <div class="col-md-auto">
            <label for="add_groups"><{$smarty.const._MD_TADSEARCH_ADD_PERM}></label>
            <{$add_groups|default:''}>
        </div>
        <div class="col-md-auto">
            <label for="modify_groups"><{$smarty.const._MD_TADSEARCH_MODIFY_PERM}></label>
            <{$modify_groups|default:''}>
        </div>
        <div class="col-md-auto">
            <label for="del_groups"><{$smarty.const._MD_TADSEARCH_DEL_PERM}></label>
            <{$del_groups|default:''}>
        </div>
    </div>
</div>

    <div class="bar text-center">
        <{$token_form|default:''}>
        <input type='hidden' name="uid" value="<{$uid|default:''}>">
        <input type="hidden" name="op" value="<{$next_op|default:''}>">
        <input type="hidden" name="id" value="<{$id|default:''}>">

        <button type="submit" class="btn btn-primary"><i class="fa fa-floppy-o" aria-hidden="true"></i> <{$smarty.const._TAD_SAVE}></button>
    </div>
</form>


<h2 class="my"><{$smarty.const._MD_TADSEARCH_REIMPORT}></h2>
<form action="index.php" method="post" class="my-4" enctype="multipart/form-data">
    <div class="input-group">
        <input type="file" name="excel_file" id="excel_file" maxlength="1" accept=".xlsx" class="form-control">
        <div class="input-group-append input-group-btn">
            <input type="hidden" name="op" value="tad_search_import">
            <input type="hidden" name="id" value="<{$id|default:''}>">
            <button type="submit" class="btn btn-primary"><{$smarty.const._MD_TADSEARCH_IMPORT}></button>
        </div>
    </div>
</form>

<div class="alert alert-info">
    <ol class="m-0">
        <{$smarty.const._MD_TADSEARCH_IMPORT_NOTE}>
    </ol>
</div>