<?php
    require_once( "base.php" );

    htmlheader();

    echo '<script>jQuery(function() {
            jQuery("#tree").jstree({
                "core" : {
                    "data" : {
                        "url" : "'.  linkprefix( '/tree.php?lazy' ) .'",
                        "data" : function (n) { return { "id" : n.id }; }
                    }
                }
            });
        
    });</script>';



    echo '<div class="row">';
    echo '<div id="tree" class="col-sm-4"></div>';
    echo '<div class="col-sm-6">Eingabeform</div>';
    echo "</div>";


    htmlfooter();

?>