# Quiz Generator

Quiz Generator est un site de génération de quiz réalisé avec Symfony, React et l'API OpenAI.

## Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- PHP 7.4 ou supérieur
- Composer
- Node.js et npm
- Symfony CLI

## Installation

1. Clonez le dépôt Git :

git clone https://github.com/yourusername/quiz_generator.git

2. Accédez au dossier du projet :

cd quiz_generator

3. Installez les dépendances PHP avec Composer :

composer install

4. Installez les dépendances JavaScript avec npm :

npm install

5. Créez la base de données :

php bin/console doctrine:database:create

6. Exécutez les migrations pour créer les tables :

php bin/console doctrine:migrations:migrate

7. (Optionnel) Chargez les fixtures pour remplir la base de données avec des données de test :

php bin/console doctrine:fixtures:load

8. Démarrez le serveur Symfony :

symfony server:start


Vous pouvez maintenant accéder à l'application dans votre navigateur à `http://localhost:8000`.
