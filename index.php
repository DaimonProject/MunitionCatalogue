<?php
    require_once( "base.php" );

    htmlheader();

    echo '<script>jQuery(function() {
        // just call data once
        jQuery.ajax( "/munition/tree.php" )
              .done( function(i) {
                jQuery("#tree").jstree({
                    "core" : {
                        "data" : [i]
                    }
                });
            });

        
    });</script>';



    echo '<div class="row">';
    echo '<div id="tree" class="col-sm-4"></div>';
    echo '<div class="col-sm-6">Eingabeform</div>';
    echo "</div>";


    htmlfooter();

?>