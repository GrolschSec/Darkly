<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirect Example</title>
</head>
<body>
    <h1>Choose a Social Media Platform to Redirect:</h1>
    <ul>
        <li><a href='?site=instagram'>Instagram</a></li>
        <li><a href='?site=facebook'>Facebook</a></li>
        <li><a href='?site=twitter'>Twitter</a></li>
    </ul>
    
    <?php
        if (isset($_GET['site'])) {
            $redirect_url = urldecode($_GET['site']);

            switch ($redirect_url) {
                case 'instagram':
                    $redirect_url = 'https://www.instagram.com/42born2code/';
                    break;
                case 'facebook':
                    $redirect_url = 'https://www.facebook.com/42born2code/';
                    break;
                case 'twitter':
                    $redirect_url = 'https://x.com/42born2code?mx=2';
                    break;
                default:
                    echo "<p>Malicious url detected</p>";
                    exit();
            }
            header("Location: $redirect_url");
            exit();
        }
    ?>
</body>
</html>
