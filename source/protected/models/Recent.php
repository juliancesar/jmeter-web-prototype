<?php

/**
 * This is the model class for table "Recent".
 *
 * The followings are the available columns in table 'Recent':
 * @property string $url
 * @property string $date
 * @property string $id
 */
class Recent extends CActiveRecord {

    /**
     * Returns the static model of the specified AR class.
     * @param string $className active record class name.
     * @return Recent the static model class
     */
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'Recent';
    }

    /**
     * @return array validation rules for model attributes.
     */
    public function rules() {
        return array(
            array('url, date, id', 'required'),
            array('url, date, id', 'safe', 'on' => 'search'),
        );
    }

    /**
     * @return array customized attribute labels (name=>label)
     */
    public function attributeLabels() {
        return array(
            'url' => 'Url',
            'date' => 'Date',
            'id' => 'Id',
        );
    }

    /**
     * Retrieves a list of models based on the current search/filter conditions.
     * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
     */
    public function search() {
        $criteria = new CDbCriteria;

        $criteria->compare('url', $this->url, true);
        $criteria->compare('date', $this->date, true);

        return new CActiveDataProvider($this, array(
                    'criteria' => $criteria,
                ));
    }

    public function defaultScope() {
        return array(
            'order' => 'date DESC',
        );
    }

    public function scopes() {
        return array(
            'recents' => array('limit' => 5),
            'list' => array('limit' => 15),
        );
    }

    public static function createRegister($url = "", $id = "") {

        $reg = new Recent();
        $reg->url = $url;
        $reg->id = $id;
        $reg->date = date("Y-m-d H:i:s");

        try {
            $reg->save();
        } catch (Exception $ex) {
            Yii::log($ex->getMessage(), CLogger::LEVEL_ERROR);
        }
    }

}