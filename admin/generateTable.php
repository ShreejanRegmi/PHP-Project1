<?php
class GenerateTable{//start of class GenerateTable
	public $table_headings;//creating class variable table_headings
	public $table_rows=[];//creating an array to store row data from table query
	public $additionalRequirement=[];//additional array variable for additional column 'function'
	public function setTableHeadings($table_heading){//method to set headings of the table
		$this->table_headings=$table_heading;//parameter value is set to class variable table_headings
	}

	public function addTableRow($table_row){//method to set row data of the table
		$this->table_rows[]=$table_row;//parameter value is set to class variable table_rows
	}
	
	public function addRowRequirement($code){//method to set additional column 'function'
		$this->additionalRequirement[]=$code;//parameter value is set to class variable additionalRequirement
	}

	public function getTableHTML(){//to generate HTML code
		$table_html='<table border="1">';//defining table tag with border value
		$table_html.='<tr>';//start of first table row
		foreach ($this->table_headings as $table_heading) {//looping through one heading value in each iteration
			$table_html.='<th>'.$table_heading.'</th>';//sets the table heading 
		}
		$table_html.='</tr>';//end of first table row
		foreach ($this->table_rows as $key => $table_row) {//looping through one row at a time for many rows
			$table_html.='<tr>';//start of table row
			foreach ($table_row as $table_column => $table_cell) {//looping through one column value at a time for many columns
				if(!is_numeric($table_column)){//if the column value is not numeric
					$table_html.='<td>'.$table_cell.'</td>';//sets the table data
					}
			}
			if(is_numeric($key)){//if the row value(ID) is numeric
				$table_html.=$this->additionalRequirement[$key];//adds code for action at the end of the row
			}
			$table_html.='</tr>';//end of table row
		}
		$table_html.='</table>';//closing of table tag
		return $table_html;//table_html variable with all HTML code is returned
	}
}
?>