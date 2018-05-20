<?php
    require_once( "base.php" );

    function row( $po )
    {
        echo "<tr>";
        echo "<td>".$po->cas."</td>";
        echo "<td>".$po->iupac."</td>";
        echo "<td>".$po->sumformula."</td>";
        echo "<td>".$po->molarmass_g_per_mol."</td>";
        echo "<td>".$po->trivialname."</td>";
        echo '<td><div style="width: 800px;"><div data-casiupacid="'.$po->id.'" class="molecule"></div></div></td>';
        echo "</tr>";
    }



    htmlheader(
    '<script>
    jQuery(function () {
            jQuery(".molecule").each(function() {
                let self = this;

                jQuery.get( "'.linkprefix("/service/sdf.php?id=").'".concat( jQuery(self).data("casiupacid") ) , function (data) {
                    let viewer = $3Dmol.createViewer( jQuery(self), {backgroundColor: "white"});
                    viewer.addModel(data, "sdf");
                    viewer.setStyle({stick: {}});
                    viewer.center();
                    viewer.zoomTo();
                    viewer.zoom(0.8, 1000);
                    viewer.render();
                });

            });
    })
</script>
<style>
    .molecule {
        width: 100%;
        height: 250px;
        position: relative;
    }
</style>');

/*

              

                */

    $lo_con = dbconnect();

    if ( pg_prepare( $lo_con, "sdf", "select ci.id, ci.cas, ci.iupac, e.sumformula, e.molarmass_g_per_mol, array_to_string( array_agg( t.name ), ', ') as trivialname from chemistry.casiupac ci join chemistry.element e ON e.id = ci.idelement left join chemistry.trivialname t on t.idcasiupac = ci.id where ci.sdf is not null group by ci.id, ci.cas, ci.iupac, e.sumformula, e.molarmass_g_per_mol" ) )
    {
        echo '<table class="table">';
        echo "<thead><tr><th>CAS</th><th>IUPAC</th><th>sum formula</th><th>molar mass in g per mol</th><th>trivial names</th><th>structure formula</th></tr></thead><tbody>";

        $lo_sdf = pg_execute( $lo_con, "sdf", array() );
        while( $lo_data = pg_fetch_object( $lo_sdf ) )
            row( $lo_data );

        echo "</tbody></table>";
    }

    pg_close( $lo_con );

    htmlfooter();
?>   