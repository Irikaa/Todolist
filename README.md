## How to clone and run the project-server

1. Open command prompt window.

2. Go to your Desktop;

3. Clone the source code on your htdocs folder;

```bash
$ git clone git@github.com:Irikaa/Todolist.git
```

4. Go inside the project folder;

```bash
$ cd Todolist/server
```

5. Open the project with VS Code;

```bash
$ code .
```

6. Open Terminal inside VS Code.

7. Execute the following command inside the terminal to install necessary PHP dependencies;

```bash
$ composer install
```

8. Create .env file copied from .env.example;

```bash
$ copy .env.example .env
```

9. Edit the .env file;

**Edit DB_DATABASE / DB_USERNAME / DB_PASSWORD*

```bash
...
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE= <Your Database Name > 
DB_USERNAME=root
DB_PASSWORD=admin
...
```

10. Execute the following command to migrate database;

**You need to have "!! Your Database Name !!" database in your MySQL database server in advance...*


```bash
$ php artisan migrate
```

11. Open another Terminal window and then execute the following command;

Execute the following command inside the terminal to install necessary package libraries;

```bash
$ yarn or
$ npm install
```

12. Execute the following command;

```bash
$ php artisan key:generate
```

13. Run the server

```bash
$ php artisan serve
```
## How to run client-side

1. Go inside the project folder;

```bash
$ cd Todolist/client
```
2. Execute the following command inside the terminal to install necessary package libraries;

```bash
$ npm install
```
13. Run the client

```bash
$ yarn watch
```

