<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
</head>
<body>

    <div class="container">
        <div class="row d-flex justify-content-center">
            <div class="col-md-4 mt-5">
                <div class="form-group">
                    <input class="form-control search" list="search" placeholder="Поиск..">
                    <datalist id="search" class="searchList">
                        <?php if($history): ?>
                            <?php $__currentLoopData = $history; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e($item); ?>"></option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <?php endif; ?>
                    </datalist>
                </div>
                <div class="form-group d-flex justify-content-end">
                    <button type="button" class="handler btn btn-primary">Найти</button>
                </div>
            </div>
        </div>
        <div class="row">
            <h1>Количество: <span class="length">0</span></h1>
        </div>
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Название</th>
                        <th scope="col">Автор</th>
                        <th scope="col">Изображение</th>
                    </tr>
                </thead>
                <tbody class="tableList">
                    <tr>

                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
    <script>
        var search = $('.search');
        var tableList = $('.tableList');
        var searchList = $('.searchList');
        var length = $('.length');

        var clickFunction = function() {
            $.get('https://www.googleapis.com/books/v1/volumes', {q: search.val()}, async function(response) {
                tableList.children().remove();
                responseData - await response;
                if (response.items.length) {
                    length.text(response.items.length);
                    try {
                        response.items.forEach(element => {
                            author = 'No info';
                            smallThumbnail = '';
                            if (element.volumeInfo.authors != undefined) author = element.volumeInfo.authors[0];
                            if (element.volumeInfo.imageLinks != undefined) smallThumbnail = element.volumeInfo.imageLinks.smallThumbnail;

                            tableList.append("<tr><td>"+element.id+"</td><td>"+element.volumeInfo.title+"</td><td>"+author+"</td><td><img src=\""+smallThumbnail+"\"></td></tr>");
                        });
                    } catch (error) {
                        console.log(error);
                    }
                }
            });    
            
            $.post('/handler', {query: search.val()}, async function(response) {
                searchList.children().remove();
                responseData = await response;
                if (responseData.length) {
                    search.val("");
                    responseData.forEach(element => {
                        searchList.append('<option value="'+element+'"></option>');
                    });
                }
            });
        };

        $('.handler').click(clickFunction);
    </script>
</body>
</html><?php /**PATH F:\jobs\newPanel\OSPanel\domains\test-pure.loc\resource\views/index.blade.php ENDPATH**/ ?>