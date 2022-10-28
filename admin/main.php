<?php
use Xmf\Request;
use XoopsModules\Tad_search\Tad_search;

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

/*-----------引入檔案區--------------*/
$GLOBALS['xoopsOption']['template_main'] = 'tad_search_adm_main.tpl';
require_once __DIR__ . '/header.php';
require_once dirname(__DIR__) . '/function.php';
$_SESSION['tad_search_adm'] = true;
$tad_search_dirname = basename(dirname(__DIR__));

/*-----------變數過濾----------*/
$op = Request::getString('op');
$id = Request::getInt('id');
$mode = Request::getString('mode');
$key_value = Request::getArray('key_value');

/*-----------執行動作判斷區----------*/
switch ($op) {

    //新增資料
    case 'tad_search_store':
        $id = Tad_search::store();
        header("location: {$_SERVER['PHP_SELF']}?id=$id");
        exit;

    //更新資料
    case 'tad_search_update':
        $where_arr['id'] = $id;
        Tad_search::update($where_arr);
        header("location: {$_SERVER['PHP_SELF']}?id=$id");
        exit;

    //新增用表單
    case 'tad_search_add':
        Tad_search::add();
        break;

    //修改用表單
    case 'tad_search_create':
        Tad_search::create($id);
        break;

    //刪除資料
    case 'tad_search_destroy':
        Tad_search::destroy($id);
        header("location: {$_SERVER['PHP_SELF']}");
        exit;

    //列出所資料
    case 'tad_search_index':
        $where_arr['enable'] = '1';
        Tad_search::index($where_arr, [], [], 20);
        break;

    //顯示某筆資料
    case 'tad_search_show':
        $where_arr['id'] = $id;
        Tad_search::show($tad_search_dirname, $where_arr, $key_value);
        break;

    //預設動作
    default:
        if (empty($id)) {
            Tad_search::index([], [], [], 20);
            $op = 'tad_search_index';
        } else {
            $where_arr['id'] = $id;
            Tad_search::show($tad_search_dirname, $where_arr, $key_value);
            $op = 'tad_search_show';
        }
        break;
}

/*-----------秀出結果區--------------*/
$xoopsTpl->assign('now_op', $op);
$xoopsTpl->assign('tad_search_dirname', $tad_search_dirname);
$xoTheme->addStylesheet('/modules/tadtools/css/font-awesome/css/font-awesome.css');
$xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/css/xoops_adm{$_SEESION['bootstrap']}.css");
$xoTheme->addStylesheet(XOOPS_URL . "/modules/{$tad_search_dirname}/css/module.css");
require_once __DIR__ . '/footer.php';

/*-----------功能函數區----------*/
