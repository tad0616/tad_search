<?php
use Xmf\Request;
use XoopsModules\Tadtools\TadDataCenter;
use XoopsModules\Tad_search\Tad_search;
use XoopsModules\Tad_search\Tools;
/*-----------引入檔案區--------------*/
require_once __DIR__ . '/header.php';
Tools::chk_is_adm('', '', __FILE__, __LINE__);

/*-----------變數過濾----------*/
$op = Request::getString('op');
$id = Request::getInt('id');
$tad_search_dirname = basename(__DIR__);

$search = Tad_search::get($tad_search_dirname, ['id' => $id]);

Tools::chk_is_adm('', '', __FILE__, __LINE__);

require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel.php'; //引入 PHPExcel 物件庫
require_once XOOPS_ROOT_PATH . '/modules/tadtools/vendor/phpoffice/phpexcel/Classes/PHPExcel/IOFactory.php'; //引入PHPExcel_IOFactory 物件庫
$objPHPExcel = new PHPExcel(); //實體化Excel
//----------內容-----------//
$title = "{$search['title']}-" . date("Y-m-d-H-i-s");
$objPHPExcel->setActiveSheetIndex(0); //設定預設顯示的工作表
$objActSheet = $objPHPExcel->getActiveSheet(); //指定預設工作表為 $objActSheet
$objActSheet->setTitle($title); //設定標題
$objPHPExcel->createSheet(); //建立新的工作表，上面那三行再來一次，編號要改

// 抓出標題資料

$col = 0;
foreach ($search['columns_arr'] as $col_title => $column) {
    $tag = '';
    if (isset($column['type'])) {
        if ($column['type'] == _MD_TADSEARCH_DATE) {
            $tag .= '[d]';
        } elseif ($column['type'] == _MD_TADSEARCH_DATETIME) {
            $tag .= '[dt]';
        } elseif ($column['type'] == _MD_TADSEARCH_PHONE) {
            $tag .= '[p]';
        } elseif ($column['type'] == _MD_TADSEARCH_TEXT) {
            $tag .= '[t]';
        } elseif ($column['type'] == _MD_TADSEARCH_NAME) {
            $tag .= '[n]';
        }
    }

    if (isset($column['groups']) && !empty($column['groups'])) {
        $tag .= '(g)';
    }
    if (isset($column['hide']) && $column['hide'] == 1) {
        $tag .= '(h)';
    }

    if (isset($column['search'])) {
        if ($column['search'] == 'bind email') {
            $tag .= '(e)';
        } elseif ($column['search'] == 'bind name') {
            $tag .= '(n)';
        } elseif ($column['search'] == 'bind schoolcode') {
            $tag .= '(s)';
        } elseif ($column['search'] == 'or like') {
            $tag .= '(%)';
        } elseif ($column['search'] == 'or same') {
            $tag .= '(=)';
        } elseif ($column['search'] == 'and like') {
            $tag .= '(%%)';
        } elseif ($column['search'] == 'and same') {
            $tag .= '(==)';
        }
    }

    $objActSheet->setCellValueByColumnAndRow($col, 1, $col_title . $tag); //直欄從0開始，橫列從1開始
    $col++;
}

$TadDataCenter = new TadDataCenter($tad_search_dirname);
$TadDataCenter->set_col('id', $id);
$data_arr = $TadDataCenter->getData();
unset($data_arr[1]);

foreach ($data_arr as $row => $data) {
    foreach ($data as $col => $val) {
        $objActSheet->setCellValueByColumnAndRow($col, $row, $val); //直欄從0開始，橫列從1開始
    }
}

// $title = (_CHARSET === 'UTF-8') ? iconv('UTF-8', 'Big5', $title) : $title;
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header("Content-Disposition: attachment;filename={$title}.xlsx");
header('Cache-Control: max-age=0');
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');

// 避免excel下載錯誤訊息
for ($i = 0; $i < ob_get_level(); $i++) {
    ob_end_flush();
}
ob_implicit_flush(1);
ob_clean();
$objWriter->setPreCalculateFormulas(false);
$objWriter->save('php://output');
exit;
