<?php $title = 'Canvas UI'; ?>

<?php ob_start(); ?>
<div id="interface">
    <div class="menuRow">
        <div class="brushs">
            <button id="drawBrush" class="button_unselect button_Select"><img src="./assets/img/brush.png" alt="brush icon"></button>
            <button id="drawLine" class="button_unselect"><img src="./assets/img/line.png" alt="line icon"></button>
            <button id="drawLineForm" class="button_unselect"><img src="./assets/img/triangle.png" alt="triangle icon"></button>
            <button id="drawRectangle" class="button_unselect"><img src="./assets/img/rectangle.png" alt="rectangle icon"></button>
            <button id="drawCircle" class="button_unselect"><img src="./assets/img/circle.png" alt="circle icon"></button>
        </div>
    </div>
    <div class="menuRow">
        <div class="sousOptionsContainer">
            <button id="strokeOption" class="button_unselect button_Select">Stroke</button>
            <button id="fillOption" class="button_unselect">Fill</button>
            <div id="colorStroke"></div>
            <div id="color"></div>
            <input type="range" min="1" max="255" value="255" class="slider" id="strokeColorR">
            <input type="range" min="1" max="255" value="0" class="slider" id="colorR">
            <input type="range" min="1" max="255" value="0" class="slider" id="strokeColorG">
            <input type="range" min="1" max="255" value="255" class="slider" id="colorG">
            <input type="range" min="1" max="255" value="0" class="slider" id="strokeColorB">
            <input type="range" min="1" max="255" value="0" class="slider" id="colorB">
            <p class="optionTitre">Opacity</p>
            <input type="number" min="0" max="100" value="100" id="opacityStroke">
            <input type="number" min="0" max="100" value="100" id="opacityFill">
            <p class="optionTitre">Line Width</p>
            <input id="lineOptionWidth" type="number" min="1" value="3">
        </div>
        <div class="undoredo">
            <button id="undo" class="button_unselect"><<</button>
            <button id="redo" class="button_unselect">>></button>
        </div>
    </div>
    <?=$GLOBALS['recordButton']?>
</div>
<div id="canvasRelative">
    <canvas id="scene" width="700" height="700"></canvas>
</div>
<code id="code">
</code>
<script src="assets/js/options.js"></script>
<script src="assets/js/engine2.js"></script>
<?php $content = ob_get_clean(); ?>
<?php require('./view/template.php'); ?>