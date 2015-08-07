<?php
namespace icron\confirm;

use yii\helpers\Html;
use yii\helpers\Json;
use yii\widgets\InputWidget;
use Yii;

class ConfirmWidget extends InputWidget
{
    public $clientOptions = [];

    public $clientEvents = [];

    public function run()
    {
        if ($this->hasModel()) {
            $field =  Html::activeFileInput($this->model, $this->attribute, $this->options);
        } else {
            $field = Html::fileInput($this->name, $this->value, $this->options);
        }
        echo $this->renderTemplate($field);
        $this->registerClientScript();
    }

    public function renderTemplate($field)
    {
        $view = $this->getViewPath() . '/confirm.php';
        return $this->getView()->renderFile(Yii::getAlias($view), ['field' => $field]);
    }

    public function registerClientScript()
    {
        $view = $this->getView();
        ConfirmAsset::register($view);
        $id = $this->options['id'];
        $options = !empty($this->clientOptions) ? Json::encode($this->clientOptions) : '';
        $js[] = ";jQuery('#$id').confirm({$options});";
        if (!empty($this->clientEvents)) {
            foreach ($this->clientEvents as $event => $handler) {
                $js[] = ";jQuery('#$id').on('$event', $handler);";
            }
        }
        $view->registerJs(implode("\n", $js));
    }
}