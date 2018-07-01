<?php include VIEW_LAYOUT . 'header.php'; ?>

<div class="container">
    <div class="row">

        <?php

        foreach ($this->view_data['message'] as $message_key => $messsage_val) {
            if ($message_key == "started") {
                ?>

                <div class="alert alert-success" role="alert">
                    <?= $messsage_val; ?>
                </div>

                <?php
            } else if ($message_key == "busy") {
                ?>

                <div class="alert alert-danger" role="alert">
                    <?= $messsage_val; ?> <a href="\deliverySystem\StartOrder\index" class="alert-link">Retry</a>
                </div>

                <?php
            }
        }

        ?>

    </div>
    
    <div class="row">
        <a href="/deliverySystem" class="btn btn-primary">Back</a>
    </div>

</div>    

<?php include VIEW_LAYOUT . 'footer.php'; ?>