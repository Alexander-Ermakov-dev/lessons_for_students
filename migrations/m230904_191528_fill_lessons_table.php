<?php

use yii\db\Migration;

/**
 * Class m230904_191528_fill_lessons_table
 */
class m230904_191528_fill_lessons_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->batchInsert('{{%lessons}}', ['title', 'description', 'video_url'], [
            ['Введение в PHP', 'Обзор языка и его возможностей', 'https://www.youtube.com/embed/3biJU63iS5M?si=Y6SBonjETpP7jF0t'],
            ['Установка и настройка PHP', 'Как настроить рабочее окружение для разработки на PHP', 'https://www.youtube.com/embed/oBJoXN0jUW4?si=Viz1QFhvfjFxle54'],
            ['Основы синтаксиса PHP', 'Ознакомление с базовым синтаксисом языка', 'https://www.youtube.com/embed/QYXaPFkyOVE?si=igNDxJQwgHvx9Tur'],
            ['Переменные и типы данных в PHP', 'Работа с переменными и типами данных', 'https://www.youtube.com/embed/K7vf0o5xJxs?si=SWQWD8naEOlKLb-E'],
            ['Управляющие конструкции', 'Условия, циклы и другие элементы управления', 'https://www.youtube.com/embed/Dp1nomQsLg8?si=Huw47O2nawAyrPEu'],
            ['Функции в PHP', 'Создание и использование функций', 'https://www.youtube.com/embed/EkAY1pXIyv0?si=-Kt0V6qVfwRFb80C'],
            ['Работа с массивами', 'Основы работы с массивами в PHP', 'https://www.youtube.com/embed/oEqwJLA390g?si=zWZCRnOKE_Un7l9A'],
            ['ООП в PHP', 'Введение в объектно-ориентированное программирование', 'https://www.youtube.com/embed/XyzRctr0rOA?si=7MZjvZrUpPqzSEZP'],
            ['Работа с файлами', 'Как работать с файлами и директориями в PHP', 'https://www.youtube.com/embed/PAP3b3D4cDw?si=d08GsNWB8YGvadd-'],
            ['Работа с формами', 'Обработка данных из форм', 'https://www.youtube.com/embed/NOn5C07U1aY?si=Lw3JLFwZsAjehMSY'],
            ['Безопасность в PHP', 'Основы безопасного кодирования', 'https://www.youtube.com/embed/X-4cunVqJj8?si=skIO2dBd7wVo8lj5'],
            ['Работа с базами данных', 'Введение в использование баз данных с PHP', 'https://www.youtube.com/embed/byV0Pc04SKY?si=SROPnz2fRnewKFI-'],
            ['PHP и сессии', 'Управление сессиями в веб-приложениях', 'https://www.youtube.com/embed/jz_d_1aiQhc?si=-1kCCHfDnf5VrgQv'],
            ['Работа с куками', 'Как использовать cookies в PHP', 'https://www.youtube.com/embed/tmIz4PFjGCg?si=bvGbIg1kdo6NOIpr'],
            ['Заключение', 'Завершающий обзор курса и следующие шаги', 'https://www.youtube.com/embed/pUDeY2sE_PE?si=dqYg6Yp2acbvFHtT'],
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $titles = [
            'Введение в PHP',
            'Установка и настройка PHP',
            'Основы синтаксиса PHP',
            'Переменные и типы данных в PHP',
            'Управляющие конструкции',
            'Функции в PHP',
            'Работа с массивами',
            'ООП в PHP',
            'Работа с файлами',
            'Работа с формами',
            'Безопасность в PHP',
            'Работа с базами данных',
            'PHP и сессии',
            'Работа с куками',
            'Заключение'
        ];

        foreach ($titles as $title) {
            $this->delete('{{%lessons}}', ['title' => $title]);
        }
        return true;
    }
}
