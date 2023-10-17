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

xoops_loadLanguage('main', 'tadtools');
define('_MD_TADSEARCH_ID', 'ID');
define('_MD_TADSEARCH_TITLE', 'Title');
define('_MD_TADSEARCH_CONTENT', 'Description');
define('_MD_TADSEARCH_COLUMNS', 'All fields');
define('_MD_TADSEARCH_GROUPS', 'Watch the group');
define('_MD_TADSEARCH_GROUPS_NOTE', '<ol>
<li>If no group is set, it means that visitors can also see the content of the column</li>
<li>Some sensitive information or personal data is recommended to set up a viewable group to avoid leakage of personal data.</li>
</ol>');
define('_MD_TADSEARCH_IS_HIDE', 'To hide or not to hide');
define('_MD_TADSEARCH_IS_HIDE_NOTE', '<ol>
<li>If "Hide" is set, the field will not be displayed.</li>
<li>For example, the "ID number" field can be used as a search field, but can be set to "hidden" to ensure the security of personal information</li>
</ol>');
define('_MD_TADSEARCH_HIDE', 'Hide');
define('_MD_TADSEARCH_SEARCH', 'Search');
define('_MD_TADSEARCH_SEARCH_BY_THIS', 'Search by this field');
define('_MD_TADSEARCH_SEARCH_BY_THIS_NOTE', '<ol>
<li>If you set "Search by this field", it means you need to enter the value of the field and search for the data that match the criteria.</li>
<li>For example, a grade query may enter "student number" + "ID number" to find the information that meets the criteria</li>
<li>If there is no "search by this field", then all contents will be listed automatically and you can search by any field.</li>
<li>"Auto-binding xxx" means that when a user logs in, the user\'s email, name, or school code (when logging in with OpenID or OIDC) will be captured and automatically compared with the information in that field, and the user\'s information will be displayed directly, without the need to search for it by typing it in (so it is impossible to search other people\'s information).</li>
</ol>');
define('_MD_TADSEARCH_FORMAT', 'Format');
define('_MD_TADSEARCH_FORMAT_NOTE', '<ol>
<li>"Format" is usually set before importing so that the correct format, such as date or phone, can be imported.</li>
<li>After importing, only the "Name" setting will have an effect. If you are a guest, the second character of your name will automatically be changed to O </li>
</ol>');

define('_MD_TADSEARCH_COLUMN_SETUP', 'Field Settings');

define('_MD_TADSEARCH_UID', 'Distributed by');
define('_MD_TADSEARCH_UPDATE_DATE', 'Last update date');
define('_MD_TADSEARCH_ENABLE', 'Enabled or not');
define('_MD_TADSEARCH_COL', 'Column Name');
define('_MD_TADSEARCH_DATETIME', 'Date and Time');
define('_MD_TADSEARCH_DATE', 'Date');
define('_MD_TADSEARCH_PHONE', 'Telephone');
define('_MD_TADSEARCH_TEXT', 'Text');
define('_MD_TADSEARCH_NAME', 'Name');

define('_MD_TADSEARCH_NEED_LOGIN', 'Please login first, your information will be displayed automatically after login');
define('_MD_TADSEARCH_INCOMPATIBLE', 'No information about your current login status');
define('_MD_TADSEARCH_NEED_KEY_IN', 'Please enter the following fields to search for information');

define('_MD_TADSEARCH_EXPORT_EXCEL', 'Export Excel');
define('_MD_TADSEARCH_NO_VIEW_PRIVILEGES', 'No viewing privileges');
define('_MD_TADSEARCH_NO_PRIVILEGES', 'No permission to operate');
define('_MD_TADSEARCH_NO_ACCESS_TO_THIS', 'You have no access to this data');
define('_MD_TADSEARCH_BOUND_TO', 'Display data is bound to:');
define('_MD_TADSEARCH_NUMBER_OF_COLUMNS', 'Number of columns:');

define('_MD_TADSEARCH_AND_SAME', 'Must be filled in, the values must be identical');
define('_MD_TADSEARCH_OR_SAME', 'Not required, the values must be identical');
define('_MD_TADSEARCH_AND_LIKE', 'Required field, the value part can match');
define('_MD_TADSEARCH_OR_LIKE', 'Not required, the value part can match');
define('_MD_TADSEARCH_BIND_EMAIL', 'Auto-binding Login Email');
define('_MD_TADSEARCH_BIND_NAME', 'Auto-bind login name');
define('_MD_TADSEARCH_BIND_SCHOOLCODE', 'Automatically bind the login school code');

define('_MD_TADSEARCH_REIMPORT', 'Data re-import (will overwrite all old data)');
define('_MD_TADSEARCH_IMPORT', 'Import');
define('_MD_TADSEARCH_IMPORT_AND_ADD', 'Import an xlsx file and create a new project');
define('_MD_TADSEARCH_IMPORT_XLSX', 'Import xlsx files');
define('_MD_TADSEARCH_IMPORT_NOTE', '<li>Open Excel for MS Office or Calc for LibreOffice</li>
<li>The first line is the title (must have), the number of columns is not restricted, can be Chinese</li>
<li>The following "formatting tags" can be added to the title to specify the format (including [ ] brackets), which must be set before importing, except for names.
    <ul>
    <li><span class="badge bage-light bg-light text-dark">[d]</span> : Date Format</li>
    <li><span class="badge bage-light bg-light text-dark">[dt]</span> : Date + Time Format</li>
    <li><span class="badge bage-light bg-light text-dark">[p]</span> : Phone (phone will automatically fill 0)</li>
    <li><span class="badge bage-light bg-light text-dark">[t]</span> : Text Format</li>
    <li><span class="badge bage-light bg-light text-dark">[n]</span> : 姓First name (the second word is automatically hidden when visitors watch)</li>
    </ul>
</li>
<li>The following "search tags" can be added to the title to specify the relevant settings (with ( ) parentheses).
    <ul>
        <li><span class="badge bage-light bg-light text-dark">(g)</span> : Login to see</li>
        <li><span class="badge bage-light bg-light text-dark">(h)</span> : Not shown on the screen</li>
        <li><span class="badge bage-light bg-light text-dark">(f)</span> : Add filter</li>
        <li><span class="badge bage-light bg-light text-dark">(e)</span> : When searching, use to bind the login Email as search criteria</li>
        <li><span class="badge bage-light bg-light text-dark">(n)</span> : When searching, use to bind the login name as search criteria</li>
        <li><span class="badge bage-light bg-light text-dark">(s)</span> : When searching, use to bind the login school code as search criteria</li>
        <li><span class="badge bage-light bg-light text-dark">(%)</span> : When searching, (not required) as long as some of the fields match</li>
        <li><span class="badge bage-light bg-light text-dark">(%%)</span> Search: (required) as long as part of the search matches</li>
        <li><span class="badge bage-light bg-light text-dark">(=)</span> : When searching, (not required) must match all</li>
        <li><span class="badge bage-light bg-light text-dark">(==)</span> : When searching, (required) must match all</li>
    </ul>
</li>
<li>The same title can have one "formatting tag" and multiple "search tags", regardless of the position before or after. For example.
<img src="images/demo.png" class="img-responsive img-fluid"></li>
<li>If the content of the cell is a pure URL (starting with http or https), a link will be added automatically.</li>
<li>If you want to customize the link text in the cell, you can use "Show Text<span style="color:red">|</span>https://link.to.somewhere" to add the link to the display text automatically.</li>
<li>The second line onwards is the content line, the number of lines is not restricted, as complete as possible</li>
<li>Be sure to save it as an xlsx file, the file name is the project name after importing</li>
<li>After saving, just import from the form below</li>');

define('_MD_TADSEARCH_NO_QUERY_CRITERIA', 'No query conditions.');
define('_MD_TADSEARCH_REQUIRE', 'Required field!');
define('_MD_TADSEARCH_COMPLETE_VALUE', 'Please enter the full "%s" value');
define('_MD_TADSEARCH_KEYWORD', 'Please enter the keyword "%s".');
define('_MD_TADSEARCH_SELECT_GROUPS', 'Please select a group');
define('_MD_TADSEARCH_DISPLAY_SEARCHBOX', 'Is the search box displayed?');
define('_MD_TADSEARCH_DISPLAY_PKID', 'Is the number displayed?');
define('_MD_TADSEARCH_URL_MODE', 'How is the web address displayed?');
define('_MD_TADSEARCH_URL_FULL', 'Full URL');
define('_MD_TADSEARCH_URL_SHORT', 'Short URL');
define('_MD_TADSEARCH_URL', 'URL');
define('_MD_TADSEARCH_VIEW_PERM', 'Who can see the data?');
define('_MD_TADSEARCH_ADD_PERM', 'Who can add data?');
define('_MD_TADSEARCH_MODIFY_PERM', 'Who can modify the data?');
define('_MD_TADSEARCH_DEL_PERM', 'Who can delete data?');
define('_MD_TADSEARCH_CAN_VIEW', 'With view permission');
define('_MD_TADSEARCH_CAN_NOT_VIEW', 'You do not have permission to use');
define('_MD_TADSEARCH_CAN_ADD', 'With add permission (You can modify or delete the information you have added)');
define('_MD_TADSEARCH_CAN_MODIFY', 'have modify privilege');
define('_MD_TADSEARCH_CAN_DEL', 'have delete privilege');
define('_MD_TADSEARCH_DEL_DATA', 'Delete Selected Data');
define('_MD_TADSEARCH_ADD_DATA', 'Add Data');
define('_MD_TADSEARCH_MODIFY_MODE', 'Enter modification mode');
define('_MD_TADSEARCH_VIEW_MODE', 'Browsing Mode');
define('_MD_TADSEARCH_FILL', 'Please fill in');
define('_MD_TADSEARCH_EMPTY', 'Empty');
