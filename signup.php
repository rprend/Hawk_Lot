<?php include("header.php"); ?>

<div class="container sign-in-up">
  <div class="row">
    <div class="col-md-4 col-md-offset-4">
      <br>
      <div class="text-center">
        <div class="btn-group">
          <a href="#new" role="tab" data-toggle="tab" class="big btn btn-primary"><i class="fa fa-plus"></i> New User</a>
          <a href="#user" role="tab" data-toggle="tab" class="big btn btn-danger"><i class="fa fa-user"></i> I have account</a>
        </div>
      </div>
      <p class="click2select">Click to select</p>
      <div class="tab-content">
        <div class="tab-pane fade in active" id="new">
          <br>
          <fieldset>
            <div class="form-group">
              <div class="right-inner-addon">
                <i class="fa fa-envelope"></i>
                <input class="form-control input-lg" placeholder="Email Address" type="text">
              </div>
            </div>
            <div class="form-group">
              <div class="right-inner-addon">
                <i class="fa fa-key"></i>
                <input class="form-control input-lg" placeholder="Password" type="password">
              </div>
            </div>
            <div class="form-group">
              <div class="right-inner-addon">
                <i class="fa fa-key"></i>
                <input class="form-control input-lg" placeholder="Confirm Password" id="" type="password">
              </div>
            </div>
          </fieldset>
          <hr>
          <ul class="nav nav-tabs" role="tablist">
            <li class="paywith">
              Pay with:
            </li>
            <li class="active"><a href="#pp" role="tab" data-toggle="tab">
              <i class="fa fa-dollar"></i> PayPal</a>
            </li>
            <li><a href="#bc" role="tab" data-toggle="tab">
              <i class="fa fa-bitcoin"></i> Bitcoin</a>
            </li>
          </ul>
          <div class="tab-content">
            <div class="tab-pane fade text-center" id="bc">
              <h2>$9<sup>,99</sup>/mo with <i class="fa fa-bitcoin"></i>
              </h2>
              <a href="#" class="q text-center">What is BitCoin?</a><br>
              <br>
              <button class="btn btn-primary btn-lg btn-block">PAY $9<sup>,99</sup> USD WITH BITCOIN</button>
            </div>
            <div class="tab-pane fade in active text-center" id="pp">
              <h2>$9<sup>,99</sup>/mo with <i class="fa fa-dollar"></i></h2>
              <a href="#" class="q text-center">What is PayPal?</a><br>
              <br>
              <button class="btn btn-primary btn-lg btn-block">PAY $9<sup>,99</sup> USD WITH PAYPAL</button>
            </div>
          </div>
        </div>
        <div class="tab-pane fade" id="user">
          <br>
          <fieldset>
            <div class="form-group">
              <div class="right-inner-addon">
                <i class="fa fa-envelope"></i>
                <input class="form-control input-lg" placeholder="Email Address" type="text">
              </div>
            </div>
            <div class="form-group">
              <div class="right-inner-addon">
                <i class="fa fa-key"></i>
                <input class="form-control input-lg" placeholder="Password" type="password">
              </div>
            </div>
          </fieldset>
          <br>
          <div class=" text-center">
            <button class="btn btn-primary">LOGIN</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
