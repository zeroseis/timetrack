Timetrack is a simle webapp to track time worked on projects for clients.

As you will see by the setup steps, it's in extremelly early development stages, so use it at your own risk.

## Requirements

- A CodeIgniter compatible web server.
- MySQL.

## Setup

- Create app/config/config.php file by duplicating config.php.sample and set the $config['base_url'] to the base URL of your Timetrack installation.
- Create app/config/database.php file by duplicating database.php.sample and set the database connection properties.
- Run all the scripts in app/sql in your database, in their specific order (001, 002, 003...).
- Create a user by directly inserting a record in the 'users' table. The key field must be filled with an MD5 hash generated from your desired password.
- Access your base URL in a web browser and log in. Before start adding tasks, you must first create at least one client and at least one project.