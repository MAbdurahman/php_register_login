# Welcome to the PHP MVC framework

This is a simple MVC framework for building web applications in PHP. It's free and [open-source](LICENSE).

It was created for the [Write PHP like a pro: build an MVC framework from scratch](https://davehollingworth.net/phpmvcg)
course. The course explains how the framework is put together, building it step-by-step, from scratch. If you've taken
the course, then you'll already know how to use it. If not, please follow the instructions below.

## Starting an application using this framework

1. First, download the framework, either directly or by cloning the repo.
2. Run **composer update** to install the project dependencies.
3. Configure your web server to have the **public** folder as the web root.
4. Create an .env file at the root of this project and enter your database configuration data: This file should have - 
   DB_HOST=, DB_NAME=, DB_USERNAME=, DB_PASSWORD=, SECRET_KEY=.
5. Open [app/Config.php](app/Config.php) and set variable SHOW_ERRORS to true for development or to false for
   production.
6. Create routes, add controllers, views and models.

See below for more details.

## Configuration

Configuration settings stored in the [app/Config.php](app/Config.php) class. Default settings include a setting to
show or hide error detail. In the created .env file, the database configuration or any other credentials can be 
stored here.

## Routing

The [Router](core/Router.php) translates URLs into controllers and actions. Routes are added in
the [front controller](public/index.php). A sample home route is included that routes to the `index` action in
the [home controller](app/controllers/Home.php).

Routes are added with the `add` method. You can add fixed URL routes, and specify the controller and action, like this:

```php
$router->add('', ['controller' => 'Home', 'action' => 'index']);
$router->add('posts/index', ['controller' => 'Posts', 'action' => 'index']);
```

Or you can add route **variables**, like this:

```php
$router->add('{controller}/{action}');
```

In addition to the **controller** and **action**, you can specify any parameter you like within curly braces, and also
specify a custom regular expression for that parameter:

```php
$router->add('{controller}/{id:\d+}/{action}');
```

You can also specify a namespace for the controller:

```php
$router->add('admin/{controller}/{action}', ['namespace' => 'Admin']);
```

## Controllers

Controllers respond to user actions (clicking on a link, submitting a form etc.). Controllers are classes that extend
the [core\Controller](core/Controller.php) class.

Controllers are stored in the `app/controllers` folder. A sample [home controller](app/controllers/Home.php) included.
Controller classes need to be in the `app/controllers` namespace. You can add subdirectories to organise your
controllers, so when adding a route for these controllers you need to specify the namespace (see the routing section
above).

Controller classes contain methods that are the actions. To create an action, add the **`Action`** suffix to the method
name. The sample controller in [app/controllers/Home.php](app/controllers/Home.php) has a sample `index` action.

You can access route parameters (for example the **id** parameter shown in the route examples above) in actions via
the `$this->route_params` property.

### Action filters

Controllers can have **before** and **after** filter methods. These are methods that are called before and after **
every** action method call in a controller. Useful for authentication for example, making sure that a user is logged in
before letting them execute an action. Optionally add a **before filter** to a controller like this:

```php
/**
 * Before filter. Return false to stop the action from executing.
 *
 * @return void
 */
protected function before()
{
}
```

To stop the originally called action from executing, return `false` from the before filter method. An **after filter**
is added like this:

```php
/**
 * After filter.
 *
 * @return void
 */
protected function after()
{
}
```

## Views

Views are used to display information (normally HTML). View files go in the `App/Views` folder. Views can be in one of
two formats: standard PHP, but with just enough PHP to show the data. No database access or anything like that should
occur in a view file. You can render a standard PHP view in a controller, optionally passing in variables, like this:

```php
View::render('home/index.php', [
    'name'    => 'Mahdi',
    'colours' => ['red', 'green', 'blue']
]);
```

The second format uses the [Twig](http://twig.sensiolabs.org/) templating engine. Using Twig allows you to have simpler,
safer templates that can take advantage of things
like [template inheritance](http://twig.sensiolabs.org/doc/templates.html#template-inheritance). You can render a Twig
template like this:

```php
View::renderTemplate('Home/index.html', [
    'name'    => 'Mahdi',
    'colours' => ['red', 'green', 'blue']
]);
```

A sample Twig template is included in [app/views/home/index.html](app/views/home/index.html) that inherits from the base
template in [app/views/base.html](app/views/base.html).

## Models

Models are used to get and store data in your application. They know nothing about how this data is to be presented in
the views. Models extend the `core\Model` class and use [PDO](http://php.net/manual/en/book.pdo.php) to access the
database. They're stored in the `app/models` folder. A sample user model class is included
in [app/models/User.php](app/models/User.php). You can get the PDO database connection instance like this:

```php
$db = static::getDB();
```

## Errors

If the `SHOW_ERRORS` configuration setting is set to `true`, full error detail will be shown in the browser if an error
or exception occurs. If it's set to `false`, a generic message will be shown using
the [app/views/404.html](app/views/404.html) or [app/views/500.html](app/views/500.html) views, depending on the error.

## Web server configuration

Pretty URLs are enabled using web server rewrite rules. An [.htaccess](public/.htaccess) file is included in
the `public` folder. Equivalent nginx configuration is in the [nginx-configuration.txt](nginx-configuration.txt) file.

---

Signup for the course [here](https://davehollingworth.net/phpmvcg) and understand how this framework is built from
scratch, putting it all together step by step.

