<?php
//判斷是否對該模組有管理權限
if (!isset($_SESSION['tad_search_adm'])) {
    $_SESSION['tad_search_adm'] = isset($xoopsUser) && \is_object($xoopsUser) ? $xoopsUser->isAdmin() : false;
}

$interface_menu[_MD_TADSEARCH_INDEX] = "index.php";
$interface_icon[_MD_TADSEARCH_INDEX] = "fa-magnifying-glass";
