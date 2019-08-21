# Symfony Messenger workshop

## Installation

1. Install the project dependencies
   ```
   composer install
   ```

2. Create the default database structure (should default using SQLite)
   ```
   bin/console doctrine:schema:update --force
   ```

3. Run the Symfony server
   ```
   bin/console server:run
   ```

4. Open the web page and expect to see two terribly-looking forms.

