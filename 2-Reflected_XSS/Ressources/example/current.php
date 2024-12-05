<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vulnerable Media Page</title>
</head>
<body>
    <section id="main" class="wrapper">
        <div class="container" style="margin-top:75px">
            <?php

            $Sources = [
                "nsa" => "http://127.0.0.1:8081/nsa_prism.jpg"
            ];

            if (isset($_GET['src'])) {
                $src = $_GET['src'];

                if (array_key_exists($src, $Sources)) {
                    $src = $Sources[$src];
                }
                echo '<table style="margin-top:-68px;">
                        <tr style="background-color:transparent;border:none;">
                            <td align="center" style="vertical-align:middle;font-size:1.5em;">File: ' . htmlspecialchars($fileName, ENT_QUOTES, 'UTF-8') . '</td>
                        </tr>
                        <tr style="background-color:transparent;border:none;">
                            <td style="vertical-align:middle;">
                                <object data="' . $src . '"></object>
                            </td>
                        </tr>
                      </table>'; 
            } else {
                echo '<p>No media source specified.</p>';
            }
            ?>
        </div>
    </section>
</body>
</html>