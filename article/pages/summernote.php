<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Summernote Integration</title>
    <!-- Summernote CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.css" rel="stylesheet">
    <!-- jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <!-- Summernote JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-lite.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>My Summernote Example</h1>
        <textarea id="summernote"></textarea>
        <button id="submitButton" class="btn btn-primary mt-3">Submit</button>
    </div>

    <script>
        $(document).ready(function() {
            $('#summernote').summernote({
                height: 300,
                focus: true
            });

            $('#submitButton').on('click', function() {
                var content = $('#summernote').val();
                alert(content); // 顯示編輯器內容
            });
        });
    </script>
</body>
</html>
