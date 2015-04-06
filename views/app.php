<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>MediaGate</title>
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.4/css/bootstrap.min.css">
</head>
<body>
    <div class="container">
        <h1>MediaGate</h1>
        <hr>
        <div class="row">
            <?php foreach($files as $file): ?>
                <div class="col-md-3">
                    <div class="panel panel-primary">
                        <div class="panel-heading">
                            <?=$file['name']?>
                            (<?=$file['size']?>)
                        </div>
                        <div class="panel-footer">
                            <a download target="_blank" href="<?=$file['path']?>">Download</a> |
                            <?php if(file_exists(substr($file['path'] . '.txt', 1))) : ?> 
                                <a download target="_blank" href="<?=$file['path']?>.txt">Download Text</a>
                            <?php else : ?>
                                Converting to PDF
                            <?php endif; ?> | 
                            <a href="/delete/<?=$file['id']?>">Delete</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
        <form method="post" class="form" enctype="multipart/form-data">
            <div class="form-group">
                <label for="file">Pick a file (pdf)</label>
                <input type="file" name="file" id="file" required accept="application/pdf">
            </div>
            <button class="btn btn-primary">Upload</button>
        </form>
    </div>
</body>
</html>