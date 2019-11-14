<?php  if (count($errors) > 0) : ?>
    <div class="error">
        <?php foreach ($errors as $error) : ?>
            <p>
                <script type="text/javascript">
                    alert("<?php echo $error ?>");

                </script>
            </p>
        <?php endforeach ?>
    </div>
<?php  endif ?>