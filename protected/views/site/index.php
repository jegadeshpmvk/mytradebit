<?php
if (isset($model)) {
   foreach ($model->content_widgets as $widgets) {
      echo $this->render('//widgets/' . $widgets['type'], [
         'data' => $widgets
      ]);
   }
}
