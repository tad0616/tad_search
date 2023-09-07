<?php
namespace XoopsModules\Tad_search;

use XoopsModules\Tadtools\Wcag;

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

/**
 * Class Tools
 */
class Tools
{

    // 變數過濾
    public static function filter($key, $value, $mode = "read", $filter_arr = [])
    {
        $myts = \MyTextSanitizer::getInstance();

        if (isset($filter_arr['pass']) && in_array($key, $filter_arr['pass'])) {
            return $value;
        }

        if ($mode == 'write' && in_array($key, $filter_arr['json'])) {
            $value = json_encode($value, 256);
        }

        if (is_array($value)) {
            foreach ($value as $k => $v) {
                $v = self::filter($key, $v, $mode, $filter_arr);
                $value[$k] = $v;
            }
        } else {
            if (isset($filter_arr['int']) && in_array($key, $filter_arr['int'], true)) {
                $value = (int) $value;
            } elseif (isset($filter_arr['html']) && in_array($key, $filter_arr['html'], true)) {
                if ($mode == 'edit') {
                    $value = $myts->htmlSpecialChars($value);
                } else {
                    $value = ($mode == 'write') ? $myts->addSlashes(Wcag::amend(trim($value))) : $myts->displayTarea($value, 1, 1, 1, 1, 0);
                }
            } elseif (isset($filter_arr['text']) && in_array($key, $filter_arr['text'], true)) {
                if ($mode == 'edit') {
                    $value = $myts->htmlSpecialChars($value);
                } else {
                    $value = ($mode == 'write') ? $myts->addSlashes(trim($value)) : $myts->displayTarea($value, 0, 0, 0, 1, 1);
                }
            } elseif (isset($filter_arr['json']) && in_array($key, $filter_arr['json'], true)) {

                if ($mode == 'write') {
                    $value = $myts->addSlashes(trim($value));
                } else {
                    $value = json_decode($value, true);
                    foreach ($value as $k => $v) {
                        $value[$k] = self::filter($k, $v, $mode);
                    }
                }

            } elseif (!isset($filter_arr['pass']) || !in_array($key, $filter_arr['pass'], true)) {
                if ($mode == 'edit') {
                    $value = $myts->htmlSpecialChars($value);
                } else {
                    $value = ($mode == 'write') ? $myts->addSlashes(trim($value)) : $myts->htmlSpecialChars($value);
                }
            }
        }

        return $value;
    }

    // 取得資料庫條件
    public static function get_and_where($where_rule = '')
    {
        if (is_array($where_rule)) {
            $and_where_rule = '';
            foreach ($where_rule as $col => $value) {
                $and_where_rule .= !is_string($col) ? " and {$value}" : " and `{$col}` = '{$value}'";
            }
        } else {
            $and_where_rule = $where_rule;
        }
        return $and_where_rule;
    }

    // 取得資料庫條件
    public static function get_order($order_rule = '')
    {
        $order_items = [];
        if (is_array($order_rule)) {
            foreach ($order_rule as $col => $asc) {
                $order_items[] = "`{$col}` $asc";
            }
            $order_rule = $order_items ? "order by " . implode(',', $order_items) : '';
        }
        return $order_rule;
    }

    // 權限檢查
    public static function chk_is_adm($other = '', $id = '', $file = '', $line = '', $to = '')
    {
        if (empty($to)) {
            $to = $_SERVER['PHP_SELF'];
        }
        if ($_SESSION['tad_search_adm'] || ($other != '' && $_SESSION[$other]) || strpos($_SERVER['PHP_SELF'], '/admin/') !== false) {
            if (!empty($id) && $_SESSION[$other]) {
                if (!in_array($id, $_SESSION[$other])) {
                    redirect_header($to, 3, _MD_TADSEARCH_NO_ACCESS_TO_THIS . " ($id)  {$file} ($line)");
                }
            }
            return true;
        } else {
            redirect_header($to, 3, _MD_TADSEARCH_NO_PRIVILEGES . "{$file} ($line)");
        }
    }

    // 建立群組
    public static function mk_group($name = "")
    {
        global $xoopsDB;
        $sql = "select groupid from " . $xoopsDB->prefix("groups") . " where `name`='$name'";
        $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

        list($group_id) = $xoopsDB->fetchRow($result);

        if (empty($group_id)) {
            $sql = "insert into " . $xoopsDB->prefix("groups") . " (`name`) values('{$name}')";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

            //取得最後新增資料的流水編號
            $group_id = $xoopsDB->getInsertId();
        }
        return $group_id;
    }

    // 將某人加入群組
    public static function add_user_to_group($uid, $group_id)
    {
        global $xoopsDB;
        $sql = "replace into " . $xoopsDB->prefix("groups_users_link") . " (`groupid`,`uid`) values('$group_id','$uid')";
        $xoopsDB->queryF($sql) or die($sql);
    }

    // 將某人移出群組
    public static function del_user_from_group($uid, $group_id)
    {
        global $xoopsDB;
        $sql = "delete from " . $xoopsDB->prefix("groups_users_link") . " where `groupid`='$group_id' and `uid`='$uid'";
        $xoopsDB->queryF($sql) or die($sql);
    }

    // uid 轉姓名
    public static function get_name_by_uid($uid)
    {
        $uid_name = \XoopsUser::getUnameFromId($uid, 1);
        if (empty($uid_name)) {
            $uid_name = \XoopsUser::getUnameFromId($uid, 0);
        }

        return $uid_name;
    }
}
