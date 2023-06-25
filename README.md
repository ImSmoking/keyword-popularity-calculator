# Keyword Popularity API

## Requirements

## Setup

  Go to your local `hosts` file and add `127.0.0.1 keyword-popularity.local` as a new line.  
  Location of the `hosts` file:  
  * Linux and macOS - `/etc/hosts`  
  * Windows 10 - `c:\Windows\System32\Drivers\etc\hosts`  

### Using Just

  The easiest way to set up the project is by using the [Just](https://github.com/casey/just) command runner.
  Go to the project's root directory and run the `just install` command. This will build up all the needed Docker containers and automatically prepare your local environment.  

### Manual 

  1. Copy the following provided distribution files:  
  * `docker-compose.yaml.dist` -> `docker-composer.yaml`  
  * `env` -> `env.local`
  2. run `docker-compose up --build --detach` in order to build up and run needed docker containers.
  3. run `docker-compose exec php composer install` in order to install all the required project dependencies.
  4. run `docker-compose exec php bin/console doctrine:database:create --if-not-exists` in order to create the MySql DB.
  5. run `docker-compose exec php bin/console doctrine:schema:update --force --complete` in order to update the MySql DB.
    

Now you should be able to access the OpenAPI documentation on http://keyword-popularity.local:8000/api/doc and the
dockerized version of [Adminer](https://www.adminer.org/) database management tool on http://localhost:8080  

## Adding New Keyword Sources
