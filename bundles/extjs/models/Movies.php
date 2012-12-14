<?php
namespace extjs;

class Movies extends \Eloquent
{
    public static $timestamps = false;
    
    public static function getMovies()
    {
        return $query = \DB::table('movies')->get() ;
    }
    
}