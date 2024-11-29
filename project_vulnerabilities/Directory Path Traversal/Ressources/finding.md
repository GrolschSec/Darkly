# Directory Path Traversal

## Description

Path Traversal, also known as Directory Traversal, occurs when an application fails to properly sanitize user-supplied input. This allows an attacker to manipulate file paths to access unauthorized directories and files on the server, potentially exposing sensitive information.

## Identify the Vulnerability

The application uses a `page` parameter to dynamically load different pages. For example:
```bash
http://darkly/?page=member
```
The parameter value directly affects the file path being loaded by the server. By manipulating the page parameter, an attacker can traverse the file system to access sensitive files.

### Steps to Exploit:
1. Test for Path Traversal:
- Replace the `page` parameter value with `../../../../../../../etc/passwd` to check if the application loads unintended files.
2. Access Sensitive Files:
- Using the payload:
```bash
http://darkly/?page=../../../../../../../etc/passwd
```
- The server loads the passwd file, revealing sensitive system information and confirming the vulnerability.

### Observed Impact:
This vulnerability can be used to:
- Read sensitive files, such as /etc/passwd or application configuration files.
- Expose credentials or other critical data stored on the server.