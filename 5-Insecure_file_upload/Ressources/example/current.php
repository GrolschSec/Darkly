<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vulnerable File Upload</title>
</head>
<body>
    <h1>Vulnerable File Upload</h1>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_FILES['file'])) {
            $fileType = $_FILES['file']['type'];
            $uploadDir = '/tmp/';

                if ($fileType === 'image/jpeg') {
                    $uploadFile = $uploadDir . basename($_FILES['file']['name']);

                    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFile)) {
                        echo "<p>File uploaded successfully to: " . htmlspecialchars($uploadFile) . "</p>";
                    }
                } else {
                    echo "<p>Your image was not uploaded.</p>";
                }
            }
        }
    ?>
    <form action="current.php" method="POST" enctype="multipart/form-data">
        <label for="file">Select a file:</label>
        <input type="file" name="file" id="file">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
