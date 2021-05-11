git pull
git checkout prod

php74 bin/composer.phar install
php74 bin/composer.phar run phpstan
php74 bin/composer.phar run phpunit

cd frontend
yarn
yarn build
