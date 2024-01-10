<!-- Not related -->
Hello World 

This is Vinith Page!
	
 <?php 
 		$post=[
 				"username" => "Vinith", 
 				"post_id" => 234323,
 				"post_body" => "I am curremtly in Banglore.... where are you guys from?",
 				"comments" => [
 				 					[
 				 							"comment_id" => 1,
 				 							"comment_by" => 'Sandeep',
 				 							"comment_body" => "I am From Naga Land..."
 				 					],
 				 					[
 				 						"comment_id" => 2, 
 				 						"comment_by" => 'Rithuraj', 
 				 						"comment_body" => "I am From bhihar"
 				 					],
 				 					[
 				 						"comment_id" => 3, 
 				 						"comment_by" => 'Lalith',
 				 						"comment_body" => "I am From Rajasthan"
 				 					]
 				]
 		];

 		foreach($post as $key => $value){
 			if($key=="username"){
 				print("posted by : $value\n");
 			}
 			if($key == "post_body")
 			{
 				print("content : $value\n");
 			}
 			if($key == "comments"){
                if(is_array($value)){
 					foreach($value as $co){
 						print("commented by : ".$co["comment_by"]. "\n");
 						print("comment : ".$co["comment_body"]."\n");
                }
 				}
 			}
 		}

  ?>
