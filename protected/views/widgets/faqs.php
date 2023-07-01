<div class="faq sec_pad">
    <div class="c">
        <div class="title align_center"><?= $data['content']['title']; ?></div>
        <div class="faq_content">
            <?php
            $faqs = $data['content']['faq'];
            if ($faqs) {
                foreach ($faqs as $key => $faq) {
            ?>
                    <div class="faq_div">
                        <a class="title faq_title"><?= $faq['title']; ?> <div class="plus"></div></a>
                        <div class="text faq_text"><?= $faq['text']; ?></div>
                    </div>
            <?php }
            }
            ?>
        </div>
    </div>
</div>