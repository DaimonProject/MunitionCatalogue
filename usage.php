<?php
    require_once( "base.php" );

    jsonheader();
    echo json_encode( sqldata( "select * from ".tableprefix("usage")." order by lower(name)" ) );
?>