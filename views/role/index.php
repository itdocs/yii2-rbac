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
 * @var $dataProvider array
 * @var $filterModel  dektrium\rbac\models\Search
 * @var $this         yii\web\View
 */


use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\Url;

$this->title = Yii::t('rbac', 'Roles');
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginContent('@dektrium/rbac/views/layout.php') ?>


    <div style="padding: 10px 0">


        <div id="w0" class="grid-view">
            <table class="table table-striped table-bordered">
                <colgroup>
                    <col style="width: 20%">
                    <col style="width: 55%">
                    <col style="width: 20%">
                    <col style="width: 5%">
                </colgroup>

                <thead>
                <tr>
                    <th>名称</th>
                    <th>描述</th>
                    <th>已开通权限</th>
                    <th>&nbsp;</th>
                </tr>

                </thead>

                <tbody>
                <?php foreach($children as $data):?>
                <tr data-key="0">
                    <td><?=$data['name']?></td>
                    <td><?=$data['description']?></td>
                    <td>
                     <!--   <?php /*foreach($permissions as $permi):*/?>

                            <?php /*if(in_array($permi['name'],$data['child'])):*/?>
                                <input type="checkbox" name="per" checked> <?/*=$permi['description']*/?><br>
                            <?php /*else:*/?>
                                <input type="checkbox" name="per"> <?/*=$permi['description']*/?><br>
                            <?php /*endif;*/?>
                        <?php /*endforeach;*/?>  -->

                        <?php foreach($data['child_desc'] as $ch):?>
                            <?=$ch?><br><br>
                        <?php endforeach;?>
                    </td>
                    <td>
                        <a href="/rbac/role/update?name=<?=$data['name']?>" title="更新" aria-label="更新" data-pjax="0">
                            <span class="glyphicon glyphicon-pencil"></span>
                        </a>
                        <a href="/rbac/role/delete?name=<?=$data['name']?>" title="删除" aria-label="删除" data-confirm="您确定要删除此项吗？" data-method="post" data-pjax="0">
                            <span class="glyphicon glyphicon-trash"></span>
                        </a>
                    </td>
                </tr>
                <?php endforeach;?>
                </tbody>
            </table>
        </div>
    </div>
<?php $this->endContent() ?>