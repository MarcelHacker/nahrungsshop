<div class="container p-2" style="background-color: #e3f2fd;">
    <div class="col">
        <div class="dropdown">
            <form class="px-4 py-3" action="pw_forgotten.php" method="POST">
                <div class="form-group">
                    <label for="email">Email address</label>
                    <input type="email" class="form-control" name="email" id="email" placeholder="email@example.com">
                </div>
                <div class="form-group col-md-6">
                    <label for="birthdate">Birthdate</label>
                    <input type="date" class="form-control" name="birthdate" id="birthdate" placeholder="">
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" class="form-control" name="password" id="password" placeholder="Password">
                </div>
                <div class="form-group">
                    <label for="passwordconfirm">Password Confirm</label>
                    <input type="password" class="form-control" name="passwordconfirm" id="passwordconfrim" placeholder="Password">
                </div>
                <button type="submit" name="forgotten" id="forgotten" class="btn btn-primary">Change Password</button>
            </form>
            <div class="dropdown">
                <a class="dropdown-item" href="register.php">New around here? Sign up</a>
                <a class="dropdown-item" href="pw_forgotten.php">Forgot password?</a>
            </div>
        </div>
    </div>
</div>