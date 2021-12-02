<?php
	require($_SERVER['DOCUMENT_ROOT']."/safra/model/connect.php");
	require('controller/simple_html_dom.php'); //simple html DOM parser
	require('controller/controller_client.php');
	$html = file_get_html('https://www.canalrural.com.br/cotacao/soja/');//Extract data
	
	//date treatment - Start
	$attdata = $html -> find('b', 0)->plaintext;
	$attdata = implode(array_reverse(explode("/",$attdata)));
	//date treatment - End

	//table treatment - Start
	$table = $html->find('table', 3);
	$rowData = array();

	foreach($table->find('tr') as $row) {
		// initialize array to store the cell data from each row
		$flight = array();
		foreach($row->find('td') as $cell) {
			// push the cell's text to the array
			$flight[] = $cell->plaintext;
			
		}
		$rowData[] = $flight;
	}
 	unset($rowData[0]); //unset an empty array
	//table treatment - End

	//array treatment - Start
	
	foreach ($rowData as $rowValues) {
		foreach ($rowValues as $key => $rowValue) {
			 $rowValues[$key] = $rowValues[$key];
		}
		
		$values[] = "('" . implode("', ", $rowValues) .", '".$attdata."', 'Soja')";
	}
	//array treatment - End

	//array split - Start
	$locations = [];
	$prices = [];
	foreach ($rowData as $k => $v){
		$locations[$k] = $v[0];
		$prices[$k]    = $v[1];
	}
	//array slit - End
	
	//Inset into DB - Start
	$obj_client = new Client();
	$result = $obj_client -> register($values, $attdata, $locations, $prices);
	//Inset into DB - End

	header("/minhasoja.php");








	

