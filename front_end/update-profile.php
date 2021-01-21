<!DOCTYPE html>
<html>
<head>
  <title>Update Profile</title>
  <link rel="stylesheet" href="css/update-profile.css" />
</head>
<body>

<div class="row"> 
  <div class="col-md-12">
<form action="display-user.php" method="post">

  <!-- USER INFO -->

    <div class="panel-heading"><h1 class="panel-title">Personal Info</h1></div>
    <!-- Full Name -->
    <label name="full-name" class="col-sm-3 control-label">Full Name <span class="asterisk">*</span></label>
    <div class="col-sm-9">
      <input id="full-name" ng-model="user.name" type="text" name="full-name" class="form-control" placeholder="Type your name..." required />
    </div>

    <!-- Email -->
    <label class="col-sm-3 control-label">Email <span class="asterisk">*</span></label>
    <div class="col-sm-9">
      <input ng-model="user.email" type="email" name="email" class="form-control" placeholder="Type your email..." required />
    </div>

    <!-- About Me -->
    <label class="col-sm-3 control-label">About Me </label>
    <div class="col-sm-9">
      <textarea  name="about-me" placeholder="Enter a description about yourself" required></textarea>
    </div>

    <br><br><br>

    <!-- FAV CRYPTOS -->
    <div class="panel-heading"><h1 class="panel-title">Enter Your Three Favourite Crypto</h1></div>
    Crypto One:  <input type="text" name="crypto-one" /><br />
    Crypto Two:  <input type="text" name="crypto-two" /><br />
    Crypto Three:  <input type="text" name="crypto-three" /><br />

    <br><br>

    <!-- UPLOAD PHOTOS -->
      <div class="panel-heading"><h1 class="panel-title">Upload Any Photos</h1></div>
     <label for="img">Select image:</label>
     <input  type="file" id="photo_name" name="photo_name" accept="image/*">
     <br><br>



     <!-- FAV WEBSITES -->
    <div class="panel-heading"><h1 class="panel-title">Favourite Websites</h1></div>
    Website One:
    <input ng-model="website-one-url" type="text" name="website-one-url" class="form-control" placeholder="URL to website one" required /><br>
    <label for="img">Website One Icon:</label>
    <input type="file" id="website-one-img" name="website-one-img" accept="image/*">
    <br><br>

    Website Two:
    <input ng-model="website-two-url" type="text" name="website-two-url" class="form-control" placeholder="URL to website one" required /><br>
    <label for="img">Website Two Icon:</label>
    <input type="file" id="website-two-img" name="website-two-img" accept="image/*">
    <br><br>

    Website Three:
    <input ng-model="website-three-url" type="text" name="website-three-url" class="form-control" placeholder="URL to website one" required /><br>
    <label for="img">Website Three Icon</label>
    <input type="file" id="img" name="img" accept="image/*">


      
    <br><br><br><br>       
    <input type="submit" name="submit" value="Update Profile!" />

</form>
</div>
</div> <!-- end of row -->


</body>
</html>