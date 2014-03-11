
<div class="wrapper cleared">
   <? if (Yii::app()->user->hasFlash('success')) :?>
    <div class="message-list">
        <div class="message-item success" style="">
            <header>Notice
                <span class="close"></span>
            </header>
            <div class="message-item-inner"><? Yii::app()->user->getFlash('success');?></div>
        </div>
    </div>
    <?endif;?>

    <form class="form-signin ajax-submit" action="{a route='site/login'}" method="post">
        <header class="initiative-header cleared">
            <span class="initiative-title pull-left">Please sign in</span>
        </header>
        <div class="form-wrap create-form">
            <div class="form-line cleared">
                <span class="input-title pull-left">Email</span>
                <label class="input-label medium">
                    <div class="input-wrap">
                        <input type="text" name="email" class="input" placeholder="Email address">
                    </div>
                </label>
            </div>
            <div class="form-line cleared">
                <span class="input-title pull-left">Password</span>
                <label class="input-label medium">
                    <div class="input-wrap">
                        <input type="password" name="password" class="input" placeholder="Password">
                    </div>
                </label>
            </div>
            <div class="form-line cleared">
                <label class="custom-control-label">
                    <input type="checkbox" class="custom-control" name="remember" value="1">
                    <span class="custom-control-title">Remember me</span>
                </label>
            </div>
        </div>

        <input type="submit" class="btn black medium pull-right" value="Sign In">
        <p class="footer-links"><a href="{a route="recover"}">Forgot password?</a></p>
        <p class="footer-links"><a href="recover">Forgot password?</a> | <a href="signup">Sign Up</a></p>
    </form>

</div>
