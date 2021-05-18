<?php

namespace common\tests\unit;

use Codeception\Test\Unit;
use common\fixtures\NewsFixture;
use common\models\News;
use common\tests\UnitTester;

class NewsTest extends Unit
{
    /**
     * @var UnitTester
     */
    public $tester;

    public function _fixtures()
    {
        return [
            NewsFixture::class,
        ];
    }

    /**
     * @param array $attribute
     * @param bool $expected
     * @dataProvider validationDataProvider
     */
    public function testValidation(array $attribute, bool $expected)
    {
        $model = new News();
        $model->load($attribute, '');
        $this->assertEquals($expected, $model->validate(array_keys($attribute)), json_encode($attribute));
    }

    /**
     * @return array[]
     */
    public function validationDataProvider()
    {
        return [
            [['title' => ' '], false],
            [['text' => ' '], false],
            [['title' => 'text'], true],
            [['text' => 'Text text'], true],
            [['image' => 'image.png'], true],
            [['image' => null], true],
        ];
    }
}
