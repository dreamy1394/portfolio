# Utilise l'image officielle PHP 8.1 avec Apache
FROM php:8.1-apache

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier tous les fichiers du projet dans le conteneur
COPY . .

# Activer le module rewrite pour les URLs propres
RUN a2enmod rewrite

# (Optionnel) Installer des extensions PHP si nécessaire
# RUN docker-php-ext-install pdo pdo_mysql

# Redémarrer Apache pour appliquer les changements
RUN service apache2 restart

# Exposer le port 80 (port par défaut d'Apache)
EXPOSE 80

# Commande pour lancer Apache (version 100% compatible avec Render)
CMD ["apache2ctl", "-D", "FOREGROUND"]
