<div class="flexible-templates">
    <?php
    $flexibleTypes = Yii::$app->function->flexibleContentTypes();
    foreach ($flexibleTypes as $f => $flexType) {
        if (in_array($attribute, $flexType["type"])) {
    ?>
            <div data-for="<?= $f ?>">
                <?=
                $this->render($f, [
                    'model' => $model,
                    'form' => $form,
                    'key' => $key,
                    'attribute' => $attribute
                ]);
                ?>
            </div>
    <?php
        }
    }
    ?>
</div>

<div class="templates">
    <?php if ($attribute == "content_widgets") { ?>
        <div data-for="slider">
            <?=
            $this->render('parts/slider', [
                'model' => $model,
                'form' => $form,
                'key' => 0,
                'k' => 0,
                'attribute' => $attribute
            ]);
            ?>
        </div>
    <?php } ?>
</div>