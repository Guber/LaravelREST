# LaravelREST
Simple REST system built in Laravel PHP Framework (v5.3), developed for a college course <i class="icon-heart"></i>

Default Laravel web interface is located at *host/path-in-host/public* and default Laravel user authentication is created (login and register capabilities). To use the API you will need to register a new user since **API uses Basic Authentication** on all resources (all users are allowed all actions on any resource by default).

**Each request is logged** in in storage/app/logs/web.log file (as a single line in „uri browser“ format). 
**Unit test cases** which cover all of the Controllers are located in *tests/* folder. Test cases can be runed using phpunit.

> **Setting up:**

> - For server requirements check official [Laravel web page][1]
> - Change *config/database.php* to you database connection data.
> - Be sure to call *php artisan migrate* to execute needed database migrations and *composer install* to install needed dependencies

## REST resources

All URIs allow HEAD and OPTIONS verb. Additionally  there are other actions defined per URI:

For resource „USER“:

|VERB	|PATH	|ACTION	|ROUTE NAME
|-----|-----|-------|----------
|GET	|/users	|index	|users.index
|POST	|/users	|store	|users.store
|GET	|/users/{id}	|show	|users.show
|PUT/PATCH	|/users/{id}	|update	|users.update
|DELETE	|/users/{id}	|destroy	|users.destroy

For resource „PROJECT“:

|VERB	|PATH	|ACTION	|ROUTE NAME
|-----|-----|-------|----------
|GET	|/projects	|index	|projects.index
|POST	|/projects	|store	|projects.store
|GET	|/projects/{id}	|show	|projects.show
|PUT/PATCH	|/projects/{id}	|update	|projects.update
|DELETE	|/projects/{id}	|destroy	|projects.destroy

For resource „TASK“:

|VERB	|PATH	|ACTION	|ROUTE NAME
|-----|-----|-------|----------
|GET	|/tasks	|index	|tasks.index
|POST	|/tasks	|store	|tasks.store
|GET	|/tasks/{id}	|show	|tasks.show
|PUT/PATCH	|/tasks/{id}	|update	|tasks.update
|DELETE	|/tasks/{id}	|destroy	|tasks.destroy

[1] https://laravel.com/docs/5.3/installation
