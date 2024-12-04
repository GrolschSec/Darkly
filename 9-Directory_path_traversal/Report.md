# Vulnerability Report

## Summary

A Directory Path Traversal vulnerability exists in the `Darkly` application. This flaw allows attackers to manipulate file paths via the `page` parameter to access unauthorized files on the server, potentially exposing sensitive information.

## Vulnerability details

### CWE Reference

- **CWE ID**: [CWE-22: Improper Limitation of a Pathname to a Restricted Directory ('Path Traversal')](https://cwe.mitre.org/data/definitions/22.html)

### Description

The application uses the `page` parameter to dynamically load different files on the server. Due to improper validation and sanitization of the parameter, attackers can manipulate it to traverse the file system and access sensitive files. This vulnerability could expose critical data, including server configurations and credentials.

### Steps to reproduce

1. Navigate to the application URL with a valid page parameter, e.g.: http://darkly/?page=member
2. Replace the `page` parameter value with a traversal payload such as: `../../../../../../../etc/passwd`.
3. Submit the request. If successful, the application displays the contents of the targeted file (e.g., `/etc/passwd`).

### Observed Impact

This vulnerability allows an attacker to:
- Access sensitive files like `/etc/passwd`, application configuration files, or other restricted directories.
- Reveal credentials or other critical data stored on the server.

## Mitigation

1. **Sanitize and Validate Input**:
- Ensure user input does not contain patterns such as `../` or other path traversal sequences.
- Example in PHP:
  ```php
  if (strpos($input, '../') !== false) {
      die("Invalid input.");
  }
  ```

2.  **Restrict File Access**:
- Limit the server's file access to only necessary directories using operating system-level permissions.
- Example for Linux:
  ```bash
  chmod -R 750 /var/www/html
  ```

By implementing these measures, the application can effectively mitigate Directory Path Traversal vulnerabilities and safeguard sensitive server resources.

