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
                            jQuery("<option/>").val( i.iso639_1 )
                                              .text( i.name + " (" + i.iso639_1 + ")" )
                        );
                    });
                  });

            jQuery.ajax("'.linkprefix( '/usage.php' ).'")
                  .done( function(n) {
                    n.forEach( function(i) {
                        jQuery("#usage").append( 
                            jQuery("<option/>").val( i.id )
                                              .text( i.name )
                        );
                    });
                  });      

            jQuery.ajax("'.linkprefix( '/parameter.php' ).'")
                  .done( function(n) {
                    n.forEach( function(i) {
                        jQuery("#data").append( 
                            jQuery("<div/>").addClass("form-group")
                                            .append( 
                                                jQuery( "<label/>" )
                                                .text( i.name )
                                                .attr( "for", i.name.replace( /\W/g, "_" ) )
                                            )
                                            .append(
                                                jQuery( "<input/>" ).addClass( "form-control" )
                                                                    .attr( "id", i.name.replace( /\W/g, "_" ) )
                                                                    .attr( "type", "text" )
                                                                    .attr( "placeholder", i.description )
                                                                   
                                            )
                        );
                    });
                  });

    });</script>';


    echo '<main role="main" class="container">';
    echo '<div class="row">';
    echo '<div id="tree" class="col-sm-4"></div>';
    echo '<div class="col-sm-6">';

    echo '<form id="data">';
    echo '<div class="form-group"><label for="name">Name</label><input type="text" class="form-control" id="name" placeholder="eindeutiger Name"></div>';
    echo '<div class="form-group"><label for="origin">hergestellt in</label><select class="form-control" id="origin"></select></div>';
    echo '<div class="form-group"><label for="usage">verwendet in</label><select multiple class="form-control" id="usage"></select></div>';
    echo '</form>';

    echo '</div>';
    echo "</div>";
    echo '</main>';


    htmlfooter();

?>