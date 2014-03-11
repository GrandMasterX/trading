<div class="wrapper cleared">

    <form class="form-signin ajax-submit" action="{a route='site/resetPassword' id=$id}" method="post">
        <header class="initiative-header cleared">
            <span class="initiative-title pull-left">Please enter new password</span>
        </header>
        <div class="form-wrap create-form">
            <div class="form-line cleared">
                <span class="input-title pull-left">New password</span>
                <label class="input-label medium">
                    <div class="input-wrap">
                        <input type="password" name="newPassword" class="input" placeholder="New password">
                    </div>
                </label>
            </div>
            <div class="form-line cleared">
                <span class="input-title pull-left">Confirm password</span>
                <label class="input-label medium">
                    <div class="input-wrap">
                        <input type="password" name="verifyPassword" class="input" placeholder="Confirm password">
                    </div>
                </label>
            </div>
        </div>
        <input type="submit" class="btn black medium pull-right" value="Reset">
        <p class="footer-links">&nbsp;</p>
    </form>

</div>
