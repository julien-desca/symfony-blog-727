1. modifier le fichier .env

DATABASE_URL="mysql://root:@127.0.0.1:3306/symfony-blog?serverVersion=5.7"

2. lancer la commande 'composer install'

3. 'php bin/console doctrine:database:create'

4. 'php bin/console doctrine:migrations:migrate'