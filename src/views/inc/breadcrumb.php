<!--====== Breadcrumb part Start ======-->
<section class="breadcrumb-section bg-img-c"
    style='background-image: url(/src/views/assets/img/breadcrumb/<?php echo $answer['data']['breadcrumb'] ?>.png);'>
    <div class="container">
        <div class="breadcrumb-text">
            <h1 class="page-title"><?php echo $answer['data']['title'] ?></h1>
            <ul>
                <li><a href="../">Inicio</a></li>
                <li><?php echo $answer['data']['breadcrumb'] ?></li>
            </ul>
        </div>
    </div>
    <!-- <div class="breadcrumb-shapes">
        <div class="one"></div>
        <div class="two"></div>
        <div class="three"></div>
    </div> -->
</section>
<!--====== Breadcrumb part End ======-->