<?php
    require_once( "base.php" );

    htmlheader();


    echo '<div id="tree"></div>';
    
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


    htmlfooter();

?>