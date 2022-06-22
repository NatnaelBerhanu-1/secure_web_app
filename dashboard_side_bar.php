<?php 
    $user_id = $_SESSION['userId'];
    $db_helper = new DB_Helper();
    $user_info = $db_helper->getUserDetails($user_id);
    if(!$user_info) {
        header("Location: http://localhost/secure_web_app/logout.php");
        exit;
    }
    $role = $user_info->role;
    echo('
    <div class="panel-group" id="accordion">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h4 class="panel-title">
          <a data-toggle="collapse" data-parent="#accordion" href="#collapse1">
          Menu</a>
        </h4>
      </div>
      <div id="collapse1" class="panel-collapse collapse in">
          <ul class="list-group">
              <li class="list-group-item"><a href="dashboard.php" class="list-group-item">Dashboard</a></li>
              <li class="list-group-item"><a href="submit_feedback.php" class="list-group-item">Submit feedback</a></li>
              '.
              getItem($role)
              .'
          </ul>
      </div>
    </div>
  </div> 
    ');

    function getItem($role) {
        if($role == 1) {
              return '
              <li class="list-group-item"><a href="moderator.php" class="list-group-item">Manage users</a></li>
              ';
        }
        return '';
    }
?>