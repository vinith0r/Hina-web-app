<?php 

include_once 'library/posts.php';
require 'vendor/autoload.php';
use Carbon\Carbon;

if(isset($_COOKIE['username']) and isset($_COOKIE['token'])){
  $username = $_COOKIE['username'];
  $token = $_COOKIE['token'];

  if(!verify_session($username, $token)){
    header("Location: /lahtp/signin.php");
  }
} else {
	header("Location: /lahtp/signin.php");
}

if(isset($_GET['post'])){
	if(isset($_POST['edit']) and isset($_POST['content'])){
		edit_post($_POST['edit'], $_POST['content']);
	} else if(isset($_POST['content']) and isset($_FILES['image'])){
		$target_directory = 'images/';
		$target_file = $target_directory . basename($_FILES['image']['name']);
		$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
		if($imageFileType == 'jpg' or $imageFileType == 'png' or $imageFileType == 'jpeg'){
				move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
				do_post($_POST['content'], "\\".$target_file);
			}
		  else {
			die("Invalid format");
		}
	}
}

if(isset($_GET['like'])){
  like_post($_GET['like']);
}
if(isset($_GET['delete'])){
  delete_post($_GET['delete']);
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../../../favicon.ico">

    <title>home</title>
    <link href="styles/home.css" rel="stylesheet">
    <link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

    <link href="album.css" rel="stylesheet">

  </head>

  <body>

    <header>
      <div class="collapse bg-black" id="navbarHeader">
        <div class="container">
          <div class="row">
            <div class="col-sm-8 col-md-7 py-4">
              <h4 class="text-white">About</h4>
              <ul class="list-unstyled">
						</ul>
              <p class="text-grey" style="color:#919191;"> Do Write, Post and like, edit</p>
            </div>
            <div class="col-sm-4 offset-md-1 py-4">
              <h4 class="text-white">Welcome, <?=get_current_username1()?></h4>
              <ul class="list-unstyled">
                <br><br><br>
                <li><a href="https://github.com/vinith0r" target = "_blank" class="text-white2">Follow on Github</a></li><br>
                <li><a href="https://www.instagram.com/vinit_h01/" target = "_blank" class="text-white2">Like on instagram</a></li><br>
                <li><a href="mailto:vini01.me@gmail.com"  target = "_blank" class="text-white2">Email me</a></li>
                <br><br>
              </ul>
              <h4><li><a href="logout.php" class="text-white1">Logout</a></li><h4>
            </div>
          </div>
        </div>
      </div>
      <div class="navbar navbar-black bg-black box-shadow">
        <div class="container d-flex justify-content-between">
          <a href="#" class="navbar-brand d-flex align-items-center">
            <img src="styles/img/icons8-compact-camera-64 (1).png" width="60" height="60" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="mr-2"><path d="M23 19a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h4l2-3h6l2 3h4a2 2 0 0 1 2 2z"></path><circle cx="12" cy="13" r="4"></circle></img>
            <strong style="color: #d1544b">ひな</strong>
          </a>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarHeader" aria-controls="navbarHeader" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
          </button>
        </div>
      </div>
    </header>

    <main role="main">
      <section class="album py-5 bg-black" id="bod11">
        <div class="home">
          <h2>Home</h2>
          <h2>Home</h2>
        </div>
					<?php
				if(!isset($_GET['edit'])){
					?>
					<form action="home.php?post" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<textarea name="content" class="text-white4" placeholder="What's on your mind?" cols="50" rows="5" style="border:dashed 2px green;"></textarea>
						</div><br>
						<div class="form-group">
							<input type="file" class="ffd" name="image">
						</div><br>
						<div class="form-group">
							<button type="submit" class="post11"id="postButton1">Post!</button>
						</div>
					</form>
					<?php
				} else {
					$post = get_post($_GET['edit']);
					?>
					<form action="home.php?post" method="POST" enctype="multipart/form-data">
						<div class="form-group">
							<textarea name="content" class="text-white4" placeholder="What's on your mind?" cols="50" rows="5" style="border:dashed 2px green;"><?=$post['content']?></textarea>
						</div>
						<?php
						if(isset($_GET['edit'])){
							?>
							<input type="hidden" class="form-control-file" name="edit" value="<?=$_GET['edit']?>">
							<?php
						}
						?>
						<div class="form-group">
							<button type="submit" class="post11">Post</button>
						</div>
					</form>
					<?php
				}
				?>
        </div>
      </section>
      <div class="album py-5 bg-black">
        <div class="container">

          <div class="row">
            <?php
            $posts = get_all_posts();
            foreach ($posts as $post){
              $carbonTime = Carbon::parse($post['posted_on']);
              $humanDiff = $carbonTime->diffForHumans();
            ?>
            <div class="col-md-4">
              <div class="card mb-4">
                <img class="card-img-top" src="<?=$post['image']?>" alt="Card image cap">
                <div class="card-body">
                  <p class="card-text"><?=$post['content']?></p>
                  <div class="d-flex justify-content-between align-items-center">
                    <div id="data-post-id" class="">
                    <a href="home.php?like=<?=$post['post_id']?>"><img src="styles/img/heart (1).png" width="48" height="38" id="data-post-id" class="btn btn-sm btn-outline-secondary like-btn" data-toggle="tooltip" data-placement="top" title="<?=get_likes_count($post['post_id'])?> Liked"></a>
												<?php
                        //echo get_likes_count($post['post_id']);
												if(has_liked($post['post_id'])) {
													echo get_likes_count($post['post_id']);
												} else {
													echo get_likes_count($post['post_id']);
												}
												?>
                      <?php 
                        if($post['posted_by'] == get_current_username1() || $_COOKIE['username']=='vinith'){
                      ?>
                      <a href="home.php?edit=<?=$post['post_id']?>" type="button" class="btn btn-sm btn-outline-secondary">Edit</a>
                      <?php } ?>
                    </div>
                    <small class="text-white3"><?=$humanDiff?></small>
                  </div>
                  <br>
                  
                  <div class="d-flex justify-content-between align-items-center">
                    <div class="btn-group">
                    <?php
                        if($post['posted_by'] == get_current_username1() || $_COOKIE['username']=='vinith'){
                      ?>
                      <a href="home.php?delete=<?=$post['post_id']?>" type="button" class="btn btn-sm btn-danger btn-sm">Delete</a>
                      <?php } ?>
                      <!-- <button type="button" class="btn btn-sm btn-outline-secondary">Edit</button> -->
                    </div>

                    <small class="text-white3">Posted_By: <?=$post['posted_by']?></small>
                  </div>
                </div>
              </div>         
            </div>
            <?php
            }
            ?>
          </div>
        </div>
      </div>

    </main>

    <footer class="album py-5 bg-black">
      <div class="container">
        <p class="">
          <a class="des" href="#">Back to top</a>
        </p>
      </div>
    </footer>

     <script type="text/javascript">
		  $(function () {
			  $('[data-toggle="tooltip"]').tooltip();
		  });
      
       $('a.like-btn').on('click', function(){
         var postId = $(this).attr('data-post-id');
         alert('The post Id is '+postId);
       })
      </script>

	<script>window.jQuery || document.write('<script src="../assets/js/vendor/jquery.slim.min.js"><\/script>')</script><script src="../assets/dist/js/bootstrap.bundle.min.js"></script>
    <script>window.jQuery || document.write('<script src="assets/js/vendor/jquery-slim.min.js"><\/script>')</script>
    <script src="assets/js/vendor/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/vendor/holder.min.js"></script>
  </body>
</html>
