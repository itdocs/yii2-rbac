<?php

/*
 * This file is part of the Dektrium project.
 *
 * (c) Dektrium project <http://github.com/dektrium>
 *
 * For the full copyright and license information, please view the LICENSE.md
 * file that was distributed with this source code.
 */

/**
 * @var $this  yii\web\View
 */
Yii::$app->session->set('current_nav', 'rbac');
?>
<style>
    #w4-success{width:300px;margin: 0 auto;}
</style>
<?= $this->render('/_alert', [
    'module' => Yii::$app->getModule('rbac'),
]) ?>

<?= $this->render('_menu') ?>

<div style="padding: 10px 0">
    <?= $content ?>
</div>