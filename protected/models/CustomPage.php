<?php

namespace app\models;

use yii\helpers\ArrayHelper;

class CustomPage extends Page
{

    public $items = array(), $rows = array(), $res = array();

    public function init()
    {
        parent::init();
        $this->page = "custom-page";
        $this->snippet = "";
    }

    public static function find()
    {
        $find = parent::find();
        return $find->andWhere(['page' => "custom-page"]);
    }

    public function attributes()
    {
        $attributes = [
            'content_widgets',
            'parent_page' // Like Banner, About us...
        ];
        return ArrayHelper::merge(parent::attributes(), $attributes);
    }

    public function rules()
    {
        $rules = [
            [['content_widgets', 'parent_page'], 'safe']
        ];
        return ArrayHelper::merge(parent::rules(), $rules);
    }

    public function getCropPosition()
    {
        return [
            '50% 50%' => 'Center',
            '0 0' => 'Top Left',
            '50% 0' => 'Top Center',
            '100% 0' => 'Top Right',
            '0 100%' => 'Bottom Left',
            '50% 100%' => 'Bottom Center',
            '100% 100%' => 'Bottom Right',
        ];
    }

    public function getEntireUrl($id)
    {
        $url = "";
        $model = static::find()->andWhere(['id' => $id])->one();
        if ($model) {
            if ($model->url == 'home') {
                $url = '/';
            } else {
                $url = "/" . $model->url;
            }
            if (!empty($model->parent_page)) {
                $url = $this->getEntireUrl($model->parent_page) . $url;
            }
        }
        return $url;
    }

    public function getFullUrl()
    {
        return $this->getEntireUrl($this->id);
    }

    public function afterFind()
    {
        $this->content_widgets = json_decode((string) $this->content_widgets, true);
        $this->meta_tag = json_decode((string) $this->meta_tag, true);
    }

    public function beforeSave($insert)
    {
        $this->content_widgets = json_encode($this->content_widgets);
        $this->meta_tag = json_encode($this->meta_tag);
        return parent::beforeSave($insert);
    }

    public function getParentPageAll()
    {
        $arr = [];
        $find = self::find()->andWhere(['!=', 'id', $this->id])->active()->all();

        foreach ($find as $b) {
            $row = array();
            $row['id'] = (string) $b->id;
            $row['parent'] = $b->parent_page;
            $row['name'] = $b->name;
            $row['link'] = $b->url;
            $row['pad'] = '- ';
            $this->items[] = $row;
        }
        $this->rows = $this->items;

        $tree = $this->buildTree($this->rows);

        $this->printTree($tree);
        return $this->res;
    }

    public function buildTree(array $data, $parent = "")
    {
        $tree = array();
        foreach ($data as $d) {
            if ($d['parent'] == $parent) {
                $children = $this->buildTree($data, $d['id']);
                // set a trivial key
                if (!empty($children)) {
                    $d['_children'] = $children;
                }
                $tree[] = $d;
            }
        }
        return $tree;
    }

    function printTree($tree, $r = 0, $p = null)
    {
        foreach ($tree as $i => $t) {
            $dash = ($t['parent'] == 0) ? '' : str_repeat('&nbsp;', $r);
            $this->res[$t['id']] = $dash . $t['name'];
            if ($t['parent'] == $p) {
                $r = 0;
            }
            if (isset($t['_children'])) {
                $this->printTree($t['_children'], $r + 3, $t['parent']);
            }
        }
    }
}
