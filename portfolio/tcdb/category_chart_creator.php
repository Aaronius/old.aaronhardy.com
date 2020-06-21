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
                                    \'transition\'      =>  "slide_left",
                                    \'delay\'           =>  0, 
                                    \'duration\'        =>  1.5,  
                                    \'x\'               =>  0, 
                                    \'y\'               =>  260, 
                                    \'width\'           =>  345,  
                                    \'height\'          =>  200,
                                    \'h_align\'         =>  "center", 
                                    \'text\'            =>  "Cases Failed\rBy Category",  
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
$chart [ \'chart_data\' ] = array ( array ( "", "Install", "Configuration", "File System", "Authentication" ),
                                  array ( "Values", $_GET[\'install\'], $_GET[\'configuration\'], $_GET[\'file_system\'], $_GET[\'authentication\'] )
                                );

//pass visible chart values
$chart [ \'chart_value_text\' ] = array ( array ( null, null, null, null, null ),
                                        array ( null, $_GET[\'install\'] . "%\r Installation", $_GET[\'configuration\'] . "%\r Configuration", $_GET[\'file_system\'] . "%\r File System", $_GET[\'authentication\'] . "%\r Authentication" )
       							       );
       							       
SendChartData ($chart);

?>
');
?>