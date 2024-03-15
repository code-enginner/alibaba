# Alibab Task


In this sample project, I use postgres as a database but you can change database as you preferred. remember that you should change database config in .env file and database.php in config directory and also create database.

## Installation

After cloning the project just run the below command:
```sh
php artisna app:init
```

This command prepares the application for use. run composer install and npm install, run databse migration for you and seed the database with some mocke data.

For user validation, I have used the _Laravel/Breeze_ package. Use the following route to access the admin panel:
```sh
admin/login
```
If you have used my database file, enter the following information to log in:
```sh
admin@admin.com
11111111
```

To log in as a regular user, use the following route:
```sh
login
```

all users have __22222222__ as password.

In this application, users can register new articles or edit their information. In the article editing section, they can change the display status of the article. However, each user is only allowed to edit their own articles because authorization and policy are used to manage permissions.

Users are not allowed to delete articles, and this capability is only available to the administrator. The administrator can view the complete list of articles and authorize their publication. Additionally, the administrator can delete articles or restore them from deletion status since softDelete capability has been utilized.

In this application, a logging system has been implemented to enable precise management and monitoring of program sections. To view logs, you can use the following route:
```sh
log-viewer
```
After entering the above route, you can view the list of log channels and inspect the logs of each channel:

- article.log
- laravel.log
- auth.log

## Features

- Using Tailwind CSS for user interface design,
- PostgreSQL database,
- Logging system,
- Custom command for running the program.



## Routes

Some of Important routes:

| route | usage |
| ------ | ------ |
| admin/login | dedicated to login admin |
| login | login for regular user |
| log-viewer | show all system logs |

## Docker

Open a terminal in the root directory of project where the Dockerfile and docker-compose.yml are located, then run:.

```sh
docker-compose up --build
```

This command will build your Docker images and start your containers. Make sure Docker is installed on your system before running this command.
