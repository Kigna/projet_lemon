##Guide de l’Utilisation de de l'aaplication gestion d'événements 

#1- Objectif 
  L'application a pour objectif de faciliter la gestion des événements au sein d'une organisation régionale. Elle offre aux utilisateurs la possibilité de créer de nouveaux événements, de mettre à jour les informations existantes et de supprimer des événements. De plus, les utilisateurs peuvent s'inscrire à des événements en toute simplicité.

##2-  Configuration système requise
	#2.1 Installation de `PHP 8.2.11`
	#2.2 Installation de `composer 2.6.5`
	#2.3 Installation de `symfony 5.5.10`
	#2.4 Installation de `mysql 8.1.0`
	
##3 – Utilisation de l’application :
	#3.1 Télécharger l’application sur github 
		voici le lien :https://github.com/Kigna/projet_lemon
	#3.2 Démarrage  de l’application
	#Créer une base de données du nom : db_gestion_evenement 
    #Dans le fichier .env coller cette dans le fichier :`DATABASE_URL=mysql://root:@127.0.0.1:3306/db_gestion_evenement` 
	#Une fois dans le projet de l’application exécuter quelques commandes avant de le démarrer 	pour migrer des tables dans la base de données qui : 
	$ `symfony console make:migration `
	$  `symfony console docrine:migrations:migrate``
            Après les deux commandes exécuter cette commande permet d'injecter des données 5 utilisateur 	et 10 événements la commande suivante(repondez toutes les question par 'yes')
	$ `php bin/console doctrine:fixtures:load ``
           Maintenant pour lancer l’application il faut exécuter cette commande 
	$ `symfony serve ` 
	Après cela on récupère le lien fourni par l’application exemple :`http://127.0.0.1:33117/ `
   	et ouvrir un navigateur  

	#3.3 Connexion à l'application
	 Une fois sur la page d'accueil, les événements à venir sont affichés pour que les utilisateurs 	puissent les consulter. De plus, deux onglets sont proposés : "Se connecter" et "S'inscrire".

	Une fois que les utilisateurs se sont connectés, ils ont accès à plusieurs fonctionnalités :

	Ils peuvent consulter la liste des événements auxquels ils ont créer en cliquant sur le boutton 'mes événement'.
	Ils ont la possibilité de s'inscrire à de nouveaux événements.
	Ils peuvent se désinscrire d'événements auxquels ils étaient précédemment inscrits.
	Les utilisateurs peuvent également ajouter de nouveaux événements à la liste s'ils sont connecter.
	De plus, ils ont la possibilité de supprimer des événements qu'ils ont créés.
	
	