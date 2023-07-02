<?php
$tabs = @$data['content']['tab'];
if ($tabs) {
?>
    <div class="tabs sec_pad">
        <div class="c">
            <div class="_row">
                <div class="_col _tab_left">
                    <div class="tab_list">
                        <?php foreach ($tabs as $key => $tab) {  ?>
                            <a class="tab" data-tab="<?= Yii::$app->function->seourl($tab['title']); ?>"><?= $tab['title']; ?></a>
                        <?php } ?>
                    </div>
                </div>
                <div class="_col _tab_right">
                    <div class="tab_contents">
                        <?php foreach ($tabs as $key => $tab) {  ?>
                            <div class="tab_content active" id="<?= Yii::$app->function->seourl($tab['title']); ?>">
                                <h4 class="title"><span class="text_color_gradiant"><?= $tab['title']; ?></span></h4>
                                <div class="c_editor"><?= $tab['text']; ?></div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php } ?>