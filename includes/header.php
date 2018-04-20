<meta name="viewport" content="width=device-width, initial-scale=1.0" />

    <div class="notice-wrapper">
        <?php if(isset($_SESSION["errors"])) : ?>
            <div class="show notice error notice-error">
                <span class="notice-message">
                    <?php
                        echo($_SESSION["errors"]);
                        unset($_SESSION["errors"]);
                    ?>
                <span>
            </div>
        <?php endif; ?>
    </div>
</header>

