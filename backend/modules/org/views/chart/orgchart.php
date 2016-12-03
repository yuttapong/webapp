<?php
/**
 * Created by PhpStorm.
 * User: RB
 * Date: 29/10/2559
 * Time: 9:23
 */
use backend\modules\org\OrgChartAsset;
use yii\web\JqueryAsset;

OrgChartAsset::register($this);

?>

<!-- wrap the text node with <a href="#"> , <span>, blabla is also OK. Note:text node must immediately follow the <li> tag, with no intervening characters of any kind.  -->
<ul id="ul-data">
    <li>Lao Lao
        <ul>
            <li>Bo Miao</li>
            <li>Su Miao
                <ul>
                    <li>Tie Hua</li>
                    <li>Hei Hei
                        <ul>
                            <li>Pang Pang</li>
                            <li>Xiang Xiang</li>
                        </ul>
                    </li>
                </ul>
            </li>
        </ul>
    </li>
</ul>
<div id="chart-container"></div>
<script>
    // sample of core source code
    var datasource = {
        'name': 'Lao Lao',
        'title': 'general manager',
        'children': [
            { 'name': 'Bo Miao', 'title': 'department manager' },
            { 'name': 'Su Miao', 'title': 'department manager',
                'children': [
                    { 'name': 'Tie Hua', 'title': 'senior engineer' },
                    { 'name': 'Hei Hei', 'title': 'senior engineer' }
                ]
            },
            { 'name': 'Hong Miao', 'title': 'department manager' },
            { 'name': 'Chun Miao', 'title': 'department manager' }
        ]
    };

    $('#chart-container').orgchart({
        'data' : datasource,
        'depth': 2,
        'nodeContent': 'title'
    });

</script>
