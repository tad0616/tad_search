<?php
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

defined('XOOPS_ROOT_PATH') || die('Restricted access.');

/**
 * Class Tad_searchCorePreload
 */
if (basename(dirname(__DIR__)) !== 'tad_search') {
    $className = ucfirst(basename(dirname(__DIR__))) . 'CorePreload';

    $classCode = "
class $className extends XoopsPreloadItem
{
    public static function eventCoreIncludeCommonEnd(\$args)
    {
        require __DIR__ . '/autoloader.php';
    }
}
";

    eval($classCode);
    // class_alias($className, 'Tad_searchCorePreload');
} else {
    class Tad_searchCorePreload extends XoopsPreloadItem
    {
        public static function eventCoreIncludeCommonEnd($args)
        {
            require __DIR__ . '/autoloader.php';
        }
    }

}
