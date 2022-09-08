Steps for installing the Project:

1. git clone git@github.com:youssfisebti/TheBestPizza.git
2. cd TheBestPizza/
3. composer install
4. php bin/console doctrine:database:create
5. php bin/console doctrine:schema:update --force
6. php bin/console doctrine:fixtures:load 
7. symfony php bin/phpunit // pour lancer les tests
8. symfony server:start // pour lancer le serveur

OU bien avec docker :)

1. git clone git@github.com:youssfisebti/TheBestPizza.git
2. cd TheBestPizza/
3. docker-compose up -d --build
4. docker exec -it php-app-pizza bash
5. php bin/console doctrine:database:create
6. php bin/console doctrine:schema:update --force
7. php bin/console doctrine:fixtures:load
8. symfony server:start
9. et depuis votre navigateur http://localhost:8089/

Pour se connecter
1. Compte admin :  admin --- admin
2. Compte Client : client --- client
