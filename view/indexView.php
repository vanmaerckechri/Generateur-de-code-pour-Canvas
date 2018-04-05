<?php $title = 'Générateur de Code pour le Canvas'; ?>

<?php ob_start(); ?>
<div id="interface">
    <div class="menuRow">
        <div class="brushs">
            <button id="drawBrush" class="button_Select" onclick="activerBouton(this)"><img src="./assets/img/brush.png" alt="brush icon"></button>
            <button id="drawLine" class="button_unselect" onclick="activerBouton(this)"><img src="./assets/img/line.png" alt="line icon"></button>
            <button id="drawLineForm" class="button_unselect" onclick="activerBouton(this)"><img src="./assets/img/triangle.png" alt="triangle icon"></button>
            <button id="drawRectangle" class="button_unselect" onclick="activerBouton(this)"><img src="./assets/img/rectangle.png" alt="rectangle icon"></button>
            <button id="drawCircle" class="button_unselect" onclick="activerBouton(this)"><img src="./assets/img/circle.png" alt="circle icon"></button>
        </div>
    </div>
    <div class="menuRow">
        <div class="sousOptionsContainer">
            <button id="strokeOption" class="button_Select" onclick="changePaintOption(this, 'stroke')">Stroke</button>
            <button id="fillOption" class="button_unselect" onclick="changePaintOption(this, 'fill')">Fill</button>
            <div id="colorStroke"></div>
            <div id="color"></div>
            <input type="range" min="1" max="255" value="0" class="slider" id="strokeColorR" onmousemove="changeColor()">
            <input type="range" min="1" max="255" value="0" class="slider" id="colorR" onmousemove="changeColor()">

            <input type="range" min="1" max="255" value="0" class="slider" id="strokeColorG" onmousemove="changeColor()">
            <input type="range" min="1" max="255" value="0" class="slider" id="colorG" onmousemove="changeColor()">
            <input type="range" min="1" max="255" value="0" class="slider" id="strokeColorB" onmousemove="changeColor()">
            <input type="range" min="1" max="255" value="0" class="slider" id="colorB" onmousemove="changeColor()">
            <input type="text" value="100" id="opacityStroke" onchange="changeStrokeOpacity()">
            <input type="text" value="100" id="opacityFill" onchange="changeFillOpacity()">
            <input id="lineOptionWidth" type="number" min="1" onclick="changeLineWidth()" onmousemove="changeLineWidth()">
        </div>
        <div class="undoredo">
            <button id="undo" class="button_unselect" onclick="activerUndo(this)">Undo</button>
            <button id="redo" class="button_unselect" onclick="activerRedo(this)">Redo</button>
        </div>
    </div>
    <?=$GLOBALS['recordButton']?>
</div>
<div id="canvasRelative">
    <canvas id="scene" width="700" height="700"></canvas>
</div>
<code id="code">
</code>
<script src="assets/js/var_globals.js"></script>
<script src="assets/js/undo.js"></script>
<script src="assets/js/engine.js"></script>
<script src="assets/js/options.js"></script>
<script src="assets/js/shapes.js"></script>
<script src="assets/js/init.js"></script>
<?php $content = ob_get_clean(); ?>
<?php require('./view/template.php'); ?>