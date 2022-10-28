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
define('_MD_TADSEARCH_ID', '編號');
define('_MD_TADSEARCH_TITLE', '標題');
define('_MD_TADSEARCH_CONTENT', '說明');
define('_MD_TADSEARCH_COLUMNS', '所有欄位');
define('_MD_TADSEARCH_GROUPS', '可觀看群組');
define('_MD_TADSEARCH_GROUPS_NOTE', '<ol>
<li>若沒設定群組，表示訪客也可以看到該欄內容</li>
<li>部份敏感資訊或個資建議設定可觀看群組，避免個資外洩</li>
</ol>');
define('_MD_TADSEARCH_IS_HIDE', '是否隱藏');
define('_MD_TADSEARCH_IS_HIDE_NOTE', '<ol>
<li>若設成「隱藏」，將不顯示該欄位。</li>
<li>例如：「身份證號」欄位可以用來作為搜尋欄位，但可設成「隱藏」，以確保個資安全</li>
</ol>');
define('_MD_TADSEARCH_HIDE', '隱藏');
define('_MD_TADSEARCH_SEARCH', '搜尋');
define('_MD_TADSEARCH_SEARCH_BY_THIS', '以此欄位搜尋');
define('_MD_TADSEARCH_SEARCH_BY_THIS_NOTE', '<ol>
<li>若有設定「以此欄位搜尋」代表需輸入該欄位的值，並依此值去搜尋出符合條件的資料。</li>
<li>例如：成績查詢可能會輸入「學號」+「身份證號」來查詢符合條件的資料</li>
<li>若無任何「以此欄位搜尋」，那會自動列出所有內容，並可進行任意搜尋</li>
<li>「自動綁定 xxx」是指當使用者登入時，可以抓到使用者的 Email、姓名、或學校代碼（用縣市OpenID或OIDC登入時），並自動比對該欄資料，直接顯示屬於該使用者資料，無須自行輸入搜尋（故無法搜尋他人資料）。</li>
</ol>');
define('_MD_TADSEARCH_FORMAT', '格式');
define('_MD_TADSEARCH_FORMAT_NOTE', '<ol>
<li>「格式」一般是匯入前就要設定好，以便匯入正確格式，如日期或手機等。</li>
<li>匯入後，僅「姓名」設定會有效果，若是訪客，會自動將姓名的第二個字改為 O </li>
</ol>');

define('_MD_TADSEARCH_COLUMN_SETUP', '欄位設定');

define('_MD_TADSEARCH_UID', '發布者');
define('_MD_TADSEARCH_UPDATE_DATE', '最後更新日期');
define('_MD_TADSEARCH_ENABLE', '是否啟用');
define('_MD_TADSEARCH_COL', '欄位名稱');
define('_MD_TADSEARCH_DATETIME', '日期時間');
define('_MD_TADSEARCH_DATE', '日期');
define('_MD_TADSEARCH_PHONE', '電話');
define('_MD_TADSEARCH_TEXT', '文字');
define('_MD_TADSEARCH_NAME', '姓名');

define('_MD_TADSEARCH_NEED_LOGIN', '請先登入，登入後會自動顯示和您相關的資料');
define('_MD_TADSEARCH_INCOMPATIBLE', '您目前的登入身份查無相關資料');
define('_MD_TADSEARCH_NEED_KEY_IN', '請輸入以下欄位，以查尋資料');

define('_MD_TADSEARCH_EXPORT_EXCEL', '匯出 Excel');
define('_MD_TADSEARCH_NO_VIEW_PRIVILEGES', '無觀看權限');
define('_MD_TADSEARCH_NO_PRIVILEGES', '無操作權限');
define('_MD_TADSEARCH_NO_ACCESS_TO_THIS', '您對此資料無操作權限');
define('_MD_TADSEARCH_BOUND_TO', '顯示資料已綁定：');
define('_MD_TADSEARCH_NUMBER_OF_COLUMNS', '欄位數：');

define('_MD_TADSEARCH_AND_SAME', '必填，值需完全相同');
define('_MD_TADSEARCH_OR_SAME', '非必填，值需完全相同');
define('_MD_TADSEARCH_AND_LIKE', '必填，值部份符合即可');
define('_MD_TADSEARCH_OR_LIKE', '非必填，值部份符合即可');
define('_MD_TADSEARCH_BIND_EMAIL', '自動綁定登入者 Email');
define('_MD_TADSEARCH_BIND_NAME', '自動綁定登入者姓名');
define('_MD_TADSEARCH_BIND_SCHOOLCODE', '自動綁定登入者學校代碼');

define('_MD_TADSEARCH_REIMPORT', '資料重新匯入（會覆蓋所有舊資料）');
define('_MD_TADSEARCH_IMPORT', '匯入');
define('_MD_TADSEARCH_IMPORT_AND_ADD', '匯入 xlsx 檔並建立新專案');
define('_MD_TADSEARCH_IMPORT_XLSX', '匯入 xlsx 檔');
define('_MD_TADSEARCH_IMPORT_NOTE', '<li>開啟 MS Office 的 Excel 或 LibreOffice 的 Calc</li>
<li>第一行為標題（一定要有），欄位數不拘，可以中文</li>
<li>標題可加入以下「格式標籤」來指定格式（含 [ ] 中括號），除姓名外，均需匯入前就設定好：
    <ul>
    <li><span class="badge bage-light bg-light text-dark">[d]</span> ：date 日期格式</li>
    <li><span class="badge bage-light bg-light text-dark">[dt]</span> ：date time 日期+時間格式</li>
    <li><span class="badge bage-light bg-light text-dark">[p]</span> ：phone 電話（手機會自動補 0）</li>
    <li><span class="badge bage-light bg-light text-dark">[t]</span> ：text 文字格式</li>
    <li><span class="badge bage-light bg-light text-dark">[n]</span> ：name 姓名（訪客觀看時會自動隱藏第二個字）</li>
    </ul>
</li>
<li>標題可加入以下「搜尋標籤」來指定相關設定（含 ( ) 小括號）：
    <ul>
        <li><span class="badge bage-light bg-light text-dark">(g)</span> ：登入才能看到</li>
        <li><span class="badge bage-light bg-light text-dark">(h)</span> ：不顯示於畫面上</li>
        <li><span class="badge bage-light bg-light text-dark">(e)</span> ：搜尋時，用來綁定登入者Email作為搜尋條件</li>
        <li><span class="badge bage-light bg-light text-dark">(n)</span> ：搜尋時，用來綁定登入者姓名作為搜尋條件</li>
        <li><span class="badge bage-light bg-light text-dark">(s)</span> ：搜尋時，用來綁定登入者學校代碼作為搜尋條件</li>
        <li><span class="badge bage-light bg-light text-dark">(%)</span> ：搜尋時，（非必填）只要部份符合即可</li>
        <li><span class="badge bage-light bg-light text-dark">(%%)</span> ：搜尋時，（必填）只要部份符合即可</li>
        <li><span class="badge bage-light bg-light text-dark">(=)</span> ：搜尋時，（非必填）要完全符合才行</li>
        <li><span class="badge bage-light bg-light text-dark">(==)</span> ：搜尋時，（必填）要完全符合才行</li>
    </ul>
</li>
<li>同一個標題可以有一個「格式標籤」和多個「搜尋標籤」，前後位置不拘。例如：
<img src="images/demo.png" class="img-responsive img-fluid"></li>
<li>第二行起均為內容行，行數不拘，盡可能完整</li>
<li>務必存成 xlsx 檔，檔案名稱匯入後就是專案名稱</li>
<li>存完後，從下方表單匯入即可</li>');

define('_MD_TADSEARCH_NO_QUERY_CRITERIA', '無查詢條件：');
define('_MD_TADSEARCH_REQUIRE', '必填！');
define('_MD_TADSEARCH_COMPLETE_VALUE', '請輸入完整「%s」的值');
define('_MD_TADSEARCH_KEYWORD', '請輸入「%s」的關鍵字');
define('_MD_TADSEARCH_SELECT_GROUPS', '請選擇群組');
