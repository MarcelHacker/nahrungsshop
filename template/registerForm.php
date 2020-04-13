<form action="register.php" method="POST">
    <div class="container" style="background-color: #e3f2fd;">
        <div class="form-row p-2">
            <div class="form-group col-md-6">
                <label for="inputFisrtname4">Firstname</label>
                <input type="text" class="form-control" name="firstname" id="firstname" placeholder="Max">
            </div>
            <div class="form-group col-md-6">
                <label for="lastname">Lastname</label>
                <input type="text" class="form-control" name="lastname" id="lastname" placeholder="Mustermann">
            </div>
            <div class="form-group col-md-6">
                <label for="email">Email</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Email">
            </div>
            <div class="form-group col-md-6">
                <label for="password">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Password">
            </div>
            <div class="form-group col-md-6">
                <label for="confrimPassword">Confirm Password</label>
                <input type="password" class="form-control" name="confirmpassword" id="confirmpassword" placeholder="Confirm Password">
            </div>
            <div class="form-group col-md-6">
                <label for="birthdate">Birthdate</label>
                <input type="date" class="form-control" name="birthdate" id="birthdate" placeholder="">
            </div>
            <div class="form-group col-md-6">
                <label for="inputAddress2">Address</label>
                <input type="text" class="form-control" name="address" id="address" placeholder="Hufeisengasse">
            </div>
            <div class="form-group col-md-1">
                <label for="houseNumber">Housenumber</label>
                <input type="number" class="form-control" name="housenumber" id="housenumber" placeholder="1">
            </div>
        </div>

        <div class="form-row">
            <div class="form-group col-md-6">
                <label for="city">City</label>
                <input type="text" class="form-control" name="city" id="city" placeholder="Guntersdorf">
            </div>
            <div class="form-group col-md-4">
                <label for="country">State</label>
                <select name="country" id="country" class="form-control">
                    <option selected>Choose...</option>
                    <option value="austria">Austria</option>
                    <option value="united kingdom">United Kingdom</option>
                    <option value="china">China</option>
                </select>
            </div>
            <div class="form-group col-md-2">
                <label for="postCode">Zip</label>
                <input type="number" class="form-control" name="postcode" id="postcode" placeholder="1234">
            </div>
        </div>
        <div class="form-group">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="checkRobot">
                <label class="form-check-label" for="checkRobot">
                    I am not a robot
                </label>
            </div>
        </div>
        <button type="submit" name="register" id="register" class="btn btn-primary p-2">Sign Up</button>
    </div>
</form>