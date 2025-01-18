# About

This is a tutorial PHP project.
Its directory structure is based on
[php-pds skeleton](https://github.com/php-pds/skeleton).

# Database configuration

We can create the required tables using the provided SQL script:

```bash
$ sudo mysql < bin/database.sql
```

Next, we are required to create a new SQL user with the necessary privileges.
Enter a MySQL shell using:

```bash
$ sudo mysql
```

And execute the following commands:

```sql
mysql> CREATE USER 'username'@'localhost' IDENTIFIED BY 'password';
```

Where `username` and `password` can be arbitrarily picked.

To grant our newly created user the necessary privileges,
we execute the following command:

```sql
mysql> GRANT ALL PRIVILEGES ON webtechdemo.* TO 'username'@'localhost';
```

Lastly, we should enter the credentials of our newly created user in the
credentials file.

Provided in the project root is an example file: `database-creds.xml.example`.
Copy this file to `database-creds.xml` and edit this file such that our username
is present in the `<userName>` tag, and our paassword is present in the `<password>`
tag.

# Running development server

To start the development server,
execute the following command in the project root:

```bash
php -S localhost:8080 -t ./public
```
