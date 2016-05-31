<html>
    <body>
        <form method="post">
            <textarea name="input" style="width:100%;height:40%" placeholder="Paste input here"></textarea><br>
            <button type="submit">Cleanup</button>
        </form>
        
        <textarea style="width:100%;height:40%" placeholder="After hitting 'Cleanup' the clean version will be shown here">
<?php
            if(isset($_POST['input'])) {
                $input = $_POST['input'];
            }
        ?></textarea>
    </body>
</html>