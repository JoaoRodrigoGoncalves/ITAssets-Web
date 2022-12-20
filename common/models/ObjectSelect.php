<?php

namespace common\models;

use ReflectionClass;
use yii\base\UnknownMethodException;
use yii\data\ArrayDataProvider;

class ObjectSelect
{

    public static function getArrayProvider($config)
    {
        $rows = array();

        // "SearchFor" para ir buscar os models
        foreach ($config->SearchFor as $modelToSearch) {
            /*
             * Eu não sei como isto funciona. Para mim, isto nem devia funcionar. Porém, ao que parace,
             * se passar o nome completo de uma classe numa variável (por mais que esta seja uma string)
             * e colocar à frente dela pontuação como se fosse uma classe, ele traduz a string numa classe.
             * Mais uma vez, não sei porquê, mas está aqui o link de onde isto me apareceu na internet e
             * parece que funciona.
             * https://laracasts.com/discuss/channels/general-discussion/creating-a-new-object-from-string-of-class-name?page=1&replyId=829588
             */
            $class = new ReflectionClass($modelToSearch->model);

            // Sei que podia usar reflection, mas não estou a encontrar o que quero, por isso vai assim

            $filter = $modelToSearch->model::find();

            if(isset($modelToSearch->whereRules))
            {
                foreach ($modelToSearch->whereRules as $whereRule) {
                    $filter->andWhere($whereRule);
                }
            }

            $filter->andWhere(['status' => 10]);
            $modelData = $filter->all();


            foreach ($modelData as $item){
                $validationStatus = true;

                if(isset($modelToSearch->functionRules))
                {
                    foreach ($modelToSearch->functionRules as $functionRule) {
                        // Se o status ficou a falso na última validação validada, parar de tentar validar
                        if(!$validationStatus)
                            break;

                        if(str_starts_with($functionRule->function, "!"))
                        {
                            // O resultado das funções a serem executadas aqui são negadas
                            $funcName = substr($functionRule->function, 1);

                            if(method_exists($item, $funcName))
                            {
                                // Validar se o objeto atual passa no filto da função
                                if(isset($functionRule->args))
                                {
                                    $validationStatus = !call_user_func(array($item, $funcName), ...$functionRule->args);
                                }
                                else
                                {
                                    $validationStatus = !call_user_func(array($item, $funcName));
                                }
                            }
                            else
                            {
                                throw new UnknownMethodException("Método " . $item::class . "::" . $funcName . "() não existe");
                            }
                        }
                        else
                        {
                            if(method_exists($item, $functionRule->function))
                            {
                                // Validar se o objeto atual passa no filto da função
                                if(isset($functionRule->args))
                                {
                                    $validationStatus = call_user_func(array($item, $functionRule->function), ...$functionRule->args);
                                }
                                else
                                {
                                    $validationStatus = call_user_func(array($item, $functionRule->function));
                                }
                            }
                            else
                            {
                                throw new UnknownMethodException("Método " . $item::class . "::" . $functionRule->function . "() não existe");
                            }
                        }
                    }
                }

                if($validationStatus)
                    $rows[] = new CustomTableRow($class->getShortName() . "_" . $item->id, $item->nome, null);
            };
        }

        //TODO: Guardar o "SendBack" em algum lado para enviar de volta

        return new ArrayDataProvider([
            'allModels' => $rows,
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);
    }
}