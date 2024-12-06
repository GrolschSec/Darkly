# Vulnerability Report

## Summary

An Improper Restriction of Excessive Authentication Attempts vulnerability exists in the `Darkly` application. This flaw allows attackers to perform brute-force attacks on the login page to guess user credentials due to the absence of restrictions on repeated authentication attempts.

## Vulnerability details

### CWE Reference

- **CWE ID**: [CWE-307: Improper Restriction of Excessive Authentication Attempts](https://cwe.mitre.org/data/definitions/307.html)

### Description

The login page of the application does not impose limits on authentication attempts. This allows attackers to repeatedly try different credentials without triggering any lockout, delay, or additional verification mechanism, making the application susceptible to brute-force attacks.

### Steps to reproduce

1. Navigate to the login page http://darkly/index.php?page=signin.
2. Attempt multiple incorrect logins in quick succession.
3. Observe that no lockout or delay is enforced after multiple failed attempts.
4. Download the rockyou wordlist:
	```bash
	wget -O utils/rockyou.txt https://raw.githubusercontent.com/danielmiessler/SecLists/refs/heads/master/Passwords/Leaked-Databases/rockyou-75.txt
	```
5. Navigate to the utils dir.
6. Create a python virtual environment:
	```bash
	python3 -m venv .env
	```
7. Activate the environment:
	```bash
	source .env/bin/activate
	```
8. Install the dependencies:
	```bash
	pip3 install -r requirements.txt
	```
9. Use the brute-force tool (e.g., `brute.py`) to automate credential guessing:
	```bash
	python3 brute.py <Darkly IP> <Path to Wordlist>
	```
10. The script identifies the password `shadow` as valid.
11. Connect using the login `admin:shadow`
12. The flag is on the page.


### Observed Impact

This vulnerability allows an attacker to:
- Perform brute-force attacks to guess user passwords.
- Compromise user accounts and access sensitive information.

## Mitigation

1. Implement throttling on the page.
2. Lockout the account after too many failed attempt.