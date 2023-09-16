# Notflix-api

## Installation du projet

- Copier le .docker/.env.dist en .docker/.env
- Copier le .docker/.env.nginx.dist en .docker/.env.nginx
- Lancer les containers
- Il faut travailler depuis le conteneur php, vous pouvez utiliser l'extension [Dev container](https://marketplace.visualstudio.com/items?itemName=ms-vscode-remote.remote-containers)

## Création de clé pour l'authenytification (Obligatoire)

```console
php bin/console lexik:jwt:generate-keypair
setfacl -R -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
setfacl -dR -m u:www-data:rX -m u:"$(whoami)":rwX config/jwt
```

## URL avec les valeurs par défaut

- Symfony : http://localhost:7071/
    - Documentation API : http://localhost:7071/api
    - Dashboard : http://localhost:7071/dashboard
    
- PhpMyadmin : http://localhost:7070/
- Maildev : http://localhost:7072/