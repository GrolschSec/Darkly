# Vulnerability Report

## Summary
During the enumeration phase, a cookie named `I_am_admin` was discovered, which appeared to be linked to administrative privileges. Upon further analysis, the cookie's value was identified as an MD5 hash encoding a boolean value. By modifying the cookie to represent a `true` boolean, administrative privileges were granted without requiring additional authentication.

## Vulnerability details

### CWE Reference

- **CWE ID**: [CWE-784: Reliance on Cookies without Validation and Integrity Checking in a Security Decision](https://cwe.mitre.org/data/definitions/784.html)

### Description
This vulnerability occurs when a web application uses cookies for critical security decisions, such as authentication or authorization, without verifying their validity or integrity. Attackers can manipulate cookies, either through browser developer tools or custom client-side scripts, to bypass security mechanisms.

### Steps to reproduce
1. Intercept a request on the website using burp.
2. Get the value of the cookie to set it as true as follow:
```bash
echo -n "true" | md5sum
```
3. Replace the cookie with the true value.
4. Forward the request.
5. The flag shows up on the page.

### Impact
Attackers can exploit this flaw to gain unauthorized administrative access making expanding them the attack surface.
## Mitigation
Use a secure method (e.g., signed or encrypted tokens like JWT) to store sensitive information in cookies, and validate privileges on the server side.
## References
- [OWASP Session Management Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Session_Management_Cheat_Sheet.html)
