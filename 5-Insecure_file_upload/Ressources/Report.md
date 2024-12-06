# Vulnerability Report

## Summary
An Insecure file upload functionality was discovered on the server. The validation of the file relies on the `Content-Type` header of the file which can be manipulated on the client side.

## Vulnerability details

### CWE Reference

- **CWE ID**: [CWE-434: Unrestricted Upload of File with Dangerous Type](https://cwe.mitre.org/data/definitions/434.html)

### Description
The vulnerability occur because the file validation is checking only if the `Content-Type` header from the file is `image/jpeg`. This allows us to upload any filetype, including PHP code, by intercept the request using a tool like burp and changing the `Content-Type` to the authorized one. 
### Steps to reproduce
1. Navigate to the vulnerable [page](http://darkly/?page=upload).
2. Click `Browse...` and select any file.
3. Set Burp `Intercept on`.
4. Click `Upload`.
5. In the Burp window modify the `Content-Type` header to `image/jpeg`.
6. Forward the request.
7. The Flag is showing up.
### Impact
While in this case the vulnerability does not allow direct code execution due to the uploaded path (tmp), it could still be exploited to upload a webshell. Chaining this with another vulnerability, such as directory path traversal, could allow attackers to execute code on the server, leading to unauthorized access or complete server compromise.
## Mitigation
Client-side data should never be trusted in the validation process. Adding more validation, such as a correctly implemented whitelist of file extensions and content inspection (e.g., using magic numbers to verify the actual file type), is sufficient to avoid insecure file uploads. Additionally, implementing file size validation can help prevent potential DoS attacks, and concealing the path of the uploaded file is crucial to avoid providing valuable indicators for attackers planning further attacks.
## References
- [OWASP File Upload Security Guide](https://owasp.org/www-community/vulnerabilities/Unrestricted_File_Upload)
