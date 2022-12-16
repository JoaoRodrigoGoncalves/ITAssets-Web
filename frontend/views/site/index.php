<?php

/** @var yii\web\View $this */

use yii\bootstrap5\Html;
use yii\helpers\Url;

$this->title = 'ItAssets';
?>


<div class="site-index">
    <div class="container col-xxl-12 px-4 py-5">
        <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
            <div class="col-10 col-sm-8 col-lg-6">
                <?= Html::img('@web/img/gatocaixabranco.png', ['alt'=>'Logotipo', 'class'=>'img-fluid float-center']); ?>
            </div>
            <div class="col-lg-6">
                <div class="lc-block mb-3">
                    <div>
                        <h2 class="fw-bold display-5">ItAssets</h2>
                    </div>
                </div>

                <div class="lc-block mb-3">
                    <div>
                        <p class="lead">
                            O projeto prático consiste na junção de quatro Unidades Curriculares, Plataformas de Sistema de Informação,
                            Sistemas e Interoperabilidade de Sistemas, Acesso Móvel a Sistemas de Informação e Projeto de Sistemas de
                            Informação.
                            O projeto irá servir essencialmente para gerir itens (computadores portáteis, desktops, adaptadores, etc.…)
                            de empresas de TI.
                        </p>
                    </div>
                </div>

                <div class="lc-block d-grid gap-2 d-md-flex justify-content-md-start">

                                <a href="<?=Url::to(['login']) ?>" class="btn btn-primary px-5 me-md-2 float-">Entrar</a>
                            </div>

            </div>
        </div>
    </div>

</div>
