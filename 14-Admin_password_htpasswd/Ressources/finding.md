# Exposure of Sensitive Information to an Unauthorized Actor

## Description

This vulnerability occurs when sensitive information, such as credentials, configuration files, or other critical data, is accessible to unauthorized actors due to insufficient access controls or poor security practices.

### Evidence of Vulnerability

While analyzing the `robots.txt` file, the `whatever` directory was discovered. Within this directory, a `.htpasswd` file was found, containing credentials for HTTP Basic Authentication.

The file content was as follows:
```bash
root:d42f2da1df5ecdf29be4ac27edda0c12
```
Using hash-identifier, the hash format was identified as MD5. Using CrackStation, the hash was cracked, revealing the password qwerty123@.

Further enumeration using gobuster revealed the /admin directory. Attempting to log in with the obtained credentials was successful, exposing sensitive administrative functionality.

### Exploitation Steps

1. Identify Sensitive Directories:
- Locate directories via `robots.txt` or directory brute-forcing tools like gobuster.
- Example:
```bash
gobuster dir -u http://darkly/ -w /path/to/wordlist
```

2. Analyze Sensitive Files:
- Access `.htpasswd` and extract the username and hashed password.

3. Crack the Hash:
- Use a tool like hash-identifier to determine the hash type.
- Crack the hash using tools like CrackStation:
```bash
echo -n "d42f2da1df5ecdf29be4ac27edda0c12" | crackstation
```

4. Access Restricted Functionality:
- Use the credentials `root:qwerty123@` to log in to the /admin section.