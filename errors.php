<?php  if (count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
            <div data-closable class="alert-box callout alert">
                <i class="fa fa-ban"></i>
                <?php echo $error ?>
                <button class="close-button" aria-label="Dismiss alert" type="button" data-close>
                    <span aria-hidden="true">&CircleTimes;</span>
                </button>
            </div>
        <?php endforeach ?>
    </div>
<?php  endif ?>