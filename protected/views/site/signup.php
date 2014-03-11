<div class="wrapper cleared">

    <form class="form-signin ajax-submit" action="registration" method="post">
        <header class="initiative-header cleared">
            <span class="initiative-title pull-left">Please sign up</span>
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
        </div>
        <input type="submit" class="btn black medium pull-right" value="Sign Up">
        <p class="footer-links"><a href="{a route="recover"}">Forgot password?</a></p>
            <p class="footer-links"><a href="{a route="recover"}">Forgot password?</a> | <a href="/">Login</a></p>
    </form>


</div>
