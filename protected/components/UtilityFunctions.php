<?php

namespace app\components;

use Yii;
use yii\helpers\Url;
use app\models\CustomPage;
use app\models\OfferCategory;
use app\models\Offer;

class UtilityFunctions extends \yii\base\Component
{
    /*     * * 
      DISPLAY STATE AS HTML
     * * */

    public function notification($data, $param = "message", $class = "class")
    {
        if (isset($data[$param]) && $data[$param] != "")
            return '<div class="message message-' . $data[$class] . '"><p>' . $data[$param] . '</p></div>';

        return "";
    }

    public function state($value = false)
    {
        $list = [
            0 => 'Draft',
            1 => 'Published'
        ];

        $cls = [
            0 => 'fa-pencil-square',
            1 => 'fa-check-circle',
        ];

        if ($value === false)
            return [$list, $cls];

        $html = '<div class="state-color c' . $value . '">';
        $html .= '<span>' . $list[$value] . '</span>';
        $html .= '</div>';

        return $html;
    }

    /*     * * 
      CHECK IF ALL ATTRIBUTES OF A MODEL ARE EMPTY
     * * */

    public function isEmpty($model)
    {
        $empty = true;
        foreach ($model->attributes() as $attr) {
            if (in_array($attr, ["_id", "state", "deleted", "type"]))
                continue;

            if (trim($model->{$attr}) != "") {
                $empty = false;
                break;
            }
        }

        return $empty;
    }

    public function checkEmailLinks($email)
    {
        return preg_replace('/([a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,6})/', 'mailto:$1', $email);
    }

    /*     * * 
      LIMIT TEXT
     * * */

    public function limit_text($text, $limit = 30)
    {
        $text = strip_tags($text);
        if (str_word_count($text, 0) > $limit) {
            $words = str_word_count($text, 2);
            $pos = array_keys($words);
            $text = substr($text, 0, $pos[$limit]) . '...';
        }
        return $text;
    }

    public function getAllPageForSelect()
    {
        $mainArr = [
            [
                "id" => "",
                "text" => ""
            ]
        ];
        $homeUrl = Url::home(true);
        $homeUrl = substr($homeUrl, 0, strlen($homeUrl) - 1);

        /* Custom Pages */
        $CustomPage = CustomPage::find()->select(['id', 'name', 'url'])->active()->all();
        if (count($CustomPage) > 0) {
            foreach ($CustomPage as $c) {
                $customPageModel = new CustomPage();

                $pArr = [];
                $js = [
                    "id" => $c->id,
                    "controller" => "/site/custom-page",
                    "model" => "CustomPage"
                ];
                $pArr['id'] = json_encode($js);
                $pArr['text'] = $c->name . "<!_>" . $homeUrl . "" . $customPageModel->getEntireUrl($c->id);

                array_push($mainArr, $pArr);
            }
        }
        /* Custom Pages */

        $mainArr = json_encode($mainArr);
        return $mainArr;
    }

    public function constructLink($json)
    {

        $decode = json_decode($json, true);

        if (@$decode['model']) {
            $arr = [];
            $arr[0] = $decode['controller'];
            $arr['url'] = $this->getModelLink($decode);

            if ($arr['url'] != false) {
                return @$arr['url'];
            }
        } else {
            if ($json != "") {
                return $this->checkEmailLinks($json);
            }
        }
        return "#";
    }

    public function getModelLink($arr)
    {
        $modelName = '\app\\models\\' . @$arr['model'];

        if (@$arr['model'] == "CustomPage") {
            $model = new $modelName;

            return $model->getEntireUrl($arr['id']);
        }
        $model = $modelName::find()->andWhere(['id' => $arr['id']])->one();
        if ($model) {
            return $model->url;
        }
        return false;
    }

    public function flexibleContentTypes()
    {
        $flexibleTypes = [
            "banner" => [
                "title" => "Banner",
                "image" => Yii::getAlias('@icons') . "/widgets/banner.png",
                "type" => ["content_widgets"],
            ],
            "three-box" => [
                "title" => "Three Box",
                "image" => Yii::getAlias('@icons') . "/widgets/three-box.png",
                "type" => ["content_widgets"],
            ],
        ];
        return $flexibleTypes;
    }

    public function seourl($string)
    {
        $string = strtolower(trim($string)); //Lower case everything
        $string = preg_replace("/\&/", "-and-", $string); //Change & to and
        $string = preg_replace("/[^a-z0-9_\s-]/", "", $string); //Make alphanumeric (removes all other characters)
        $string = preg_replace("/[\s-]+/", " ", $string); //Clean up multiple dashes or whitespaces
        $string = preg_replace("/[\s_]/", "-", $string); //Convert whitespaces and underscore to dash
        return $string;
    }
}
