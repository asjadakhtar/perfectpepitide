<?php
    $editor = get_field('editor');

    if( !$editor ) {
        return;
    }
?>

<section class="lg:mt-[120px] mt-12 py-12" id="legal-page">
    <div class="max-w-[850px] mx-auto px-5">
        <?= $editor; ?>
    </div>
</section>