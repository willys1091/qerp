<aside class="main-sidebar">

    <section class="sidebar">
        <?php

        use app\components\MdlDb;

        $connection = MdlDb::getDbConnection();
        $userRole = Yii::$app->user->identity->userRole;

        $headItems[] = [
            'label' => 'Home',
            'icon' => 'home',
            'url' => Yii::$app->getHomeUrl(),
        ];

        $sql = "SELECT DISTINCT b.accessID, b.description, b.icon
                FROM ms_useraccess a
                JOIN lk_accesscontrol b ON LEFT(a.accessID,1) = b.accessID
                WHERE a.userRole = '" . $userRole . "' AND a.indexAcc = 1
                ORDER BY a.accessID ";
        $model = $connection->createCommand($sql);
        $headResult = $model->queryAll();
        
        foreach ($headResult as $headMenu) {
            $sql = "SELECT b.description, b.node, b.icon
            FROM ms_useraccess a
            JOIN lk_accesscontrol b ON a.accessID = b.accessID
            WHERE a.userRole = '" . $userRole . "' AND a.accessID LIKE '" . $headMenu['accessID'] . "%' AND a.indexAcc = 1
            ORDER BY CAST(SUBSTRING(b.accessID,3) AS UNSIGNED) ";
             
            $model = $connection->createCommand($sql);
            $detailResult = $model->queryAll();
             
            $detailItems = [];
            foreach ($detailResult as $detailMenu) {
                $detailItems[] = [
                        'label' => $detailMenu['description'],
                        'icon' => $detailMenu['icon'],
                        'url' => ['/'. $detailMenu['node']],
                ];
            }
             
            $headItems[] = [
                'label' => $headMenu['description'],
                'url' => '#',
                'icon' => $headMenu['icon'],
                'items' => $detailItems
            ];
        }

        echo dmstr\widgets\Menu::widget(
            [
                'options' => ['class' => 'sidebar-menu'],
                'items' => $headItems,
            ]
        ) ?>

    </section>

</aside>
