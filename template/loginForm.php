<div class="container" style="background-color: #e3f2fd;">
    <div class="dropdown">
        <form class="px-4 py-3" action="login.php" method="POST">
            <div class="form-group">
                <label for="email">Email address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" id="dropdownCheck">
                <label class="form-check-label" for="dropdownCheck">
                    Remember me
                </label>
            </div>
            <button type="submit" name="login" id="login" class="btn btn-primary">Sign In</button>
        </form>
        <div class="dropdown">
            <a class="dropdown-item" href="register.php">New around here? Sign up</a>
            <a class="dropdown-item" href="passwordForgotten.php">Forgot password?</a>
        </div>
    </div>
</div>