# Information Exposure Through Directory Listing

## Description

Directory listing allows unauthorized users to view the structure and contents of a web server's directories. This can expose sensitive information, such as configuration files, administrative paths, or other restricted resources, to attackers.

### Evidence of Vulnerability

The `robots.txt` file on the `Darkly` server contains a directive to disallow access to the path `/.hidden`. However, this directory is accessible and contains numerous nested subdirectories, some of which include files like `README` or potentially sensitive information.

### Exploitation Steps

1. Locate the Vulnerable Directory**:
- Access the `robots.txt` file to identify restricted paths.
- Navigate to the `/.hidden` directory.

2. Download Files Recursively**:
- Use `wget` to download all files and subdirectories from `/.hidden`:
   ```bash
   wget -r -np -e robots=off -R "index.html*" http://darkly/.hidden/
   ```

3. Search for Sensitive Information**:
- Use a Bash script to parse downloaded files for a flag or other sensitive information:
   ```bash
   for file in $(find darkly/ -type f); do
      cat $file | grep flag;
   done
   ```