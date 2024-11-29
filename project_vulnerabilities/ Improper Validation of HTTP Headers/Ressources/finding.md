# Improper Validation of HTTP Headers

## Description

This vulnerability occurs when an application relies on HTTP headers, such as `Referer` or `User-Agent`, for access control or critical functionality without proper validation. Attackers can manipulate these headers to bypass restrictions or access sensitive resources.

## Identify the Vulnerability

By inspecting the source code of the main page, the following link was observed in the HTML:

```html
<ul class="copyright">
    <a href="?page=b7e44c7a40c5f80139f0a50f3650fb2bd8d00b0d24667c4c2ca32c88e13b758f">
        <li>&copy; BornToSec</li>
    </a>
</ul>
```

Navigating to the specified URL revealed additional comments in the source code:
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
These comments suggest that the application uses the Referer and User-Agent HTTP headers to control access.

### Exploitation Steps:

1. Modify HTTP Headers:
- Set the `Referer` header to `https://www.nsa.gov/`.
- Set the `User-Agent` header to `ft_bornToSec`.

2. Send the Modified Request:
- Using a tool like `curl` or a custom browser extension, include the modified headers in the request.

Example with curl:
```bash
curl -H "Referer: https://www.nsa.gov/" -H "User-Agent: ft_bornToSec" http://darkly/?page=b7e44c7a40c5f80139f0a50f3650fb2bd8d00b0d24667c4c2ca32c88e13b758f
```

### Observed Impact

Improper validation of HTTP headers allows attackers to bypass security mechanisms by forging header values. In this case, manipulating the `Referer` and `User-Agent` headers grants unauthorized access to a sensitive page, exposing the flag.