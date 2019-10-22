# php-tinyhtml
 Minify HTML in PHP with just a single class

## examples
```
$html = '<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>

  </body>
</html>';

$tiny = new TinyHtml($html);

echo $tiny;
```

or

```
$html = file_get_contents('test.html');

$tiny = new TinyHtml($html);

echo $tiny;
```
