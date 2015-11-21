<?php

namespace app\models;

use Yii;
use app\models\Authors;

/**
 * This is the model class for table "books".
 *
 * @property integer $id
 * @property string $name
 * @property string $date_create
 * @property string $date_update
 * @property string $preview
 * @property string $date
 * @property integer $author_id
 */
class Books extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'books';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['name', 'author_id', 'date'], 'required'],
            [['date_create', 'date_update', 'date'], 'safe'],
            [['author_id'], 'integer'],
            [['name', 'preview'], 'string', 'max' => 255],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'date_create' => 'Дата добавления',
            'date_update' => 'Дата последнего изменения',
            'preview' => 'Превью',
            'date' => 'Дата выхода книги',
            'author_id' => 'Автор',
            'authors.firstname' => 'Автор',
        ];
    }

    public function getAuthors() {
        return $this->hasOne(Authors::className(), ['id' => 'author_id']);
    }

    public function beforeSave($insert) {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->date_create = $this->date_update = date('Y-m-d H:i:s');
                $this->preview = !strlen($this->preview) ? Yii::$app->params['filepath'] . 'noimage.jpg' : $this->preview;
            } else {
                $this->date_update = date('Y-m-d H:i:s');
            }
            $this->date = date('Y-m-d H:i:s', strtotime(str_replace('/', '-', $this->date)));
            return true;
        } else {
            return false;
        }
    }

    public static function formatDate($date) {
        $month = array(
            1 => 'анваря', 2 => 'февраля', 3 => 'марта', 4 => 'апреля',
            5 => 'мая', 6 => 'июня', 7 => 'июля', 8 => 'августа',
            9 => 'сентября', 10 => 'октября', 11 => 'ноября', 12 => 'декабря'
        );
        $today = date('Y-m-d', time());
        $yesterday = date('Y-m-d', time() - 86400);
        $in_date = date('Y-m-d', strtotime($date));
        if ($today == $in_date)
            return 'Сегодня';
        if ($yesterday == $in_date)
            return 'Вчера';
        return date('d ', strtotime($date)) . $month[date('n', strtotime($date))] . date(' Y', strtotime($date));
    }

}
