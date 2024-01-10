<?php
// include_once 'library/posts.php';
// header('Content-Type: application/json');

// if(isset($_GET['post'])){
// 	$post_id = $_GET['post'];
// 	$post = get_post($post_id);
// 	echo json_encode($post, JSON_PRETTY_PRINT);
// }

// if(isset($_GET['like_post'])){
// 	$post_id = $_GET['post'];
// 	if(like_post($post_id)){
// 		$result['result']='success';
// 		$result['total_count']=get_likes_count($post_id);
// 	}else{
// 		$result['result']='failure';
// 	} 
// 	echo json_encode($post, JSON_PRETTY_PRINT);
// }

include_once 'library/posts.php';
header('Content-Type: application/json');

if(isset($_GET['post'])){
	$post_id = $_GET['post'];
	$post = get_post($post_id);
	echo json_encode($post, JSON_PRETTY_PRINT);
}

if(isset($_GET['like_post'])){
	$post_id = $_GET['like_post'];
	if(like_post($post_id)){
		$result['result'] = 'success';
		$result['total_count'] = get_likes_count($post_id);
	} else {
		$result['result'] = 'failure';
	}
	echo json_encode($result, JSON_PRETTY_PRINT);
}