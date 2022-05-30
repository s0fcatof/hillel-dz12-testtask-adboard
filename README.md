# Ad Board

## Install dependencies
```
docker run --rm --interactive --tty --volume $(pwd):/app composer install
```

## Configure container
1) Copy `.env.example` to `.env` and set DB settings.
2) Run command ```docker-compose up -d```

## Run tests

### All feature tests
```
php artisan test --testsuite=Feature
```

## Run code sniffer
E.g. to check `app` folder against the `PSR-12` coding standard
```
docker run --rm -v $(pwd):/data cytopia/phpcs --standard=PSR12 app
```
