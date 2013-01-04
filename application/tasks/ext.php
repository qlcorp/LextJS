<?php
class Ext_Task {

    public function __construct() {
        Autoloader::map(array( 'lext' => Bundle::path('extjs').'libraries/lext.php' )
        );
    }
    public function run($args)
    {
        echo 'Usage: php artisan ext:generate model_name';
    }
    
    public function generate($args)
    {
        $model = $args[0];
        $table = Str::lower($model);
        $columns = DB::query('SHOW columns from '.$table );
        Cache::forever('ext'.$model, $columns);
        
        /* GENERATING EXT MODEL */
        $handle = fopen(path('public').'js/EXTmodels/'. $model.'.js' , "w");
        
        $contents = "Ext.define('$model', {
            extend: 'Ext.data.Model',
            fields: [";
        $iteration=0;
        foreach ($columns as $column)
        {
            if ( $iteration) $contents .= ',';
            $contents .= "\n";           
            $contents .= "{ name: '$column->field' , type: '" . lext::getExtType($column->type) .'\' }';
            $iteration++;
        }
        $contents .= '] } )';
        
        fwrite($handle, $contents);
        fclose($handle);
        
        /* GENERATING RESTFUL CONTROLLER FOR GRID */
        $handle = fopen(path('app').'controllers/'. $table . '.php' , "w");
        
           $contents= '<?php
        class ';
           $contents .= $model;
           $contents .= '_Controller extends Base_Controller {
            public $restful = true;';
        
           //GET_INDEX()
           $contents .= "\n";
           $contents .= ' public function get_index()
            {
              $data = ';
           $contents .= $model;
            $contents .= '::all();
        $result = array();
        foreach ($data as $v)
            $result[] = $v->to_array();
        $json = json_encode($result);
        return $json;
    } ';
         //POST_INDEX()
            $contents .= "\n";
         $contents .= 'public function post_index()
    {
         $new = new ';
         $contents .= $model.'();' ;
         $contents .= '$new->save();          
        
        $response = array(\'success\' => true, \'data\' => array(\'id\' => $new->id));
        
        $json = json_encode($response);
        return $json;
    }';
         //PUT_INDEX()
         $contents .= "\n";
        $contents .= 'public function put_index()
    {
            $data =  file_get_contents(\'php://input\');  
            $temp = json_decode($data);' . "\n";
        
         $contents .= '$new= ' . $model . '::find($temp->id);' . "\n";  
            
            $columns = Cache::get('ext'.$model );
            foreach ($columns as $column )
            {
                $contents .= '$new->'. $column->field . '=$temp->'  . $column->field  . ';' . "\n" ;
            }
         
            $contents .= '$new->save(); ';
            
           $contents .= ' $array = array(\'success\' => \'true\');
            $json = json_encode($array );
            return $json;
    }';
        
         //DELETE_INDEX()
         $contents .= "\n";
         $contents .= 'public function delete_index()
    {
        $data = file_get_contents("php://input");
        $json = json_decode($data);
        
        $id = $json->id;';
         $contents .= '$affected = DB::table(\'' . $table . '\')->where(\'id\', \'=\', $id)->delete(); ';
         $contents .= '$array = array(\'success\' => \'true\');
            $json = json_encode($array );
            return $json; }';
         
            
        $contents .= "\n}";    //ending bracket of the class
        fwrite($handle, $contents);
        fclose($handle);
        
        //ROUTE FOR GRID RESTFUL CONTROLLER
        $route = "\nRoute::any('".$table."/(:num?)', array('as' => '".$table."', 'uses' => '".$table."@index' ) ); ";
        
        File::append( path('app').'routes.php' , $route );
        
        /*  GENERATING CONTROLLER FOR FORM HANDLING  */
        $handle = fopen(path('app').'controllers/'. $table . 'form.php' , "w");
        
           $contents= '<?php
        class ';
           $contents .= $model . 'form';
           $contents .= "_Controller extends Base_Controller { \n";
           $contents .="public function action_index() \n { \n";
           
           $contents .= '$record = new '.$model."(); \n" ;
           foreach ($columns as $column )
           {
               if ($column->field == 'id' ) continue;
               if ( lext::getExtType($column->type) == 'datefield' )
                   $contents .= '$record-> '. $column->field . "=". 
                   'date( "Y-m-d", strtotime($_POST[\''.$column->field .'\'] ) );'."\n";
                else
               $contents .= '$record-> '. $column->field . "=".'$_POST[\''.$column->field.'\']' ."; \n" ;
           }
                $contents .= '$record->save();' . "\n" .
                        '$array = array(\'success\' => \'true\', \'msg\' => \'Record added successfully\' );' . "\n" .
                        '$json = json_encode($array);' . "\n" .
                        'return $json;' . "\n";
                
           
           $contents .= "\n } \n }";
           fwrite($handle, $contents);
           fclose($handle);
           
           /* ROUTE FOR FORM CONTROLLER */
           $route = "\nRoute::any('update_".$table."', array('uses' => '".$table."form@index' ) ); ";
        
           File::append( path('app').'routes.php' , $route );
     
        /////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////////
        echo 'OK';
        
    }
    

}
