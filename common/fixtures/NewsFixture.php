<?php

namespace common\fixtures;

use common\models\News;
use yii\test\ActiveFixture;

/**
 * Class NewsFixture
 * @package common\fixtures
 */
class NewsFixture extends ActiveFixture
{
    public $modelClass = News::class;
}
