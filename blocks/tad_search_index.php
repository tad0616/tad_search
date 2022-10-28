<?php
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

$mod_name = basename(dirname(dirname(__FILE__)));
if ($mod_name != 'tad_search') {
    eval("function {$mod_name}_index(\$options){
        return tad_search_index(\$options);
    }");
    eval("function {$mod_name}_index_edit(\$options){
        return tad_search_index_edit(\$options);
    }");
}

//區塊主函式 (tad_search_index)
if (!function_exists('tad_search_index')) {
    function tad_search_index($options = '')
    {
        $mod_name = $options[0];
        $block['mod_name'] = $mod_name;
        $block['content'] = Tad_search::get_all($mod_name, ['enable' => 1]);

        return $block;
    }
}

//區塊編輯函式 (tad_search_index_edit)
if (!function_exists('tad_search_index_edit')) {
    function tad_search_index_edit($options = '')
    {

        // $mod_name = basename(dirname(dirname(__FILE__)));

        $mod_name = $options[0];
        $form = "
        <ol class='my-form'>
            <li class='my-row'>
                <lable class='my-label'>模組目錄（沒事勿改）</lable>
                <div class='my-content'>
                    <input type='text' name='options[0]' class='my-input' value='" . $mod_name . "'>
                </div>
            </li>
        </ol>
        ";
        return $form;
    }
}
