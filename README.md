The main goal of this bundle is to make using ExtJS components in Laravel easier. The bundle provides a class, which contains helpers for three most common components used in ExtJS: grid, form and tree. The only thing you need is a model in Laravel. The bundle provides a command-line task which generates ExtJS models, restful controllers to handle database sync and routes for them. These generated files are based on the model you want to use. In other words, you just run a command-line task and the bundle takes care about the rest. After generating the files, you can call a helper in a view:
echo lext::grid('YourModelName');
To use a different component just switch the word 'grid' to 'form' or 'tree'.
There are a few conventions and assumptions:

    the model should have a corresponding table named like the model but in plural form (for example: model 'File', table 'files')
    models should extend the Eloquent class (Eloquent is the standard ORM in Laravel)

Using ExtJS Bundle for Laravel step by step:

    Create a model in Laravel
    Execute the following task in the command-line:
    php artisan extjs::ext:generate modelName
    The modelName parameter is a Laravel model you want to use
    Now, you can use the helper in a view in Laravel by using a bundle's helper, for example:
    echo lext::grid('YourModelName');

In the Git repository there are two folders: demo and development. The demo folder contains a project with already generated EXT models, routes, controllers etc. In short, everything is ready, so you can open it in your browser and see the three components in action. The homepage shows the grid; you can change the component using the navigation bar at the top of the page. The components are filled with some example data. If you want to add new models, you can use the development version. It's a clean project with installed ExtJS Bundle, where you can add your models, check whether everything works fine etc.
A short description of components:

Grid
according to the authors of ExtJS the grid component is "a supercharged <table>". It is able not only to display data in a table, but you can also add, delete and modify the data. These all actions don't require reloading the page, while an HTML table does. The grid is able to communicate with a database using REST - every request is sent using a dedicated HTTP method (GET, POST, PUT, DELETE). Laravel provides restful controllers, so the data can be easily synced with the database.

Form
Every model has also forms for adding new records in the table. After clicking "submit" button the data is saved in the database.
Tree
Trees are very useful to display hierarchical data like files structure or categories with subcategories. In the grid you can add new nodes, delete or modify them. A special type of a node is a leaf, which cannot have "children", so new nodes can be nested only in another nodes. The tree component also provides a drag and drop editor, so you can easily change the tree structure.
Moreover, tree requires that Laravel model has three specific fields for storing information about

    parent element,
    elements's state (leaf/node),
    main value (tree displays only one field, unlike the grid which displays all of them).

By default those fields are named parent_id, leaf and text respectively, and can be changed in model's annotations to any other values.
This code would change default values to parenting_node_name, de_field an is_leaf respectively:

/**
 * @ParentID(parenting_node_name)
 * @DefaultField(de_field)
 * @Leaf(is_leaf)
 */
class Files extends Eloquent [...]

