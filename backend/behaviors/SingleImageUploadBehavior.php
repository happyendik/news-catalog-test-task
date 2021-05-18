<?php

namespace backend\behaviors;

use yii\base\Behavior;
use yii\db\ActiveRecord;
use yii\web\UploadedFile;
use yii\validators\ImageValidator;
use yii\base\InvalidConfigException;

/**
 * Class SingleImageUploadBehavior
 * @package backend\behaviors
 */
class SingleImageUploadBehavior extends Behavior
{
    /**
     * @var array|string
     */
    public $attributes;

    /**
     * @var array
     */
    public $validatorOptions = [
        'extensions' => 'jpg, png',
    ];

    /**
     * @var string
     */
    public $uploadPath = '@frontend/web';

    /**
     * {@inheritDoc}
     * @throws InvalidConfigException
     */
    public function init()
    {
        if (!$this->attributes) {
            throw new InvalidConfigException('`attributes` param is required');
        }
        parent::init();
    }

    /**
     * {@inheritDoc}
     */
    public function events()
    {
        return [
            ActiveRecord::EVENT_AFTER_VALIDATE => 'onAfterValidate',
            ActiveRecord::EVENT_AFTER_UPDATE => 'onAfterSave',
            ActiveRecord::EVENT_AFTER_INSERT => 'onAfterSave',
        ];
    }

    public function onAfterValidate()
    {
        $attributes = is_array($this->attributes) ? $this->attributes : (array) $this->attributes;
        foreach ($attributes as $attribute) {
            $file = UploadedFile::getInstance($this->owner, $attribute);
            if (!$file) {
                continue;
            }
            $validator = new ImageValidator($this->validatorOptions);
            if (!$validator->validate($file, $error)) {
                $this->owner->addError($attribute, $error);
            }
        }
    }

    public function onAfterSave()
    {
        $attributes = is_array($this->attributes) ? $this->attributes : (array) $this->attributes;
        foreach ($attributes as $attribute) {
            $file = UploadedFile::getInstance($this->owner, $attribute);
            if ($file) {
                $filename = $this->generateFilename($file);
                $file->saveAs(rtrim($this->uploadPath, '/') . '/' . $filename);
                $this->owner->updateAttributes([
                    $attribute => $filename,
                ]);
                continue;
            }
            if (!$this->owner->{$attribute}) {
                $this->owner->updateAttributes([
                    $attribute => null,
                ]);
            }
        }
    }

    /**
     * @param UploadedFile $file
     * @return string
     */
    private function generateFilename(UploadedFile $file)
    {
        return $file->baseName . '.' . $file->extension;
    }
}
