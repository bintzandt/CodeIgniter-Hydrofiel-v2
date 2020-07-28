# Codeigniter-Hydrofiel
This repository contains all the necessary files for Hydrofiel.nl.

# Installation
First and foremost, clone this repository in the desired directory!

## Docker
For hosting the local development environment, docker is used.

Install docker for your operating system. See [their documentation](https://docs.docker.com/install) for information.

## Editing /etc/hosts
Make sure to add the following line to your /etc/hosts (Google to see how this is done on windows machines!)
`127.0.0.1 hydrofiel.test`

## Install dependencies and build all files
1. Make sure that you have `yarn` installed on your machine ([installation guide](https://yarnpkg.com/lang/en/docs/install]))
1. Run `yarn install` to download all dependencies
1. Run `grunt build` to build all assets
1. Run `composer install` to install PHP dependencies.

Optional: if you plan on making changes to the `sass` or `js` files, you can run `grunt watch` to keep building the assets in the background.

## Build the webcontainer
Run `docker-compose build` to build the container for the webserver.

## Setup your local environment
Copy `env` to `.env` and adjust variables as you need. The provided configuration should be enough to get you up and running.

## Start up the website
Run `docker-compose up` to start up everything. You should be able to visit the website on `hydrofiel.test`.

## Static assets
The static assets can be requested by sending me an email at webmaster@hydrofiel.nl