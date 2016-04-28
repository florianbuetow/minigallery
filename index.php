<?php
    // config
    $page = 1; // starting page
    $ppp  = 3; // pics per page
    if (isset($_GET['page'])) {
        $page = max(1, intval($_GET['page']));
    }

    $extensions = array('jpg', 'jpeg', 'png', 'gif'); // display these
    $fixedImageWidth = 0;   // is turned off for values <= 0
    $maxImageWidth   = 900; // is turned off for values <= 0
    $allowImageClick = 0;   // generate link to original image for values != 0
    $sortOrder       = 1;   // 0 is alphanum order, 1 is reversed alphanum order

    $title = '    Welcome to my mini gallery!       '; // optional
    $subTitle = '"The sun never sets on my gallery."" - Larry Gagosian'; // optional
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <title><?php echo $title; ?></title>
        <style type="text/css">
        <!--

            body {
                margin: 0px;
                background-color: #fafafa;
                text-align: center;
                color: #000000;
            }

            .gallery_image {
                margin-left: auto;
                margin-right: auto;
                -webkit-box-shadow: 0px 2px 8px rgba(0,0,0,0.33);
                -moz-box-shadow: 0px 2px 8px rgba(0,0,0,0.33);
                box-shadow: 0px 2px 8px rgba(0,0,0,0.33);
                background-color:white;
                <?php if ($maxImageWidth > 0) { ?>max-width: <?php echo $maxImageWidth; ?>px;<?php } ?>
                <?php if ($fixedImageWidth > 0) { ?>width: <?php echo $fixedImageWidth; ?>px;<?php } ?>
            }

            a:link {
                color: #000000;
                text-decoration:none;
            }

            a:visited {
                color: #000000;
                text-decoration:none;
            }

            a:hover {
                color: #000000;
                text-decoration:none;
            }

            span {
                font-family: Courier New, monospace;
                font-size: 0.75em;
            }

            #footer {
                position: relative;
                bottom: 0px;
                width: 100%;
                font-family: Courier New, monospace;
                font-size: 0.75em;
                text-align: right;
                background-color:#f0f0f0;
            }
        -->
    </style>
</head>
<body>
        <a href="https://github.com/fbcom/minigallery"><img style="position: absolute; top: 0; right: 0; border: 0;" src="https://camo.githubusercontent.com/365986a132ccd6a44c23a9169022c0b5c890c387/68747470733a2f2f73332e616d617a6f6e6177732e636f6d2f6769746875622f726962626f6e732f666f726b6d655f72696768745f7265645f6161303030302e706e67" alt="Fork me on GitHub" data-canonical-src="https://s3.amazonaws.com/github/ribbons/forkme_right_red_aa0000.png"></a>
        <br>
<?php
    if (0 < strlen(trim(strip_tags($title.$subTitle)))) {
?>
        <span>
            <?php echo strlen(trim($title))>0 ? trim($title). "<br>\r" : ''; ?>
            <?php echo str_pad('',max(strlen(strip_tags($title)),strlen(strip_tags($subTitle)))+4,'-'), "<br>\r"; ?>
            <?php echo strlen(trim($subTitle))>0 ? trim($subTitle). "<br>\r" : ''; ?>
        </span>
        <br>
<?php
    }
?>
<?php
$numpics = 0; // stores the total number of displayable images
foreach (scandir('.', $sortOrder) as $file) { // walk through all files in dir
    foreach ($extensions as $extension) {
        if (strpos($file, '.'.$extension)>0) { // find displayable images by extension
            $numpics++;
            if ($numpics>($page-1)*$ppp && $numpics <= $page*$ppp) { // decide if image should be shown on current $page
                $caption = basename($file,'.'.$extension); // caption := the filename without extension
?>
            <a<?php if ($allowImageClick) { echo " href=\"$file\""; } ?>>
                <img class="gallery_image" src="<?php echo rawurlencode($file); ?>" alt="<?php echo $allowImageClick ? 'click to enlarge' : $file; ?>">
            </a>
            <br>
            <span><?php echo $caption; ?></span>
            <br>
            <br>
<?php
            }
            break;
        }
    }
}

?>
<?php
    // page navigation
    if ($numpics > $ppp) {
        echo "<span>";
        $numpages = ceil($numpics / $ppp);
        if ($page <= 1) {
            echo '<a style="color: #cccccc">&lt;--</a>';
        } else {
            echo '<a href="' . basename(__FILE__) . "?page=".($page - 1).'">&lt;--</a>';
        }
        echo '&nbsp;' . $page .'/' . $numpages. '&nbsp;';
        if ($page >= $numpages) {
            echo '<a style="color: #cccccc"">--&gt;</a>';
        } else {
            echo '<a href="' . basename(__FILE__) . "?page=".($page + 1).'">--&gt;</a>';
        }
        echo "</span>";
        echo "<br>";
    }
?>
	<br>
    <div id="footer">
        <!-- you can put something in here -->
    </div>
</body>
</html>
