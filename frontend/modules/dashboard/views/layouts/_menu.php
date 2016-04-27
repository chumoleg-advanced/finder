<?php

use kartik\nav\NavX;
use yii\bootstrap\NavBar;
use frontend\modules\dashboard\components\MenuItems;
use kartik\helpers\Html;
use yii\helpers\Url;

/*NavBar::begin([
    'brandLabel' => '
      <div class="svg">
          <svg width="40" height="40" viewBox="0 0 40 40">
            <path d="M31.668,15.865 C31.658,11.633 30.002,7.651 27.005,4.652 C23.008,0.652 17.141,-0.933 11.693,0.516 C9.026,1.225 6.580,2.637 4.621,4.598 C1.638,7.583 0.002,11.557 0.012,15.788 C0.022,20.020 1.678,24.002 4.675,27.001 C8.672,31.001 14.539,32.586 19.987,31.137 C22.043,30.590 23.966,29.625 25.638,28.314 L37.308,39.994 L39.988,37.312 L28.316,25.631 C30.496,22.858 31.677,19.455 31.668,15.865 ZM24.367,24.360 C22.877,25.851 21.020,26.924 18.995,27.462 C14.853,28.564 10.392,27.360 7.355,24.319 C5.077,22.040 3.819,19.013 3.811,15.798 C3.803,12.582 5.047,9.561 7.313,7.293 C8.803,5.802 10.661,4.729 12.685,4.191 C16.828,3.089 21.288,4.293 24.326,7.334 C26.603,9.613 27.862,12.640 27.870,15.855 C27.878,19.071 26.634,22.092 24.367,24.360 ZM17.178,13.501 L21.456,12.364 L22.448,16.039 L18.170,17.176 L19.327,21.463 L15.660,22.438 L14.503,18.151 L10.225,19.289 L9.233,15.614 L13.511,14.477 L12.353,10.189 L16.020,9.214 L17.178,13.501 Z"/>
          </svg>
      </div>
    ',
    'brandUrl'   => Yii::$app->getHomeUrl(),
    'options'    => [
        'class' => 'navbar-inverse navbar-fixed-top ',
    ],
]);

echo NavX::widget([
    'options'         => ['class' => 'navbar-nav'],
    'items'           => MenuItems::getItems(),
    'activateParents' => true,
    'encodeLabels'    => false
]);

NavBar::end();*/
?>
<!-- <div class="container">
  <div class="nav">
    <ul>
      <li><a href="<?= Url::toRoute('request/index'); ?>">Мои заявки</a></li>
      <li><a href="<?= Url::toRoute('request-offer/index'); ?>">Заявки от клиентов</a></li>
      <li>2</li>
      <li>3</li>
      <li>4</li>
      <li>5</li>
      <li>6</li>
    </ul>
  </div>
</div> -->

<nav id="w1" class="navbar-inverse navbar-fixed-top navbar yamm" role="navigation">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w1-collapse">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="/dashboard">
        <div class="svg">
            <svg width="40" height="40" viewBox="0 0 40 40">
              <path d="M31.668,15.865 C31.658,11.633 30.002,7.651 27.005,4.652 C23.008,0.652 17.141,-0.933 11.693,0.516 C9.026,1.225 6.580,2.637 4.621,4.598 C1.638,7.583 0.002,11.557 0.012,15.788 C0.022,20.020 1.678,24.002 4.675,27.001 C8.672,31.001 14.539,32.586 19.987,31.137 C22.043,30.590 23.966,29.625 25.638,28.314 L37.308,39.994 L39.988,37.312 L28.316,25.631 C30.496,22.858 31.677,19.455 31.668,15.865 ZM24.367,24.360 C22.877,25.851 21.020,26.924 18.995,27.462 C14.853,28.564 10.392,27.360 7.355,24.319 C5.077,22.040 3.819,19.013 3.811,15.798 C3.803,12.582 5.047,9.561 7.313,7.293 C8.803,5.802 10.661,4.729 12.685,4.191 C16.828,3.089 21.288,4.293 24.326,7.334 C26.603,9.613 27.862,12.640 27.870,15.855 C27.878,19.071 26.634,22.092 24.367,24.360 ZM17.178,13.501 L21.456,12.364 L22.448,16.039 L18.170,17.176 L19.327,21.463 L15.660,22.438 L14.503,18.151 L10.225,19.289 L9.233,15.614 L13.511,14.477 L12.353,10.189 L16.020,9.214 L17.178,13.501 Z"></path>
            </svg>
        </div>
      </a>
    </div>
    <div id="w1-collapse" class="collapse navbar-collapse">
      <ul id="w2" class="navbar-nav nav">
        <li class="dropdown">
          <a class="dropdown-toggle" href="#" data-toggle="dropdown">Создать заявку <span class="caret"></span></a>
          <ul id="w3" class="dropdown-menu list-inline">
            <li class="dropdown dropdown-submenu yamm-fw">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown">Автосервис</a>
              <ul class="dropdown-menu">
                <li>
                  <div class="yamm-content">
                    <div class="row">
                      <div class="col-xs-12 col-sm-4 col-md-2">
                        <a href="/dashboard/request/create/1">Авторемонт и техобслуживание (СТО)</a>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-2">
                        <a href="/dashboard/request/create/2">Ремонт дисков</a>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-2">
                        <a href="/dashboard/request/create/3">Кузовной ремонт / малярные работы</a>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-2">
                        <a href="/dashboard/request/create/4">Установка / ремонт автостёкол</a>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-2">
                        <a href="/dashboard/request/create/5">Ремонт автоэлектрики</a>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-2">
                        <a href="/dashboard/request/create/6">Ремонт ходовой части автомобиля</a>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-2">
                        <a href="/dashboard/request/create/7">Ремонт дизельных двигателей</a>
                      </div>
                      <div class="col-xs-12 col-sm-4 col-md-2">
                        <a href="/dashboard/request/create/8">Ремонт бензиновых двигателей</a>
                      </div>
                    </div>
                  </div>
                </li>
              </ul>
            </li>
            <li class="dropdown dropdown-submenu">
              <a class="dropdown-toggle" href="#" tabindex="-1" data-toggle="dropdown">Автозапчасти / Автотовары <span class="caret"></span></a>
              <ul class="dropdown-menu">
                <li><a href="/dashboard/request/create/9" tabindex="-1">Автозапчасти для иномарок</a></li>
                <li><a href="/dashboard/request/create/12" tabindex="-1">Автозапчасти для отечественных автомобилей</a></li>
                <li><a href="/dashboard/request/create/13" tabindex="-1">Шины для легковых а\м</a></li>
                <li><a href="/dashboard/request/create/14" tabindex="-1">Диски для легковых а\м</a></li>
              </ul>
            </li>
          </ul>
        </li>
        <li><a href="/dashboard/request/index">Мои заявки</a></li>
        <li><a href="/dashboard/request-offer/index">Заявки от клиентов</a></li>
        <li class="dropdown">
          <a class="dropdown-toggle" href="#" data-toggle="dropdown">Мои компании <span class="caret"></span></a>
          <ul id="w4" class="dropdown-menu list-inline">
            <li><a href="/dashboard/company/update/5" tabindex="-1">Юнис</a></li>
            <li><a href="/dashboard/company-create/index" tabindex="-1"><i class="glyphicon glyphicon-plus"></i> Создать компанию</a></li>
          </ul>
        </li>
        <li class="messageButton">
          <a href="#">
            <div class="svg">
                <svg width="18" height="22" viewBox="0 0 18 22">
                  <path d="M9.000,22.000 C10.165,22.000 11.118,21.010 11.118,19.800 L6.882,19.800 C6.882,21.010 7.835,22.000 9.000,22.000 ZM15.882,15.400 L15.882,9.350 C15.882,5.940 13.659,3.190 10.588,2.420 L10.588,1.650 C10.588,0.770 9.847,-0.000 9.000,-0.000 C8.153,-0.000 7.412,0.770 7.412,1.650 L7.412,2.420 C4.341,3.190 2.118,5.940 2.118,9.350 L2.118,15.400 L-0.000,17.600 L-0.000,18.700 L18.000,18.700 L18.000,17.600 L15.882,15.400 Z"></path>
                </svg>
            </div>
            <span class="badge messageBadgeMenu">1</span>
          </a>
        </li>
        <li class="dropdown">
          <a class="dropdown-toggle" href="#" data-toggle="dropdown">
            <div class="svg">
                <svg width="21" height="21" viewBox="0 0 21 21">
                  <path d="M10.341,10.400 C13.185,10.400 15.511,8.060 15.511,5.200 C15.511,2.340 13.185,-0.000 10.341,-0.000 C7.497,-0.000 5.170,2.340 5.170,5.200 C5.170,8.060 7.497,10.400 10.341,10.400 ZM10.341,13.000 C6.851,13.000 -0.000,14.690 -0.000,18.200 L-0.000,20.800 L20.682,20.800 L20.682,18.200 C20.682,14.690 13.831,13.000 10.341,13.000 Z"></path>
                </svg>
            </div>
            mamedov.y@devlabo.ru <span class="caret"></span>
          </a>
          <ul id="w5" class="dropdown-menu list-inline">
            <li><a href="/dashboard/profile/index" tabindex="-1">Настройки</a></li>
            <li><a href="/auth/logout" data-method="post" tabindex="-1">Выход</a></li>
          </ul>
        </li>
      </ul>
    </div>
  </div>
</nav>