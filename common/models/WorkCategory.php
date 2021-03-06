<?php
/**
 * Created by Ed.Creater <ed.creater@gmail.com>.
 * Author Site: https://codesweet.ru
 * Date: 27.02.2018
 */

namespace common\models;

use common\models\query\WorkCategoryQuery;
use Yii;
use yii\behaviors\SluggableBehavior;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "work_category".
 *
 * @property integer $id
 * @property string $slug
 * @property string $title
 * @property integer $status
 *
 * @property Work[] $works
 */
class WorkCategory extends ActiveRecord
{
	const STATUS_ACTIVE = 1;
	const STATUS_DRAFT = 0;

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%work_category}}';
	}

	/**
	 * @return WorkCategoryQuery
	 */
	public static function find()
	{
		return new WorkCategoryQuery(get_called_class());
	}

	public function behaviors()
	{
		return [
			TimestampBehavior::className(),
			[
				'class' => SluggableBehavior::className(),
				'attribute' => 'title',
				'immutable' => true
			]
		];
	}


	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['title'], 'required'],
			[['title'], 'string', 'max' => 512],
			[['slug'], 'unique'],
			[['slug'], 'string', 'max' => 1024],
			['status', 'integer'],
        ];
	}

	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'id' => Yii::t('common', 'ID'),
			'slug' => Yii::t('common', 'Slug'),
			'title' => Yii::t('common', 'Title'),
            'status' => Yii::t('common', 'Active')
		];
	}

	/**
	 * @return \yii\db\ActiveQuery
	 */
	public function getWorks()
	{
		return $this->hasMany(Work::className(), ['category_id' => 'id']);
	}


}
