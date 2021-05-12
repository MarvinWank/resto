git pull
git checkout prod

cp .env.prod .env

php7.4 bin/composer.phar install --optimize-autoloader --no-dev

php7.4 artisan migrate

cd frontend
yarn
yarn build


