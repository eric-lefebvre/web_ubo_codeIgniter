# EscapeWeb

Projet web de gestion d'une application web back-end et front-end.
! Seuls les fichiers Model View Controller ont été gardés dans le git

## Description

Escape web est une application de jeu sérieux en ligne accessible à tous, créé pour divertir des visiteurs d'un musée d'expositions ephémères.
Un visiteur peut choisir un scénario correspondant à l'exposition qu'il visite. Il aura alors accès à une série de questions.
Une fois les questions terminées, il peut s'inscrire pour enregistrer son score.

Toutes les données relatives à l'application (expositions, images, scénarios, participants...) sont stockées dans une base de données.
La page web questionne directement la base lors de son affichage grâce à des commandes PHP.

L'application web fonctionne grâce au framework CodeIgniter basé sur le système Model/View/controller.
Il permet d'afficher les pages webs comme si elles étaient une liste d'objets web.
