# Vulnerability Report

## Summary

An Improper Validation of HTTP Headers vulnerability exists in the `Darkly` application. This flaw allows attackers to manipulate headers like `Referer` and `User-Agent` to bypass security mechanisms and gain unauthorized access to sensitive resources.

## Vulnerability details

### Description

The application uses HTTP headers such as `Referer` and `User-Agent` for access control. These headers are client-controlled and can be easily forged. In this case, access to a sensitive resource depends on specific values of these headers, making the application vulnerable to header manipulation.

### Steps to reproduce

1. **Inspect the Page Source**:
   - On the main page http://darkly/index.php, observe the following link in the HTML:
     ```html
     <ul class="copyright">
         <a href="?page=b7e44c7a40c5f80139f0a50f3650fb2bd8d00b0d24667c4c2ca32c88e13b758f">
             <li>&copy; BornToSec</li>
         </a>
     </ul>
     ```

2. **Identify Header Dependency**:
   - In the source code of the linked page, observe comments indicating required values for the `Referer` and `User-Agent` headers:
     ```html
     <!--
     You must come from : "https://www.nsa.gov/".
     -->
     ```
     ```html
     <!--
     Let's use this browser : "ft_bornToSec". It will help you a lot.
     -->
     ```

3. **Modify HTTP Headers Using Burp Suite**:
   - Open Burp Suite and configure it as your browser's proxy.
   - Navigate to the sensitive page in your browser to intercept the request in Burp Suite.
   - In the intercepted request:
     - Modify the `Referer` header to `https://www.nsa.gov/`.
     - Modify the `User-Agent` header to `ft_bornToSec`.
   - Forward the modified request to the server.

4. **Access the Sensitive Resource**:
   - Send the request with the forged headers to bypass the security mechanism and view the sensitive content.

### Observed Impact

This vulnerability allows attackers to:
- Manipulate HTTP headers to bypass security mechanisms.
- Gain unauthorized access to sensitive pages, exposing critical information like flags or internal data.

