<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Browser Image</title>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/ckeditor/4.15.0/ckeditor.js"></script>

    <script>
        $(document).ready(function(){
            var funcNum = <?php echo $_GET['CKEditorFuncNum'].';'; ?>
            $('#fileExplorer').on('click', 'img', function(){
                var fileUrl = $(this).attr('title');
                window.opener.CKEDITOR.tools.callFunction(funcNum, fileUrl);
                window.close();
            }).hover(function(){
                $(this).css('cursor', 'pointer');
            });
        });
    </script>

    <style>
        ul.file-list
        {
            list-style: none;
            padding: 0;
            margin: 0;
        }
        ul.file-list li
        {
            float: left;
            margin: 5px;
            border: 1px solid #ddd;
            padding: 10px;
        }
        ul.file-list img
        {
            display: block;
            margin: 0 auto;
        }
        ul.file-list li:hover
        {
            background: cornsilk;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div id="fileExplorer">
        @foreach($fileNames as $file)
            <div class="thumbnail">
                <ul class="file-list">
                    <li>
                        <img src="{{ asset('upload/ckeditor/'.$file) }}" alt="thumb" title="{{ asset('upload/ckeditor/'.$file) }}" width="120" height="130">
                        <br>
                        <span style="color: blue;">{{ $file }}</span>
                    </li>
                </ul>    
            </div>
        @endforeach
    </div>
</body>
</html>