<?php

    require_once( "../base.php" );


    // http://js.cytoscape.org/
    // http://js.cytoscape.org/#getting-started/including-cytoscape.js
    // http://js.cytoscape.org/#getting-started/initialisation
    // http://js.cytoscape.org/demos/cose-layout/cy-style.json

    function node( $po, $pl_therapy )
    {
        return array(
            "data" => array( 
                "id" => ($po->trivialname ? $po->trivialname  : $po->iupac)." (".$po->cas.")",
                "therapy" => $pl_therapy
            )
        );
    }

    function edge( $po )
    {
        return array(
            "data" => array(
                "id" => $po->contamination_idcasiupac.$po->therapy_idcasiupac,
                "source" => ($po->contamination_trivialname ? $po->contamination_trivialname : $po->contamination_iupac)." (".$po->contamination_cas.")",
                "target" => ($po->therapy_trivialname ? $po->therapy_trivialname : $po->therapy_iupac)." (".$po->therapy_cas.")"
            )
        );
    }


    $la_result = array();
    $lo_con = dbconnect();

    if ( pg_prepare( $lo_con, "therapycontamination", "select * from chemistry.viewtherapycontamination" )
        && pg_prepare( $lo_con, "therapyelements", "select * from chemistry.viewtherapyelements" ) 
        && pg_prepare( $lo_con, "therapy", "select * from chemistry.viewtherapy" )
    )
    {
        $lo_therapy = pg_execute( $lo_con, "therapycontamination", array() );
        while( $lo_data = pg_fetch_object( $lo_therapy ) )
            array_push( $la_result, node( $lo_data, false ) );

        $lo_therapy = pg_execute( $lo_con, "therapyelements", array() );
        while( $lo_data = pg_fetch_object( $lo_therapy ) )
            array_push( $la_result, node( $lo_data, true ) );    

        $lo_therapy = pg_execute( $lo_con, "therapy", array() );
        while( $lo_data = pg_fetch_object( $lo_therapy ) )
            array_push( $la_result, edge( $lo_data ) );    
    }

    pg_close( $lo_con );

    jsonheader();
    echo json_encode( $la_result );
?>