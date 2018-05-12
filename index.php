<?php
    require_once( "base.php" );

    htmlheader();

    echo '<script>jQuery(function() {
            jQuery("#tree").jstree({
                "core" : {
                    "data" : {
                        "url" : "'.linkprefix( '/tree.php?lazy' ).'",
                        "data" : function (n) { return { "id" : n.id }; }
                    }
                }
            });

            jQuery.ajax("'.linkprefix( '/country.php' ).'")
                  .done( function(n) {
                    n.forEach( function(i) {
                        jQuery("#origin").append( 
                            jQuery("<option>").val( i.iso639_1 )
                                              .text( i.name + " (" + i.iso639_1 + ")" )
                        );
                    });
                  });
    });</script>';


    echo '<div class="container">';
    echo '<div class="row">';
    echo '<div id="tree" class="col-sm-4"></div>';
    echo '<div class="col-sm-6">';

    echo '<form>';
    echo '<div class="form-group"><label for="origin">Herstellung in</label><select class="form-control" id="origin"></select></div>';
    echo '</form>';

    echo '</div>';
    echo "</div>";
    echo '</div>';


    htmlfooter();

?>