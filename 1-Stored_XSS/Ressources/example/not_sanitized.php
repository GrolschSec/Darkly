<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
</head>
<body>
    <form action="" method="POST">
        <label for="name">Name:</label><br>
        <input type="text" id="name" name="name" required><br><br>

        <label for="message">Message:</label><br>
        <textarea id="message" name="message" rows="4" cols="50" required></textarea><br><br>

        <button type="submit">Submit</button>
    </form>

    <hr>

    <?php
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $name = $_POST['name'];
        $message = $_POST['message'];

        // Print the inputs to the page
        echo "<h2>Submitted Data:</h2>";
        echo "<p><strong>Name:</strong> $name</p>";
        echo "<p><strong>Message:</strong> $message</p>";
        error_log("Name: $name");
        error_log("Message: $message");
    }
    ?>
</body>
</html>
