git pull
git checkout prod

php7.4 bin/composer.phar install
php7.4 bin/composer.phar run phpstan
php7.4 bin/composer.phar run phpunit

cd frontend
yarn
yarn build
