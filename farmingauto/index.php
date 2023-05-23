<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <title>Farm RPG AutoFarming</title>
</head>
<body>
    
</body>
</html>

<script>
    $(document).ready(function(){
        console.log('work!');
        
        function autofarm(){
            var url = 'farmrpg.php';
            request = $.ajax({
                type: "GET",
                dataType:"json",
                URL: url,
                contentType: "application/json; charset=utf-8",
                success: function(data){
                    console.log(data);
                    setTimeout(autofarm, 61000); 
                },
                error: function(e){
                    console.log(e.message); 
                }
            });
        }
        autofarm();
    })
</script>