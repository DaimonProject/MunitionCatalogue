<?php
    require_once( "../base.php" );

    // https://stackoverflow.com/questions/30212852/how-to-populate-jquery-treeselect-widget

    $la_result = array();
    $lo_con = dbconnect();

    if ( pg_prepare( $lo_con, "root", "select * from daimon.substance order by lower(iupac)" ) 
         && pg_prepare( $lo_con, "node", "select id, parent, name from daimon.substances where id = $1" )
    )
    {
    }

    pg_close( $lo_con );

    jsonheader();
    echo json_encode( $la_result );
?>