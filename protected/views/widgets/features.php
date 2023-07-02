<div class="features sec_pad" id="features">
    <div class="c">
        <div class="_row">
            <div class="_col _col_2 vAlign_middle">
                <div class="circles">
                    <?php
                    $features = $data['content']['feature'];
                    if ($features) {
                        foreach ($features as $key => $feature) {
                            $image = \app\models\Media::find()->where(['id' => isset($feature["image_id"]) ? $feature["image_id"] : 0])->one();
                            echo '<div class="circle_image ' . ($key === 0 ? 'active' : '') . '" data-key="feature_' . $key . '">' . Yii::$app->file->asBackground($image, '750x750') . '</div>';
                        }
                    } ?>
                </div>
            </div>
            <div class="_col _col_2 vAlign_middle">
                <h2 class="title"><?= $data['content']['title']; ?></h2>
                <p class="text"><?= $data['content']['text']; ?></p>
                <?php
                $features = $data['content']['feature'];
                if ($features) {
                    foreach ($features as $key => $feature) {
                        echo '<a class="text hover_div ' . ($key === 0 ? 'active' : '') . '"  data-hover="feature_' . $key . '">' . $feature['text'] . '</a>';
                    }
                }
                ?>
            </div>
        </div>
    </div>
    <img class="features_circle" src="../../../media/icons/circles.jpg" />
</div>