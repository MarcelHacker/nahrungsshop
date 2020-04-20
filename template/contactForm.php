<form action="about.php" method="POST">
  <div class="container">
    <h2><span class="badge badge-secondary-">Contact Us</span></h2>
    <div class="form-group">
      <label for="exampleFormControlInput1">Email address</label>
      <input type="email" name="email" class="form-control" id="exampleFormControlInput1" placeholder="name@example.com">
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Name</label>
      <input type="text" name="name" class="form-control" id="exampleFormControlInput1" placeholder="Max Mustermann">
    </div>
    <div class="form-group">
      <label for="exampleFormControlInput1">Subject</label>
      <input type="text" name="subject" class="form-control" id="exampleFormControlInput1" placeholder="product request">
    </div>
    <div class="form-group">
      <label for="exampleFormControlTextarea1">Message</label>
      <textarea class="form-control" name="message" id="exampleFormControlTextarea1" rows="3"></textarea>
    </div>
    <div>
      <button type="submit" name="contact" class="btn btn-info"> Send </button>
    </div>
  </div>
</form>