<?php

namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\BaseObject;
use app\models\CustomPage;

class CustomPageUrlRule extends BaseObject implements UrlRuleInterface
{

    public function createUrl($manager, $route, $params)
    {
        if ($route === 'site/custom-page') {
            if (isset($params['url'])) {
                return $params['url'];
            }
        }
        return false;
    }

    public function parseRequest($manager, $request)
    {
        $pathInfo = $request->getPathInfo();
        $split = explode("/", $pathInfo);
        $count = count($split);
        $error = 0;
        $parent = $params['redirect'] = $params['model'] = $params['url'] = false;

        if ($count) {
            if (trim($split[$count - 1]) == "") {
                unset($split[$count - 1]);
                $params['redirect'] = '/' . implode("/", $split);
                return ['site/custom-page', $params];
            }

            foreach ($split as $k => $s) {
                if ($k === 0)
                    $model = CustomPage::find()->where(['url' => $s])->active()->one();
                else
                    $model = CustomPage::find()->where(['url' => $s, 'parent_page' => $parent])->active()->one();

                //Check if model exists
                if (!$model) {
                    $error = 1;
                    break;
                }

                //Check if parent page doesn't exist for first page
                if ($k === 0 && trim(@$model->parent_page != "")) {
                    $error = 1;
                    break;
                }

                $parent = $model->id;
            }
        } else
            $error = 1;

        if ($error !== 1) {
            $params['model'] = $model;
            $params['url'] = $pathInfo;
            return ['site/custom-page', $params];
        }

        return false;
    }
}
