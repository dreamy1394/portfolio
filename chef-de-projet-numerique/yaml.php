services:
  - type: web
    name: mon-site-php
    env: docker
    buildCommand: docker build -t render-build .
    startCommand: docker run -d -p 10000:80 --name render-app render-build
    autoDeploy: true