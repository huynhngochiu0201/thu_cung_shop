<!DOCTYPE html>
<!--
Click nbfs://nbhost/SystemFileSystem/Templates/Licenses/license-default.txt to change this license
Click nbfs://nbhost/SystemFileSystem/Templates/Scripting/EmptyPHPWebPage.php to edit this template
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title></title>
        <script type="text/javascript" src="http://js.nicedit.com/nicEdit-latest.js"></script>
        <script type="text/javascript">
            bkLib.onDomLoaded(function () {
                new nicEditor().panelInstance('area');
            }); // Thay thế text area có id là area1 trở thành WYSIWYG editor sử dụng nicEditor
        </script>
    </head>
    <body>
        <textarea name="area" id="area" style="width:70%;height:200px;">
      Đây là nội dung
        </textarea>
        
        <?php echo substr('2011-09-08 000000000', 0, 10)?>
    </body>
</html>
