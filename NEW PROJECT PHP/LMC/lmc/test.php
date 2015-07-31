<?php
$fruits = array("Banana", "Orange");
$search=array("Banana", "Orange");
//echo array_search("Orange",$fruits);
//echo $ds=array_key_exists(2, $search);
//if($ds!=1){
//    echo 'dsfsd';
//}

//$string = "16348,16348,14643,d ,d ,sdfs";
//$string1 = "16348,16348,14643,dfsdf,";
//$string2 = "3097_16324,16324,dsfds";
//echo $string = rtrim($string,',');
//
//echo base64_decode('bGNlYWRtaW4xMjM=');
//echo base64_decode('ZGVtbzEyMzQ1');

$customermail= "raja@ssomens.com";
$emailindex = strstr($customermail,'@',true);
$eusername = strtoupper($emailindex);
echo $emailindex;
echo '<br>'.substr($customermail, 0, strpos($customermail, '@'));

//echo strpos($string2,'_');
//if(strpos($string2,'_')>0)
//    echo 'true';
//else
//    echo 'false';
?>
<html>
<head>
    <!--Load the AJAX API-->
    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">

        // Load the Visualization API and the piechart package.
        google.load('visualization', '1.0', {'packages':['corechart']});

        // Set a callback to run when the Google Visualization API is loaded.
        google.setOnLoadCallback(drawChart);

        // Callback that creates and populates a data table,
        // instantiates the pie chart, passes in the data and
        // draws it.
        function drawChart() {

            // Create the data table.
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Topping');
            data.addColumn('number', 'Slices');
            data.addRows([
                ['Mushrooms', 3],
                ['Onions', 1],
                ['Olives', 1],
                ['Zucchini', 1],
                ['Pepperoni', 2]
            ]);

            // Set chart options
            var options = {'title':'How Much Pizza I Ate Last Night',
                'width':400,
                'height':300};

            // Instantiate and draw our chart, passing in some options.
            var chart = new google.visualization.PieChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>
</head>

<body>
<!--Div that will hold the pie chart-->
<div id="chart_div"></div>
</body>
</html>