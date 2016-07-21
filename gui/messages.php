<?php if ($this->getMessages() != NULL) {
?>
<div class="messages">
    <div class="row">
        <div class="large-push-4 large-4 column">
            <div style="" class="callout small" data-closable>
                <!-- Your content goes here -->
                <?php echo $this->getMessages(); ?>
                <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
        </div>
    </div>
</div>
<?php } ?>