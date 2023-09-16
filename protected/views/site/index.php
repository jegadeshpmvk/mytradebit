<?php
echo '<div class="all_pages" data-url="' . $page . '">';
if (isset($model)) {
   foreach ($model->content_widgets as $widgets) {
      echo $this->render('//widgets/' . $widgets['type'], [
         'data' => $widgets,
         'auth' => [
                'class' => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
      ]);
   }
}
echo '</div>';
