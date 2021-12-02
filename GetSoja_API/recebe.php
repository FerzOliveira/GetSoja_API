<?php
require($_SERVER['DOCUMENT_ROOT']."/safra/model/connect.php");

//calls connection - Start
$obj_con = new ConnectionDB;
$connect = $obj_con->con();
//calls connection - End

//get values - Start
$filterDate = @$_GET['attdate'];
$filterLoc  = @$_GET['location'];
$comando    = @$_GET['comando'];
//get values - End

$info   = array();

if($comando == "listcotacao"){
	if($filterDate > 0 and $filterLoc > 0){ //date and loc informed

		//date check - Start
		$dataexplode = explode("-","$filterDate");
		$y = $dataexplode[0];
		$m = $dataexplode[1];
		$d = $dataexplode[2];

		$datacheck = checkdate($m,$d,$y);
		//date check - End

		if($datacheck == 1){ //if date is valid
			if (preg_match('~[0-9]+~', $filterLoc)) { //invalid location
				$info['erro'][] = array(
						'resposta' => "local invalido"
					);
			}else{ //valid location and date
					$sql    = "SELECT * FROM soja_tbl WHERE localSoja = '".$filterLoc."' AND dataSoja = '".$filterDate."'";
					$result = mysqli_query($connect, $sql);
				if(mysqli_num_rows($result) > 0){
						while ($soja = mysqli_fetch_array($result)){
						$info['cotacao'][] = array(
							'id'       => intval($soja['idSoja']),
							'location' => $soja['localSoja'],
							'price'    => floatval($soja['precoSoja']),
							'attdate'  => $soja['dataSoja'],
							'culture'  => $soja['cultura']
						);
					}

				}else{ //no results found
					$info['erro'][] = array(
						'resposta' => "nenhum resultado encontrado"
					);	
				}
			}
		}else{ //invalid date
			$info['erro'][] = array(
						'resposta' => "data invalida"
					);
		}

	}elseif($filterDate > 0){ //location is null
		
		$sql = "SELECT * FROM soja_tbl WHERE dataSoja = '".$filterDate."'";
		$result = mysqli_query($connect, $sql);
		if(mysqli_num_rows($result) > 0){
				while ($soja = mysqli_fetch_array($result)){
				$info['cotacao'][] = array(
					'id'       => intval($soja['idSoja']),
					'location' => $soja['localSoja'],
					'price'    => floatval($soja['precoSoja']),
					'attdate'  => $soja['dataSoja'],
					'culture'  => $soja['cultura']
						);
					}
		}
		
	}elseif($filterLoc > 0){ //date is null
		$info['erro'][] = array(
						'resposta' => "necessario informar local"
					);
					
	}else{
		$info['erro'][] = array( //date and loc is null
						'resposta' => "necessario informar local e data"
					);
	}
}elseif($comando = "listlocal"){
	$sql    = "SELECT distinct localSoja FROM soja_tbl";
					$result = mysqli_query($connect, $sql);
				if(mysqli_num_rows($result) > 0){
						while ($soja = mysqli_fetch_array($result)){
						$info['cotacao'][] = array(
							'location' => $soja['localSoja'],
							);
						}
				}
	
}else{
	$info['erro'][] = array( //date and loc is null
						'resposta' => "comando não é valido"
					);
}

echo json_encode($info); //sends json
