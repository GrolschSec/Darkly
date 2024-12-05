<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Secure File Upload</title>
</head>
<body>
    <h1>Secure File Upload</h1>
    <?php
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {

            if (isset($_FILES['file'])) {
                $uploadDir = '/tmp/';
                $allowedExtensions = ['jpg', 'jpeg']; // Whitelist of file extensions
                $maxFileSize = 2 * 1024 * 1024; // 2 MB size limit

                // Extract file information
                $fileName = basename($_FILES['file']['name']);
                $fileTmpPath = $_FILES['file']['tmp_name'];
                $fileSize = $_FILES['file']['size'];
                $fileExtension = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                // Check file size
                if ($fileSize > $maxFileSize) {
                    echo "<p>File size exceeds the maximum allowed size of 2 MB.</p>";
                    exit;
                }

                // Validate file extension
                if (!in_array($fileExtension, $allowedExtensions)) {
                    echo "<p>Invalid file type. Only JPEG images are allowed.</p>";
                    exit;
                }

                // Inspect file content using magic numbers
                $fileContent = file_get_contents($fileTmpPath);
                $magicNumber = bin2hex(substr($fileContent, 0, 2)); // JPEG files start with 0xFFD8
                if ($magicNumber !== 'ffd8') {
                    echo "<p>The uploaded file does not match the expected file type.</p>";
                    exit;
                }

                // Generate a random filename to avoid overwriting
                $newFileName = uniqid('upload_', true) . '.' . $fileExtension;
                $uploadFile = $uploadDir . $newFileName;

                // Move the uploaded file
                if (move_uploaded_file($fileTmpPath, $uploadFile)) {
                    echo "<p>File uploaded successfully.</p>";
                } else {
                    echo "<p>There was an error uploading your file.</p>";
                }
            } else {
                echo "<p>No file was uploaded.</p>";
            }
        }
    ?>
    <form action="mitigated.php" method="POST" enctype="multipart/form-data">
        <label for="file">Select a file:</label>
        <input type="file" name="file" id="file">
        <button type="submit">Upload</button>
    </form>
</body>
</html>
