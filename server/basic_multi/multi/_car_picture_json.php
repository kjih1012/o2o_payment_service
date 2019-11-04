<?php
include_once('./_common.php');
include_once(G5_LIB_PATH.'/thumbnail.lib.php');
$thumb_width = 150;
$thumb_height = 100;

$bo_table = $_POST['bo_table'];
$wr_id	= $_POST['wr_id'];
$switch = $_SESSION['multi_view_image'];

$source_path = G5_DATA_PATH."/file/".$bo_table;
//$target_path = G5_DATA_PATH."/file/".$bo_table."/thumb";
$target_path = G5_DATA_PATH."/file/".$bo_table;
$source_url = G5_DATA_URL."/file/".$bo_table;
//$target_url = G5_DATA_URL."/file/".$bo_table."/thumb";
$target_url = G5_DATA_URL."/file/".$bo_table;

if(!$switch) { die(); }

$sql = "select
			wr_id,
			bf_no,
			bf_file,
			( select mb_id from {$write_table} where wr_id = '{$wr_id}' ) as mb_id
		from
			{$g5['board_file_table']}
		where
			bo_table = '{$bo_table}' and wr_id = '{$wr_id}' and bf_type between 1 and 3
		order by
			bf_no asc ";
$res = sql_query($sql, true);

//echo $sql;
$id = array();
$total_count = 0;
while ($data = sql_fetch_array($res)) {

	$check_file = $target_url."/thumb-".$data['bf_file'];
	if(!is_file($check_file)) {
		$thumb_file = thumbnail($data['bf_file'], $source_path, $target_path, $thumb_width, $thumb_height, false, true);
	}

	$responce->arr[] = array(
					"thumb_filename"	=> $target_url."/".$thumb_file,
					"filename"			=> $source_url."/".$data['bf_file'],
					"wr_id"				=> $data['wr_id'],
					"bf_no"				=> $data['bf_no'],
					"sour"				=> ($switch==$bo_table."_on")? "<div class='pic_d' onclick=\"pic_Del('{$data['wr_id']}', '{$data['bf_no']}', '1');\"><i class='fa fa-remove' aria-hidden='true'></i></div>":"<div class='pic_dN'></div>"
					);
	$total_count++;
}

$responce->total_count = $total_count; // 총 이미지 개수
if($total_count==0) {
	$responce->arr = "";
}

echo json_encode($responce);
?>