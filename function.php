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


/********************* 自訂函數 *********************/
function test($var, $v = 1, $mode = 'dd')
{
    if ($_GET['test'] == $v) {
        if ($mode == 'die') {
            die($var);
        } else {
            Utility::dd($var);
        }
    }
}
