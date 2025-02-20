<?php
use XoopsModules\Tad_search\Tad_search;
if (! class_exists('XoopsModules\Tad_search\Tad_search')) {
    require XOOPS_ROOT_PATH . '/modules/tad_search/preloads/autoloader.php';
}
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

$mod_name = basename(dirname(dirname(__FILE__)));
if ($mod_name != 'tad_search') {
    eval("function {$mod_name}_show(\$options){
        return tad_search_show(\$options);
    }");
    eval("function {$mod_name}_show_edit(\$options){
        return tad_search_show_edit(\$options);
    }");
}

//區塊主函式 (tad_search_show)
if (! function_exists('tad_search_show')) {
    function tad_search_show($options = '')
    {
        $mod_name          = $options[0];
        $block['mod_name'] = $mod_name;
        $block['id']       = $options[1] ? (int) $options[1] : 1;
        $block['content']  = Tad_search::show($mod_name, ['enable' => 1, 'id' => $block['id']], [], 'return');
        return $block;
    }
}

//區塊編輯函式 (tad_search_show_edit)
if (! function_exists('tad_search_show_edit')) {
    function tad_search_show_edit($options = '')
    {

        $options[1] = $options[1] ? (int) $options[1] : 1;

        $mod_name = $options[0];
        // $mod_name = basename(dirname(dirname(__FILE__)));
        $all_search = Tad_search::get_all($mod_name, ['enable' => 1]);
        foreach ($all_search as $search) {
            $selected = $options[1] == $search['id'] ? 'selected' : '';
            $option   = "<option value='{$search['id']}' $selected>{$search['title']}</option>";
        }

        $form = "
        <ol class='my-form'>
            <li class='my-row'>
                <lable class='my-label'>模組目錄（沒事勿改）</lable>
                <div class='my-content'>
                    <input type='text' name='options[0]' class='my-input' value='" . $mod_name . "'>
                </div>
            </li>
            <li class='my-row'>
                <lable class='my-label'>請指定一個資料查詢</lable>
                <div class='my-content'>
                    <select name='options[1]' class='my-input'>
                        <option value=''></option>
                        {$option}
                    </select>
                </div>
            </li>
        </ol>
        ";
        return $form;
    }
}
