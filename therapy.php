<?php
    require_once( "base.php" );

    htmlheader();

    echo '<script>
        const RADIUS = 1000;


                    jQuery.ajax("'.linkprefix( '/service/therapy.php' ).'")
                        .done( function(i) {
  
                                var cy = cytoscape({
                                    container: $("#substance"),
                                    elements: i,
                                    layout: {
                                        name: "cola",
                                        nodeSpacing: 200,
                                        edgeLengthVal: 250,
                                        animate: true,
                                        randomize: true,
                                        maxSimulationTime: 1000
                                    },

                                    style: [{
                                        selector: "node",
                                        style: {
                                            content: "data(id)",
                                            "background-color" : function( i )
                                            {
                                                return i.data("therapy") ? "#0f0" : "#f00";
                                            }
                                        }
                                    }]
                                });

                            });

    </script>';

    echo '<div id="substance"></div>';

    htmlfooter();
?>