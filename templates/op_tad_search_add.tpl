<h2 class="my"><{$smarty.const._MD_TADSEARCH_IMPORT_AND_ADD}></h2>

<form action="index.php" method="post" class="my-4" enctype="multipart/form-data">
    <div class="input-group">
        <input type="file" name="excel_file" id="excel_file" maxlength="1" accept=".xlsx" class="form-control">
        <div class="input-group-append input-group-btn">
            <input type="hidden" name="op" value="tad_search_import">
            <input type="hidden" name="mode" value="store">
            <button type="submit" class="btn btn-primary"><{$smarty.const._MD_TADSEARCH_IMPORT_XLSX}></button>
        </div>
    </div>
</form>

<div class="alert alert-info">
    <ol class="m-0">
        <{$smarty.const._MD_TADSEARCH_IMPORT_NOTE}>
    </ol>
</div>