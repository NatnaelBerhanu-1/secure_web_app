<?php
    define('RESTRICTED',1);
    include_once 'db_helper.php';
    require 'check_auth.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
    <script src="//code.jquery.com/jquery-1.11.1.min.js"></script>
    <script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
</head>
<body>
<?php require('dashboard_top_nav.php'); ?>
				<div class="container-fluid">
					<div class="col col-md-3">			
						<?php require('dashboard_side_bar.php') ?>
					</div>
					<div class="col col-md-9">
						<div class="row">
							<?php
                                $user_id = $_SESSION['userId'];
                                $feedbacks = $db_helper->getUserFeedbacks($user_id);
                                // echo(json_encode($feedbacks));
                            ?>
                            <h3 class="text-center text-info">Feedbacks</h3>
                            <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Name</th>
      <th scope="col">Email</th>
      <th scope="col">Feedback</th>
      <th scope="col">Attachment</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($feedbacks && !empty($feedbacks)) {

        for ($i=0; $i < sizeof($feedbacks); $i++) { 
            echo('
        <tr>
      <th scope="row">'.($i+1).'</th>
      <td>'.htmlspecialchars($feedbacks[$i]['name']).'</td>
      <td>'.htmlspecialchars($feedbacks[$i]['email']).'</td>
      <td>'.htmlspecialchars($feedbacks[$i]['feedback']).'</td>
      <td><a href="http://localhost/secure_web_app/'.$feedbacks[$i]['file_url'].'"download="attachment">attachment</a></td>
    </tr>
        ');
        }
        
    }?>
  </tbody>
</table>
						</div>
					</div>
				</div>
</body>
</html>

    		