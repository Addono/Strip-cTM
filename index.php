<!--
      The MIT License (MIT)

      Copyright (c) 2016 Adriaan Knapen
      Author Adriaan Knapen

      Permission is hereby granted, free of charge, to any person obtaining a copy of
      this software and associated documentation files (the "Software"), to deal in
      the Software without restriction, including without limitation the rights to
      use, copy, modify, merge, publish, distribute, sublicense, and/or sell copies of
      the Software, and to permit persons to whom the Software is furnished to do so,
      subject to the following conditions:

      The above copyright notice and this permission notice shall be included in all
      copies or substantial portions of the Software.

      THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
      IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY, FITNESS
      FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE AUTHORS OR
      COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER LIABILITY, WHETHER
      IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM, OUT OF OR IN
      CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE SOFTWARE.
    -->
<html>
    <body>
        <form method="post">
            <textarea name="input" style="width:100%;height:40%" placeholder="Paste input here"><?php if(isset($_POST['input'])) {echo $_POST['input'];}?></textarea><br>
            <button type="submit">Cleanup</button>
            <input type="checkbox" name="rem_comm" value="true" checked>Remove comments<br>
            <input type="checkbox" name="repl_states" value="true" checked>Replace name states
        </form>
        
        <textarea style="width:100%;height:40%" placeholder="After hitting 'Cleanup' the clean version will be shown here">
<?php
            $states = [];
            $count = 0;
            
            function replace_states($matches) {
                global $states, $count;
                
                $output = replace_state($matches[1]) . 
                        $matches[2] .
                        replace_state($matches[3]);
                
                return $output;
            }
            
            function replace_state($matches) {
                global $states, $count;
                
                
                if(!isset($states[$matches])) {
                    $states[$matches] = "q" . $count;
                    $count++;
                }
                
                return $states[$matches];
            }
            
            if(isset($_POST['input'])) {
                $input = $_POST['input'];
                
                if(isset($_POST['rem_comm'])) {
                    // Remove the comments
                    $rem_com_regex = "/%%[^\n]*/i";
                    $input = preg_replace($rem_com_regex, '', $input);
                }
                
                if(isset($_POST['repl_states'])) {
                    // Replace state names
                    $sel_state_regex = "/([^\s\n]*)(\s[^\s\n\r]\/[^\s\n\r],[LR]\s)([^\s\n]*)/im";
                    $input = preg_replace_callback($sel_state_regex, function($matches) {return replace_states($matches);}, $input);
                }
                
                // Remove extra whitespace
                $rem_ext_lines_regex = "/[\s\n]{3,}/im";
                $input = preg_replace($rem_ext_lines_regex, "\n\n", $input);
                
                echo $input;
            }
        ?></textarea>
    </body>
</html>