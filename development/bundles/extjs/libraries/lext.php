<?php
class lext {
    public static function grid($model)
    {
        return View::make('extjs::grid')->with('model', $model );
    }
    
    public static function form($model)
    {
        echo View::make('extjs::form')->with('model', $model );
    }
    
    public static function tree($model)
    {
        echo View::make('extjs::tree')->with('model', $model );     
    }
    
    public static function getExtType($type) // "converts" MySQL type into an ExtJS type
    {
        if (preg_match( '/^.*int.*$/' , $type ) )
            return 'numberfield';
        
        elseif (preg_match( '/^.*char.*$/' , $type) )
                return 'textfield';
        elseif (preg_match( '/^.*date.*$/' , $type) )
                return 'datefield';
        
        else return 'textfield';
    }
    
    public static function text($text) // "un-slugifies" a string
    {      
        $result = strtr($text, '_', ' ');
        $result= ucfirst($result);
        return $result;
    }
    
}