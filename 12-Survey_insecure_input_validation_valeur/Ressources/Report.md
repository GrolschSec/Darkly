# Vulnerability Report

## Summary

An Insecure Input Validation vulnerability exists in the `Darkly` application. This flaw allows attackers to manipulate the `valeur` parameter in the survey feature beyond its expected range, potentially bypassing security controls and compromising the application.

## Vulnerability details

### CWE Reference

- CWE ID: [CWE-20: Improper Input Validation](https://cwe.mitre.org/data/definitions/20.html)

### Description

The `Darkly` application includes a survey feature accessible via the `?page=survey` endpoint at url http://darkly/index.php?page=survey. The survey accepts a `valeur` parameter, intended to accept values between 0 and 10. However, server-side validation is not enforced, allowing attackers to manipulate the input to exceed the expected range through client-side modifications.

### Steps to reproduce

1. Observe Normal Behavior:
   - Submit a request with a valid `valeur` parameter (e.g., 8) and observe that the application processes it as expected.

2. Modify the Input Client-Side:
   - Intercept the request and change the `valeur` parameter to exceed the expected range (e.g., 999).

3. Submit the Modified Input:
   - Send the manipulated request to the application.
   - Observe that the application accepts the invalid input without error.

### Observed Impact

This vulnerability allows an attacker to:
- Manipulate application behavior by bypassing input restrictions.
- Potentially exploit unexpected application states, leading to errors or unauthorized access.

## Mitigation

1. Implement Server-Side Validation:
   - Validate all inputs server-side to ensure they conform to the expected range or format.
   - Example in PHP:
   ```php
   if ($valeur < 0 || $valeur > 10) { die("Invalid input."); }
   ```

2. Enforce Client-Side Validation:
   - Use client-side validation to provide immediate feedback to users. Example with JavaScript:
   ```php
   if (valeur < 0 || valeur > 10) { alert("Value must be between 0 and 10."); }
   ```

## References

1. [OWASP Input Validation Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/Input_Validation_Cheat_Sheet.html)

