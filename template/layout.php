<!DOCTYPE html>

<html>
    <head>
        <meta charset="UTF-8">
        <title><?= Theme::$pageTitle ?></title>
        <link href="<?= Theme::$path ?>/css/style.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
        <div class="main">
            <div class="header"></div>
            <div class="content-body">
                <div class="menu">
                    <ul>
                </div>
                <div class="content">
                    <?php
                    $infoMessages = FlashMessage::getMessages(FlashMessage::TYPE_INFO);
                    if (count($infoMessages)) {
                        foreach ($infoMessages as $msg) {
                            echo "<li>$msg</li>";
                        }
                    }
                    ?>


                    <?php
                    echo $content;
                    ?></div>
            </div>
            <div class="footer">
                <?= Theme::$footer ?>
            </div>
        </div>
    </body>
</html>
