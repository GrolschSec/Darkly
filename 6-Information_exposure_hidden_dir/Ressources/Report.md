# Vulnerability Report

## Summary
During enumeration, a robots.txt file was discovered at the root of the server. While this file is intended to guide crawlers on where they should and should not go, it can provide valuable hints for attackers to locate restricted directories.

## Vulnerability details

### CWE Reference

- **CWE ID**: [CWE-548: Exposure of Information Through Directory Listing](https://cwe.mitre.org/data/definitions/548.html)

### Description
In the robots.txt, we found a restricted directory named .hidden with directory indexing enabled, allowing us to access and gather valuable files contained within it. The .hidden directory contained numerous subdirectories, each with additional subdirectories and files. Manually examining each file was impractical and time-consuming.
To address this, we used wget to download all the files in bulk. This allowed us to analyze the files further on our local machine using tools like find and grep. The vulnerability primarily arises from unrestricted access to directories with directory indexing enabled.
### Steps to reproduce
1. Download all the files using wget:
    ```bash
    wget -r -np -e robots=off -R "index.html*" http://darkly/.hidden/
    ```
2. Find all the files in the downloaded dir:
    ```bash
    find darkly/ -type f > files.txt
    ```
3. Copy all the files content into a single file:
    ```bash
    for file in $(cat files.txt); do cat $file >> content.txt;done
    ```
4. Grep reverse unwanted output:
    ```bash
    grep -v "Demande" content.txt | grep -v "Tu" | grep -v "Toujours" | grep -v "Non"
    ```
5. The flag is in the output.

### Impact
Directory indexing enabled on the .hidden directory exposes sensitive files and subdirectories, allowing attackers to gather confidential information or metadata about the server structure. This significantly increases the attack surface and can lead to further exploitation.
## Mitigation
Disable directory indexing on the web server to prevent unauthorized access to directory contents. Additionally, implement proper access controls to ensure sensitive files and directories are not accessible without authentication or authorization.
