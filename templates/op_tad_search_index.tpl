<{if $all_tad_search}>
    <div class="vtb mt-4">
        <ul id="tad_search_sort" class="vhead">
            <!--標題-->
            <li class="w30"><{$smarty.const._MD_TADSEARCH_TITLE}></li>
            <!--所有欄位-->
            <li class="w30"><{$smarty.const._MD_TADSEARCH_COLUMNS}></li>
            <!--發布者-->
            <li class="w10"><{$smarty.const._MD_TADSEARCH_UID}></li>
            <!--最後更新日期-->
            <li class="w20"><{$smarty.const._MD_TADSEARCH_UPDATE_DATE}></li>
            <{if $smarty.session.tad_search_adm}>
                <li class="w10"><{$smarty.const._TAD_FUNCTION}></li>
            <{/if}>
        </ul>
        <{foreach from=$all_tad_search key=k item=data name=all_tad_search}>
            <ul id="tr_<{$data.id}>">
                <!--標題-->
                <li class="vcell ">
                    <{$smarty.const._MD_TADSEARCH_TITLE}>
                </li>
                <li class="vm w30">
                    <{if $data.enable == '1'}>
                        <img src="<{$xoops_url}>/modules/<{$tad_search_dirname}>/images/yes.gif" alt="<{$smarty.const._YES}>" title="<{$smarty.const._TAD_ENABLE}>">
                    <{else}>
                        <img src="<{$xoops_url}>/modules/<{$tad_search_dirname}>/images/no.gif" alt="<{$smarty.const._NO}>" title="<{$smarty.const._TAD_UNABLE}>">
                    <{/if}>
                    <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?id=<{$data.id}>"><{$data.title}></a>
                </li>


                <!--所有欄位-->
                <li class="vcell light">
                    <span class="vlabel"><{$smarty.const._MD_TADSEARCH_COLUMNS}><{$smarty.const._TAD_FOR}></span>
                    <{$smarty.const._MD_TADSEARCH_NUMBER_OF_COLUMNS}><{$data.columns|@count}>
                </li>
                <li class="vm c w30 blank">
                    <{$smarty.const._MD_TADSEARCH_NUMBER_OF_COLUMNS}><{$data.columns|@count}>
                </li>

                <!--發布者-->
                <li class="vcell light">
                    <span class="vlabel"><{$smarty.const._MD_TADSEARCH_UID}><{$smarty.const._TAD_FOR}></span>
                    <a href="<{$xoops_user}>/user.php?uid=<{$data.uid}>"><{$data.uid_name}></a>
                </li>
                <li class="vm c w10 blank">
                    <a href="<{$xoops_user}>/user.php?uid=<{$data.uid}>"><{$data.uid_name}></a>
                </li>

                <!--最後更新日期-->
                <li class="vcell light">
                    <span class="vlabel"><{$smarty.const._MD_TADSEARCH_UPDATE_DATE}><{$smarty.const._TAD_FOR}></span>
                    <{$data.update_date}>
                </li>
                <li class="vm c w20 blank">
                    <{$data.update_date}>
                </li>

                <{if $smarty.session.tad_search_adm}>
                    <li class="vm c w10">
                        <a href="javascript:tad_search_destroy_func(<{$data.id}>);" class="btn btn-sm btn-xs btn-danger" title="<{$smarty.const._TAD_DEL}>"><i class="fa fa-trash-o"></i></a>
                        <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?op=tad_search_create&id=<{$data.id}>" class="btn btn-sm btn-xs btn-warning" title="<{$smarty.const._TAD_EDIT}>"><i class="fa fa-pencil"></i></a>
                    </li>
                <{/if}>
            </ul>
        <{/foreach}>
    </div>

    <{if $smarty.session.tad_search_adm && $smarty.session.single_mode==0}>
        <div class="text-right text-end my-3">
            <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?op=tad_search_add" class="btn btn-info">
                <i class="fa fa-plus"></i> <{$smarty.const._TAD_ADD}>
            </a>
        </div>
    <{/if}>

    <div class="bar"><{$bar}></div>

<{else}>
    <div class="alert alert-warning text-center">
        <{if $smarty.session.tad_search_adm && $smarty.session.single_mode==0}>
            <a href="<{$xoops_url}>/modules/<{$tad_search_dirname}>/index.php?op=tad_search_add" class="btn btn-info">
                <i class="fa fa-plus"></i> <{$smarty.const._TAD_ADD}>
            </a>
        <{else}>
            <h3><{$smarty.const._TAD_EMPTY}></h3>
        <{/if}>
    </div>
<{/if}>
