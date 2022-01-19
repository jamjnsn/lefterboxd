# Lefterboxd
Everybody knows that some of the best movies are leftists: Iron Man, Iron Man 2, Iron Man 3, Avengers and all Avengers films. But how do you know if a film is leftist? Just because its made by Marvel? No. There is another answer and its Lefterboxd a new app for your screens.

# Getting Started

1. Create your `docker-compose.yml`
```
version: '3'
services:
    app:
        build: .
        env_file: .env
        ports:
          - '8080:80'
        volumes:
          - storage:/var/www/storage
          - .env:/var/www/.env
        restart: unless-stopped
    mariadb:
        image: 'mariadb:10'
        environment:
          MARIADB_DATABASE: ${DB_DATABASE}
          MARIADB_ROOT_PASSWORD: ${DB_PASSWORD}
          MARIADB_PASSWORD: ${DB_PASSWORD}
          MARIADB_USER: ${DB_USERNAME}
        volumes:
          - db:/var/lib/mysql
        restart: unless-stopped
volumes:
  db:
  storage:
```

2. Make a copy of `.env.example` renamed to `.env` and configure
3. Run `docker-compose up -d`
4. Initialize Laravel app:
```
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```
5. Head to `http://localhost:8080` (or whatever port you selected) and enjoy!
