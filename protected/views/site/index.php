<? if (!Yii::app()->user->isGuest) : ?>
    <div id="myfirstchart" style="height: 250px;"></div>
<? endif;?>

<?

var_dump(Deals::dealsByTicket(1,2));

?>