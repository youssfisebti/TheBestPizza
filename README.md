Steps for installing the Project:

1. git clone git@github.com:youssfisebti/TheBestPizza.git
2. cd TheBestPizza/
3. composer install
4. php bin/console doctrine:database:create
5. php bin/console doctrine:schema:update --force
6. php bin/console doctrine:fixtures:load 
7. symfony php bin/phpunit // pour lancer les tests
8. symfony server:start // pour lance le serveur