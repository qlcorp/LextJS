<?php

Autoloader::namespaces(array(
    'extjs' => Bundle::path('extjs').'models',
));

Autoloader::map(array( 'lext' => Bundle::path('extjs').'libraries/lext.php' )
        );
