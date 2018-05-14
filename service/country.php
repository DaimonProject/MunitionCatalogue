<?php
    require_once( "../base.php" );

    jsonheader();
    echo json_encode( sqldata( "select iso639_1, name from daimon.country order by lower(name)" ) );
?>