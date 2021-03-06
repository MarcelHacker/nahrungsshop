<div class="container p-2" style="background-color: #e3f2fd;">
    <div class="col">
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
                <div class="form-check p-2">
                    <input type="checkbox" class="form-check-input" id="dropdownCheck">
                    <label class="form-check-label" for="dropdownCheck">
                        I am not a robot
                    </label>
                </div>
                <button type="submit" name="login" id="login" class="btn btn-primary">Sign In</button>
            </form>
            <div class="dropdown">
                <a class="dropdown-item" href="register.php">New around here? Sign up</a>
                <a class="dropdown-item" href="pw_forgotten.php">Forgot password?</a>
            </div>
        </div>
    </div>
</div>