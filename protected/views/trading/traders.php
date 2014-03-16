<?
$traders = Trader::allTraders();
echo '<div class="row" style="margin-left: 2px">';
foreach($traders as $trader){

    echo'<div class="col-md-3">
        <ul class="nav nav-stacked" id="accordion1">
            <li class="panel">
                <a data-toggle="collapse" data-parent="#accordion1" href="#firstLink">'.$trader['fullname'].
                '</a>
                    <ul id="firstLink" class="collapse">';
                        foreach($trader->statements as $statementData) {
                            echo '<li>
                                    <input class="tradersStnt" id="'.$statementData['ticket'].'" type="checkbox">'.$statementData['item'].'/'.$statementData['profit'].'
                                 </li>';

                        }
    echo '</ul></li></ul></div></div></div>';
}?>


<!--http://www.highcharts.com/samples/data/usdeur.js-->