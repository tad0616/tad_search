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
$tad_search_dirname = basename(dirname(__DIR__));
$function_name = "xoops_module_install_{$tad_search_dirname}";
$function_code = "
function $function_name(\$module)
{
    XoopsModules\Tadtools\Utility::mk_dir(XOOPS_ROOT_PATH . \"/uploads/$tad_search_dirname\");
    XoopsModules\Tadtools\Utility::mk_dir(XOOPS_ROOT_PATH . \"/uploads/$tad_search_dirname/file\");
    XoopsModules\Tadtools\Utility::mk_dir(XOOPS_ROOT_PATH . \"/uploads/$tad_search_dirname/image\");
    XoopsModules\Tadtools\Utility::mk_dir(XOOPS_ROOT_PATH . \"/uploads/$tad_search_dirname/image/.thumbs\");

    return true;
}
";

eval($function_code);
