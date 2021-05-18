<?php

namespace common\models;

use backend\behaviors\SingleImageUploadBehavior;
use common\models\queries\NewsQuery;
use yii\db\ActiveRecord;
use yii\base\InvalidConfigException;
use Yii;
use yii\web\UploadedFile;

/**
 * Class News
 * @package common\models
 *
 * @property int $id
 * @property string $title
 * @property string $text
 * @property string $image
 */
class News extends ActiveRecord
{
    /**
     * {@inheritDoc}
     */
    public static function tableName()
    {
        return '{{%news}}';
    }

    /**
     * {@inheritDoc}
     */
    public function behaviors()
    {
        return [
            [
                'class' => SingleImageUploadBehavior::class,
                'attributes' => 'image',
            ]
        ];
    }

    /**
     * {@inheritDoc}
     */
    public function rules()
    {
        return [
            [['title', 'text'], 'trim'],
            [['title', 'text'], 'required'],
            ['image', 'string'],
        ];
    }

    /**
     * @return NewsQuery
     * @throws InvalidConfigException
     */
    public static function find()
    {
        /** @var NewsQuery $query */
        $query = Yii::createObject(NewsQuery::class, [get_called_class()]);
        return $query;
    }
}
