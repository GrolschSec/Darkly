# Insecure Input Validation

## Description

Insecure Input Validation occurs when an application does not properly validate or sanitize user-supplied inputs. This allows attackers to manipulate inputs beyond the expected range or format, potentially bypassing security controls.

## Identify the Vulnerability

The `Darkly` application includes a survey feature accessible via the `?page=survey` endpoint. The survey accepts a `valeur` parameter, which is meant to accept values between 0 and 10. However, it was found that the application fails to enforce this restriction server-side, making it vulnerable to client-side manipulation.

### Exploitation Steps:

1. Observe Normal Behavior:
- Submit a request with a valid `valeur` parameter (e.g., 8) and observe that the application processes it as expected.

2. Modify the Input Client-Side:
- Change the value of the `valeur` parameter to exceed the expected range.

3. Submit the Modified Input:
- Send the modified request to the application.


