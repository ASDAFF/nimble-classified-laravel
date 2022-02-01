<style>
    .get_emoji img{
        height: 18px !important;
    }
    span.get_emoji {
        margin-right: 2px;
    }
</style>
<div class="nicescroll" id="smiles">
    <?php
    echo '<div>';
    for( $i = 1 ; $i < 119; $i++ ) {
        echo '<span class="get_emoji" ><img class="m-t-2" src = "'.asset('assets/images/emoji/smiles/sm'.$i.'.png').'" alt = "" ></span>';
    }
    echo '</div>';
    echo '<div id="flags">';
    for( $i = 1 ; $i < 259; $i++ ){
        echo '<span class="get_emoji"><img class="m-t-2" src="'.asset('assets/images/emoji/flags/'.$i.'.png').'" alt=""></span>';
    }
    echo '</div>';

    echo '<div id="animals">';
    for( $i = 1 ; $i < 73; $i++ ){
        echo '<span class="get_emoji"><img class="m-t-2" src="'.asset('assets/images/emoji/animals/'.$i.'.png').'" alt=""></span>';
    }
    echo '</div>';
    echo '<div id="car">';
    for( $i = 1 ; $i < 13; $i++ ){
        echo '<span class="get_emoji"><img class="m-t-2" src="'.asset('assets/images/emoji/vahicles/'.$i.'.png').'" alt=""></span>';
    }
    echo '</div>';
    echo '<div id="flower">';
    for( $i = 1 ; $i < 111; $i++ ){
        echo '<span class="get_emoji"><img class="m-t-2" src="'.asset('assets/images/emoji/flower/'.$i.'.png').'" alt=""></span>';
    }
    echo '</div>';
    echo '<div id="symbols">';
    for( $i = 0 ; $i < 58; $i++ ){
        echo '<span class="get_emoji"><img class="m-t-2" src="'.asset('assets/images/emoji/symbols/'.$i.'.png').'" alt=""></span>';
    }
    echo '</div>';
    echo '<div id="buildings">';
    for( $i = 1 ; $i < 33; $i++ ){
        echo '<span class="get_emoji"><img class="m-t-2" src="'.asset('assets/images/emoji/buildings/'.$i.'.png').'" alt=""></span>';
    }
    echo '</div>';
    echo '<div id="family">';
    for( $i = 1 ; $i < 33; $i++ ){
        echo '<span class="get_emoji"><img class="m-t-2" src="'.asset('assets/images/emoji/family/'.$i.'.png').'" alt=""></span>';
    }
    echo '</div>';
    ?>
</div>