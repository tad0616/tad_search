<?php
use Xmf\Request;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tadtools\Utility;

include_once "header.php";

$op = Request::getString('op');
$id = Request::getInt('id');
$ids = Request::getArray('ids');
$data_name = Request::getInt('pk');
$data_sort = Request::getInt('name');
$value = Request::getString('value');
$force = Request::getInt('force');

switch ($op) {
    case "add_data":
        echo add_data($id);
        break;

    case "del_data":
        echo del_data($id, $ids, $force);
        break;

    case "update_value":
        echo update_value($id, $data_name, $data_sort, $value);
        break;

}

function del_data($id, $ids = [], $force = 0)
{
    global $xoopsDB, $xoopsModule, $xoopsUser;
    $mod_name = empty($mod_name) ? $xoopsModule->dirname() : $mod_name;
    $TadDataCenter = new TadDataCenter($mod_name);
    $TadDataCenter->set_col('uid_row', $id);
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;
    $my_row = $TadDataCenter->getData($uid, 0);
    $all_my_row = explode(',', $my_row);
    // 移除空值元素
    $all_my_row = array_filter($all_my_row, function ($value) {
        // 使用 empty() 檢查是否為空值
        return !empty($value);
    });

    foreach ($ids as $data_name) {
        if ($force || in_array($data_name, $all_my_row)) {
            $sql = "delete from `" . $xoopsDB->prefix("{$mod_name}_data_center") . "` where `col_name` ='id' and  `col_sn` ='$id' and `data_name`='$data_name'";
            $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);

            // 使用array_diff()移除指定值的元素
            if (in_array($data_name, $all_my_row)) {
                $all_my_row = array_diff($all_my_row, array($data_name));
            } elseif ($force) {
                if (!isset($other_uid_row)) {
                    $sql = "select `data_name`, `data_value` from `" . $xoopsDB->prefix("{$mod_name}_data_center") . "` where `col_name` ='uid_row' and  `col_sn` ='$id' and `data_name`!='$uid'";
                    $result = $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
                    while (list($other_uid, $other_row) = $xoopsDB->fetchRow($result)) {
                        $other_uid_row[$other_uid] = explode(',', $other_row);
                    }
                }
                foreach ($other_uid_row as $other_uid => $other_row_arr) {
                    if (in_array($data_name, $other_row_arr)) {
                        $other_row_arr = array_diff($other_row_arr, array($data_name));

                        $TadDataCenter->set_col('uid_row', $id);
                        $TadDataCenter->saveCustomData([$other_uid => [implode(',', $other_row_arr)]]);
                    }
                }
            }

        }
    }

    $TadDataCenter->set_col('uid_row', $id);
    $TadDataCenter->saveCustomData([$uid => [implode(',', $all_my_row)]]);
}

function add_data($id)
{
    global $xoopsDB, $xoopsModule, $xoopsUser;

    $mod_name = $xoopsModule->dirname();
    $mid = $xoopsModule->mid();
    $TadDataCenter = new TadDataCenter($mod_name);
    $TadDataCenter->set_col('uid_row', $id);
    $uid = $xoopsUser ? $xoopsUser->uid() : 0;
    $my_row = $TadDataCenter->getData($uid, 0);
    $all_my_row = explode(',', $my_row);
    // 移除空值元素
    $all_my_row = array_filter($all_my_row, function ($value) {
        // 使用 empty() 檢查是否為空值
        return !empty($value);
    });

    $sql = "SELECT `data_name`, `data_sort`
    FROM `" . $xoopsDB->prefix("{$mod_name}_data_center") . "`
    WHERE `data_name`= (
    SELECT MAX(CAST(`data_name` AS UNSIGNED))
    FROM `" . $xoopsDB->prefix("{$mod_name}_data_center") . "`
    WHERE `mid` = '$mid' AND `col_name` = 'id' AND `col_sn` = '$id')
    ORDER BY `data_sort`";
    $result = $xoopsDB->query($sql) or Utility::web_error($sql, __FILE__, __LINE__);

    while (list($data_name, $data_sort) = $xoopsDB->fetchRow($result)) {
        $new_data_name = $data_name + 1;
        $data_arr[$new_data_name][$data_sort] = '';
    }
    if (!in_array($new_data_name, $all_my_row)) {
        $all_my_row[] = $new_data_name;
    }

    $TadDataCenter->set_col('id', $id);
    $TadDataCenter->saveCustomData($data_arr);

    $TadDataCenter->set_col('uid_row', $id);
    $TadDataCenter->saveCustomData([$uid => [implode(',', $all_my_row)]]);
    return $new_data_name;
}

function update_value($id, $data_name, $data_sort, $value)
{
    global $xoopsDB, $xoopsModule;

    $mod_name = empty($mod_name) ? $xoopsModule->dirname() : $mod_name;
    $sql = "update `" . $xoopsDB->prefix("{$mod_name}_data_center") . "` set `data_value`='{$value}' where `col_name` ='id' and  `col_sn` ='$id' and `data_name`='$data_name' and `data_sort`='$data_sort'";
    $xoopsDB->queryF($sql) or Utility::web_error($sql, __FILE__, __LINE__);
    return $value;

}
