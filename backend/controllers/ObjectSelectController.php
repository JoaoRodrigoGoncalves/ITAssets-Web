<?php

namespace backend\controllers;

use common\models\CustomTableRow;
use ReflectionClass;
use Yii;
use yii\data\ArrayDataProvider;
use yii\filters\VerbFilter;
use yii\web\Controller;

class ObjectSelectController extends Controller
{
    public function behaviors()
    {
        return array_merge(parent::behaviors(),
        [
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'index' => ['post'],
                ],
            ],
        ]);
    }

    public function actionIndex()
    {
        $rows = array();

        // "SearchFor" para ir buscar os models
        foreach (explode(",", $_POST['SearchFor']) as $modelName) {
            /*
             * Eu não sei como isto funciona. Para mim, isto nem devia funcionar. Porém, ao que parace,
             * se passar o nome completo de uma classe numa variável (por mais que esta seja uma string)
             * e colocar à frente dela pontuação como se fosse uma classe, ele traduz a string numa classe.
             * Mais uma vez, não sei porquê, mas está aqui o link de onde isto me apareceu na internet e
             * parece que funciona.
             * https://laracasts.com/discuss/channels/general-discussion/creating-a-new-object-from-string-of-class-name?page=1&replyId=829588
             */
            $class = new ReflectionClass($modelName);

            // Sei que podia usar reflection, mas não estou a encontrar o que quero, por isso vai assim
            foreach ($modelName::findAll(['status' => 10]) as $item){
                $validationStatus = true;

                if(isset($_POST['functionRules']))
                {
                    foreach (explode(",", $_POST['functionRules']) as $functionRule) {
                        if(str_starts_with($functionRule, "!"))
                        {
                            // O resultado das funções a serem executadas aqui são negadas
                            $functionRule = substr($functionRule, 1);

                            if(method_exists($item, $functionRule))
                            {
                                // Validar se o objeto atual passa no filto da função
                                $validationStatus = !call_user_func(array($item, $functionRule));
                            }
                        }
                        else
                        {
                            if(method_exists($item, $functionRule))
                            {
                                // Validar se o objeto atual passa no filto da função
                                $validationStatus = call_user_func(array($item, $functionRule));
                            }
                        }
                    }
                }

                if($validationStatus)
                    $rows[] = new CustomTableRow($class->getShortName() . "_" . $item->id, $item->nome, null);
            };
        }

        $tableDataProvider = new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        //TODO: Guardar o "SendBack" em algum lado para enviar de volta

        return $this->render('index', [
            'callback' => $_POST['Callback'],
            'multiselect' => $_POST['Multiselect'] ?? false,
            'currentlySelected' => $data['currentlySelected'] ?? null,
            'tableData' => $tableDataProvider
        ]);
    }
}
