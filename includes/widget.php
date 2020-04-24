<div class="well">
	<h4 class="text-primary">Notable bloggers</h4>
	<div class="row">
		<div class="col-lg-12">
			<ul class="list-group">
				<?php if (isset($_SESSION['role'])): ?>
				
				<?php 

					$query = "SELECT user_name FROM users";
					$select_users = mysqli_query($connection, $query);

					while ($row = mysqli_fetch_assoc($select_users)) {
						$username = $row['user_name'];

						echo "<li class='list-group-item'><a href='#'>@{$username}</a></li>";
					}

				 ?>

				<?php else: ?>
				
				<p class="text-info">We have some of the notable bloggers in CMS Blog for you to follow.</p>
				<p class="text-info">What are you waiting for, <a href="registration.php">sign up</a> or <a href="login.php">login</a> to your account now, and be part of an awesome experience.</p>
				<?php endif; ?>
			</ul>
		</div>
	</div>
</div>