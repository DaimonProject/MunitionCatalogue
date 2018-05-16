<?php
    require_once( "base.php" );

    htmlheader();

    // https://stackoverflow.com/questions/5300938/calculating-the-position-of-points-in-a-circle
    // http://js.cytoscape.org/#notation/elements-json

    echo '<script>
        function circle(points, radius)
        {
            let l_result = [];
            let slice = 2 * Math.PI / points;
            for (int i = 0; i < points; i++)
            {
                let double angle = slice * i;
                l_result.push({
                    x: radius * Math.Cos(angle),
                    y: radius * Math.Sin(angle)
                });
            }
            return l_result;
        }

        
        jQuery.ajax("'.linkprefix( '/service/substanceroot.php' ).'")
              .done( function(n) { 
                    let la_color = {};

                    let la_map = colormap({
                        colormap: "rainbow", 
                        nshades: n.length
                    });
                    
                    for( i=0; i < n.length; i++ )
                        la_color[ n[i] ] = la_map[i];

     
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
                                            content: "data(id)",
                                            "background-color" : function(n) { 
                                                let l_col = la_color[ n.data("id") ];
                                                return l_col ? l_col : "#ddd"; 
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