<?php
    require_once( "base.php" );

    htmlheader();

    // https://stackoverflow.com/questions/5300938/calculating-the-position-of-points-in-a-circle
    // http://js.cytoscape.org/#notation/elements-json

    echo '<script>
        const RADIUS = 500;

        
        jQuery.ajax("'.linkprefix( '/service/substanceroot.php' ).'")
              .done( function(n) { 
                    let la_nodes = {};

                    let ln_slice = 2 * Math.PI / n.length;
                    let la_colormap = colormap({
                        colormap: "rainbow", 
                        nshades: n.length
                    });
                    
                
                    for( i=0; i < n.length; i++ )
                    {
                        let ln_angle = ln_slice * i;
                        la_nodes[ n[i] ] = {
                            color: la_colormap[i],
                            position : {
                                x: RADIUS * Math.cos( ln_angle ),
                                y: RADIUS * Math.sin( ln_angle )
                            }
                        };
                    }

                    jQuery.ajax("'.linkprefix( '/service/substancereference.php' ).'")
                        .done( function(i) {
  
                                var cy = cytoscape({
                                    container: $("#substance"),
                                    elements: i.map(function(n) {
                                        let l_root = la_nodes[ n.data.id ]
                                        if ( l_root )
                                            n.position = l_root.position;
                                        return n; 
                                    }),
                                    layout: {
                                        name: "cola",
                                        nodeSpacing: 200,
                                        edgeLengthVal: 250,
                                        animate: true,
                                        randomize: false,
                                        maxSimulationTime: 1000
                                    },

                                    style: [{
                                        selector: "node",
                                        style: {
                                            content: "data(id)",
                                            "background-color" : function(n) { 
                                                let l_root = la_nodes[ n.data("id") ]
                                                return l_root ? l_root.color : "#ddd"; 
                                            }
                                        }
                                    }]
                                });

                            });
            });

    </script>';

    echo '<div id="substance"></div>';

    htmlfooter();
?>