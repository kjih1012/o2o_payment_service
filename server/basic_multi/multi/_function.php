<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

function option_str($data1,$data2,$option_name=''){

	$data1=explode("|",$data1);
	$data2=explode("|",$data2);
	for($i=0; $i < count($data1); $i++){ $dataA[$i] = trim($data1[$i]); }
	for($i=0; $i < count($data2); $i++){ $dataB[$i] = trim($data2[$i]); }
	for($i=0; $i < count($data2); $i++){
		$selected = ( $option_name == $dataB[$i] )? "selected":"";
		$result .="<option value='".$dataB[$i]."' ".$selected.">".$dataA[$i]."</option>";
	}
	return($result);
}

function option_int($start,$end,$plus,$option_name){

	for($i=$start; $i <= $end; $i+=$plus){
		$selected=($option_name==$i)? "selected":"";
		$result .="<option value='$i' $selected>$i</option>";
	}
	return($result);
}

?>
