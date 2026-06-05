#!/usr/bin/env bash
# Ce script est exécuté par Render pour builder l'image Docker

# Vérifier si Docker est disponible (ne pas utiliser la commande docker directement)
if ! command -v docker &> /dev/null; then
    echo "Docker n'est pas installé dans l'environnement de build."
    echo "Utilisation de la méthode officielle de Render..."
    # Render gère lui-même la construction de l'image Docker
    # Il suffit de s'assurer que le Dockerfile est présent
    exit 0
fi

# Si Docker est disponible, on peut builder manuellement
docker build -t mon-site-php .
