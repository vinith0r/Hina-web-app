<?php /*
1. do_post($post_content, $image_url) - we take user from cookie!
	- return post ID
2. edit_post($post_id, $post_content)
3. delete_post($post_id)
4. like_post($post_id) - we take user from cookie!
5. get_all_posts() - to get all posts
6. get_post($post_id) - to get a single post using its ID
7. get_likes_count($post_id) - get number of likes for a specific post
8. has_liked($post_id) - return true if atleast one like is there, else false

Database Table:
	1. posts
		- post_id : int,auto_increment,primary_key,unique,not_null
		- content: varchar,not_null
		- image: varchar,not_null
		- posted_on: datetime,default:current_timestamp
		- posted_by: varchar,not_null
		- edited_on: datetime,default:current_timestamp
	2. likes
		- id : int,auto_increment,primary_key,unique,not_null
		- liked_by: varchar,not_null
		- post_id: int,not_null
*/

require_once(dirname(__DIR__).'/library/auth.php');
function do_post($post_content, $image_url){
    $conn = get_db_connection();
    $username = get_current_username1();
    $query = "INSERT INTO `lahtp`.`posts` (`content`, `image`, `posted_by`) VALUES ('$post_content', '$image_url', '$username');";

    if(mysqli_query($conn, $query)){  
        $post_id = mysqli_insert_id($conn);
        return $post_id;
    }
    else{
        return NULL;
    }
}

function get_post($post_id){
    $conn = get_db_connection();
    $query = "SELECT * FROM lahtp.posts WHERE (`post_id` = '$post_id');";
    $result  = mysqli_query($conn, $query);
	if (mysqli_num_rows($result) == 1) {
		$row = mysqli_fetch_assoc($result);
        return $row;
    } else {
        return NULL;
    }
}

function edit_post($post_id, $post_content){
    $conn = get_db_connection();
    $username = get_current_username1();
    $query = "UPDATE `lahtp`.`posts` SET `content` = '$post_content' WHERE (`post_id` = '$post_id');";

    if(mysqli_query($conn, $query)){  
        return TRUE;
    }
    else{
        return FALSE;
    }
}

function delete_post($post_id){
    $conn = get_db_connection();
    $post = get_post($post_id);
    $query = "DELETE FROM `lahtp`.`posts` WHERE (`post_id` = '$post_id');";

    if(mysqli_query($conn, $query)){
        unlink('../'.$post['image']);
        return TRUE;
    }
    else{
        return FALSE;
    }
}

function like_post($post_id){
    $conn = get_db_connection();
    $username = get_current_username1();
    $query = "INSERT INTO `lahtp`.`likes` (`liked_by`, `post_id`) VALUES ('$username', '$post_id');";
    if(mysqli_query($conn, $query)){  
        return TRUE;
    }
    else{
        return FALSE;
    }
}

function get_likes_count($post_id){
    $conn = get_db_connection();
	$query = "SELECT COUNT(*) AS count FROM lahtp.likes WHERE `post_id`=$post_id;";
	$result = mysqli_query($conn, $query);
	return mysqli_fetch_assoc($result)['count'];
}

function has_liked($post_id){
	$conn = get_db_connection();
	$username = get_current_username1();
	$query = "SELECT COUNT(*) AS count FROM lahtp.likes WHERE `post_id`=$post_id AND `liked_by` = '$username';";
	$result = mysqli_query($conn, $query);
	if((int)mysqli_fetch_assoc($result)['count'] > 0){
		return TRUE;
	} else {
		return FALSE;
	}
}

function get_all_posts(){
    $conn = get_db_connection();
    $username = get_current_username1();
    $query = "SELECT * FROM lahtp.posts ORDER BY posted_on DESC;";

    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) > 0){
		$posts = [];
		while($row = mysqli_fetch_assoc($result)){
			$posts[] = $row;
		}
		return $posts;
	} else {
		return [];
	}
}

?>