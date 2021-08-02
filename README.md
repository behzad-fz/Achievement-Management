# iPHONE PHOTOGRAPHY SCHOOL
Achievement Management<br>

## Requirements:
- Docker
- Docker-compose

## Dockerized Environment:
- NGINX
- PHP-FPM
- MySQL

## Installation Guide (Only First Time)
Run below commands into your terminal:

NOTICE: if your port 8889 and 3308 are already in use, please set DOCKER_HTTP_PORT and DOCKER_MYSQL_PORT to free ports in .env file.

```
git clone https://github.com/behzad-fz/Achievement-Management.git
cd Achievement-Management
cp .env.example .env
docker-compose build
docker-compose up -d
```
NOTICE: Wait enough for docker to create database. Make sure it is up and running and then run:
```
make setup
```
NOTICE : if you get following error, Your database docker container may have stopped for some reason
```
 SQLSTATE[HY000] [2002] php_network_getaddresses: getaddrinfo failed: Name or service not known (SQL: select * from information_schema.tables where table_schema = AchievementManagement and table_name = migrations and table_type = 'BASE TABLE')
```
Just run "docker-compose up -d" again to start the containers, then run "make setup" command to resume setup process.

NOTICE: At the end it will require you to enter root password to set permission:

## Makefile
You can see available make commands by typing `make` in the terminal.

Now app should be alive on http://localhost:8889.

Enjoy :)
