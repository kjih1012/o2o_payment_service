<?php
include_once('./_common.php');

$bf_no		= (int)$_POST['bf_no'];
$wr_id		= (int)$_POST['wr_id'];
$mode		= (int)$_POST['mode'];
$bo_table	= $_GET['bo_table'];

if(!$wr_id) { die(); }

if(!$_POST['mode']){
	die();
}


	// 삭제하려는 파일이 회원 본인의 파일인지 체크
	$sql = "select
				count(*) as cnt
			from
				{$write_table}
			where
				mb_id = '{$member['mb_id']}' and wr_id = '{$wr_id}' ";
	$row = sql_fetch($sql, true);

	// 관리자가 아니면서 자신의 게시물이 아니라면..
	if(!$is_admin && $row['cnt']==0) {
		$msg['msg'] = "권한이 없습니다.";
		echo json_encode($msg);
		exit;
	}

	// 단일파일 삭제시
	if($mode=='1') {

		$sql = "select
					*
				from
					g5_board_file
				where
					bo_table = '".$bo_table."' and wr_id = '".$wr_id."' and bf_no = '".$bf_no."' ";
		$rs = sql_fetch($sql, true);

		$file_name	= $rs['bf_file'];
		$file_path	= G5_DATA_PATH."/file/".$bo_table."/".$file_name; // 원본 경로.

		$fn = preg_replace("/\.[^\.]+$/i", "", basename($file_path)); // 파일이름만 구하기 (확장자 및 . 제외)

		$files = glob(G5_DATA_PATH.'/file/'.$bo_table.'/thumb-'.$fn.'*'); // 원본 파일명과 같은 파일들 배열생성
		if (is_array($files)) {
			foreach ($files as $filename) {
				unlink($filename); // 썸네일 파일들 삭제... 각 크기별로 모두 삭제.
			}
		}

		/*  썸네일 폴더를 thumb를 사용시.
		$files = glob(G5_DATA_PATH.'/file/'.$bo_table.'/thumb/thumb-'.$fn.'*'); // 원본 파일명과 같은 파일들.
		if (is_array($files)) {
			foreach ($files as $filename) {
				unlink($filename); // 썸네일 파일들 삭제... 각 크기별로 모두 삭제.
			}
		}
		*/

		//$file_path_t= G5_DATA_PATH."/file/".$bo_table."/thumb/thumb_".$file_name;
		if (file_exists($file_path)) {
			@unlink($file_path);   // 원본파일 제거
			sql_query(" delete from
							{$g5['board_file_table']}
						where
							bo_table = '{$bo_table}' and wr_id = '{$wr_id}'	and bf_no = '{$bf_no}' ");
			$msg['msg'] = "1. 파일이 삭제되었습니다.";

		} else {
			$msg['msg'] = "2. 해당 파일이 존재하지 않습니다.";
		}




	} // end if

	// 파일 전체 삭제
	if($mode=='2') {

		$sql = "select
					*
				from
					{$g5['board_file_table']}
				where
					bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ";
		$result = sql_query($sql, true);
		$cnt_s = 0; // 성공시 카운트
		$cnt_f = 0; // 실패시 카운트
		while($row = sql_fetch_array($result)) {
			$file_path	= G5_DATA_PATH."/file/".$bo_table."/".$row['bf_file'];

			$fn = preg_replace("/\.[^\.]+$/i", "", basename($file_path)); // 파일이름만 구하기 (확장자 및 . 제외)

			$files = glob(G5_DATA_PATH.'/file/'.$bo_table.'/thumb-'.$fn.'*'); // 원본 파일명과 같은 파일들 배열생성
			if (is_array($files)) {
				foreach ($files as $filename) {
					unlink($filename); // 썸네일 파일들 삭제... 각 크기별로 모두 삭제.
				}
			}



			/* 썸네일 폴더를 thumb를 사용시
			$files = glob(G5_DATA_PATH.'/file/'.$bo_table.'/thumb/thumb-'.$fn.'*'); // 원본 파일명과 같은 파일들.
			if (is_array($files)) {
				foreach ($files as $filename) {
					unlink($filename); // 썸네일 파일들 삭제... 각 크기별로 모두 삭제.
				}
			}
			*/

			if (file_exists($file_path)) {
				@unlink($file_path);   // 원본파일 제거
				sql_query(" delete from
								g5_board_file
							where
								bo_table = '".$bo_table."' and wr_id = '".$row['wr_id']."' and bf_no = '".$row['bf_no']."' ");

				$msg['msg'] = "1. 파일이 삭제되었습니다.";
				$cnt_s++;
			} else {
				$msg['msg'] = "2. 해당 파일이 존재하지 않습니다.";
				$cnt_f++;
			}
		}

		$msg['msg'] = "총 ".$cnt_s."개의 파일이 삭제되었고, ".$cnt_f."개의 파일이 삭제 실패하였습니다.";
	}


// 삭제후 남아 있는 파일 갯수 구해서 해당글의 파일 개수 업데이트
$sql = "select
			count(*) as cnt
		from
			{$g5['board_file_table']}
		where
			bo_table = '{$bo_table}' and wr_id = '{$wr_id}' ";
$rs = sql_fetch($sql, true);
sql_query("update {$write_table} set wr_file = '{$rs['cnt']}' where wr_id = '{$wr_id}' ");

echo json_encode($msg);
?>

