# Lefterboxd
Everybody knows that some of the best movies are leftists: Iron Man, Iron Man 2, Iron Man 3, Avengers and all Avengers films. But how do you know if a film is leftist? Just because its made by Marvel? No. There is another answer and its Lefterboxd a new app for your screens.

A silly project created as a joke for [Globe Hell Warning](https://directory.libsyn.com/shows/view/id/globehell).

# Getting Started

1. Clone the repository:
```
git clone https://github.com/jamjnsn/lefterboxd.git
```
2. Make a copy of `.env.example` renamed to `.env` and configure
3. Run `docker-compose up -d`
4. Initialize Laravel app:
```
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate
```
5. Head to `http://localhost:8080` and enjoy!
