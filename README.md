# HEUWAY

_Une application web de gestion de temps de travail_


##  1. <a name='Table'></a> Table des matières
<!-- vscode-markdown-toc -->
1. [Table des matières](#Table)
2. [Présentation du projet et objectifs](#Pres)
3. [Consignes d’installation](#Consignes)
4. [Sources et contact des auteurs](#Sources)

<!-- vscode-markdown-toc-config
	numbering=true
	autoSave=true
	/vscode-markdown-toc-config -->
<!-- /vscode-markdown-toc -->



##  2. <a name='Pres'></a>Présentation du projet et objectifs
Heuway est une application Symfony qui permet à des employés de consulter une liste de services, caractérisés par un début, une fin, une pause... et de visualiser des statistiques sur ces derniers. L'objectif est d'offrir une vue d'ensemble, tout en contrôlant les temps de travail...

##  3. <a name='Consignes'></a>Consignes d’installation
Consignes d’installation pour éditer et visualiser le projet « Heuway » :
1. Cloner le dépôt : git clone https://github.com/ECurvat/Heuway.git
2. Installer les dépendances : composer install
3. Configurer la base de données dans le fichier .env
4. Créer la base de données : php bin/console doctrine:database:create
5. Appliquer les migrations : php bin/console doctrine:migrations:migrate
6. Lancer le serveur : php bin/console server:run

##  4. <a name='Sources'></a>Sources et contact des auteurs
- Icônes : Fontawesome - https://fontawesome.com

Si vous rencontrez des problèmes lors de l’installation ou de la manipulation du projet, veuillez contacter l’équipe de développement pour obtenir de l'aide :
- [CURVAT Elliot](@p2020739) (curvat.elliot@outlook.com)
