<?php

return [
    'autoload' => false,
    'hooks' => [],
    'route' => [
        '/example$' => 'example/index/index',
        '/example/d/[:name]' => 'example/demo/index',
        '/example/d1/[:name]' => 'example/demo/demo1',
        '/example/d2/[:name]' => 'example/demo/demo2',
        '/kaoshi$' => 'kaoshi/index/index',
        '/kaoshi/logout$' => 'kaoshi/user/logout',
        '/kaoshi/login$' => 'kaoshi/user/login',
        '/kaoshi/changepwd$' => 'kaoshi/user/changepwd',
        '/kaoshi/user$' => 'kaoshi/user/index',
        '/kaoshi/answercard$' => 'kaoshi/exams/answercard',
        '/kaoshi/score$' => 'kaoshi/exams/score',
        '/kaoshi/start$' => 'kaoshi/exams/getquestion',
        '/kaoshi/rank$' => 'kaoshi/exams/rank',
        '/kaoshi/study$' => 'kaoshi/user_plan/study',
        '/kaoshi/exam$' => 'kaoshi/user_plan/exam',
        '/kaoshi/studyhistory$' => 'kaoshi/user_plan/studyhistory',
        '/kaoshi/examhistory$' => 'kaoshi/user_plan/examhistory',
    ],
    'priority' => [],
];
