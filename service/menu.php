<?php
    require_once( "../base.php" );

    function buildresult()
    {
        return array(
            "id" => -1,
            "data" => -1,
            "text" => "",
            "children" => array()
        );
    }

    function treenode( $po_con, $po )
    {
        $la = buildresult();
        $la["id"] = $po->id;
        $la["data"] = $po->id;
        $la["text"] = $po->name;
        $la["children"] = pg_fetch_object( pg_execute( $po_con, "childrencount", array( $po->id ) ) )->children > 0;
        return $la;
    }




    $la_result = array();
    $lo_con = dbconnect();

    if ( pg_prepare( $lo_con, "root", "select id, parent, name from ".tableprefix( "munitiongroup" )." where parent is null" )  
        && pg_prepare( $lo_con, "node", "select id, parent, name from ".tableprefix( "munitiongroup" )." where id = $1" )
        && pg_prepare( $lo_con, "children", "select id, parent, name from ".tableprefix( "munitiongroup" )." where parent = $1" )
        && pg_prepare( $lo_con, "childrencount", "select count( id ) as children from ".tableprefix( "munitiongroup" )." where parent = $1" ) 
    )
    {
        if ( isset( $_GET["id"] ) && strlen($_GET["id"]) > 0 && ($_GET["id"] !== "#") )
        {
            array_push( 
                $la_result,
                treenode( 
                    $lo_con,
                    pg_fetch_object( pg_execute( $lo_con, "node", array( $_GET["id"] ) ) )
                )
                );
            $la_result[0]["children"] = array();

            $lo_root = pg_execute( $lo_con, "children", array( $_GET["id"] ) );
            while( $lo_data = pg_fetch_object( $lo_root ) )
                array_push( $la_result[0]["children"], treenode( $lo_con, $lo_data ) );   
        }
        else
        {     
            array_push( 
                $la_result,
                buildresult()
            );
            $la_result[0]["text"] = "munition";

            $lo_root = pg_execute( $lo_con, "root", array() );
            while( $lo_data = pg_fetch_object( $lo_root ) )
                array_push( $la_result[0]["children"], treenode( $lo_con, $lo_data ) );

        } 
    }

    pg_close( $lo_con );

    jsonheader();
    echo json_encode( $la_result );
?>