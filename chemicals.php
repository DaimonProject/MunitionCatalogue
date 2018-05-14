<?php
    require_once( "base.php" );

    // https://stackoverflow.com/questions/30212852/how-to-populate-jquery-treeselect-widget

    $la_result = array();
    $lo_con = dbconnect();

    //if ( pg_prepare( $lo_con, "substances", "select * from daimon.substance order by lower(iupac)" )
    //{
    //}

    jsonheader();
    echo json_encode( $la_result );
?>