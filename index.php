<?php
    require_once( "base.php" );

    htmlheader();

    // https://github.com/swisnl/jQuery-contextMenu

    echo '<script>jQuery(function() {
            jQuery("#tree").jstree({
                "core" : {
                    "data" : {
                        "url" : "'.linkprefix( '/service//menu.php?lazy' ).'",
                        "data" : function (n) { return { "id" : n.id }; }
                    }
                }
            });

            jQuery.ajax("'.linkprefix( '/service/country.php' ).'")
                  .done( function(n) {
                    n.forEach( function(i) {
                        jQuery("#origin").append( 
                            jQuery("<option/>").val( i.iso639_1 )
                                              .text( i.name + " (" + i.iso639_1 + ")" )
                        );
                    });
                  });

            jQuery.ajax("'.linkprefix( '/service/usage.php' ).'")
                  .done( function(n) {
                    n.forEach( function(i) {
                        jQuery("#usage").append( 
                            jQuery("<option/>").val( i.id )
                                              .text( i.name )
                        );
                    });
                  });      

            jQuery.ajax("'.linkprefix( '/service/parameter.php' ).'")
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

                jQuery("chemicals").chosentree({
                    width: 500,
                    deepLoad: false,
                    load: function(node, callback) {
                    }
                });

    });</script>';

    echo '<main role="main" class="container">';
    

    echo '<div class="row">';
    
    echo '<div class="col-xs-8 col-md-6">';
    echo '<div id="tree"></div>';
    echo '<div class="col-xs-8 col-md-6 action">';
    echo '<button type="button" id="save" class="btn btn-success">Speichern</button>';
    echo '<button type="button" id="delete" class="btn btn-danger">Löschen</button>';
    echo '</div>';
    echo '<span class="text-muted"><a href="substance.php">Darstellung Chemische Stoffe</a></span><br/><br/>';
    echo '<span class="text-muted"><a href="therapy.php">Darstellung Therapiemöglichkeit</a></span><br/><br/>';
    echo '<span class="text-muted"><a href="visualize.php">Darstellung Molekül</a></span><br/><br/>';
    echo '<span class="text-muted">by <a href="mailto:philipp.kraus@tu-clausthal.de">Philipp Kraus</a></span>';
    echo '</div>';

    echo '<div class="col-xs-10 col-md-6">';

    echo '<form id="data"><input type="hidden" id="objectid"/><input type="hidden" id="groupid"/>';
    echo '<div class="form-group"><label for="name">Name</label><input type="text" class="form-control" id="name" placeholder="eindeutiger Name"></div>';
    echo '<div class="form-group"><label for="origin">hergestellt in</label><select class="form-control" id="origin"></select></div>';
    echo '<div class="form-group"><label for="chemicals">Kampfstoff</label><div id="chemicals"></div></div>';
    echo '<div class="form-group"><label for="usage">verwendet in</label><select multiple class="form-control" id="usage"></select></div>';
    echo '</form>';

    echo '</div>';
    echo "</div>";


    echo '</main>';


    htmlfooter();

?>