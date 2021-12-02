<?php
require_once($_SERVER['DOCUMENT_ROOT']."/safra/model/connect.php");

class Client{
		
		function register($values, $attdata, $locations, $prices){
		$result = true;
		
		$obj_con = new ConnectionDB;
		$connect=$obj_con->con();
		
		
		$search = mysqli_query($connect ,"SELECT dataSoja FROM soja_tbl WHERE dataSoja = '".$attdata."'"); //check for new date.
		if(mysqli_num_rows($search) > 0){ //if date already exist
			
			$sojinha = mysqli_query($connect, "SELECT idSoja FROM soja_tbl WHERE dataSoja = '".$attdata."'");
			
			$y = 0;
			foreach($sojinha as $valor){
				$y++;
				$sqlUpdate = "UPDATE soja_tbl SET localSoja='".$locations[$y]."', precoSoja=".$prices[$y]." WHERE idSoja=".$valor['idSoja'];
		
				mysqli_query($connect,$sqlUpdate);
			}
			
		}else{ //if date dont exist
			$sqlQuery = "
					INSERT INTO
						soja_tbl (localSoja, precoSoja, dataSoja, culturaSoja)
					VALUES
						". implode (", ", $values);
			
			mysqli_query($connect,$sqlQuery);
		}
			
		if($result === false){
			return false;
		}else{
			return true;
		}	
	}
}

