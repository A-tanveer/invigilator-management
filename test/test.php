
<html>
    <head>
        <title>Test</title>
        <style>
            div.test{
                background-color: yellow;
                display: none;
                width: 500px;
                height: 400px;
            }
          
        </style>
        <script src="jquery.min.js"></script>
        <script src="jquery.bpopup.min.js"></script>
        <script>
            $(document).ready(function(){
                $('.idbutt').click(function(){
                    var id = this.id;
                    $('div.pop').bPopup({
                        content: 'iframe',
                        
                        loadUrl: 'test2.php?id='+id
                    })
                })
            });
        </script>
        
    </head>
    <body>

            <button class='idbutt' id='1'>id = 1</button>
            <button class='idbutt' id='2'>id = 2</button>
            <button class='idbutt' id='3'>id = 3</button>
            <div class="pop"></div>
    </body>
    
<!--   <?php 
//header("Location: ../index.php");
?>-->
</html>

