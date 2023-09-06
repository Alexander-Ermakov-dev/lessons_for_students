<?php

namespace app\controllers;

use app\models\Lessons;
use app\models\SignupForm;
use app\models\UserLessons;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only' => ['logout', 'signup', 'login'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                    [
                        'actions' => ['signup', 'login'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['signup', 'login'],
                        'allow' => false,
                        'denyCallback' => function ($rule, $action) {
                            return $this->goHome();
                        },
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $lessons = Lessons::find()->all();
        $completedLessons = UserLessons::find()->select('lesson_id')->where(['user_id' => Yii::$app->user->id])->column();

        if (!empty($completedLessons)) {
            $lastCompletedLessonId = max($completedLessons);
            $nextAvailableLessonId = $lastCompletedLessonId + 1;
        } else {
            $firstLesson = Lessons::find()->orderBy(['id' => SORT_ASC])->one();
            $nextAvailableLessonId = $firstLesson ? $firstLesson->id : null;
        }
        $allLessonsCompleted = count($lessons) === count($completedLessons);

        return $this->render('index', [
            'lessons' => $lessons,
            'completedLessons' => $completedLessons,
            'nextAvailableLessonId' => $nextAvailableLessonId,
            'allLessonsCompleted' => $allLessonsCompleted,
        ]);
    }

    public function actionView($id)
    {
        $lesson = Lessons::findOne($id);
        if (!$lesson) {
            throw new NotFoundHttpException("Урок не найден");
        }

        $isCompleted = UserLessons::find()->where(['user_id' => Yii::$app->user->id, 'lesson_id' => $id])->exists();

        return $this->render('view', [
            'lesson' => $lesson,
            'isCompleted' => $isCompleted,
        ]);
    }

    public function actionComplete($id)
    {
        Yii::$app->response->format = Response::FORMAT_JSON;

        if (UserLessons::find()->where(['user_id' => Yii::$app->user->id, 'lesson_id' => $id])->exists()) {
            return ['success' => false];
        }

        $userLesson = new UserLessons();
        $userLesson->user_id = Yii::$app->user->id;
        $userLesson->lesson_id = $id;

        if ($userLesson->save()) {
            return ['success' => true, 'redirect' => Url::to(['site/index'])];
        }
        return ['success' => false];
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Спасибо за регистрацию!');
            return $this->goHome();
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }
}
