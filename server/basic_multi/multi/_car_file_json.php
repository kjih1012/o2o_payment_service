<?php
include_once('./_common.php');

$bo_table = $_POST['bo_table'];
$wr_id	= $_POST['wr_id'];
if(!$bo_table || !$wr_id) { die(); }
// 가변 파일
$data = Array();
$view = get_view($write, $board, $board_skin_url);
for ($i=0; $i<count($view['file']); $i++)
{
	if (isset($view['file'][$i]['source']) && $view['file'][$i]['source'] && !$view['file'][$i]['view'])
	{

		$data[] = Array(
					"no"		=> $i,
					"source"	=> $view['file'][$i]['source'],
					"size"		=> $view['file'][$i]['size'],
					"download"	=> $view['file'][$i]['download'],
					"content"	=> $view['file'][$i]['content'],
					"datetime"	=> $view['file'][$i]['datetime'],
					"dlink"		=> "<span class='dlink' onclick=\"pic_Del('{$wr_id}', '{$i}', '1');\">삭제</span>"
					);
	}
}
$data = ($data==null)? "":$data;
echo json_encode($data);
exit;
?>