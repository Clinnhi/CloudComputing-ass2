<!DOCTYPE html>
<html>
<head>
  <title>Update Profile</title>

</head>
<body>

<form action="/about-me.php">
      <div class="row">
        <div class="col-md-12">
          <form name="basicForm" class="form-horizontal form-bordered" novalidate>
          <div class="panel panel-default">
              <div class="panel-heading">
                <h1 class="panel-title">Personal Info</h1>
              </div>
              <div class="panel-body">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Full Name <span class="asterisk">*</span></label>
                  <div class="col-sm-9">
                    <input ng-model="user.name" type="text" name="name" class="form-control" placeholder="Type your name..." required />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">Email <span class="asterisk">*</span></label>
                  <div class="col-sm-9">
                    <input ng-model="user.email" type="email" name="email" class="form-control" placeholder="Type your email..." required />
                  </div>
                </div>

                <div class="form-group">
                  <label class="col-sm-3 control-label">About Me </label>
                  <div class="col-sm-9">
                    <textarea ng-model="user.about-me.summary" rows="5" class="form-control" placeholder="Enter a description about yourself" required></textarea>
                  </div>
                </div>
              </div>
          </div>



              <div class="panel-footer">
                <div class="row">
                  <!-- <div class="col-sm-9 col-sm-offset-3"> -->
                    <button class="btn btn-primary">Submit</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                  <!-- </div> -->
                </div>
              </div>

        </div>
      </div>
     
      <!-- Facts About Yourself-->
      <div class="row">
        <div class="col-md-12">
          <form name="facts" class="form-horizontal">
          <div class="panel panel-default" novalidate>

              <div class="panel-heading">
                <h1 class="panel-title">Enter Your Three Favourite Cryptocurrencies</h1>
              </div>

              <div class="panel-body">
                <div class="form-group">
                  <label class="col-sm-3 control-label">Cryptocurrency One</label>
                  <div class="col-sm-9">
                    <input type="text" name="cryptocurrency-one" class="form-control" placeholder="Crypto one here" required />
                    <br>
                    <label class="col-sm-3 control-label">Cryptocurrency Two</label><br>
                     <input type="text" name="cryptocurrency-two" class="form-control" placeholder="Crypto two here" required /><br>
                    <label class="col-sm-3 control-label">Cryptocurrency Three</label><br>
                     <input ng-model="cryptocurrency-three" type="text" name="cryptocurrency-three" class="form-control" placeholder="Crypto three here" required />
                  </div>
                </div>
              </div>
          </div>
          </form>
        </div>
      </div>
      <!-- end facts -->

      <!-- Upload Photos -->
      <div class="panel-heading">
                <h1 class="panel-title">Upload Any Photos</h1>
      </div>
      <form action="/action_page.php">
          <label for="img">Select image:</label>
          <input type="file" id="img" name="img" accept="image/*">
          <input type="submit"  value="Upload">
      </form>
      <!-- End upload photos -->
      


      <!-- Favourite Websites -->
      <div class="row">
        <div class="panel-heading">
          <h1 class="panel-title">Enter Your Favourite Website</h1>
        </div>
        <form action="/action_page.php">
            Website One:
            <input ng-model="website-one-url" type="text" name="website-one-url" class="form-control" placeholder="URL to website one" required />
            <label for="img">Website One Icon</label>
            <input type="file" id="website-one-img" name="website-one-img" accept="image/*">
            <input type="submit"  value="Upload"><br>

            Website Two:
            <input ng-model="website-two-url" type="text" name="website-two-url" class="form-control" placeholder="URL to website one" required />
            <label for="img">Website Two Icon</label>
            <input type="file" id="website-two-img" name="website-two-img" accept="image/*">
            <input type="submit"  value="Upload"><br>

            Website Three:
            <input ng-model="website-three-url" type="text" name="website-three-url-three" class="form-control" placeholder="URL to website one" required />
            <label for="img">Website Three Icon</label>
            <input type="file" id="img" name="img" accept="image/*">
            <input type="submit"  value="Upload"><br>
        </form><br><br><br>
        <input type="submit" value="Update Profile">
      </div>







  </form>

  </div>
  </script>
  </form>

</body>
</html>