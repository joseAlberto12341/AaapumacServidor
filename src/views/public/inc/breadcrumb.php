<!--====== Breadcrumb part Start ======-->
<?php global $answer; ?>
<section class="breadcrumb-section bg-img-c"
    style='background-image: url(/Aaapumac/src/views/assets/img/breadcrumb/<?php echo isset($answer["data"]["breadcrumb"]) ? $answer["data"]["breadcrumb"] : "default" ?>.png);'>
    <div class="container">
        <div class="breadcrumb-text"> 
            <h1 class="page-title wow slideInLeft"><?php echo isset($answer["data"]["title"]) ? $answer["data"]["title"] : "" ?></h1>
            <ul>
                <a style="font-size:30px; color: #ffff; font-weight: bold;" class="wow slideInRight">SE PARTE DE ESTE GRAN EQUIPO DE TRABAJO</a>
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