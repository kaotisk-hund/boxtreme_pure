<head>
<?php $this->head(SITE_CHARSET, VIEWPORT, Configuration::$css, Configuration::$script);?>
<?php
// No change order plz xD 
        $this->loadMeta();
        ?>
    <!-- Title here -->
    <title><?php $this->loadTitle(); ?></title>

<?php
        $this->loadCSS();
        $this->headScripts();

        ?>
<!-- Favicon here -->
<link rel="icon" type="image/ico" href="<?php $this->loadFavicon(); ?>"/>
</head>