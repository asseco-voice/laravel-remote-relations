<p align="center"><a href="https://see.asseco.com" target="_blank"><img src="https://github.com/asseco-voice/art/blob/main/evil_logo.png" width="500"></a></p>

# Laravel remote relations

This package enables creating relations locally from Eloquent models to remote services. 

## Installation

Install the package through composer. It is automatically registered
as a Laravel service provider, so no additional actions are required.

``composer require asseco-voice/laravel-remote-relations``

## Setup

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
make it extend ``HasRemoteRelations`` interface

1. Interface has 2 methods which are responsible for resolving a single relation or a
collection of relations. 

1. Resolving collections will always be done on a single model type (i.e. collection
of users) on a single service so that you can resolve multiple models at once if possible. 

1. Model IDs are of ``string`` type so that it supports non-numeric IDs as well.

1. Add the class to config under ``services`` key in the format `'service_name' => Service::class'`

## Usage

You can have your models use a ``Relatable`` trait which will provide an Eloquent relation to 
a `RemoteRelation` class, so you don't have to repeat yourself. 

There is also a handy ``relate($service, $model, $id)`` method to create a relation. 

### Example

Given the following configuration:

```
'services' => [
    'some_remote_service' => SomeRemoteService::class,
],
``` 

Having added a `Relatable` trait to your ``User`` model.

You can now call a ``relate()`` method on a single user instance like this:

```
$user->relate('some_remote_service', 'model_on_your_remote_service', 'id_of_a_model_on_your_remote_service');
```

Note that first parameter equals to the service key in the configuration. That is how package knows which 
service to use. 

Resolving relations can be done for a single relation, or a collection of relations:

```
$user->remoteRelations->first()->resolve() // resolves a single relation
$user->remoteRelations->resolve() // resolves a relation collection
```
