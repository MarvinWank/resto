php7.4 artisan down

git pull
git checkout prod

cp .env.prod .env

php7.4 bin/composer.phar install --optimize-autoloader --no-dev
php7.4 bin/composer.phar run phpstan
php7.4 bin/composer.phar run phpunit

php7.4 artisan migrate

cd frontend
yarn
yarn build


php7.4 artisan up
