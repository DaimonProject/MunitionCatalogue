<?php
    require_once( "base.php" );

    $la_result = array();

    $lo_con = dbconnect();
    $lo_query = pg_query( $lo_con, "select * from ".tableprefix("usage")." order by lower(name)" );
    while( $lo_data = pg_fetch_object( $lo_query ) )
        array_push( $la_result, $lo_data );

    pg_close( $lo_con );


    jsonheader();
    echo json_encode( $la_result );
?>