<?php

    require_once( "../base.php" );


    // http://js.cytoscape.org/
    // http://js.cytoscape.org/#getting-started/including-cytoscape.js
    // http://js.cytoscape.org/#getting-started/initialisation
    // http://js.cytoscape.org/demos/cose-layout/cy-style.json

    function node( $po )
    {
        return array(
            "data" => array( 
                "id" => $po->iupac
            )
        );
    }

    function edge( $po )
    {
        return array(
            "data" => array(
                "id" => $po->idsubstance.$po->idcontains,
                "source" => $po->source,
                "target" => $po->target
            )
        );
    }



    $la_result = array();
    $lo_con = dbconnect();

    if ( pg_prepare( $lo_con, "substance", "select * from daimon.substance" )  
        && pg_prepare( $lo_con, "reference", "select rf.*, s.iupac as source, t.iupac as target from daimon.refsubstance rf join daimon.substance s on s.id = rf.idsubstance join daimon.substance t on t.id = rf.idcontains" )
    )
    {
        $lo_substance = pg_execute( $lo_con, "substance", array() );
        while( $lo_data = pg_fetch_object( $lo_substance ) )
            array_push( $la_result, node( $lo_data ) );
        
        $lo_reference = pg_execute( $lo_con, "reference", array() );
        while( $lo_data = pg_fetch_object( $lo_reference ) )
            array_push( $la_result, edge( $lo_data ) );          
    }

    pg_close( $lo_con );

    jsonheader();
    echo json_encode( $la_result );
?>