<?php
    require_once( "base.php" );

    htmlheader();

    echo '<script>
        jQuery.ajax("'.linkprefix( '/service/substancereference.php' ).'")
              .done( function(i) {
                    var cy = cytoscape({
                        container: $("#substance"),
                        elements: i,
                        layout: {
                            name: "cola",
                            nodeSpacing: 150,
                            edgeLengthVal: 100,
                            animate: true,
                            randomize: false,
                            maxSimulationTime: 1500
                          },

                          style: [{
                            selector: "node",
                            style: {
                                content: "data(id)"
                            }
                        }]
                    });
                });

    </script>';

    echo '<div id="substance"></div>';

    htmlfooter();
?>