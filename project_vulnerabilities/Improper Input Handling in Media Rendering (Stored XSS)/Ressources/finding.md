# Improper Input Handling in Media Rendering (Stored XSS)

## Description

This vulnerability occurs when an application improperly handles user-supplied input for rendering media content, allowing attackers to inject malicious scripts. By exploiting this flaw, attackers can execute arbitrary JavaScript in the victim's browser, leading to unauthorized actions or data exposure.

## Identify the Vulnerability

The application provides a media rendering feature accessible via the following URL structure:

```plaintext
http://darkly/index.php?page=media&src=nsa
```
The `src` parameter specifies the source of the media to render. By default, it loads an image, but it was discovered that the application fails to validate or sanitize the `src` parameter, making it vulnerable to injection.

### Steps to Exploit:

1. Inspect the Default Behavior:
- Navigate to the media page:
```plaintext
http://darkly/index.php?page=media&src=nsa
```
- Observe that the `src` parameter loads an image from the specified source.

2. Inject a Malicious Payload:
- Replace the src parameter with a Base64-encoded payload to execute arbitrary JavaScript:
```plaintext
http://darkly/index.php?page=media&src=data:text/html;base64,PHNjcmlwdD5hbGVydCg0Mik8L3NjcmlwdD4K
```
- The decoded Base64 payload:
```html
<script>alert(42)</script>
```

### Observed Impact:

This vulnerability allows attackers to inject and execute arbitrary JavaScript via the src parameter. This can be exploited for:
- Unauthorized data access.
- Session hijacking.