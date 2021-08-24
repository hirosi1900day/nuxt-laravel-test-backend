<!DOCTYPE html>
<html lang="ja">
    <head>
        <meta charset="utf-8">
        <title>仮登録</title>
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="csrf-token" content="{{ csrf_token() }}">
    </head>

    <body>
      <a href="{{config('frontend.frontend-url').'/'.$token}}">本登録に進む</a>
    </body>
</html>
