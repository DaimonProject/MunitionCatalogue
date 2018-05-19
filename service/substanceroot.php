<?php
    require_once( "../base.php" );

    // https://stackoverflow.com/questions/30212852/how-to-populate-jquery-treeselect-widget

    jsonheader();
    echo json_encode( 
        array_map(
            function( $i ) { return $i->iupac; },
            sqldata( "select * from chemistry.viewconcatelements order by molarmass_g_per_mol" ) 
        )
    );
?>