<?php
/**
 * Created by EdCreater.
 * Email: ed.creater@gmail.com
 * Site: codesweet.ru
 * Date: 25.12.2017
 */

namespace common\widgets;

use common\models\ArticleCategory;
use yii\base\Widget;
use Yii;
use yii\helpers\Html;

/**
 * Class SideArticleCategories
 * Return a base categories stored in db
 * @package common\widgets
 */
class SideArticleCategories extends Widget
{

	/**
	 * @return string
	 */
	public function run()
	{


		$items =  ArticleCategory::find()
		                 ->where(['status' => ArticleCategory::STATUS_ACTIVE])
		                 ->all();
		if ($items) {

			?>

			<div class="widget s-categories">
                <div class="s-categories__heading">
                    Категории блога
                </div>
                <ul class="s-categories__items">
				<?php
				foreach ($items as $item){

					?>

					<li class="s-categories__item">
						<?php echo Html::a(
							$item->title,
							['article/category', 'category' => $item->slug]
						)?>
                    </li>


					<?php
				};
				?>
                </ul>
			</div><!-- End Side article categories widget -->
			<?php
		}

		return false;
	}
}
