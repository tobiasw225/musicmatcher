			<div class='user_info'>
			<?php
				if (isset($_SESSION['user_name'])) {
					$user_name = $_SESSION['user_name'];
					$user_id = $_SESSION['user_id'];
					$user_points = $_SESSION['user_points'];
					echo "User: <span class='current_user' u_id=$user_id>$user_name</span><br/>";
					echo "Points: <span class='current_user' u_id=$user_id>$user_points</span>";
				} else {
					echo 'not logged in';
				}
			?>
			</div>