# Reliance on Cookies without Validation and Integrity Checking in a Security Decision

## Description

This vulnerability occurs when a web application uses cookies for critical security decisions, such as authentication or authorization, without verifying their validity or integrity. Attackers can manipulate cookies, either through browser developer tools or custom client-side scripts, to bypass security mechanisms.

### Evidence of Vulnerability

During the enumeration of the `Darkly` web application, the following cookie was observed in HTTP requests:

`I_am_admin`

Using `hash-identifier`, we determined the cookie value is hashed with **MD5**. By generating MD5 hashes for potential keywords (e.g., `true`, `false`), we identified that the cookie functions as a boolean:

```bash
# Generate MD5 hash for "false"
echo -n "false" | md5sum
```

The generated hash matches the observed value, confirming that the cookie represents a boolean value. By modifying the cookie value to true:

```bash
# Generate MD5 hash for "true"
echo -n "true" | md5sum
```

We can inject the modified cookie to gain administrator privileges.

### Exploitation Steps

1. Inspect the HTTP request headers to find the `I_am_admin` cookie.

2. Generate the MD5 hash for true using a hashing tool:

```bash
echo -n "true" | md5sum
```

3. Replace the existing cookie value with the new hash.

4. Submit the modified request to gain admin privileges.