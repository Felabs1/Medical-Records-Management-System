
<!DOCTYPE html>
<html>

<head>
    <title>Document</title>
    <link rel="stylesheet" type="text/css" href="./css/w3.css">
    <script src="./jquery/jquery.min.js"></script>


    <style type="text/css">
    body {
        background-color: #eeeeff;
    }

    /* *{
        color: #333;
    } */

    .w3-bar a:hover {
        border-bottom: 2px solid white;
        font-weight: 600;
    }
    </style>
</head>

<body>
<?php include("./navbar.php") ?>
    
    <br><br>
    <div class="w3-container w3-white w3-round-large" style="margin: 20px 300px 20px 300px;">
        <h3>Reports</h3>
        <div class="w3-row-padding">
            <div class="w3-third">
                From
                <input type="date" id="datefrom" class="w3-input w3-border w3-round" placeholder="Date From">
            </div>
            <div class="w3-third">
                To
                <input type="date" id="dateto" class="w3-input w3-border w3-round" placeholder="Date to">
            </div>
            <div class="w3-third">
                <br>
                <button class="w3-button w3-grey w3-round" onclick="query()">Query</button><br><br>
            </div>
        </div>
    </div>
    <div class="w3-container w3-white w3-round-large" style="margin: 20px 300px 20px 300px;" id="reports">
        Server Error...
    </div>

    <script>
    // $(document).ready(function(){
    //     alert('hello wolrd');
    // })

    $.get("./data/data.php?viewreports=true", function(data) {
        // console.log(data);
        $("#reports").html(data);
    })

    function query(dFrom, dTo) {
        dFrom = $("#datefrom").val();
        dTo = $("#dateto").val();
        $.get("./data/data.php?dfrom=" + dFrom + "&dto=" + dTo, function(data) {
            // console.log(data);
            $("#reports").html(data);
        })
    }
    </script>

</body>

</html>