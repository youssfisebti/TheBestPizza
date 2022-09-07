Érapes Pour installer le Projet:

1. git clone git@github.com:youssfisebti/TheBestPizza.git
2. cd TheBestPizza/
3. composer install
4. php bin/console doctrine:database:create
5. php bin/console doctrine:schema:update --force
6. php bin/console doctrine:fixtures:load 
7. symfony server:start
be sure in .env you have
   DATABASE_URL=mysql://root:secret@127.0.0.1:3306/pizza?serverVersion=5.7