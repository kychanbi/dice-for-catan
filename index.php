<head>

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Catan Dice</title>
    <link rel="stylesheet" type="text/css" href="js/Minimal-Animated-jQuery-Data-Visualization-Plugin-Dataviz/style.css" />
    <link rel="stylesheet" href="css/foundation.css">
    <link rel="stylesheet" href="css/app.css?v=<?= time() ?>">
</head>
<body>

<script type="text/javascript" src="js/jquery-3.3.1.slim.min.js"></script>

<script type="text/javascript" src="js/Minimal-Animated-jQuery-Data-Visualization-Plugin-Dataviz/jquery.dataviz_modified.js?v=<?= time() ?>"></script>
<script src="js/vendor/what-input.js"></script>
<script src="js/vendor/foundation.js"></script>
<script src="js/app.js"></script>
<script type="text/javascript">
    var getRandomColor= function() {
        var letters = '0123456789ABCDEF';
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    };
    var shuffleArray= function(array) {
        for (var i = array.length - 1; i > 0; i--) {
            var j = Math.floor(Math.random() * (i + 1));
            var temp = array[i];
            array[i] = array[j];
            array[j] = temp;
        }
        return array;
    }
    Window.dice_count = Array.from({length: 11}, () => 0 );
    Window.fair_dices = shuffleArray(Array.from({length: 36}, (x,i)=>{ return[~~(i/6) ,i%6 ]}) );
    Window.current_index = 0;
    Window.options ={
        colors:Window.dice_count.map(getRandomColor)
    };
    jQuery(document).ready(function($) {
        // $('form').submit(function(e){
        //     e.preventDefault();
        // $(this).find('input[type=text]').each(function(index){
        //     val = ($(this).val()> 0) ? $(this).val() : 0;
        //     values.push(parseFloat(val));
        // });
        var draw = function() {
            $('#bar_graph_wrapper').DataViz({
                'values': Window.dice_count,
                'colors': Window.options.colors
            }).data('DataViz').draw_bar();
        };
        var rollFairDice = ()=>{
            if (Window.current_index == 36){
                Window.current_index = 0;
                Window.fair_dices = shuffleArray( Window.fair_dices);
            }
            return result = Window.fair_dices[Window.current_index++];
        }
        var getRandomInt = function (min, max) {
            console.log(Math.floor(Math.random() * (max - min+1 )) + min);
            return Math.floor(Math.random() * (max - min+1 )) + min;
        }

        var rollNormalRandomDice = ()=> {
            return  [getRandomInt(0,5), getRandomInt(0,5)]
        }
        var rollDice = function(){
            let result;
            if ($("#fair_random").is(":checked")){
                result = rollFairDice();
            }
            else
                result = rollNormalRandomDice();


            $("#dice_1").attr("src","images/"+(result[0]+1)+".png");
            $("#dice_2").attr("src", "images/"+(result[1]+1)+".png");
            $("span.total_roll").html( parseInt($("span.total_roll").html())+1);
            return result;
        }
        draw();
        $(".dice").click( ()=> {

            var result =  rollDice();

            var sum= result[0]+result[1];
            $(".sum_display").html((sum+2));
            Window.dice_count[sum]++;
            draw();
        })
        $("input#night_mode_switch").on("change", (e)=>{
            console.log(e);
            // if($(e.target).is(":checked")){
            $("body").toggleClass("night");
            // }
        })

        $("input#history_display").on("change", (e)=>{
            console.log(e);
            // if($(e.target).is(":checked")){
            $("#bar_graph_wrapper").toggle();
            $(".indexes").toggle();
            // }
        })
        // });
    });
</script>
<div class="grid-x">
    <div class="cell large-8 small-12 left_col">
        <div class="grid-x">
            <div class="sum_display"></div>
            <div id="bar_graph_wrapper"></div>
        </div>
        <div class="grid-x indexes">
            <?php  for($i = 2;  $i<=12; $i++):
                ?>
                <div class="cell auto"><?= $i ?></div>
            <?php endfor;?>
        </div>
    </div>
    <div class="cell large-4 small-12">
        <div class="grid-x">
            <div class="cell">
                <div>Dark Mode Switch</div>
                <div class="switch">
                    <input class="switch-input" id="night_mode_switch" type="checkbox" name="night_mode"  >
                    <label class="switch-paddle" for="night_mode_switch">
                        <span class="show-for-sr">Night Mode</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="cell small-6">
                <div>
                    Fair Random
                </div>
                <div class="switch">
                    <input class="switch-input" id="fair_random" type="radio" checked name="testGroup">
                    <label class="switch-paddle" for="fair_random">
                        <span class="show-for-sr">Fair Random</span>
                    </label>
                </div>
            </div>
            <div class="cell small-6">
                <div>
                    Normal Random
                </div>
                <div class="switch">
                    <input class="switch-input" id="normal_random" type="radio"  name="testGroup">
                    <label class="switch-paddle" for="normal_random">
                        <span class="show-for-sr">Normal Random</span>
                    </label>
                </div>
            </div>
        </div>
        <div class="grid-x">
            <div class="cell small-6 ">
                <img src="images/1.png" alt="" class="button dice" id="dice_1">
            </div>
            <div class="cell small-6">
                <img src="images/1.png" alt="" class="button dice" id="dice_2">
            </div>
        </div>
        <div class="grid-x">
            <div class="cell small-6">
                <div>
                    History Display
                </div>
                <div class="switch">
                    <input class="switch-input" id="history_display" type="checkbox" checked name="testGroup2">
                    <label class="switch-paddle" for="history_display">
                        <span class="show-for-sr">History Display</span>
                    </label>
                </div>
            </div>
            <div class="cell small-6">

            </div>
        </div>

    </div>
</div>
<div class="grid-x total_roll" >Total Roll: <span class="total_roll">0</span></div>

</body>