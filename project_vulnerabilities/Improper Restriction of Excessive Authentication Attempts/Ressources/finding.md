# Improper Restriction of Excessive Authentication Attempts

## Description

This vulnerability occurs when an application does not properly restrict the number of authentication attempts allowed. This enables attackers to perform brute-force attacks to guess user credentials.

## Identify the Vulnerability

The login page of the application does not impose any limits on authentication attempts. During testing, it was observed that repeated login attempts with invalid credentials did not trigger any form of blocking or delay.

### Steps to Exploit:

1. **Test for Authentication Limits**:
   - Attempt multiple incorrect logins in quick succession.
   - Observe that the application does not enforce any lockout, delay, or captcha mechanism.

2. **Perform a Brute-Force Attack**:
   - Use the `brute.py` Python script to brute force the login page using a wordlist.

3. **Run the Script**:
   - Save the script as `brute.py` and execute it using the following command:
     ```bash
     python3 login-brute.py <Darkly IP or Domain> <Path to Wordlist>
     ```

4. **Gain Unauthorized Access**:
   - Once the script finds a valid password, use it to log in and gain access.

This lack of restriction allows an attacker to compromise user accounts by guessing passwords through brute force.
