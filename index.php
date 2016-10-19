<?php

require_once 'bootstrap.php';

// echo country_code_to_locale('US');

$sql = "
  SELECT Name, Code2
  FROM country
  ORDER BY Name
";
$stmt = $dbh->prepare($sql);
$stmt->execute();

$countries = $stmt->fetchAll(PDO::FETCH_ASSOC);

$output = '';

// format_print_r($countries);

if (isset($_GET['translate_this'])) {
  // format_print_r($_GET);

  if (!$_GET['language']) {
    echo '<h4>Sorry, please pick another language!</h4>';
  } else {
    $translate_this = $_GET['translate_this'];
    $language = 'en-' . substr($_GET['language'], 0, 2);

    $url = 'https://translate.yandex.net/api/v1.5/tr.json/translate';
    $data = array('key' => $_ENV['API_KEY'],
      'text' => $translate_this,
      'lang' => $language);

    // use key 'http' even if you send the request to https://...
    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data)
        )
    );
    $context = stream_context_create($options);
    $result = file_get_contents($url, false, $context);

    $parsed = json_decode($result);

    $output = $parsed->text[0];

    // format_print_r($parsed);
  }

}

?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <title></title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" media="screen" title="no title">
    <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
  </head>
  <body>
    <div class="container">
      <h2 id="ett">English Text Translator</h2>

      <form action="<?php echo $_SERVER['PHP_SELF'] ?>" method="get">
        <!-- <div class="form-group row"> -->
          <!-- <div class="col-xs-12"> -->
            <input placeholder="Text to translate" name="translate_this" class="form-control" type="text" value="" id="translate_this">
          <!-- </div> -->
        <!-- </div> -->
        <!-- <div class="form-group"> -->
          <select class="form-control" name="language" id="language">
            <option value="">- Select a language</option>

            <?php foreach ($countries as $country): ?>
              <option <?php echo (isset($_GET['language']) && $_GET['language'] === country_code_to_locale($country['Code2'])) ? 'selected="selected"' : '' ?> value="<?php echo country_code_to_locale($country['Code2']) ?>"><?php echo $country['Name'] ?></option>
            <?php endforeach ?>

          </select>
        <!-- </div> -->
        <div class="form-group">
          <input type="submit" class="btn btn-primary" value="Submit" />
        </div>
      </form>

      <h3><?php echo $output ?></h3>
    </div>
  </body>
</html>
