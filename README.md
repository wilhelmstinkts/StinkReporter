# StinkReporter

The Stink Reporter provides a RESTful HTTP-api to report when and where it stinks and query for past stinks.
The use can be looked up in the [OpenApi Specification](interface/openapi.yaml)

## Development

### Building and running the project

The project uses docker-compose to provide an environment to develop and test the app in. To start the app simply run `docker-compose up` from the main folder.
You will get:

- A mysql database
- A phpmyadmin adminstration web frontend for that database at `localhost:2000`
- The actual app running on a dokerized Apache server at `localhost:8080`
- A small container providing the testing framework `Tavern`

To add all dependencies run `docker-compose exec apache composer update`

### Tests

There are unittests that can be carried with `docker-compose exec apache composer test` and api tests that are run by calling `docker-compose run tavern /apitests/run-api-tests.sh`

### Linting

To lint the php code run `docker-compose exec apache composer phpcs`

### Environment settings

We use a file that contains environment settings: [env.php](source/env.php)
The checked in version obviously only contains test settings and will not be copied to the server.
Please upload a production env.php manually.
