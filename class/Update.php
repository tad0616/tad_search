<?php
namespace XoopsModules\Tad_search;

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
 * Class Update
 */
class Update
{

    public static function update_group_permission($module)
    {
        global $xoopsDB;
        $mid = $module->mid();
        $dirname = $module->dirname();
        $sql = 'SELECT count(*) FROM ' . $xoopsDB->prefix('group_permission') . " WHERE `gperm_modid`='$mid' and `gperm_name`='view'";
        $result = $xoopsDB->query($sql);
        list($count) = $xoopsDB->fetchRow($result);
        if (empty($count)) {
            $sql = 'SELECT `id` FROM ' . $xoopsDB->prefix($dirname) . "";
            $result = $xoopsDB->queryF($sql);
            while (list($id) = $xoopsDB->fetchRow($result)) {
                $sql = 'replace into ' . $xoopsDB->prefix('group_permission') . " (`gperm_groupid`, `gperm_itemid`, `gperm_modid`, `gperm_name`) values(2, '$id', '$mid', 'view'), (3, '$id', '$mid', 'view')";
                $xoopsDB->queryF($sql);
            }
        }
        return true;
    }
}
