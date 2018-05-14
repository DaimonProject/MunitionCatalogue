<?php

    // JSON file with configuration
    // {
    //    database: <Postgres Connection String>,
    //    linkprefix: <Directory of the Scripts>,
    //    tableprefix: <Postgres Schema Name>
    // }
    
    $lc_config = file_get_contents("config.json");
    if (!$lc_config)
        die( "configuration error" );

    define( "CONFIG", json_decode( $lc_config, true ) );
    unset( $lc_config );



    function dbconnect()
    {
        $l_con = pg_connect( CONFIG["database"] );
        if (!$l_con)
            die( "no database connection" );

        return $l_con;
    }

    function linkprefix( $pc_link )
    {
        return CONFIG["linkprefix"].".".$pc_link;
    }

    function tableprefix( $pc_table )
    {
        return CONFIG["tableprefix"].".".$pc_table;  
    }





    function sqldata( $pc_sql )
    {
        $la_result = array();

        $lo_con = dbconnect();
        $lo_query = pg_query( $lo_con, $pc_sql );
        while( $lo_data = pg_fetch_object( $lo_query ) )
            array_push( $la_result, $lo_data );
        pg_close( $lo_con );

        return $la_result;
    } 

    function jsonheader()
    {
        // https://www.codeofaninja.com/2017/02/create-simple-rest-api-in-php.html

        header( "Content-Type: application/json" );
    }

    function htmlheader()
    {
        echo '<!doctype html>';
        echo '<html lang="de">';
        echo '<head>';
        echo '<meta charset="utf-8"/>';
        echo '<meta name="viewport" content="width=device-width, initial-scale=1.0">';
        echo '<title>DAIMON Munitionsdatenbank</title>';
        
        echo '<script src="//cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js" crossorigin="anonymous"></script>';
        echo '<script src="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.5/jstree.min.js" crossorigin="anonymous"></script>';
        echo '<script src="jquery.treeselect.min.js" crossorigin="anonymous"></script>';

        echo '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.5/themes/default/style.min.css" />';
        echo '<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css">';
        echo '<link rel="stylesheet" href="jquery.treeselect.css" />';
        echo '<link rel="stylesheet" href="layout.css" />';
        
        echo '</head>';
        echo '<body>';
    }

    function htmlfooter()
    {
        echo '</body></html>';
    }
?>