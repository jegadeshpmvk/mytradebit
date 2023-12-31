<div class="testmonials sec_pad" id="testmonials">
    <div class="c">
        <div class="_row">
            <div class="_col _testi_left">
                <p class="text"><?= $data['content']['sub_title']; ?></p>
                <h4 class="title"><?= $data['content']['title']; ?></h4>
                <div class="_testi_dots">
                    <a class="dots active"></a><a class="dots"></a><a class="dots"></a>
                </div>
            </div>
            <div class="_col _testi_right">
                <div class="_testi_right_padd">
                    <div class="swiper-container">
                        <div class="swiper-wrapper">
                            <?php
                            $testmonials = $data['content']['testimonial'];
                            if ($testmonials) {
                                foreach ($testmonials as $key => $testmonial) {
                            ?>
                                    <div class="_col swiper-slide">
                                        <?php
                                        $image = \app\models\Media::find()->where(['id' => isset($testmonial["image_id"]) ? $testmonial["image_id"] : 0])->one();
                                        echo '<div class="testi_image">' . Yii::$app->file->asBackground($image, '180x180') . '</div>';
                                        ?>
                                        <p class="text testi_text"><?= $testmonial["text"]; ?></p>
                                        <p class="text author"><?= $testmonial["author"]; ?></p>
                                        <p class="text desingnation"><?= $testmonial["desingnation"]; ?></p>
                                    </div>
                            <?php }
                            }
                            ?>
                        </div>
                    </div>
                </div>
                <div class="testi_controls">
                    <?php
                    echo '<a class="control testi_btn_prev"><div class="pulse_btn"></div></a><a class="control testi_btn_next"><div class="pulse_btn"></div></a>';
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
