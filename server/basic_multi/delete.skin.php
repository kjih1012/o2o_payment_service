<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

// ./bbs/delete.php 파일에서 파일정보를 삭제하기전에 멀티업로드한 파일의 썸네일을 삭제해야 한다.

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

			$files = glob(G5_DATA_PATH.'/file/'.$bo_table.'/thumb/thumb-'.$fn.'*'); // 원본 파일명과 같은 파일들.
			if (is_array($files)) {
				foreach ($files as $filename) {
					unlink($filename); // 썸네일 파일들 삭제... 각 크기별로 모두 삭제.
				}
			}

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


?>
