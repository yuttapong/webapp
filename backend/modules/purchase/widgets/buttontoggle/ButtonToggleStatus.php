<?php
namespace backend\modules\purchase\widgets\buttontoggle;

use yii\helpers\Html;

/**
 * Created by Yuttapong Napikun
 * Email : yuttaponk@gmail.com
 * Date: 17/1/2017
 * Time: 14:04
 */
class ButtonToggleStatus extends \yii\base\Widget
{
    public $dataKey;

    public $dataStatus;
    public $options;
    public $url;

    public $textStatus = [
        'active' => '&#10003;',
        'inactive' => '&#9632;'
    ];

    private $_statusInactive = [0, false, '0', 'no', 'n', 'No', 'NO'];
    private $_statusActive = [1, true, '1', 'yes', 'y', 'Yes', 'YES'];

    private $_textName;
    private $_textclass;


    private function _generateTextStatus()
    {
        if ($this->dataKey) {
            if (in_array($this->dataStatus, $this->_statusActive, true)) {
                $this->_textName = $this->textStatus['active'];
                $this->_textclass = 'label label-success';

            } elseif (in_array($this->dataStatus, $this->_statusInactive, true)) {
                $this->_textName = $this->textStatus['inactive'];
                $this->_textclass = 'label label-danger';
            } else {

            }
        }
    }

    public function run()
    {
        $this->_generateTextStatus();
        $this->registerClientScript();
        return Html::a($this->_textName, "javascript:void(0);", [
            'id' => 'noomy_toggle_' . $this->dataKey,
            'data-status' => $this->dataStatus,
            'data-id' => $this->dataKey,
            'class' => 'noomy-buttontoggle-item  ' . $this->_textclass
        ]);
    }


    public function registerClientScript()
    {
        $active = $this->textStatus['active'];
        $inactive = $this->textStatus['inactive'];

        $view = $this->getView();
        $js = <<<JS
$(".noomy-buttontoggle-item").on('click', function (e) {
     var id =  $(this).data("id");
     var status = $(this).data("status");
     var target = $(this).attr("id");
     var el = $('#'+target);
      $.ajax({
         type:'post',
         url: '$this->url',
         dataType:'json',
         data:{id:id, status:status},
         success: function(rs) {
             console.log('status : ' , rs.active);
              if(rs.active == 1){
               el.removeClass("label-danger").addClass("label-success");
               el.html("$active");
               el.data("status",rs.active);
            } else {
               el.removeClass("label-success").addClass("label-danger");
               el.html("$inactive");
               el.data("status",rs.active);
            }  
         }
      })

});
JS;
        $view->registerJs($js);
    }


}