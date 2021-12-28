<?php
  $q = $_GET['q'];
  if ($q == "rtmr") {
  echo '<label>Name (What name should be in your thank meter)</label>
  <input type="text"  class="form-control" name="tmname" placeholder="Enter your thank meter name"/><br>
  <label>In Game Name</label>
  <input type="text"  class="form-control" name="ign" placeholder="Enter your in game name"/><br>
  <label>Already Paid?</label><br>
  <textarea class="form-control" name="description" cols="40" rows="6" placeholder="Yes or no. If yes please paste the image url here, if no please type no"></textarea><br>';
  } elseif ($q == "tmr_normal") {
    echo '<label>Name (What name should be in your thank meter)</label>
    <input type="text"  class="form-control" name="tmname" placeholder="Enter your thank meter name"/><br>
    <label>In Game Name</label>
    <input type="text"  class="form-control" name="ign" placeholder="Enter your in game name"/><br>
    <label>Already Paid?</label><br>
    <textarea class="form-control" name="description" cols="40" rows="6" placeholder="Yes or no. If yes please paste the image url here, if no please type no"></textarea><br>';
  } elseif ($q == "tmr_premium") {
    echo '<label>Name (What name should be in your thank meter)</label>
    <input type="text"  class="form-control" name="tmname" placeholder="Enter your thank meter name"/><br>
    <label>In Game Name</label>
    <input type="text"  class="form-control" name="ign" placeholder="Enter your in game name"/><br>
    <label>Describe your thank meter design</label><br>
    <textarea class="form-control" name="description" cols="40" rows="6" placeholder="Describe your thank meter design"></textarea><br>
    <label>Already Paid?</label><br>
    <textarea class="form-control" name="description1" cols="40" rows="6" placeholder="Yes or no. If yes please paste the image url here, if no please type no"></textarea><br>';
  } elseif ($q == "tmr_special") {
    echo '<label>Name (What name should be in your thank meter)</label>
    <input type="text"  class="form-control" name="tmname" placeholder="Enter your thank meter name"/><br>
    <label>In Game Name</label>
    <input type="text"  class="form-control" name="ign" placeholder="Enter your in game name"/><br>
    <label>Describe your thank meter design and paste the Download link of the font</label><br>
    <textarea class="form-control" name="description" cols="40" rows="6" placeholder="Describe your thank meter design and paste the Download link of the font"></textarea><br>
    <label>Already Paid?</label><br>
    <textarea class="form-control" name="description1" cols="40" rows="6" placeholder="Yes or no. If yes please paste the image url here, if no please type no"></textarea><br>';
  } elseif ($q == "tmc") {
    echo '<label>Thank meter ID <abbr title="Find your ID by going to your thank meter page and go down to the page and then your thank meter id will show up">(?)</abbr></label>
    <input type="text"  class="form-control" name="tmid" placeholder="Enter your thank meter id" value="'.$_GET["id"].'" /><br>
    <label>Your Thank Meter Name</label>
    <input type="text"  class="form-control" name="tmname"  value="'.$_GET["name"].'" placeholder="Enter your thank meter name"/><br>
    <label>In Game Name</label>
    <input type="text"  class="form-control" name="ign"  value="'.$_GET["ign"].'" placeholder="Enter your in game name"/><br>
    <label>What do you want to change?</label><br>
    <textarea class="form-control" name="description" cols="40" rows="6" placeholder="What do you want to change?"></textarea><br>
    <label>Already Paid?</label><br>
    <textarea class="form-control" name="description1" cols="40" rows="6" placeholder="Yes or no. If yes please paste the image url here, if no please type no"></textarea><br>';
  } elseif ($q == "ctmrcs") {
    echo '<label>RID <abbr title="You can find your rid if you requested a request/changes or you can find it by on your post">(?)</abbr></label>
    <input type="text"  class="form-control" name="riduser" placeholder="Enter your RID"/><br>';
  } else {
    echo 'Undefined Function';
  }
?>
