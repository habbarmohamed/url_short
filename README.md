# go into the project
cd url_short

# create a .env file
cp .env.example .env

# install composer dependencies
composer update

# install npm dependencies
npm install

# generate a key for your application
php artisan key:generate

# add the database connection config to your .env file
DB_CONNECTION=mysql
DB_DATABASE=test
DB_USERNAME=root
DB_PASSWORD=

# run the clear cache and migration files to generate the schema
php artisan config:cache
php artisan migrate

# run webpack and watch for changes
npm run watch
