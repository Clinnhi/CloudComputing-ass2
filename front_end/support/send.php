<?php
// Import PHPMailer classes into the global namespace
// These must be at the top of your script, not inside a function
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// If necessary, modify the path in the require statement below to refer to the
// location of your Composer autoload.php file.
require './vendor/autoload.php';

$sender_name = $_POST['name'];
$recipient_email = 's3806690@student.rmit.edu.au'; // support team's email
$message_content = $_POST['message'];
$subject_title = $_POST['subject'] . ' <' . $_POST['email'] . '>';


// Replace sender@example.com with your "From" address.
// This address must be verified with Amazon SES.
$sender = 's3605044@student.rmit.edu.au';
$senderName = $sender_name;

// Replace recipient@example.com with a "To" address. If your account
// is still in the sandbox, this address must be verified.
$recipient = $recipient_email;

// Replace smtp_username with your Amazon SES SMTP user name.
$usernameSmtp = 'AKIARQCLRSM2USZZJ275';

// Replace smtp_password with your Amazon SES SMTP password.
$passwordSmtp = 'BCLaDITWALFdI1aXy2cVRbzTDLXrnfrUnCSoDigWk4/K';

// Specify a configuration set. If you do not want to use a configuration
// set, comment or remove the next line.
//$configurationSet = 'ConfigSet';

// If you're using Amazon SES in a region other than US West (Oregon),
// replace email-smtp.us-west-2.amazonaws.com with the Amazon SES SMTP
// endpoint in the appropriate region.
$host = 'email-smtp.us-east-1.amazonaws.com';
$port = 587;

// The subject line of the email
$subject = $subject_title;

// The plain-text body of the email
// $bodyText =  $message_content;

// The HTML-formatted body of the email
$bodyHtml = $message_content;

$mail = new PHPMailer(true);

$success_email_message = "";

$error_email_message = "";

try {
    // Specify the SMTP settings.
    $mail->isSMTP();
    $mail->setFrom($sender, $senderName);
    $mail->Username   = $usernameSmtp;
    $mail->Password   = $passwordSmtp;
    $mail->Host       = $host;
    $mail->Port       = $port;
    $mail->SMTPAuth   = true;
    $mail->SMTPSecure = 'tls';
  //  $mail->addCustomHeader('X-SES-CONFIGURATION-SET', $configurationSet);
    // Specify the message recipients.
    $mail->addAddress($recipient);
    // You can also add CC, BCC, and additional To recipients here.
    // Specify the content of the message.
    $mail->isHTML(true);
    $mail->Subject    = $subject;
    $mail->Body       = $bodyHtml;
    // $mail->AltBody    = $bodyText;
    $mail->Send();
    // echo "Email sent!" , PHP_EOL;
    $success_email_message = "Email sent! Our support team will be in contact with you soon.";
} catch (phpmailerException $e) {
    // echo "An error occurred. {$e->errorMessage()}", PHP_EOL; //Catch errors from PHPMailer.
    $error_email_message = "Failed to send email. Please try again. ";
} catch (Exception $e) {
    // echo "Email not sent. {$mail->ErrorInfo}", PHP_EOL; //Catch errors from Amazon SES.
    $error_email_message = "Failed to send email. Please try again. ";
}
?>

<head>
    <meta charset="UTF-8">

    <title>Email status</title>

    <link rel="stylesheet" href="css/about-me.css">

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.4/jquery.min.js"></script>

    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap-theme.min.css" integrity="sha384-fLW2N01lMqjakBkx3l/M9EahuwpSfeNvV63J5ezn3uZzapT0u7EYsXMjQV+0En5r" crossorigin="anonymous">

</head>

<body>
    <div class="container">
        <nav class="navbar navbar-default">
            <ul class="nav navbar-nav">
            <li><a href="../newsfeed.php">News Feed</a></li>
                <li><a href="../messages/messaging.php">Messages</a></li>
                <li><a href="../display-user.php">My Profile</a></li>
                <li><a href="../update-profile.php">Update Profile</a></li>
                <li><a href="../connect/connect-list.php">Connected Friends</a></li>
                <li><a href="../connect/connect-request-list.php">Connect Requests</a></li>
                <li><a href="contact-form.php">Support Center</a></li>
                <li><a href="../logout.php">Logout</a></li>
            </ul>

            <form class="form-inline">
                <div class="input-group">
                    <div class="input-group-prepend">
                    </div>


                </div>
            </form>

            <!-- SEARCH USERNAME -->
            <!-- SEARCH USERNAME -->
            <form action="display-user.php" method="get" name="form">
                <span class="right_header">
                    <a href="../search-user.php"><button type="button" class="btn btn-primary btn-lg">Find Friends</button>
                    </a>
                </span>
            </form>
        </nav>

        <?php 
            if ($success_email_message) {
                echo '<div class="alert alert-success"><strong>Success: </strong> ' . $success_email_message . '</div>';
            }
            if ($error_email_message) {
                echo '<div class="alert alert-danger"><strong>Error: </strong> ' . $error_email_message . '<a href=\'contact-form.php\'>Click here</a></div>';
            }
        ?>

    </div>
</body>

</html>



<!-- Code taken from https://docs.aws.amazon.com/ses/latest/DeveloperGuide/send-using-smtp-php.html with minor adjustments -->