<?php
class FormGenerator{//start of class FormGenerator
	public $formHTML;//creating a class variable formHTML where entire HTML code is stored
	public function setMethod($method){
		$this->formHTML='<form action ="" method="'.$method.'">';//to set the form method and action
	}
	public function setMethodEnc($method, $enctype){
		$this->formHTML='<form action ="" method="'.$method.'" enctype="'.$enctype.'">';//to set the form with method, action and enctype
	}
	public function addText($label, $name, $value){
		//for addition of input type text with label, name and default value
		$this->formHTML.= '<label>'.$label.'</label>'.'<input type="text" name="'.$name.'" value="'.$value.'" required/>';
	}
	public function addTextArea($label, $name, $value){
		//for addition of textarea with label, name and default value
		$this->formHTML.='<label>'.$label.'</label>'.'<textarea name="'.$name.'" required>'.$value.'</textarea>';
	}
	public function addSelect($label, $name){
		//for addition of input type select with label and name
		$this->formHTML.='<label>'.$label.'</label>'.'<select name="'.$name.'">';	
	}

	public function addSelectValue($row){
		//for addition of options for select tag
			foreach($row as $column_name => $cell){//cell in each iteration contains data of one column of one row. Runs for all columns 
				if(!is_numeric($column_name)){//if the column_name is numeric
				if(is_numeric($cell))//if cell data is numeric
					$this->formHTML.='<option value="'.$cell.'">';//option value is set
				if(!is_numeric($cell))//if cell data is not numeric
					$this->formHTML.=$cell.'</option>';//set the value in between tags for display in drop down
				}
			}					
	}

	public function addSelectDirectValue($row){//options tags for direct value as arguments
		foreach ($row as $column_name => $cell) {//cell in each iteration contains data of one column of one row. Runs for all columns 
			$this->formHTML.='<option value="'.$cell.'">'.$cell.'</option>';//value and name is set for option tag
		}
	}

	public function closeSelect(){
		$this->formHTML.='</select>';//for closure for select tag
	}

	public function addEmail($label, $name, $value){
		//for addition of input type email with label, name and default value
		$this->formHTML.='<label>'.$label.'</label>'.'<input type="email" name="'.$name.'" value="'.$value.'" required/>';
	}

	public function addPassword($label, $name){
		//for addition of input type password with label, name and default value
		$this->formHTML.='<label>'.$label.'</label>'.'<input type="password" name="'.$name.'" required/>';
	}

	public function addHidden($name, $value){
		//for addition of input type hidden with label, name and default value
		$this->formHTML.='<input type="hidden" name="'.$name.'" value="'.$value.'"/>';
	}
	public function addImage($label, $name){
		//for addition of input type file for image with label, name
		$this->formHTML.='<label>'.$label.'</label><input type="file" name="'.$name.'"/>';
	}
	public function addSubmit($name, $value){
		//for addition of input type submit for form submission
		$this->formHTML.='<input type="submit" name="'.$name.'" value="'.$value.'"/>';
	}
	public function getHTML(){
		//returns all the data added to the formHTML variable
		return $this->formHTML.'</form>';
	}
}

?>