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
                "id" => $po->idelement.$po->idreference,
                "source" => $po->source,
                "target" => $po->target
            )
        );
    }


    $la_result = array();
    $lo_con = dbconnect();

    if ( pg_prepare( $lo_con, "substance", "select array_to_string(iupac, ', ' ) as iupac from chemistry.viewconcatelements" )  
         && pg_prepare( $lo_con, "reference", "select rf.*, array_to_string(s.iupac, ', ' ) as source, array_to_string(t.iupac, ', ' ) as target from chemistry.viewconcatelements s
         join chemistry.refelementreference rf on rf.idelement = s.idelement
         join chemistry.viewconcatelements t on t.idelement = rf.idreference" )
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