<?php
    require_once( "../base.php" );

    jsonheader();
    echo json_encode( sqldata( "select p.id, p.name, p.description, u.name as unitname, u.localscale as scale from ".tableprefix("parameter")." as p left join daimon.unit as u on u.id = p.idunit order by lower(p.name)" ) );
?>