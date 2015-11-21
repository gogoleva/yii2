<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "authors".
 *
 * @property integer $id
 * @property string $firstname
 * @property string $lastname
 */
class Authors extends \yii\db\ActiveRecord {

    /**
     * @inheritdoc
     */
    public static function tableName() {
        return 'authors';
    }

    /**
     * @inheritdoc
     */
    public function rules() {
        return [
            [['firstname', 'lastname'], 'required'],
            [['firstname', 'lastname'], 'string', 'max' => 45]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels() {
        return [
            'id' => 'ID',
            'firstname' => 'Firstname',
            'lastname' => 'Lastname',
        ];
    }

    public static function get() {
        $sql = "SELECT id, CONCAT(firstname, ' ', lastname) as name FROM " . Authors::tableName();
        $rows = Yii::$app->db->createCommand($sql)->queryAll();
        foreach ($rows as $row) {
            $result[$row['id']] = $row['name'];
        }
        return isset($result) ? $result : [];
    }
}
