# Vulnerability Report

## Summary
During testing of the website, an open redirect vulnerability was identified in the `site` parameter of the redirect page. This vulnerability allows an attacker to redirect users to arbitrary external domains, which could be exploited for phishing or other malicious activities.
## Vulnerability details

### CWE Reference

- **CWE ID**: [CWE-601: URL Redirection to Untrusted Site ('Open Redirect')](https://cwe.mitre.org/data/definitions/601.html)

### Description
 The vulnerability arises because the application does not properly validate or sanitize user-supplied input in the `site` parameter, allowing attackers to supply arbitrary URLs that the application will redirect users to.
### Steps to reproduce
1. Navigate to the vulnerable [url](http://darkly/index.php?page=redirect&site=).
2. Pass any domain to the site parameter.
3. The flag shows up on the page: 
![Flag](imgs/)

### Impact
While this vulnerability does not directly impact the functionality of the web application, it could lead users to fall victim to phishing attacks, thereby damaging the company's reputation.
## Mitigation
Since a switch statement is already implemented for the `site` parameter, the simplest way to mitigate this issue is to explicitly exit the script in the default case of the switch if the provided value does not match any of the authorized websites. This ensures that no unintended or arbitrary redirections are allowed.

## References
- [OWASP Unvalidated Redirects and Forwards Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Unvalidated_Redirects_and_Forwards_Cheat_Sheet.html)