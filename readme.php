<?php

/**
 * A php entry file for browser markdown file.
 *
 * @author Weilong Wang <github.com/wilon>
 */

error_reporting(0);

if ($argv) {
    $_GET['file'] = $argv[1];
    $_GET['style'] = $argv[2];
    $_GET['github'] = $argv[3];
}

$fileName = current(array_keys($_GET)) ?: $_GET['file'];
$file = "./{$fileName}.md" ?: './README.md';
$markdownContent = @file_get_contents($file) ?: '## File not found.';

$src = 'https://wilon.github.io/easy-markdown-page';
$src = '.';

// css file
$style = $_GET['style'] ?: 'default';
if ($style === 'bootcss') {
    $css = "$src/static/docs.min.css";
} else if ($style === 'bootstrap') {
    $css = "$src/static/docs.min.css";
} else {
    $css = "$src/static/style.css";
}
$codecss = "$src/static/github.css";

// js file
$jquery = "$src/static/jquery.min.js";
$anchor = "$src/static/anchor.min.js";
$docs = "$src/static/docs.v0.3.min.js";
$showdown = "$src/static/showdown.min.js";
$generate = "$src/static/generate.js";

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="<?php echo $css; ?>" rel="stylesheet">
    <link href="<?php echo $codecss; ?>" rel="stylesheet">
    <!--[if lt IE 9]><script src="http://v3.bootcss.com/assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <!--[if lt IE 9]>
      <script src="http://cdn.bootcss.com/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="http://cdn.bootcss.com/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
    <link rel="icon" href="/favicon.ico">
</head>
<body>
<textarea style="display: none;" id="mdinput" title="write md here">

<?php echo $markdownContent; ?>

</textarea>
    <?php if ($style === 'bootcss'): ?>
        <div class="bs-docs-header" id="content">
            <div class="container" id="header"> </div>
        </div>
    <?php endif ?>
    <div class="container bs-docs-container">
        <div class="row">
            <div class="col-md-9" role="main">
                <div class="bs-docs-section markdown-body" id="body"> </div>
            </div>
            <?php if ($style === 'bootcss'): ?>
                <div class="col-md-3">
                    <div class="bs-docs-sidebar hidden-print hidden-xs hidden-sm" role="complementary">
                        <ul class="nav bs-docs-sidenav" id="navbar"> </ul>
                        <a class="back-to-top" href="#top"> Return Top </a>
                </div>
            <?php endif ?>
        </div>
    </div>
    <?php if ($style === 'bootcss'): ?>
    <footer class="bs-docs-footer" role="contentinfo">
        <div class="container" id="footer"> </div>
    </footer>
    <?php endif ?>
    <script type="text/javascript" src="<?php echo $jquery ?>"></script>
    <script type="text/javascript" src="<?php echo $anchor ?>"></script>
    <script type="text/javascript" src="<?php echo $showdown ?>"></script>
    <script src="./static/highlight.pack.js"></script>
    <?php if ($style === 'bootcss'): ?>
        <script type="text/javascript" src="<?php echo $docs; ?>"></script>
    <?php endif ?>
    <script type="text/javascript" src="<?php echo $generate ?>"></script>
</body>
</html>
