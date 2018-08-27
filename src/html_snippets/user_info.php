			<div class='user_info'>
			<?php
				if (isset($_SESSION['user_name'])) {
					$user_name = $_SESSION['user_name'];
					$user_id = $_SESSION['user_id'];
					$user_points = $_SESSION['user_points'];
					echo "<span class='glyphicon glyphicon-user'></span> <span class='current_user' u_id=$user_id>$user_name</span><br/>";
					
					echo "<span class='glyphicon glyphicon-music'></span>  <span class='current_user' u_id=$user_id>$user_points</span>";
				} else {
					echo 'not logged in';
				}
			?>
			</div>