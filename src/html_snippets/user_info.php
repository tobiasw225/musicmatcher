			<?php
				if (isset($_SESSION['user_name'])) {
					$user_name = $_SESSION['user_name'];
					$user_id = $_SESSION['user_id'];
					$user_points = $_SESSION['user_points'];
					echo "<li><a href='#'><span class='glyphicon glyphicon-user' u_id=$user_id></span> $user_name
					| <span class='glyphicon glyphicon-music'></span> <span u_id=$user_id>$user_points</span></a></li>";
					
					} else {
					echo 'not logged in';
				}
			?>
