<?php
session_start();
require_once ('export_excel_sheet_.php');

$excel_sheet = new ExportExcelSheet(
		$_SESSION['filename'],
		$_SESSION['headers'],
		$_SESSION['values']
		);

unset($excel_sheet);	
?>