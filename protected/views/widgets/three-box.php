<?php $three_box = $data['content']['three-box'];
if ($three_box) { ?>
    <div class="three_box sec_pad">
        <div class="three_box_inner">
            <?php
            $image = \app\models\Media::find()->where(['id' => isset($data['content']['image_id']) ? $data['content']['image_id'] : 0])->one();
            echo '<div class="three_box_image">' . Yii::$app->file->asBackground($image, '1920x1000') . '</div>';
            ?>
            <div class="c">
                <div class="_row">
                    <?php
                    foreach ($three_box as $key => $tbox) {
                    ?>
                        <div class="_col _col_3">
                            <div class="grid">
                                <h5 class="title"><?= $tbox["title"]; ?></h5>
                                <div class="text"><?= $tbox["text"]; ?></div>
                                <a class="btn" href="<?= $tbox["link"]; ?>">Read More</a>
                            </div>
                        </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
<?php } ?>
<div class="features">
    <div class="c">
        <div class="_row">
            <div class="_col _col_2">

            </div>
            <div class="_col _col_2">
                <h2 class=""></h2>
            </div>
        </div>
    </div>
</div>