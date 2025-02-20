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
$tad_search_dirname = $xoopsModule->getVar('dirname');
require_once dirname(dirname(dirname(__DIR__))) . '/include/cp_header.php';
require_once XOOPS_ROOT_PATH . '/modules/' . $tad_search_dirname . '/preloads/autoloader.php';
require_once XOOPS_ROOT_PATH . '/modules/tadtools/preloads/autoloader.php';

xoops_loadLanguage('main', $tad_search_dirname);

if (! isset($xoopsTpl) || ! is_object($xoopsTpl)) {
    require_once XOOPS_ROOT_PATH . '/class/template.php';
    $xoopsTpl = new \XoopsTpl();
}

xoops_cp_header();

// Define Stylesheet and JScript
$xoTheme->addStylesheet('modules/tadtools/css/iconize.css');
$xoTheme->addStylesheet(XOOPS_URL . "/modules/tadtools/css/xoops_adm{$_SESSION['bootstrap']}.css");
$xoTheme->addStylesheet('modules/' . $tad_search_dirname . '/css/module.css');
$xoTheme->addStylesheet('modules/' . $tad_search_dirname . '/css/admin.css');
$_SESSION[$tad_search_dirname . '_adm'] = true;
