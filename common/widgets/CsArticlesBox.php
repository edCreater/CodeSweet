<?php
/**
 * Created by EdCreater.
 * Email: ed.creater@gmail.com
 * Site: codesweet.ru
 * Date: 25.12.2017
 */

namespace common\widgets;

use common\models\Article;
use yii\base\Widget;
use Yii;
use yii\helpers\Html;

/**
 * Class CsArticlesBox
 * Return a base services stored in db
 * @package common\widgets
 */
class CsArticlesBox extends Widget
{
	/**
	 * @var string text block key
	 */
	public $count_items;

	/**
	 * @return string
	 */
	public function run()
	{


		$items =  Article::find()
		                 ->where(['status' => Article::STATUS_PUBLISHED])
		                 ->orderBy('published_at DESC')
		                 ->limit($this->count_items)
		                 ->all();
		if ($items) {
            $i = 0;
            $count_items = count($items);
			?>

			<div class="articles-box">

                <div class="articles-box">
                    <div class="articles-box__heading">
                        <p class="articles-box__title">Свежие статьи</p>
                        <a href="#" class="articles-box__link">Все статьи</a>
                    </div>
                    <div class="articles-box__columns">
                        <?php foreach ($items as $item) : ?>

                        <?php
                        if ($item->thumbnail['path']) {

                            $thumb = Html::img(
                                Yii::$app->glide->createSignedUrl([
                                    'glide/index',
                                    'path' => $item->thumbnail_path,
                                    'w' => 265,
                                    'h' => 185,
                                    'fit' => 'crop'
                                ], true),
                                ['class' => 'img-fluid']
                            );
                        }
                        ?>
                            <?php if ($i==0) : ?>
                                <div class="articles-box__column articles-box__column--left">
                                    <div class="articles-box__item articles-box__item--large new-post-large">
                                        <div class="new-post-large__thumb">
                                            <?php echo Html::a($thumb, ['article/view', 'category'=>$item->category->slug, 'slug'=>$item->slug]) ?>
                                        </div>
                                        <div class="new-post-large__content">
                                            <p class="new-post-large__title">
                                                <?php echo Html::a($item->title, ['article/view', 'category'=>$item->category->slug, 'slug'=>$item->slug]) ?>
                                            </p>
                                            <p class="new-post-large__date"><?php echo date('j F Y'); ?></p>
                                        </div>
                                    </div>

                                </div>
                            <?php endif; ?>

                            <?php echo ($i==0) ? '<div class="articles-box__column articles-box__column--right">' : ''; ?>

                            <?php if ($i>0) : ?>
                                <div class="articles-box__item articles-box__item--standard new-post-standard">
                                    <div class="new-post-standard__thumb">
                                        <?php echo Html::a($thumb, ['article/view', 'category'=>$item->category->slug, 'slug'=>$item->slug]) ?>
                                    </div>
                                    <div class="new-post-standard__content">
                                        <p class="new-post-standard__title">
                                            <?php echo Html::a($item->title, ['article/view', 'category'=>$item->category->slug, 'slug'=>$item->slug]) ?>
                                        </p>
                                        <p class="new-post-standard__date"><?php echo date('j F Y'); ?></p>
                                    </div>
                                </div>
                            <?php endif; ?>

                            <?php echo ($i==($count_items)) ? '</div>' : ''; ?>

                            <?php $i++; ?>

                        <?php endforeach; ?>
                    </div>
                </div>

            </div><!-- End articles-box -->
			<?php
		}

		return false;
	}
}
