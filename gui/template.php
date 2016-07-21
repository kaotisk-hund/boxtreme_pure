<?php
/*
 * @author kaotisk <ccc2007chaos@gmail.com>
 * 
 * Template file
 * 
 * In order to alter the template you can change the html elements either ids
 * or classes. 
 * 
 * Whatever is in '<?php ?>' please do NOT edit
 * 
 * For comments use '<!-- Comment -->' syntax
 * 
 */
?>
<!DOCTYPE html>
<html lang="<?php echo $this->language;?>">
    <?php include 'gui/head.php'; ?>
    <body>
        <div id="body">
        <div class="row">
            <?php if($this->headEnabled()){ ?><div id="head"></div><?php }?>
        </div>
        <!-- Top bar -->
        <?php include 'gui/topbar.php'; ?>
        <!-- Messages -->
        <?php include 'gui/messages.php'; ?>
        <!-- Main content -->
        <div id="container" class="row">
            <!--    Body-->
            <div id="content" class="small-12 large-12 columns">
                <?php include 'gui/body.php'; ?>
            </div>


            <!--    Side bar
            <div id="sidebar" class="small-4 large-4 columns">
                <!-- Widgets
                <?php include 'gui/widgets.php'; ?>
            </div>-->
        </div>

        <!-- Footer -->
        <?php include 'gui/footer.php'; ?>
        </div>
        <script src="js/vendor/jquery.js"></script>
        <script src="js/vendor/what-input.js"></script>
        <script src="js/vendor/foundation.js"></script>
        <script src="js/foundation.core.js"></script>
        <script src="js/foundation.util.mediaQuery.js"></script>
        <script src="js/foundation.tabs.js"></script>
        <script src="js/foundation.accordion.js"></script>
        <script>
            $(document).foundation();
        </script>
    </body>
</html>