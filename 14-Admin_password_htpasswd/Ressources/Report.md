# Vulnerability Report

## Summary

An Exposure of Sensitive Information to an Unauthorized Actor vulnerability exists in the `Darkly` application. This flaw allows unauthorized actors to access sensitive information, such as credentials and administrative functionality, due to insufficient access controls and poor security practices.

## Vulnerability details

### CWE References

- CWE ID: [CWE-200: Exposure of Sensitive Information to an Unauthorized Actor](https://cwe.mitre.org/data/definitions/200.html)
- CWE ID: [CWE-548: Exposure of Information Through Directory Listing](https://cwe.mitre.org/data/definitions/548.html)
- CWE ID: [CWE-327: Use of a Broken or Risky Cryptographic Algorithm](https://cwe.mitre.org/data/definitions/327.html)

### Description

Sensitive information, including credentials for HTTP Basic Authentication, was discovered during an analysis of the `robots.txt` file and further directory enumeration. The `.htpasswd` file contained an MD5-hashed password that was cracked, granting unauthorized access to administrative functionality in the `/admin` section.

### Steps to reproduce

1. Identify Sensitive Directories:
   - Locate directories using `robots.txt`.

2. Analyze Sensitive Files:
   - Access the `.htpasswd` file in the discovered `whatever` directory to extract the username and hashed password:
     ```
     root:d42f2da1df5ecdf29be4ac27edda0c12
     ```

3. Crack the Hash:
   - Use hash-identifier to determine the hash type (MD5).
   - Crack the hash with tools like CrackStation to reveal the password: `d42f2da1df5ecdf29be4ac27edda0c12`.
   - Result: `qwerty123@`.

4. Access Restricted Functionality:
   - Use the credentials `root:qwerty123@` to log in to the `/admin` section and access sensitive administrative functionality.

### Observed Impact

This vulnerability allows attackers to:
- Access sensitive information, such as hashed credentials.
- Crack weakly hashed passwords to gain unauthorized access.
- Expose administrative functionality, increasing the risk of compromise.

## Mitigation

1. Disable Directory Listing:
   - Prevent the web server from exposing directory contents.
   - Example for Nginx:
     ```
      server {
         listen 80;
         server_name example.com;

         root /var/www/html;

         location / {
            autoindex off;
         }

         location /admin {
            autoindex off;
         }
      }
     ```

2. Use Secure Cryptographic Algorithms:
   - Replace MD5 with secure hashing algorithms such as `bcrypt` or `Argon2` for password storage.
   - Example in PHP:
     ```php
     $hashed_password = password_hash("qwerty123@", PASSWORD_BCRYPT);
     ```

