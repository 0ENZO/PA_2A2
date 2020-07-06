#!/bin/sh


# Vu qu'on ne peut pas mettre à jour les fixtures si on a des objets qui sont
# liés entre eux par des tables parents, symfony n'arrive pas à la supprimer
# et on obtient une erreur avec un "CONTRAINT" etc.
# Donc il faut supprimer, recréer, et mettre les fixtures pour charger de
# nouvelles fixtures

# Ne pas oublier de donner les droits en exécutions de du script avec un
# chmod +x load_fixtures.sh

# ATTENTION
# Il supprime et recréer la base
# Y penser à deux fois avant d'éxecuter ce script

# Efface la base de données correcpondant au .env*
php bin/console doctrine:database:drop --force

# Créer la base de données correspondant au .env*
php bin/console doctrine:database:create

# Met à jour la base de données, en fonction du shema d'objet que l'on a dans
# l'application Symfony, donc dans le Manager
php bin/console doctrine:migrations:migrate --no-interaction

# Charge les fixtures
php bin/console doctrine:fixtures:load --append