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
    $class_name = ucfirst(basename(dirname(__DIR__))) . 'CorePreload';
    class_alias('Tad_searchCorePreload', $class_name);
}

if (!class_exists('Tad_searchCorePreload')) {
    class Tad_searchCorePreload extends XoopsPreloadItem
    {
        // to add PSR-4 autoloader

        /**
         * @param $args
         */
        public static function eventCoreIncludeCommonEnd($args)
        {
            require __DIR__ . '/autoloader.php';
        }
    }
}
