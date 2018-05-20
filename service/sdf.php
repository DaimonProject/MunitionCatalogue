<?php

    require_once( "../base.php" );

    $lo_con = dbconnect();

    if ( pg_prepare( $lo_con, "sdf", "select sdf from chemistry.casiupac where id=$1" ) && isset($_GET["id"])  )
        echo pg_fetch_object( pg_execute( $lo_con, "sdf", array( $_GET["id"] ) ) )->sdf;

    pg_close( $lo_con );
?>