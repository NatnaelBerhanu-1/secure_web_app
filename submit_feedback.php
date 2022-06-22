<?php
define('RESTRICTED',1);
include_once 'db_helper.php';
require 'check_auth.php';
require 'action_submit_feedback.php';

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
    <title>Submit feedback</title>
</head>
<body>
<?php require('dashboard_top_nav.php'); ?>
				<div class="container-fluid">
					<div class="col col-md-3">			
						<?php require('dashboard_side_bar.php') ?>
					</div>
					<div class="col col-md-9">
						<div class="row">
                        <div id="login">
        <div class="container">
            <div id="login-row" class="row justify-content-center align-items-center">
                <div id="login-column" class="col-md-6">
                    <div id="login-box" class="col-md-12">
                        <form id="login-form" class="form" action="submit_feedback.php" method="post" enctype="multipart/form-data">
                            <h3 class="text-center text-info">Submit Feedback</h3>
        <h6 class="text-center text-danger"><?php echo($add_feedback_error)?></h6>

                            <input type="hidden" name="token" value="<?= $_SESSION['token'] ?? '' ?>">
                            <!-- Honeypot field -->
                            <input type="text" name="honeypot" id="honeypot" style="display:none" value="1">
                            <div class="form-group">
                                <label for="name" class="text-info">Name:</label><br>
                                <input type="text" name="name" id="name" class="form-control" value="<?php echo($name) ?>">
                                <label for="name_err" class="text-danger"><?php echo($name_err) ?></label><br>

                            </div>
                            <div class="form-group">
                                <label for="email" class="text-info">Email:</label><br>
                                <input type="email" name="email" id="email" class="form-control" value="<?php echo($email) ?>">
                                <label for="email_err" class="text-danger"><?php echo($email_err) ?></label><br>
                            </div>
                            <div class="form-group">
                                <label for="feedback" class="text-info">Feedback:</label><br>
                                <textarea type="text" name="feedback" id="feedback" class="form-control" ><?php echo($feedback) ?></textarea>
                                <label for="feedback_err" class="text-danger"><?php echo($feedback_err) ?></label><br>

                            </div>
                            <div class="form-group">
                                <label for="attachment" class="text-info">Attachment:</label><br>
                                <input type="file" name="attachment" id="attachment" class="form-control" >
                                <label for="attachment_err" class="text-danger"><?php echo($attachment_err) ?></label><br>
                            </div>
                            <div class="form-group">
                                <input type="submit" name="submit" class="btn btn-info btn-md" value="submit">
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
						</div>
					</div>
				</div>
</body>
</html>