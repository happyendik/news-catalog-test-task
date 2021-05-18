<?php

namespace common\models\queries;

use yii\db\ActiveQuery;
use common\models\News;

/**
 * Class NewsQuery
 * @package common\models\queries
 */
class NewsQuery extends ActiveQuery
{
    /**
     * @param null $db
     * @return array|News|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }

    /**
     * @param null $db
     * @return array|News[]
     */
    public function all($db = null)
    {
        return parent::all($db);
    }
}
