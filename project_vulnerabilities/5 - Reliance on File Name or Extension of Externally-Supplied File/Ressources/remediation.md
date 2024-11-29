# Remediation for Reliance on File Name or Extension of Externally-Supplied File

To mitigate this vulnerability, follow these best practices:

1. **Server-Side File Type Validation**:
   - Use server-side libraries to validate the actual file type, not just the `Content-Type` provided by the client.
   - Example in PHP:
     ```php
     $mimeType = mime_content_type($file);
     if (!in_array($mimeType, ['image/jpeg', 'image/png'])) {
         throw new Exception('Invalid file type');
     }
     ```

2. **Restrict Allowed File Types**:
   - Only allow specific file types, such as images (`.jpg`, `.png`), and reject all others.

3. **Isolate Upload Directory**:
   - Store uploaded files in a non-executable directory to prevent execution of malicious scripts.
   - Configure the server to disable execution of PHP or other scripts in the upload directory.

4. **Rename Uploaded Files**:
   - Generate secure, unique names for uploaded files to prevent directory traversal or overwriting existing files.

5. **Enforce File Size Limits**:
   - Set a maximum file size on the server to prevent resource exhaustion or denial-of-service attacks.

6. **Monitor and Log File Uploads**:
   - Log all file uploads and monitor for suspicious activity to detect and respond to potential attacks.

Implementing these measures ensures that malicious files cannot be executed or mishandled by the server.