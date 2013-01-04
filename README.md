LextJS
======

Laravel ExtJS Bundle

In order to use the ExtJS helper, first you have to execute the Artisan CLI Task, which generates an ExtJS model, a controller for the grid with a route and a controller  for the form with a route. To accomplish it, you have to type in the command line (in the root of Laravel project) the following command:
php artisan ext:generate model_name

The model must exist in Laravel and the model must extend the Eloquent class (Eloquent is the default ORM in Laravel). There is a naming convention in Laravel that the model name is the table name with first letter uppercase.
Now you can use the helper using in the view the following code:
lext::component_name(model_name)

There are implemented helpers for 3 components: grid, form and tree.