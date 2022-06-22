<?php
    define('RESTRICTED',1);
    include_once 'db_helper.php';


$request_method = strtoupper($_SERVER['REQUEST_METHOD']);

if($request_method=='POST') {
    if(isset($_POST['status']) && isset($_POST['user_id'])) {
        // echo($_POST['status']);
        $dbhelper = new DB_Helper();
        $dbhelper->updateUserStatus($_POST['user_id'], $_POST['status']);
    }
}
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
    <title>Moderator</title>
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
                                $users = $db_helper->getUsers();
                                // echo(json_encode($users));
                            ?>
                            <h3 class="text-center text-info">Users</h3>
                            <table class="table">
  <thead>
    <tr>
      <th scope="col">#</th>
      <th scope="col">Username</th>
      <th scope="col">Status</th>
    </tr>
  </thead>
  <tbody>
    <?php if ($users && !empty($users)) {

        for ($i=0; $i < sizeof($users); $i++) { 
            $activate = $users[$i]['user_status']==1 ? "" : "none";
            $disable = $users[$i]['user_status']==0 ? "" : "none";
            $status = $users[$i]['user_status']==0 ? 1 : 0;
            echo('
        <tr>
      <th scope="row">'.($i+1).'</th>
      <td>'.htmlspecialchars($users[$i]['username']).'</td>
      <td>
            <form method="POST" action="moderator.php" >
            <input type="hidden" name="status" value="'.$status.'"/>
            <input type="hidden" name="user_id" value="'.$users[$i]['id'].'"/>
        
            <button type="submit" class="btn btn-primary" style="display:'.$activate.';">Activate</button>
            <button type="submit" class="btn btn-danger" style="display:'.$disable.';">Disable</button>

            </form>
      </td>
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