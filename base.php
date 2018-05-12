<?php

    // === Datenbank Connection, Table- und Link-Prefix IMMER überprüfen ===

    function dbconnect()
    {
        $l_con = pg_connect( "host=localhost port=5432 dbname=daimon" );
        if (!$l_con)
            die( "no database connection" );

        return $l_con;
    }

    function linkprefix( $pc_link )
    {
        return "/munition".$pc_link;
    }

    function tableprefix( $pc_table )
    {
        return "munition_new.".$pc_table;  
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
        echo '<link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jstree/3.3.5/themes/default/style.min.css" />';
        echo '<link rel="stylesheet" href="//stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">';
        echo '<link rel="stylesheet" href="layout.css" />';
        echo '</head>';
        echo '<body>';
    }

    function htmlfooter()
    {
        echo '<footer class="footer">';
        echo '<div class="container">';
        echo '<span class="text-muted">made by <a href="mailto:philipp.kraus@tu-clausthal.de">Philipp Kraus</a></span>';
        echo '</div>';
        echo '</footer>';
        echo '</body></html>';
    }
?>