<?
highlight_string('
<?
//include charts.php to access the SendChartData function
include_once "charts.php";

//change the chart to a bar chart
$chart [ \'chart_type\' ] = "3d pie";
$chart [ \'chart_value\' ] [ \'position\' ] = "inside";
$chart [ \'legend_rect\' ] [ \'x\' ] = 1000; // X position of legend - 1000 pushes it off screen
$chart [ \'chart_rect\' ] [ \'x\' ] = 45; // X position of chart
$chart [ \'chart_rect\' ] [ \'width\' ] = 250;
$chart [ \'series_color\' ] = array ( "99CC00", "FFCC33", "D8C2EF", "99CCFF", "FF6699", "CCFF00" );
$chart [ \'draw\' ] = array ( 
                            array ( \'type\'            =>  "text",
                                    \'layer\'           =>  "background",
                                    \'transition\'      =>  "slide_right",
                                    \'delay\'           =>  0, 
                                    \'duration\'        =>  1.5,  
                                    \'x\'               =>  0, 
                                    \'y\'               =>  260, 
                                    \'width\'           =>  345,  
                                    \'height\'          =>  200,
                                    \'h_align\'         =>  "center", 
                                    \'text\'            =>  "Bugs Found\rBy Severity",  
                                    \'font\'            =>  "Arial", 
                                    \'bold\'            =>  true, 
                                    \'size\'            =>  15, 
                                    \'color\'           =>  "8F8F8F"
                                 )
                          ); 

$chart [ \'chart_transition\' ] = array ( \'type\'      =>  "dissolve",
                                        \'delay\'     =>  0, 
                                        \'duration\'  =>  .5, 
                                        \'order\'     =>  "category"                                  
                                      );  

//pass chart values
$chart [ \'chart_data\' ] = array ( array ( "", "Blocker", "Critical", "Major", "Normal", "Minor", "Enhancement" ),
                                  array ( "Values", $_GET[\'blocker\'], $_GET[\'critical\'], $_GET[\'major\'], $_GET[\'normal\'], $_GET[\'minor\'], $_GET[\'enhancement\'] )
                                );

//pass visible chart values
$chart [ \'chart_value_text\' ] = array ( array ( null, null, null, null, null, null, null ),
                                        array ( null, $_GET[\'blocker\'] . "%\r Blocker", $_GET[\'critical\'] . "%\r Critical", $_GET[\'major\'] . "%\r Major", $_GET[\'normal\'] . "%\r Normal", $_GET[\'minor\'] . "%\r Minor", $_GET[\'enhancement\'] . "%\r Enhancement" )
       							       );
       							       
SendChartData ($chart);

?>
');
?>