# Keyword Popularity API

Symfony based API used to calculate the popularity a keyword on the give source.

Once the popularity of a keyword is calculated that info will be stored in the mysql DB.
This is done so that next time the same data is requested it can be fetched faster.

#### formula used for calculating the keyword popularity
`score = (positiv hits / (positiv hits + negativ hits) ) * 10`  
example for keyword **PHP**  
positive hist: 4231  
negative hits: 5988  
**score: 4.14 = (4231 / (4231+5988)) * 10**

## Requirements

## Setup

  Go to your local `hosts` file and add `127.0.0.1 keyword-popularity.local` as a new line.  
  Location of the `hosts` file:  
  * Linux and macOS - `/etc/hosts`  
  * Windows 10 - `c:\Windows\System32\Drivers\etc\hosts`  

### Using Just

  The easiest way to set up the project is by using the [Just](https://github.com/casey/just) command runner.
  Go to the project's root directory and run the `just install` command. This will build up all the needed Docker containers and automatically prepare your local environment.    
  Included `Justfile` has a number of useful commands so make sure to check it out.

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

### Running tests
  Written test are placed in the [test](https://github.com/ImSmoking/keyword-popularity-calculator/tree/master/tests) folder.  
  Before they can be run the test database needs to be set up which can be done by running commands  
  `docker-compose exec php bin/console --env=test bin/console doctrine:schema:update --force --complete` and  
  `docker-compose exec php bin/console --env=test doctrine:database:create --if-not-exists`
    
  Once that is done the tests can be run using the `docker-compose exec php composer run-tests` composer script.


## Usage

The API has one main endpoint that is used to get the popularity score of the passed word for the give source.    
**ENDPOINT:** `/api/v1/keyword/score/{source}/{term}`
  
**source** (required) - On which source the popularity of the passed **term** should be calculated. Currently the only 
supported source is **github**, new sources can be added and how to do that is covered in the **Adding New Keyword Source** section.
  
**term** (required) - Word whose popularity score on give **source** is calculated and returned.

### Response 
**REQUEST**: `/api/v1/keyword/score/github/docker`
```php
{
  "data": {
    "term": "docker",
    "score": "7.21",
    "source": "github",
    "searched_count": 1
  }
}
```
### Adding New Keyword Sources

1. Create a new keyword provider class and extend to it the `AbstractKeywordProvider.php` class.
   ```php
      <?php

        namespace App\Provider;
   
        use App\Handler\KeywordScoreHandler;use App\Provider\AbstractKeywordProvider;use App\Repository\KeywordRepository;
   
        class NewSourceKeywordProvider extends AbstractKeywordProvider
        {
            
            private NewSourceClient $newSourceClient;
   
            public function __construct(
                KeywordRepository $keywordRepository,
                KeywordScoreHandler $keywordScoreHandler,
                NewSourceClient $newSourceClient // example client for the new source.
            ) {
   
                $this->newSourceClient = $newSourceClient;
   
                parent::__construct($keywordRepository,$keywordScoreHandler);
              }

            public function getSource(): string
            {
                return 'new_source'
            }

            public function getHitsPositive(string $term): int
            {
                /* @toDO Add logic that will return the total number of positive 
                  hits for the passed term. */
   
                // Example code.
                return $this->newSourceClient->searchTearm($term.' '.AbstractKeywordProvider::POSITIVE_CONTEXT);
            }

            public function getHitsNegative(string $term): int
            {
                /* @toDO Add logic that will return the total number of negative 
                   hits for the passed term. */
   
                // Example code.
                return $this->newSourceClient->searchTearm($term.' '.AbstractKeywordProvider::NEGATIVE_CONTEXT);
            }
        }
   ```
   
2. Add the newly created keyword provider to the `KeywordProviderContainer.php` mini container.
   ```php
      <?php
        namespace App\Container;
        ...
        namespace App\Provider\NewSourceKeywordProvider;
   
        class KeywordProviderContainer implements ServiceSubscriberInterface
        {
            ...
            public static function getSubscribedServices(): array
            {
                return [
                    'github' => GithubKeywordProvider::class,
                    ...
                    // this line adds the newly created keyword source.
                    'new_source' => NewSourceKeywordProvider::class
                ];
            }
            ...
        }
   ```
   That is it. Now you should be able to calculate the popularity of a keyword on this newly added source
   by passing the **new_source** new source identifier as the `source` path parameter in the `/api/v1/keyword/score/{source}/{term}`
   endpoint.