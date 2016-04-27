<?php

/* @var $this yii\web\View */

use \yii\helpers\Url;
use yii\web\Cookie;
use frontend\assets\OwlCarouselAsset;
use yii\helpers\ArrayHelper;

OwlCarouselAsset::register($this);

$this->title = Yii::t('title', 'Search');
?>
<div class="owl-carousel owl-theme MainSlider">
    <div class="item sl1">
        <section class="slide1">
            <div class="w1170">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title">Товары и услуги для вас</h1>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="number">1</div>
                        <div class="text"><span>Заполните заявку</span><br>Мы быстро оповестим<br>исполнителей Searchplace<br>о вашей заявке.</div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="number">2</div>
                        <div class="text"><span>Получите предложения</span><br>Заинтересованные исполнители<br>предложат вам<br>свои услуги.</div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="number">3</div>
                        <div class="text"><span>Выберите исполнителя</span><br>Выберите подходящее для вас<br>предложение по цене или<br>рейтингу исполнителя.</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="item sl2">
        <section class="slide2">
            <div class="w1170">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title">Ваш автосервис</h1>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="number">1</div>
                        <div class="text"><span>Заполните заявку</span><br>Мы быстро оповестим<br>исполнителей Searchplace<br>о вашей заявке.</div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="number">2</div>
                        <div class="text"><span>Получите предложения</span><br>Заинтересованные исполнители<br>предложат вам свои услуги по<br>автосервису.</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-6 col-md-5 col-md-offset-1">
                        <div class="number">3</div>
                        <div class="text"><span>Выберайте удобно</span><br>Выберите подходящее для вас<br>предложение по цене или рейтингу<br>исполнителя.</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="item sl3">
        <section class="slide3">
            <div class="w1170">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="title">Удобный поиск автозапчастей</h1>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4 col-md-offset-4">
                        <div class="number">1</div>
                        <div class="text"><span>Заполните заявку</span><br>Мы быстро оповестим<br>исполнителей Searchplace<br>о вашей заявке.</div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-4">
                        <div class="number">2</div>
                        <div class="text"><span>Получите предложения</span><br>Заинтересованные исполнители<br>предложат вам широкий выбор<br>автотоваров.</div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="col-xs-12 col-sm-6 col-md-5 col-md-offset-5">
                        <div class="number">3</div>
                        <div class="text"><span>Выберайте удобно</span><br>Выберите подходящее для вас<br>предложение по цене или рейтингу<br>исполнителя.</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<div class="container">
    <div class="row">
<!--         <div class="col-md-12 text-center">-->
<!--            --><?php
//             $city = Yii::$app->getRequest()->getCookies()->getValue('city');
//
//             if (empty($city)) {
//                 $info = new common\components\GeoIpInfo();
//                 $city = $info->getValue('city');
//
//                 $cookie = new Cookie([
//                     'name'   => 'city',
//                     'value'  => $city,
//                     'expire' => time() + 86400 * 365,
//                 ]);
//                 Yii::$app->getResponse()->getCookies()->add($cookie);
//             }
//            ?>
<!--        -->
<!--            <h3>Ваш город: --><?php //echo $city; ?><!--</h3>-->
<!--        </div>-->

        <?php foreach (\common\helpers\CategoryHelper::getList() as $id => $item) : ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <a class="whiteCard" href="<?= Url::toRoute(['/search/category', 'id' => $id]); ?>">
                    <div class="col-xs-12 col-sm-4 col-md-3">
                        <img src="<?= ArrayHelper::getValue($item, 'image'); ?>" alt="">
                    </div>
                    <div class="col-xs-12 col-sm-8 col-md-9">
                        <h2><?= ArrayHelper::getValue($item, 'name'); ?></h2>
                        <p><?= ArrayHelper::getValue($item, 'description'); ?></p>
                    </div>
                </a>
            </div>
        <?php endforeach; ?>
    </div>
</div>
