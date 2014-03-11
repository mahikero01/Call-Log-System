<?php
//class use for generating excel sheet 
class ExportExcelSheet
{
	private $sheet_headers = array();
	private $sheet_values = array();
	private $file_name;
	
	function __construct($file_name, $headers, $values) 
	{
		$this->file_name = $file_name;
		$this->sheet_headers = $headers;
		$this->sheet_values = $values;
		
		$this->GenerateExcelFile();
	}
	
	//generate the file
	public function GenerateExcelFile() {
		$excel_report_header = "";
		$excel_report_value = "";
		
		foreach ($this->sheet_headers as $sheet_header) 
 		{ 
 			$excel_report_header .= $sheet_header."\t"; 
 		} 
 		
		$last_index = count($this->sheet_values);
		$last_index_inner = count($this->sheet_values[0]);
	 	for ($index = 0; $index < $last_index; $index++) {
	 		for ($inner_index = 0; $inner_index < $last_index_inner; $inner_index++) {
	 			$excel_report_value .= $this->sheet_values[$index][$inner_index]."\t";
	 		}
	 		
	 		$excel_report_value .= "\n";
	 	}
 
		header("Content-type: application/vnd.ms-excel"); 
		header("Content-Disposition: attachment; filename=$this->file_name"); 
		header("Pragma: no-cache"); 
		header("Expires: 0"); 
		print "$excel_report_header\n$excel_report_value";  
	}
}
?>
