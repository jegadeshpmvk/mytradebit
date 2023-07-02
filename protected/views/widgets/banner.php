<div class="banner" id="banner">
    <div class="c">
        <div class="_row">
            <div class="_col _col_left vAlign_middle">
                <h1 class="banner_title"><?= $data['content']['title']; ?></h1>
                <h4 class="banner_sub"><?= $data['content']['sub_title']; ?></h4>
                <p class="banner_text"><?= $data['content']['text']; ?></p>
                <a href="<?= $data['content']['btn_link']; ?>" class="btn btn_black"><?= $data['content']['btn_text']; ?></a>
            </div>
            <div class="_col _col_right vAlign_middle">
                <?php
                $sliders = $data['content']['slider'];
                if ($sliders) {
                    foreach ($sliders as $key => $slider) {
                        $image = \app\models\Media::find()->where(['id' => isset($slider["image_id"]) ? $slider["image_id"] : 0])->one();
                        echo '<div class="banner_image">' . Yii::$app->file->asBackground($image, '1920x1000') . '</div>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
</div>