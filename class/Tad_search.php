<?php
namespace XoopsModules\Tad_search;

use XoopsModules\Tadtools\Bootstrap3Editable;
use XoopsModules\Tadtools\BootstrapTable;
use XoopsModules\Tadtools\CkEditor;
use XoopsModules\Tadtools\FormValidator;
use XoopsModules\Tadtools\SweetAlert;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\Utility;
use XoopsModules\Tad_search\Tools;

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

class Tad_search
{
    // 過濾用變數的設定
    public static $filter_arr = [
        'int' => ['id', 'uid', 'view_groups', 'add_groups', 'modify_groups', 'del_groups'], //數字類的欄位
        'html' => ['content'], //含網頁語法的欄位（所見即所得的內容）
        'text' => [], //純大量文字欄位
        'json' => ['columns'], //內容為 json 格式的欄位
        'pass' => [], //不予過濾的欄位
        'explode' => [], //用分號隔開的欄位
    ];

    //列出所有 tad_search 資料
    public static function index($where_arr = [], $view_cols = [], $order_arr = [], $amount = '')
    {
        global $xoopsTpl, $xoopsModule;

        $mod_name = $xoopsModule->dirname();
        if ($amount) {
            list($all_tad_search, $total, $bar) = self::get_all($mod_name, $where_arr, $view_cols, $order_arr, 'read', $amount);
            $xoopsTpl->assign('bar', $bar);
            $xoopsTpl->assign('total', $total);
        } else {
            $all_tad_search = self::get_all($mod_name, $where_arr, $view_cols, $order_arr);
        }

        $xoopsTpl->assign('all_tad_search', $all_tad_search);

        //刪除確認的JS
        $SweetAlert = new SweetAlert();
        $SweetAlert->render('tad_search_destroy_func', "{$_SERVER['PHP_SELF']}?op=tad_search_destroy&id=", "id");

    }

    //取得tad_search所有資料陣列
    public static function get_all($mod_name = '', $where_arr = [], $view_cols = [], $order_arr = [], $filter = 'read', $amount = '')
    {
        global $xoopsDB, $xoopsModule;

        $and_where = Tools::get_and_where($where_arr);

        $view_col = empty($view_cols) ? '*' : '`' . implode('`, `', $view_cols) . '`';

        $order_sql = Tools::get_order($order_arr);
        $order = $amount ? '' : $order_sql;

        $mod_name = empty($mod_name) ? $xoopsModule->dirname() : $mod_name;

        $sql = "SELECT $view_col FROM `" . $xoopsDB->prefix($mod_name) . "`
        WHERE 1 $and_where $order";

        // Utility::getPageBar($原sql語法, 每頁顯示幾筆資料, 最多顯示幾個頁數選項);
        if ($amount) {
            $PageBar = Utility::getPageBar($sql, $amount, 10, '', '', $_SESSION['bootstrap'], 'none', $order_sql);
            $bar = $PageBar['bar'];
            $sql = $PageBar['sql'];
            $total = $PageBar['total'];
        }

        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data_arr = [];
        while ($data = $xoopsDB->fetchArray($result)) {

            //將 uid 編號轉換成使用者姓名（或帳號）
            $data['uid_name'] = Tools::get_name_by_uid($data['uid']);

            if ($filter) {
                foreach ($data as $key => $value) {
                    $data[$key] = Tools::filter($key, $value, 'read', self::$filter_arr);
                }
            }

            foreach (self::$filter_arr['explode'] as $item) {
                $data[$item . '_arr'] = explode(';', $data[$item]);
            }
            foreach (self::$filter_arr['json'] as $item) {
                $data[$item . '_arr'] = json_decode($data[$item], true);
            }

            $data_arr[] = $data;
        }

        if ($amount) {
            return [$data_arr, $total, $bar];
        } else {
            return $data_arr;
        }
    }

    //以流水號秀出某筆 tad_search 資料內容
    public static function show($mod_name = '', $where_arr = [], $key_value = [], $mode = "")
    {
        global $xoopsTpl, $xoopsModule, $xoopsUser;
        if (empty($where_arr)) {
            redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_TADSEARCH_NO_QUERY_CRITERIA . __FILE__ . __LINE__);
        }
        $mod_name = empty($mod_name) ? $xoopsModule->dirname() : $mod_name;

        $modhandler = &xoops_gethandler('module');
        $xoopsModule = &$modhandler->getByDirname($mod_name);

        $all = self::get($mod_name, $where_arr);
        if (empty($all)) {
            return false;
        }

        foreach ($all as $key => $value) {
            $value = Tools::filter($key, $value, 'read', self::$filter_arr);
            $all[$key] = $value;
            $$key = $value;
        }

        $TadDataCenter = new TadDataCenter($mod_name);
        $TadDataCenter->set_col('uid_row', $id);
        $uid = $xoopsUser ? $xoopsUser->uid() : 0;
        if ($uid) {
            $my_row = explode(',', $TadDataCenter->getData($uid, 0));
            // 移除空值元素
            $my_row = array_filter($my_row, function ($value) {
                // 使用 empty() 檢查是否為空值
                return !empty($value);
            });
            $all['my_row'] = $my_row;
        } else {
            $all['my_row'] = [];
        }

        $can_view = false;
        if (Utility::power_chk('view', $id, $xoopsModule->mid(), true, $mod_name)) {
            $can_view = true;
        }
        $all['can_view'] = $can_view;

        $can_add = false;
        if (Utility::power_chk('add', $id, $xoopsModule->mid(), true, $mod_name)) {
            $can_add = true;
        }
        $all['can_add'] = $can_add;

        $Bootstrap3EditableCode = '';
        $can_modify = Utility::power_chk('modify', $id, $xoopsModule->mid(), true, $mod_name);
        $xoopsTpl->assign('can_modify', $can_modify);
        if ($can_modify || !empty($my_row)) {
            $Bootstrap3Editable = new Bootstrap3Editable();
            $Bootstrap3EditableCode = $Bootstrap3Editable->render('.editable', XOOPS_URL . "/modules/$mod_name/ajax.php");
        }

        $can_del = false;
        if (Utility::power_chk('del', $id, $xoopsModule->mid(), true, $mod_name)) {
            $can_del = true;
        }
        $all['can_del'] = $can_del;

        $xoopsTpl->assign('Bootstrap3EditableCode', $Bootstrap3EditableCode);

        //將 uid 編號轉換成使用者姓名（或帳號）
        $uid_name = Tools::get_name_by_uid($uid);
        $all['uid_name'] = $uid_name;

        $SweetAlert = new SweetAlert();
        $SweetAlert->render('tad_search_destroy_func', "{$_SERVER['PHP_SELF']}?op=tad_search_destroy&id=", "id");

        $BootstrapTable = BootstrapTable::render();
        $all['BootstrapTable'] = $BootstrapTable;

        $formValidator = new FormValidator("#searchForm{$id}", true);
        $formValidator->render();

        $TadDataCenter->set_col('config', $id);
        $config = $TadDataCenter->getData();
        foreach ($config as $config_name => $config_value) {
            $all[$config_name] = $config_value[0];
        }

        $TadDataCenter->set_col('id', $id);

        // 目前登入者群組
        $groups = $xoopsUser ? $xoopsUser->groups() : [3];

        // 第一行資料，就是標題
        $data_arr = $TadDataCenter->getData();
        $heads = $data_arr[1];
        unset($data_arr[1]);

        $all_ok = $name_col = $search_col = $hide_col = $filter_col = [];

        $ok_bind_val = $is_bind = $is_search = false;
        $search_form = [];
        foreach ($heads as $key => $col_title) {
            $hide_col[$key] = $columns_arr[$col_title]['hide'];
            $filter_col[$key] = $columns_arr[$col_title]['filter'];
            $all_ok[$key] = empty($columns_arr[$col_title]['groups']) || array_intersect($groups, $columns_arr[$col_title]['groups']) ? 1 : 0;
            $name_col[$key] = $columns_arr[$col_title]['type'] == _MD_TADSEARCH_NAME ? 1 : 0;
            if ($columns_arr[$col_title]['search']) {
                $search_col[$key] = $columns_arr[$col_title]['search'];

                // 偵測有無綁定
                if (!$ok_bind_val && substr($columns_arr[$col_title]['search'], 0, 4) == 'bind') {
                    $is_bind = true;
                    list($data_arr, $ok_bind_val) = self::bind($columns_arr[$col_title]['search'], $key, $data_arr);
                } elseif ($columns_arr[$col_title]['search'] != '') {
                    // 偵測有搜尋界面
                    $is_search = true;
                    $search_form[$key]['title'] = $col_title;
                    $search_form[$key]['placeholder'] = '';
                    if (substr($columns_arr[$col_title]['search'], 0, 3) == 'and') {
                        $search_form[$key]['type'] = 'and';
                        $search_form[$key]['require'] = 'validate[required]';
                        $search_form[$key]['color'] = '#f9e0e1';
                        $search_form[$key]['placeholder'] = $mode == 'return' ? _MB_TADSEARCH_REQUIRE : _MD_TADSEARCH_REQUIRE;
                    } elseif (substr($columns_arr[$col_title]['search'], 0, 2) == 'or') {
                        $search_form[$key]['type'] = 'or';
                        $search_form[$key]['require'] = '';
                        $search_form[$key]['color'] = '#e6f4f7';
                    }
                    if (strpos($columns_arr[$col_title]['search'], 'same') !== false) {
                        $search_form[$key]['rule'] = 'same';
                        $search_form[$key]['placeholder'] .= $mode == 'return' ? sprintf(_MB_TADSEARCH_COMPLETE_VALUE, $col_title) : sprintf(_MD_TADSEARCH_COMPLETE_VALUE, $col_title);
                    } elseif (strpos($columns_arr[$col_title]['search'], 'like') !== false) {
                        $search_form[$key]['rule'] = 'like';
                        $search_form[$key]['placeholder'] .= $mode == 'return' ? sprintf(_MB_TADSEARCH_KEYWORD, $col_title) : sprintf(_MD_TADSEARCH_KEYWORD, $col_title);
                    }
                }
            }
        }

        if ($key_value) {
            foreach ($data_arr as $row => $row_data) {
                $unset = false;
                foreach ($row_data as $col => $value) {
                    // Utility::dd($key_value);
                    if (isset($key_value[$col]) && $key_value[$col] != '') {
                        if ($search_form[$col]['rule'] == 'same' && $value != $key_value[$col]) {
                            $unset = true;
                        } elseif ($search_form[$col]['rule'] == 'like' && strpos($value, $key_value[$col]) === false) {
                            // Utility::dd($key_value[$col]);
                            $unset = true;
                        }
                    }
                }
                if ($unset) {
                    unset($data_arr[$row]);
                }
            }
        }

        krsort($data_arr, SORT_NUMERIC);
        // Utility::dd($data_arr);

        $content_arr = [];
        foreach ($data_arr as $key => $data) {
            $val['pkid'] = $key;
            foreach ($data as $k => $v) {
                if ($hide_col[$k] != 1) {
                    if ($all_ok[$k]) {
                        if ($name_col[$k] && !$xoopsUser) {
                            $v = substr_replace($v, 'O', 3, 3);
                        } elseif (substr($v, 0, 4) == "http") {
                            if (empty($my_row) || (!$can_modify && !in_array($key, $my_row))) {
                                if ($mode != 'edit') {
                                    if ($all['url_mode'] == "short") {
                                        $v = "<a href='{$v}' target='_blank'>" . _MD_TADSEARCH_URL . "</a>";
                                    } else {
                                        $v = "<a href='{$v}' target='_blank'>{$v}</a>";
                                    }
                                }
                            }
                        } elseif (strpos($v, "|http") !== false && $mode != 'edit') {
                            $link_var = explode('|', $v);
                            $v = "<a href='{$link_var[1]}' target='_blank'>{$link_var[0]}</a>";
                        }
                        $val[$k] = $v;
                    } else {
                        $val[$k] = '<span class="text-muted">' . _MD_TADSEARCH_NO_VIEW_PRIVILEGES . '</span>';
                    }
                }
            }
            $content_arr[] = $val;
        }

        $all['heads'] = $heads;
        $all['contents'] = $data_arr;
        $all['json'] = json_encode($content_arr, 256);
        $all['total'] = count($data_arr);
        $all['all_ok'] = $all_ok;
        $all['name_col'] = $name_col;
        $all['search_col'] = $search_col;
        $all['hide_col'] = $hide_col;
        $all['filter_col'] = $filter_col;
        $all['is_bind'] = $is_bind;
        $all['ok_bind_val'] = $ok_bind_val;
        $all['is_search'] = $is_search;
        $all['search_form'] = $search_form;
        $all['key_value'] = $key_value;

        if ($mode == "return") {
            return $all;
        } else {
            foreach ($all as $key => $value) {
                $xoopsTpl->assign($key, $value);
            }
        }
    }

    // 綁定檢查
    public static function bind($bind_kind = '', $search_col_key = '', $data_arr = [])
    {
        global $xoopsUser;

        $func_arr['bind email'] = 'email';
        $func_arr['bind name'] = 'name';
        $func_arr['bind schoolcode'] = 'user_intrest';

        $func = $func_arr[$bind_kind];
        $ok_bind_val = false;
        $bind_val = $xoopsUser ? $xoopsUser->$func() : '';
        if ($bind_val) {
            foreach ($data_arr as $row => $data) {
                // if (strpos($data[$search_col_key], $bind_val) === false) {
                if ($data[$search_col_key] != $bind_val) {
                    unset($data_arr[$row]);
                } else {
                    $ok_bind_val = $bind_val;
                }
            }
        }

        return [$data_arr, $ok_bind_val];
    }

    //以流水號取得某筆 tad_search 資料
    public static function get($mod_name = '', $where_arr = [], $pass = [], $other_rule = [])
    {
        global $xoopsDB, $xoopsModule;

        if (empty($where_arr)) {
            redirect_header($_SERVER['HTTP_REFERER'], 3, _MD_TADSEARCH_NO_QUERY_CRITERIA . __FILE__ . __LINE__);
        }

        $and_where = Tools::get_and_where($where_arr);
        $other_sql = implode(' ', $other_rule);

        $mod_name = empty($mod_name) ? $xoopsModule->dirname() : $mod_name;

        $sql = "SELECT * FROM `" . $xoopsDB->prefix($mod_name) . "`
        WHERE 1 $and_where $other_sql";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);
        $data = $xoopsDB->fetchArray($result);

        foreach (self::$filter_arr['explode'] as $item) {
            $data[$item . '_arr'] = explode(';', $data[$item]);
        }
        foreach (self::$filter_arr['json'] as $item) {
            $data[$item . '_arr'] = json_decode($data[$item], true);
        }

        return $data;
    }

    //tad_search 編輯表單
    public static function create($id = '')
    {
        global $xoopsTpl, $xoopsUser, $xoopsModule;
        Tools::chk_is_adm('', '', __FILE__, __LINE__);
        $mod_name = $xoopsModule->dirname();

        //抓取預設值
        $tad_search = (!empty($id)) ? self::get($mod_name, ['id' => $id]) : [];

        //預設值設定
        $def['id'] = $id;
        $user_uid = $xoopsUser ? $xoopsUser->uid() : "";
        $def['uid'] = $user_uid;
        $def['update_date'] = date("Y-m-d H:i:s");
        $def['enable'] = '1';

        if (empty($tad_search)) {
            $tad_search = $def;
        }

        foreach ($tad_search as $key => $value) {
            $value = Tools::filter($key, $value, 'edit', self::$filter_arr);
            $$key = isset($tad_search[$key]) ? $tad_search[$key] : $def[$key];
            $xoopsTpl->assign($key, $value);
        }

        $op = (!empty($id)) ? "tad_search_update" : "tad_search_store";
        $xoopsTpl->assign('next_op', $op);

        $formValidator = new FormValidator("#myForm", true);
        $formValidator->render();

        //說明
        $ck = new CkEditor("tad_search", "content", $content);
        $ck->setHeight(150);
        $editor = $ck->render();
        $xoopsTpl->assign('content_editor', $editor);

        //加入Token安全機制
        include_once XOOPS_ROOT_PATH . "/class/xoopsformloader.php";
        $token = new \XoopsFormHiddenToken();
        $token_form = $token->render();
        $xoopsTpl->assign("token_form", $token_form);

        $group_form = [];
        foreach ($columns_arr as $col_title => $column) {
            $SelectCheckGroup_name = new \XoopsFormSelectGroup(_MD_TADSEARCH_SELECT_GROUPS, "columns[$col_title][groups]", true, $column['groups'], 3, true);
            $group_form[$col_title] = $SelectCheckGroup_name->render();
        }
        $xoopsTpl->assign("group_form", $group_form);

        $view_groups = new \XoopsFormSelectGroup(_MD_TADSEARCH_VIEW_PERM, "view_groups", true, Utility::get_perm($id, 'view'), 3, true);
        $xoopsTpl->assign("view_groups", $view_groups->render());

        $add_groups = new \XoopsFormSelectGroup(_MD_TADSEARCH_ADD_PERM, "add_groups", false, Utility::get_perm($id, 'add'), 3, true);
        $xoopsTpl->assign("add_groups", $add_groups->render());

        $modify_groups = new \XoopsFormSelectGroup(_MD_TADSEARCH_ADD_PERM, "modify_groups", false, Utility::get_perm($id, 'modify'), 3, true);
        $xoopsTpl->assign("modify_groups", $modify_groups->render());

        $del_groups = new \XoopsFormSelectGroup(_MD_TADSEARCH_ADD_PERM, "del_groups", false, Utility::get_perm($id, 'del'), 3, true);
        $xoopsTpl->assign("del_groups", $del_groups->render());

        $TadDataCenter = new TadDataCenter($mod_name);
        $TadDataCenter->set_col('config', $id);
        $config = $TadDataCenter->getData();
        foreach ($config as $config_name => $config_value) {
            $xoopsTpl->assign($config_name, $config_value[0]);
        }
    }

    //新增資料到 tad_search 中
    public static function store($data_arr = [])
    {
        global $xoopsDB, $xoopsUser, $xoopsModule;
        Tools::chk_is_adm('', '', __FILE__, __LINE__);

        //XOOPS表單安全檢查
        if (empty($data_arr)) {
            Utility::xoops_security_check();
            $data_arr = $_POST;
        }

        foreach ($data_arr as $key => $value) {
            $$key = Tools::filter($key, $value, 'edit', self::$filter_arr);
        }

        //取得使用者編號
        $uid = ($xoopsUser) ? $xoopsUser->uid() : 0;
        $update_date = date("Y-m-d H:i:s", xoops_getUserTimestamp(time()));

        $mod_name = $xoopsModule->dirname();
        $sql = "INSERT INTO `" . $xoopsDB->prefix($mod_name) . "` (
            `title`,
            `content`,
            `columns`,
            `uid`,
            `update_date`,
            `enable`
        ) VALUES(
            '{$title}',
            '{$content}',
            '{$columns}',
            '{$uid}',
            '{$update_date}',
            '{$enable}'
        )";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        //取得最後新增資料的流水編號
        $id = $xoopsDB->getInsertId();

        $TadDataCenter = new TadDataCenter($mod_name);
        $TadDataCenter->set_col('config', $id);
        $TadDataCenter->saveData();

        Utility::save_perm($view_groups, $id, 'view');
        Utility::save_perm($add_groups, $id, 'add');
        Utility::save_perm($modify_groups, $id, 'modify');
        Utility::save_perm($del_groups, $id, 'del');

        return $id;
    }

    //更新tad_search某一筆資料
    public static function update($where_rule = [], $data_arr = [])
    {
        global $xoopsDB, $xoopsUser, $xoopsModule;
        Tools::chk_is_adm('', '', __FILE__, __LINE__);

        $and_where = Tools::get_and_where($where_rule);
        $mod_name = $xoopsModule->dirname();

        if (!empty($data_arr)) {
            $col_arr = [];

            foreach ($data_arr as $key => $value) {
                $value = Tools::filter($key, $value, 'write', self::$filter_arr);
                $col_arr[] = "`$key` = '{$value}'";
            }
            $update_cols = implode(', ', $col_arr);
            $sql = "UPDATE `" . $xoopsDB->prefix($mod_name) . "` SET
            $update_cols WHERE 1 $and_where";
        } else {
            //XOOPS表單安全檢查
            Utility::xoops_security_check(__FILE__, __LINE__);

            foreach ($_POST as $key => $value) {
                $$key = Tools::filter($key, $value, 'write', self::$filter_arr);
            }

            //取得使用者編號
            $uid = ($xoopsUser) ? $xoopsUser->uid() : 0;
            $update_date = date("Y-m-d H:i:s", xoops_getUserTimestamp(time()));

            $sql = "UPDATE `" . $xoopsDB->prefix($mod_name) . "` SET
            `title` = '{$title}',
            `content` = '{$content}',
            `columns` = '{$columns}',
            `uid` = '{$uid}',
            `update_date` = '{$update_date}',
            `enable` = '{$enable}'
            WHERE 1 $and_where";
        }
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        $TadDataCenter = new TadDataCenter($mod_name);
        $TadDataCenter->set_col('config', $id);
        $TadDataCenter->saveData();

        Utility::save_perm($view_groups, $id, 'view');
        Utility::save_perm($add_groups, $id, 'add');
        Utility::save_perm($modify_groups, $id, 'modify');
        Utility::save_perm($del_groups, $id, 'del');
        return $id;
    }

    //刪除tad_search某筆資料資料
    public static function destroy($id = '')
    {
        global $xoopsDB, $xoopsModule;
        Tools::chk_is_adm('', '', __FILE__, __LINE__);

        if (empty($id)) {
            return;
        }

        $mod_name = $xoopsModule->dirname();
        $TadDataCenter = new TadDataCenter($mod_name);
        $TadDataCenter->set_col('id', $id);
        $TadDataCenter->delData();

        $and = '';
        if ($id) {
            $and .= "and `id` = '$id'";
        }

        $sql = "DELETE FROM `" . $xoopsDB->prefix($mod_name) . "`
        WHERE 1 $and";
        $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        Utility::del_perm($id, 'view');
        Utility::del_perm($id, 'add');
        Utility::del_perm($id, 'modify');
        Utility::del_perm($id, 'del');

    }

    //匯入資料
    public static function import($id = '', $mode = '')
    {
        global $xoopsModule, $xoopsUser;
        $mod_name = $xoopsModule->dirname();
        $TadDataCenter = new TadDataCenter($mod_name);

        Tools::chk_is_adm('', '', __FILE__, __LINE__);
        if (!empty($id)) {
            $TadDataCenter->set_col('id', $id);
            $TadDataCenter->delData();
            $TadDataCenter->set_col('uid_row', $id);
            $TadDataCenter->delData();

        } elseif (empty($id) || $mode == "store") {
            $title = $_FILES['excel_file']['name'];
            $id = self::store(['title' => substr($title, 0, -5), 'enable' => 1]);
        }

        require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php';

        $reader = \PHPExcel_IOFactory::createReader('Excel2007');
        $PHPExcel = $reader->load($_FILES['excel_file']['tmp_name']); // 檔案名稱
        $sheet = $PHPExcel->getSheet(0); // 讀取第一個工作表(編號從 0 開始)
        $maxCell = $PHPExcel->getActiveSheet()->getHighestRowAndColumn();
        $maxColumn = self::getIndex($maxCell['column']);

        // 一次讀一列
        $xlsx_data = $columns = $type = $my_row = [];
        for ($row = 1; $row <= $maxCell['row']; $row++) {
            // 讀出每一格
            for ($col = 0; $col <= $maxColumn; $col++) {

                if (isset($type[$col]) && $type[$col] == _MD_TADSEARCH_DATE) {
                    if (\PHPExcel_Shared_Date::isDateTime($sheet->getCellByColumnAndRow($col, $row))) {
                        $val = \PHPExcel_Shared_Date::ExcelToPHPObject($sheet->getCellByColumnAndRow($col, $row)->getValue())->format('Y-m-d');
                    } else {
                        $val = $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
                    }
                } elseif (isset($type[$col]) && $type[$col] == _MD_TADSEARCH_DATETIME) {
                    if (\PHPExcel_Shared_Date::isDateTime($sheet->getCellByColumnAndRow($col, $row))) {
                        $val = \PHPExcel_Shared_Date::ExcelToPHPObject($sheet->getCellByColumnAndRow($col, $row)->getValue())->format('Y-m-d H:i:s');
                    } else {
                        $val = $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
                    }
                } elseif (isset($type[$col]) && $type[$col] == _MD_TADSEARCH_TEXT) {
                    $val = $sheet->getCellByColumnAndRow($col, $row)->getValue();
                } else {
                    $val = $sheet->getCellByColumnAndRow($col, $row)->getCalculatedValue();
                }

                if ($row == 1) {
                    $clean_title = str_replace(['[d]', '[dt]', '[p]', '[t]', '[n]', '(g)', '(h)', '(f)', '(e)', '(s)', '(n)', '(%)', '(=)', '(%%)', '(==)'], '', $val);

                    if (strpos($val, '[d]') !== false) {
                        $columns[$clean_title]['type'] = $type[$col] = _MD_TADSEARCH_DATE;
                    } elseif (strpos($val, '[dt]') !== false) {
                        $columns[$clean_title]['type'] = $type[$col] = _MD_TADSEARCH_DATETIME;
                    } elseif (strpos($val, '[p]') !== false) {
                        $columns[$clean_title]['type'] = $type[$col] = _MD_TADSEARCH_PHONE;
                    } elseif (strpos($val, '[t]') !== false) {
                        $columns[$clean_title]['type'] = $type[$col] = _MD_TADSEARCH_TEXT;
                    } elseif (strpos($val, '[n]') !== false) {
                        $columns[$clean_title]['type'] = $type[$col] = _MD_TADSEARCH_NAME;
                    }

                    if (strpos($val, '(g)') !== false) {
                        $columns[$clean_title]['groups'] = [2];
                    }

                    if (strpos($val, '(h)') !== false) {
                        $columns[$clean_title]['hide'] = 1;
                    } else {
                        $columns[$clean_title]['hide'] = 0;
                    }

                    if (strpos($val, '(f)') !== false) {
                        $columns[$clean_title]['filter'] = 1;
                    } else {
                        $columns[$clean_title]['filter'] = 0;
                    }

                    if (strpos($val, '(e)') !== false) {
                        $columns[$clean_title]['search'] = 'bind email';
                    } elseif (strpos($val, '(n)') !== false) {
                        $columns[$clean_title]['search'] = 'bind name';
                    } elseif (strpos($val, '(s)') !== false) {
                        $columns[$clean_title]['search'] = 'bind schoolcode';
                    } elseif (strpos($val, '(%)') !== false) {
                        $columns[$clean_title]['search'] = 'or like';
                    } elseif (strpos($val, '(=)') !== false) {
                        $columns[$clean_title]['search'] = 'or same';
                    } elseif (strpos($val, '(%%)') !== false) {
                        $columns[$clean_title]['search'] = 'and like';
                    } elseif (strpos($val, '(==)') !== false) {
                        $columns[$clean_title]['search'] = 'and same';
                    }
                    $val = $clean_title;
                } else {
                    if (isset($type[$col]) && $type[$col] == _MD_TADSEARCH_PHONE && is_numeric($val) && strlen($val) == 9 && substr($val, 0, 1) == 9) {
                        $val = "0{$val}";
                    }
                }

                $xlsx_data[$row][$col] = $val;
            }
            $my_row[] = $row;
        }

        self::update(['id' => $id], ['columns' => $columns]);

        $TadDataCenter->set_col('id', $id);
        $TadDataCenter->saveCustomData($xlsx_data);

        $TadDataCenter->set_col('uid_row', $id);
        $TadDataCenter->saveCustomData([$xoopsUser->uid() => [implode(',', $my_row)]]);
        return $id;
    }

    // 將文字轉為數字
    public static function getIndex($let)
    {
        // Iterate through each letter, starting at the back to increment the value
        for ($num = 0, $i = 0; $let != ''; $let = substr($let, 0, -1), $i++) {
            $num += (ord(substr($let, -1)) - 65) * pow(26, $i);
        }

        return $num;
    }

    // 上傳界面
    public static function add()
    {
        Tools::chk_is_adm('', '', __FILE__, __LINE__, 'index.php');
    }

}
