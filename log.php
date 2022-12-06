<?php 
    include_once('header.php'); 
    $con = connect_to_database("ut_manado_olv");
    $sql = mysqli_query( $con,"SELECT * FROM log ORDER BY id DESC" ) or die (mysqli_error($con));
?>
    <h1 class="ml-4 mt-4">REKAP LOG</h1>

    <hr>

<?php

    $tableSet = [
		"table_name" => "log",
        "where"      => "",
		"fields"     => [   "fields"=>["columns1","column2","column3"],
                            "previledge"=>[
                                "column1"=>[
                                    "appear_for"=>"",// [admin,2,3,etc]
                                    "read_only_for"=>""// [admin,2,3,etc]
                                ],
                                "column2"=>[
                                    "appear_for"=>"",// [admin,2,3,etc]
                                    "read_only_for"=>""// [admin,2,3,etc]
                                ],
                                "column3"=>[
                                    "appear_for"=>"",// [admin,2,3,etc]
                                    "read_only_for"=>""// [admin,2,3,etc]
                                ]
                            ]
                        
                        ],
		"buttons"    => [   "create"=>[
                                "active"=>"on", // on/off
                                "label"=>"",
                                "appear_for"=>"" // [admin,2,3,etc]
                            ], 
                            "update"=>[
                                "active"=>"on", // on/off
                                "label"=>"",
                                "appear_for"=>"" // [admin,2,3,etc]
                            ], 
                            "delete"=>[
                                "active"=>"on", // on/off
                                "label"=>"",
                                "appear_for"=>"" // [admin,2,3,etc]
                            ]
        
                        ]
	];

    generateTable($tableSet);

?>
          
<?php include_once('footer.php'); ?>
                
