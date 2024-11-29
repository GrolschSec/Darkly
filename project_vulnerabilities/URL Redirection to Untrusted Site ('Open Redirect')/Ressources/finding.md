# URL Redirection to Untrusted Site ('Open Redirect')

## Description
The application is vulnerable to Open Redirect, allowing attackers to redirect users to untrusted external sites by manipulating URL parameters.

## Evidence of Vulnerability
Examining the `Darkly` source code reveals a redirection mechanism used for social media links:

```index.php?page=redirect&site=instagram```

By replacing the `site` parameter value with a malicious URL, such as a phishing site resembling Instagram, an attacker can trick users into visiting malicious domains while maintaining the appearance of legitimacy.

### Steps to Reproduce
1. Access the vulnerable endpoint: `http://darkly/index.php?page=redirect&site=instagram`.
2. Replace the `site` parameter with a phishing URL, e.g., `http://darkly/index.php?page=redirect&site=malicious.com`.
3. Observe the redirection to the provided malicious site.

### Impact
This vulnerability can be exploited to:
- Conduct phishing attacks by redirecting users to malicious sites.
- Damage the reputation of the website.
- Compromise user credentials or other sensitive information.

