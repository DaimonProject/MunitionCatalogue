<?php
    require_once( "../base.php" );

    // https://stackoverflow.com/questions/30212852/how-to-populate-jquery-treeselect-widget

    jsonheader();
    echo json_encode( 
        array_map(
            function( $i ) { return $i->iupac; },
            sqldata( "select r.iupac from chemistry.substanceroot r join chemistry.substance s on s.id = r.id order by molarmass_g_per_mol" ) 
        )
    );
?>