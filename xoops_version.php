<?php
use XoopsModules\Tadtools\Utility;

/**
 * Tad Search module
 *
 * You may not change or alter any portion of this comment or credits
 * of supporting developers from this source code or any supporting source code
 * which is considered copyrighted (c) material of the original comment or credit authors.
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 *
 * @copyright  The XOOPS Project http://sourceforge.net/projects/xoops/
 * @license    http://www.fsf.org/copyleft/gpl.html GNU public license
 * @package    Tad Search
 * @since      2.5
 * @author     tad
 * @version    $Id $
 **/

$tad_search_dirname = basename(__DIR__);
Utility::mk_dir(XOOPS_ROOT_PATH . "/uploads/tad_search");

if (!file_exists(XOOPS_ROOT_PATH . "/uploads/tad_search/{$tad_search_dirname}.sql")) {

    $fp = fopen(XOOPS_ROOT_PATH . "/uploads/tad_search/{$tad_search_dirname}.sql", 'w');

    $sql_content = "CREATE TABLE `{$tad_search_dirname}` (
        `id` smallint(6) unsigned NOT NULL auto_increment COMMENT '編號',
        `title` varchar(255) default '' COMMENT '標題',
        `content` text COMMENT '說明',
        `columns` text COMMENT '所有欄位',
        `uid` mediumint(9) unsigned default '0' COMMENT '發布者',
        `update_date` datetime COMMENT '最後更新日期',
        `enable` enum('1','0') COMMENT '是否啟用',
    PRIMARY KEY  (`id`)
    ) ENGINE=MyISAM;

    CREATE TABLE `{$tad_search_dirname}_data_center` (
    `mid` mediumint(9) unsigned NOT NULL AUTO_INCREMENT COMMENT '模組編號',
    `col_name` varchar(100) NOT NULL default '' COMMENT '欄位名稱',
    `col_sn` mediumint(9) unsigned NOT NULL default 0 COMMENT '欄位編號',
    `data_name` varchar(100) NOT NULL default '' COMMENT '資料名稱',
    `data_value` text NOT NULL COMMENT '儲存值',
    `data_sort` mediumint(9) unsigned NOT NULL default 0 COMMENT '排序',
    `col_id` varchar(100) NOT NULL COMMENT '辨識字串',
    `sort` mediumint(9) unsigned COMMENT '排序',
    `update_time` datetime NOT NULL COMMENT '更新時間',
    PRIMARY KEY (`mid`,`col_name`,`col_sn`,`data_name`,`data_sort`)
    ) ENGINE=MyISAM;

    CREATE TABLE `{$tad_search_dirname}_files_center` (
    `files_sn` smallint(5) unsigned NOT NULL AUTO_INCREMENT COMMENT '檔案流水號',
    `col_name` varchar(255) NOT NULL default '' COMMENT '欄位名稱',
    `col_sn` varchar(255) NOT NULL default '' COMMENT '欄位編號',
    `sort` smallint(5) unsigned NOT NULL default 0 COMMENT '排序',
    `kind` enum('img','file') NOT NULL default 'img' COMMENT '檔案種類',
    `file_name` varchar(255) NOT NULL default '' COMMENT '檔案名稱',
    `file_type` varchar(255) NOT NULL default '' COMMENT '檔案類型',
    `file_size` int(10) unsigned NOT NULL default 0 COMMENT '檔案大小',
    `description` text NOT NULL COMMENT '檔案說明',
    `counter` mediumint(8) unsigned NOT NULL default 0 COMMENT '下載人次',
    `original_filename` varchar(255) NOT NULL default '' COMMENT '檔案名稱',
    `hash_filename` varchar(255) NOT NULL default '' COMMENT '加密檔案名稱',
    `sub_dir` varchar(255) NOT NULL default '' COMMENT '檔案子路徑',
    `upload_date` datetime NOT NULL COMMENT '上傳時間',
    `uid` mediumint(8) unsigned NOT NULL default 0 COMMENT '上傳者',
    `tag` varchar(255) NOT NULL default '' COMMENT '註記',
    PRIMARY KEY (`files_sn`)
    ) ENGINE=MyISAM;
    ";

    fwrite($fp, $sql_content);
    fclose($fp);
}

if (file_exists(XOOPS_ROOT_PATH . "/modules/{$tad_search_dirname}/font.ttf") && !file_exists(XOOPS_ROOT_PATH . "/uploads/tad_search/font.ttf")) {
    copy(XOOPS_ROOT_PATH . "/modules/{$tad_search_dirname}/font.ttf", XOOPS_ROOT_PATH . "/uploads/tad_search/font.ttf");
}

if (file_exists(XOOPS_ROOT_PATH . "/modules/tad_search/images/logo.png") && !file_exists(XOOPS_ROOT_PATH . "/uploads/tad_search/{$tad_search_dirname}.png")) {
    $im = imagecreatefrompng(XOOPS_ROOT_PATH . "/modules/tad_search/images/logo.png")
    or die("Cannot Initialize new GD image stream");
    $text_color = imagecolorallocate($im, 255, 255, 255);
    imagettftext($im, 12, 0, 8, 22, $text_color, XOOPS_ROOT_PATH . "/uploads/tad_search/font.ttf", $tad_search_dirname);
    imagepng($im, XOOPS_ROOT_PATH . "/uploads/tad_search/{$tad_search_dirname}.png");
    imagedestroy($im);
}

$modversion = [];
global $xoopsConfig;

//---模組基本資訊---//
$modversion['name'] = $tad_search_dirname . _MI_TADSEARCH_NAME;
// $modversion['version'] = '1.4';
$modversion['version'] = $_SESSION['xoops_version'] >= 20511 ? '2.0.0-Stable' : '2.0';
$modversion['description'] = _MI_TADSEARCH_DESC;
$modversion['author'] = _MI_TADSEARCH_AUTHOR;
$modversion['credits'] = _MI_TADSEARCH_CREDITS;
$modversion['help'] = 'page=help';
$modversion['license'] = 'GPL see LICENSE';
$modversion['image'] = "../../uploads/tad_search/{$tad_search_dirname}.png";
$modversion['dirname'] = $tad_search_dirname;

//---模組狀態資訊---//
$modversion['release_date'] = '2024-12-12';
$modversion['module_website_url'] = 'https://www.tad0616.net';
$modversion['module_website_name'] = _MI_TADSEARCH_AUTHOR_WEB;
$modversion['module_status'] = 'release';
$modversion['author_website_url'] = 'https://www.tad0616.net';
$modversion['author_website_name'] = _MI_TADSEARCH_AUTHOR_WEB;
$modversion['min_php'] = '5.4';
$modversion['min_xoops'] = '2.5.10';

//---paypal資訊---//
$modversion['paypal'] = [
    'business' => 'tad0616@gmail.com',
    'item_name' => 'Donation : ' . _MI_TAD_WEB,
    'amount' => 0,
    'currency_code' => 'USD',
];

//---安裝設定---//
$modversion['onInstall'] = "include/onInstall.php";
$modversion['onUpdate'] = "include/onUpdate.php";
$modversion['onUninstall'] = "include/onUninstall.php";

//---資料表架構---//
if ($tad_search_dirname == 'tad_search') {
    $modversion['sqlfile']['mysql'] = "sql/mysql.sql";
} else {
    $modversion['sqlfile']['mysql'] = "../../uploads/tad_search/{$tad_search_dirname}.sql";
}

$modversion['tables'] = [
    "{$tad_search_dirname}",
    "{$tad_search_dirname}_data_center",
    "{$tad_search_dirname}_files_center",
];

//---後台使用系統選單---//
$modversion['system_menu'] = 1;

//---後台管理介面設定---//
$modversion['hasAdmin'] = 1;
$modversion['adminindex'] = 'admin/main.php';
$modversion['adminmenu'] = 'admin/menu.php';

//---前台主選單設定---//
$modversion['hasMain'] = 1;

//---樣板設定---//
$modversion['templates'] = [
    ['file' => 'tad_search_admin.tpl', 'description' => 'tad_search_admin.tpl'],
    ['file' => 'tad_search_index.tpl', 'description' => 'tad_search_index.tpl'],
];

//---區塊設定 (索引為固定值，若欲刪除區塊記得補上索引，避免區塊重複)---//
$modversion['blocks'] = [
    1 => [
        'file' => 'tad_search_show.php',
        'name' => $tad_search_dirname . _MI_TAD_SEARCH_SHOW_BLOCK_NAME,
        'description' => $tad_search_dirname . _MI_TAD_SEARCH_SHOW_BLOCK_DESC,
        'show_func' => $tad_search_dirname . '_show',
        'template' => 'block_tad_search_show.tpl',
        'edit_func' => $tad_search_dirname . '_show_edit',
        'options' => "{$tad_search_dirname}|",
    ],
    2 => [
        'file' => 'tad_search_index.php',
        'name' => $tad_search_dirname . _MI_TAD_SEARCH_INDEX_BLOCK_NAME,
        'description' => $tad_search_dirname . _MI_TAD_SEARCH_INDEX_BLOCK_DESC,
        'show_func' => $tad_search_dirname . '_index',
        'template' => 'block_tad_search_index.tpl',
        'edit_func' => $tad_search_dirname . '_index_edit',
        'options' => $tad_search_dirname,
    ],
];

//---偏好設定---//
$modversion['config'][] = [
    'name' => 'single_mode',
    'title' => '_MI_TADSEARCH_SINGLE_MODE',
    'description' => '_MI_TADSEARCH_SINGLE_MODE_DESC',
    'formtype' => 'textbox',
    'valuetype' => 'int',
    'default' => '0',
];
