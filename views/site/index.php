<?php

/** @var Array $completedLessons */
/** @var Array $lessons */
/** @var Integer $nextAvailableLessonId */

/** @var Bool $allLessonsCompleted */

use yii\helpers\Html;
use yii\helpers\Url;

?>

<div class="container mt-5">
    <?php if (!Yii::$app->user->isGuest): ?>
        <h2>Список уроков по PHP</h2>
        <ul class="list-group">
            <?php if ($allLessonsCompleted): ?>
                <div class="alert alert-success text-center mb-4">
                    Поздравляем! Вы успешно завершили все уроки этого курса.
                </div>
            <?php endif; ?>
            <?php foreach ($lessons as $lesson): ?>
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <?php if ($lesson->id <= $nextAvailableLessonId): ?>
                        <?= Html::a(Html::encode($lesson->title), Url::to(['site/view', 'id' => $lesson->id])) ?>
                    <?php else: ?>
                        <?= Html::encode($lesson->title) ?>
                    <?php endif; ?>

                    <?php if (in_array($lesson->id, $completedLessons)): ?>
                        <span class="badge bg-success">✓</span>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    <?php else: ?>
        <h2>Добро пожаловать на наш курс по PHP!</h2>
        <p>На этом курсе вы научитесь основам программирования на PHP, узнаете о различных фреймворках и лучших
            практиках разработки.</p>
        <p>Чтобы начать обучение, пожалуйста, <a href="<?= Url::to(['site/login']) ?>">войдите</a> или <a
                    href="<?= Url::to(['site/signup']) ?>">зарегистрируйтесь</a>.</p>
    <?php endif; ?>
</div>

