<p align="center"><a href="https://see.asseco.com" target="_blank"><img src="https://github.com/asseco-voice/art/blob/main/evil_logo.png" width="500"></a></p>

# Laravel remote relations

This package enables creating relations locally from Eloquent models to remote services. 

## Installation

Install the package through composer. It is automatically registered
as a Laravel service provider, so no additional actions are required.

``composer require asseco-voice/laravel-remote-relations``

## Usage

Run ``php artisan migrate`` to migrate the table. 

Table consists of:

1. Local model type/id - polymorphic relation of local Eloquent models
1. Service - indicating a key which needs to be mapped to a certain service class
1. Remote model - plain string representing a model in a remote service (isn't Laravel
specific)
1. Remote model ID - actual ID to which a relation is created 

Out of the box no services are registered because the package doesn't know
where to fetch related data from, so you need to provide services manually. 

1. Publish the configuration:

    ```
    php artisan vendor:publish --provider="Voice\RemoteRelations\RemoteRelationsServiceProvider"
    ```

1. Create a new service class for remote service you'd like to make a relation to and
make it extend ``RemoteService`` interface

1. Interface has a single method which is responsible for resolving a collection of
relations. It has 2 parameters. First parameter is remote model string, and second is
relation collection.

1. Package will behind the scenes group relations by service and model, so that when
resolve method is hit, you can be sure that you are getting a collection only for that 
service and for a same set of models.

1. You can then proceed with resolving IDs either at once, or doing a request to 
remote service multiple times, depending on what the API supports.

1. Model IDs are of ``string`` type so that it supports non-numeric IDs as well.
