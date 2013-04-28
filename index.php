<?php
    // config
    $page = 1; // starting page
    $ppp  = 4; // pics per page
    $extensions = array('jpg', 'jpeg', 'png', 'gif'); // display these
    $imagewidth = 0; // autoresize off if value <= 0
    $title = 'Welcome to my gallery.';

    if (isset($_GET['page'])) {
        $page = intval($_GET['page']);
    }
?>
<html>
    <head>
        <style type="text/css">
        <!--

            body {
                margin: 0px;
                background-color: #fafafa;
            }

            img {
                display: block;
                margin-left: auto;
                margin-right: auto; 
                padding: 7px;
                border: solid 1px;
                border-color: #c8c8c8;
                border-width: 1px;
                background-color:white;
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
        -->
    </style>
</head>
<body>
    <center>
        <br />
        <span>
            <?php echo $title; ?><br />
            <?php echo str_pad('',strlen($title)+4,'-');?><br />
        </span>
        <br />
        <table border="0" cellspacing="0" cellpadding="2px">
<?php
$c = 0;
foreach (scandir('.') as $file) { // walk all files in dir
    foreach ($extensions as $extension) {
        if (strpos($file, '.'.$extension)>0) { // find jpegs
            $c++;
            if ($c>($page-1)*$ppp && $c <= $page*$ppp) { // show then on current $page
                $caption = basename($file,'.'.$extension); // caption is the filename without extension
?>
                <tr><td><img src="<?php echo $file; ?>" <?php echo ($imagewidth > 0 ? ' width="'.$imagewidth.'px"' : '');?> border="0"></td></tr>
                <tr><td align="center"><span><?php echo $caption; ?></span></td></tr>
                <tr><td>&nbsp;</td></tr>
<?php        
            }
            break;
        }
    }
}
?>
        </table>
        <br />
        <span>
<?php
    // Page navigation
    if ($page > 1) {
        echo '<a href="' . basename(__FILE__) . "?page=".($page-1).'">&lt;--</a>';
    }
    if ($c > $page*$ppp) {        
        echo ($page > 1) ? '&nbsp;|&nbsp;' : '';
        echo '<a href="' . basename(__FILE__) . "?page=".($page+1).'">--&gt;</a>';
    }      
?>
        </span>
        <br />
    </center>
</body>
</html>
