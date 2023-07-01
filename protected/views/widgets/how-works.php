<div class="how_works sec_pad">
    <div class="c">
        <div class="title align_center"><?= $data['content']['title']; ?></div>
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php
                $howworks = $data['content']['how-work'];
                if ($howworks) {
                    foreach ($howworks as $key => $howwork) {
                        $image = \app\models\Media::find()->where(['id' => isset($howwork["image_id"]) ? $howwork["image_id"] : 0])->one();
                ?>
                        <div class="_col swiper-slide">
                            <?php
                            echo '<a class="work_image video-player" href="' . $howwork["video_link"] . '"><img class="work_play_circle" src="../../../media/icons/play-audio.png" />' . Yii::$app->file->asBackground($image, '750x750') . '</a>';
                            ?>
                            <div class="work_content">
                                <h5 class="title"><?= $howwork["title"]; ?></h5>
                                <p class="text"><?= $howwork["text"]; ?></p>
                            </div>
                        </div>
                <?php }
                }
                ?>
            </div>
        </div>
        <?php
        echo '<a class="nav right swiper-button-next"></a><a class="nav left swiper-button-prev"></a>';
        ?>
    </div>
</div>