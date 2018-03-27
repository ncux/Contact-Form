<?php
// Message vars
$msg = '';
$msgClass = '';

// check for submit
if(filter_has_var(INPUT_POST, 'submit')) {
    // echo "Form submitted";
    $name = $_POST['name'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    // check required fields
    if(!empty($name) && !empty($email) && !empty($message)) {
        if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $msg = "Use a valid email";
            $msgClass = 'alert-danger';
        } else {
            $admin = 'admin@upyours.com';
            $subject = 'Message'. ' from '. $name;
            $body = '<h2>Contact Request</h2>
                    <h4>Name</h4><p>'.$name.'</p>
                    <h4>Email</h4><p>'.$email.'</p>
                    <h4>Message</h4><p>'.$message.'</p>';

            $headers = 'MIME-Version: 1.0' .'\r\n';
            $headers .= "Content-Type:text/html;charset=UTF-8" .'\r\n';
            $headers .= "From ". $name. "<". $email. ">" .'\r\n';

            if(mail($admin, $subject,  $body,  $headers  )) {
                $msg = "Message sent!";
                $msgClass = 'alert-success';
            } else {
                $msg = "Message sending failed, sorry.";
                $msgClass = 'alert-warning';
            }
        }

    } else {
        $msg = "All fields must be filled";
        $msgClass = 'alert-danger';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Contact form</title>
    <link href="https://bootswatch.com/4/cosmo/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<nav class="navbar navbar-default">
    <div class="container">
        <div class="navbar-header">
            <a class="navbar-brand" href="Contact Form.php">Our Site</a>
        </div>
    </div>
</nav>
<br>
<div class="container">
    <?php if($msg != ''):  ?>
    <div class="alert <?php echo $msgClass; ?>">
        <?php echo $msg; ?>
    </div>
    <?php endif; ?>


    <form method="post" action="Contact%20Form.php">
        <div class="form-group">
            <label for="name">Name:
                <input id="name" class="form-control" type="text" name="name"
                value="<?php echo isset($_POST['name']) ? $name : ''; ?>">
            </label>
        </div>

        <div class="form-group">
            <label for="email">Email:
                <input id="email" class="form-control" type="email" name="email"
                value="<?php echo isset($_POST['email']) ? $email : ''; ?>">
            </label>
        </div>

        <div class="form-group">
            <label for="message">Message:
                <textarea id="message" class="form-control" type="text" name="message">
                    <?php echo isset($_POST['message']) ? $message : ''; ?>
                </textarea>
            </label>
        </div>
        <br>
        <button type="submit" name="submit" class="btn btn-success">Submit</button>
    </form>

</div>

</body>
</html>
