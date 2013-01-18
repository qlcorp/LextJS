<?php
class Extjs_Ext_Task
{
    private static $usageMessage = "Usage: php artisan ext:generate model_name\n";

    /**
     * Decorator for indenting generated code.
     * @param $length
     * @param bool $do
     * @return string
     */
    private static function s($length, $do = true) {
        if ($do)
            return str_repeat(' ', $length);
        else
            return '';
    }

    public function __construct()
    {
        Autoloader::map(array('lext' => Bundle::path('extjs') . 'libraries/lext.php')
        );
    }

    public function run($args)
    {
        echo self::$usageMessage;
    }

    public function generate($args)
    {
        if (count($args) != 1)
            die(self::$usageMessage);

        $model = $args[0];
        $table = Str::plural(Str::lower($model));
        $options = array(
            'Model' => $model,
            'Table' => $table,
            'DefaultField' => 'text',
            'ParentID' => 'parent_id',
            'Leaf' => 'leaf'
        );
        $r = new ReflectionClass($model);
        preg_match_all('#@(.*?)\n#s', $r->getDocComment(), $annotations);
        if (!empty($annotations)) {
            foreach ($annotations[0] as $annotation) {
                preg_match('#@(?P<name>\w+)[ ]*(\([ ]*(?P<value>\w+)[ ]*\))?\n#s', $annotation, $a);
                if (array_key_exists($a['name'], $options))
                    $options[$a['name']] = $a['value'];
            }
        }
        $columns = DB::query('SHOW columns from ' . $table);
        if (Cache::has('ext' . $model, $columns)) {
            $was_cached = true;
        } else {
            Cache::forever('ext' . $model, $columns);
            $was_cached = false;
        }


        // Generate code
        $this->generateExtModel($columns, $model, $options);
        $this->generateGrid($columns, $model, $options, $was_cached);
        $this->generateForm($columns, $model, $options, $was_cached);
        $this->generateTree($model, $options, $was_cached);

        /**************************************************************/
        echo 'Task executed successfully';

    }

    private function generateTree($model, $options, $was_cached)
    {
        $handle = fopen(path('app') . 'controllers/' . Str::lower($model) . 'nodes.php', "w");
        $content = str_replace(
            array('MODEL', 'TABLE', 'DEFAULT_FIELD', 'PARENT_ID', 'LEAF'),
            array($options['Model'], $options['Table'], $options['DefaultField'], $options['ParentID'], $options['Leaf']),
            file_get_contents(Bundle::path('extjs') . '/tasks/templates/TreeController.template.php')
        );
        fwrite($handle, $content);
        fclose($handle);

        /* ROUTE FOR TREE CONTROLLER */
        if (!$was_cached) {
            $route = "\n" . "Route::any('".Str::lower($model). "nodes/(:all?)', array('uses' => '".Str::lower($model)."nodes@index' ));";
            File::append(path('app') . 'routes.php', $route);
        }
    }

    private function generateForm($columns, $model, $options, $was_cached)
    {
        $saveFields = '';
        $iteration = 0;
        foreach ($columns as $column) {
            if ($column->field == 'id') continue;
            if (lext::getExtType($column->type) == 'datefield')
                $saveFields .= self::s(8, $iteration++ != 0) . '$record-> ' . $column->field . "=" . 'date( "Y-m-d", strtotime($_POST[\'' . $column->field . '\'] ) );' . "\n";
            else
                $saveFields .= self::s(8, $iteration++ != 0) . '$record-> ' . $column->field . "=" . '$_POST[\'' . $column->field . '\']' . "; \n";
        }

        $handle = fopen(path('app') . 'controllers/' . Str::lower($model) . 'form.php', "w");
        $content = str_replace(
            array('MODEL', 'SAVE_FIELDS;', 'PARENT_ID', 'LEAF'),
            array($options['Model'], $saveFields, $options['ParentID'], $options['Leaf']),
            file_get_contents(Bundle::path('extjs') . '/tasks/templates/FormController.template.php')
        );
        fwrite($handle, $content);
        fclose($handle);

        /* ROUTE FOR FORM CONTROLLER */
        if (!$was_cached) {
            $route = "\nRoute::any('update_" . Str::lower($model) . "', array('uses' => '" . Str::lower($model) . "form@index' ) ); ";
            File::append(path('app') . 'routes.php', $route);
        }
    }

    private function generateGrid($columns, $model, $options, $was_cached)
    {
        $saveFields = '';
        $iteration = 0;
        foreach ($columns as $column) {
            $saveFields .= self::s(8, $iteration++ != 0) . '$new->' . $column->field . '=$temp->' . $column->field . ';' . "\n";
        }

        $handle = fopen(path('app') . 'controllers/' . Str::lower($model) . 'grid.php', "w");
        $content = str_replace(
            array('MODEL', 'TABLE', 'SAVE_FIELDS;', 'PARENT_ID', 'LEAF'),
            array($options['Model'], $options['Table'], $saveFields, $options['ParentID'], $options['Leaf']),
            file_get_contents(Bundle::path('extjs') . '/tasks/templates/GridController.template.php')
        );
        fwrite($handle, $content);
        fclose($handle);

        /*******************ROUTE FOR GRID RESTFUL CONTROLLER *********************/
        if (!$was_cached) {
            $route = "\nRoute::any('" . Str::lower($model) . 'grid' . "/(:num?)', array( 'uses' => '" . Str::lower($model) . "grid@index' ) ); ";
            File::append(path('app') . 'routes.php', $route);
        }
    }

    private function generateExtModel($columns, $model, $options)
    {
        $fields = '';
        $iteration = 0;
        foreach ($columns as $column) {
            if ($iteration > 0) {
                $fields .= ',';
                $fields .= "\n";
            }
            $fields .= self::s(8, $iteration != 0) . "{ name: '$column->field' , type: '" . lext::getExtType($column->type) . '\' }';
            $iteration++;
        }

        $handle = fopen(path('public') . 'js/EXTmodels/' . $model . '.js', "w");
        $content = str_replace(
            array('MODEL', 'FIELDS'),
            array($options['Model'], $fields),
            file_get_contents(Bundle::path('extjs') . '/tasks/templates/ExtModel.template.js')
        );
        fwrite($handle, $content);
        fclose($handle);
    }


}
