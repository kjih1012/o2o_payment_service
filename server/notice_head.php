<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if(defined('G5_THEME_PATH')) {
    require_once(G5_THEME_PATH.'/head.php');
    return;
}

if (G5_IS_MOBILE) {
    include_once(G5_MOBILE_PATH.'/head.php');
    return;
}

include_once(G5_PATH.'/head.sub.php');
include_once(G5_LIB_PATH.'/latest.lib.php');
include_once(G5_LIB_PATH.'/outlogin.lib.php');
include_once(G5_LIB_PATH.'/poll.lib.php');
include_once(G5_LIB_PATH.'/visit.lib.php');
include_once(G5_LIB_PATH.'/connect.lib.php');
include_once(G5_LIB_PATH.'/popular.lib.php');
?>

<!-- 상단 시작 { -->
	<div id="tnb">
		<div id="tnb_wrapper">
			<ul>
                <?php if ($is_member) {  ?>
                
                <li><a href="<?php echo G5_BBS_URL ?>/member_confirm.php?url=<?php echo G5_BBS_URL ?>/register_form.php">EDIT</a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/logout.php">LOGOUT</a></li>
                <?php if ($is_admin) {  ?>
                <li class="tnb_admin"><a href="<?php echo G5_ADMIN_URL ?>"> ADMINISTER</a></li>
                <?php }  ?>
                <?php } else {  ?>
                <li><a href="<?php echo G5_BBS_URL ?>/login.php">LOGIN</a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/register.php">SIGN UP</a></li>
                <?php }  ?>
			</ul>
		</div>
	</div>

	<div id="hd">
		<div id="hd_wrapper">
			<div id="logo">
				<a href="<?php echo G5_URL ?>"><img src="../css/img/logo.png" alt="logo"></a>
			</div>
		</div>
	</div>
	<div id="gnb">
		<div id="gnb_wrapper">
			<ul>
				<li><a href="#">ABOUT US</a></li>
				<li><a href="#">OUR WORK</a></li>
				<li><a href="http://heyitsspoon.dothome.co.kr/bbs/board.php?bo_table=notice" style="background-image:url(../css/img/hd_a_bg.png); background-repeat: no-repeat; background-size:100%;">NOTICE</a></li>
				<li><a href="#">REFERENCE</a></li>
				<li><a href="#">DONATION</a></li>
			</ul>
		</div>
	</div>
<!-- } 상단 끝 -->


<hr>

<!-- 콘텐츠 시작 { -->
<div id="wrapper">
    <div id="container_wr">
   
    <div id="container">
        <?php if (!defined("_INDEX_")) { ?><h2 id="container_title"><span title="<?php echo get_text($g5['title']); ?>"><?php echo get_head_title($g5['title']); ?></span></h2><?php } ?>

