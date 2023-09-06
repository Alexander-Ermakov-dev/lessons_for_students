<?php
/** @var app\models\Lessons $lesson*/
/** @var yii\web\View $this */
/** @var Bool $isCompleted */

use yii\helpers\Html;
use yii\helpers\Url;
?>

<div class="container mt-5">
    <h2 class="text-center"><?= Html::encode($lesson->title) ?></h2>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center mt-3">
            <p><?= Html::encode($lesson->description) ?></p>
        </div>
    </div>

    <div class="row mt-4 justify-content-center">
        <div class="col-md-8 mb-4 d-flex flex-column align-items-center">
            <div class="embed-responsive embed-responsive-16by9 mb-3">
                <iframe class="embed-responsive-item" width="560" height="315" src="<?= Html::encode($lesson->video_url) ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>

            <div class="mt-3">
                <?= Html::a('Урок просмотрен', '#', [
                    'class' => 'btn btn-success complete-lesson' . ($isCompleted ? ' disabled' : ''),
                    'data-url' => Url::to(['site/complete', 'id' => $lesson->id]),
                ]) ?>
             </div>
        </div>
    </div>
</div>

<?php
$this->registerJs("
    $(document).on('click', '.complete-lesson', function(e) {
        e.preventDefault();
        
        let url = $(this).data('url');

        $.ajax({
            type: 'POST',
            url: url,
            success: function(response) {
                if (response.success && response.redirect) {
                    window.location.href = response.redirect; 
                } else {
                    alert('Произошла ошибка');
                }
            }
        });
    });
");
?>




