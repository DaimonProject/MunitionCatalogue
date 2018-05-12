<?php
    require_once( "base.php" );

    function treenode( $po_con, $po )
    {
        $la = array();
        $lo_query = pg_execute( $po_con, "treenode", array( $po->id ) );
        while ( $lo_data = pg_fetch_object( $lo_query ) )
            array_push( $la, treenode( $po_con, $lo_data ) );

        return array(
            "text" => $po->name,
            "data" => $po->id,
            "children" => $la
        );
    }

    $la_result = array(
        "text" => "munition",
        "data" => -1,
        "children" => array()
    );
    $lo_con = dbconnect();

    if ( pg_prepare( $lo_con, "treeroot", "select id, parent, name from ".tableprefix( "munitiongroup" )." where parent is null" ) 
        && pg_prepare( $lo_con, "treenode", "select id, parent, name from ".tableprefix( "munitiongroup" )." where parent = $1" ) 
    )
    {
        $lo_query = pg_execute( $lo_con, "treeroot", array() );
        while ( $lo_data = pg_fetch_object( $lo_query ) )
            array_push( $la_result["children"], treenode( $lo_con, $lo_data ) );
    }

    pg_close( $lo_con );

    jsonheader();
    echo json_encode( $la_result );  
?>