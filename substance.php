<?php
    require_once( "base.php" );

    htmlheader();

    echo '<script>
        jQuery.ajax("'.linkprefix( '/service/substancerelationship.php' ).'")
              .done( function(i) {
                    var cy = cytoscape({
                        container: $("#substance"),
                        elements: i,
                        layout: {
                            idealEdgeLength: 100,
                            nodeOverlap: 20,
                            refresh: 20,
                            fit: true,
                            padding: 20,
                            randomize: true,
                            componentSpacing: 100,
                            nodeRepulsion: 400000,
                            edgeElasticity: 100,
                            nestingFactor: 5,
                            gravity: 80,
                            numIter: 1000,
                            initialTemp: 200,
                            coolingFactor: 0.95,
                            minTemp: 1.0
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