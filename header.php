<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <link rel="stylesheet" href="/scripts/style.css">
  <link rel="stylesheet" href="http://code.jquery.com/ui/1.11.2/themes/smoothness/jquery-ui.css">
  <link rel="stylesheet" href="/scripts/css/bootstrap-theme.css">
  <link rel="stylesheet" href="/scripts/css/bootstrap.css">
  <link rel="stylesheet" href="/scripts/css/bootstrap-theme.min.css">
  <link rel="stylesheet" href="/scripts/css/bootstrap.min.css">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.1/css/select2.min.css" />
  <script type="text/javascript" src="http://code.jquery.com/jquery-1.10.2.js"></script>
  <script type="text/javascript" src="http://code.jquery.com/ui/1.11.2/jquery-ui.js"></script>
  <script type="text/javascript" src="/scripts/js/bootstrap.js"></script>
  <script type="text/javascript" src="/scripts/jquery-1.11.2.min.js"></script>
  <script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.2/jquery-ui.min.js"></script>
  <script type="text/javascript" src="/scripts/typeahead.min.js"></script>
  <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/select2/4.0.0-rc.1/js/select2.min.js"></script>
  <script>
    $(document).ready(function(){
      $('#search').on('input', function() {
            var searchKeyword = $(this).val();
            if (searchKeyword.length >= 3) {
              $.post('../search.php', { keywords: searchKeyword }, function(data) {
                $('#liveSearch').empty()
                $.each(data, function() {
                  $('#liveSearch').append('<li><a href="../results.php?id=' + this.id + '">' + this.make + ' ' + this.model + '</a></li>');
                });
              }, "json");
            }
          });
    });
  </script>
</head>
<body>
  <?php
  session_start();
  $first=$_SESSION['first'];
  date_default_timezone_set('UTC');
  ?>
  <div class="container">
    <h1>NSU/Media</h1>
    <h2>At Northumbria Students Union</h2>

    <nav class="navbar navbar-default">
      <div class="container-fluid">
        <div>
          <ul class="nav navbar-nav">
            <li><a href="../splash.php">Home</a></li>
            <li><a href="../bookings.php">Manage Booking</a></li>
            <li><a href="../account.php">Manage Your Account</a></li>
            <li><a href="../results.php">Book Asset</a></li>
            <li class="dropdown">
              <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button">
              Management <span class="caret"></span></a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="../pendingLoans.php">Pending Loans</a></li>
                  <li class="divider"></li>
                  <li><a href="../management/manageAsset.php">Manage Asset</a></li>
                  <li><a href="../management/manageUser.php">Manage Users</a></li>
                  <li class="divider"></li>
                  <li><a href="../management/reports.php">Reports</a></li>
                </ul>
            </li>
          </ul>
        </div>
          <span class="navbar-text">Welcome back <?php echo $first; ?></span>
          <a href='logout.php'><button type="button" class="btn btn-default btn-sml navbar-btn">Log Out<button></a>
      </div>
    </nav>
    <form class="navbar-form navbar-right" role="search" method="POST" action="results.php">
      <div class="form-group">
        <input type="text" class="form-control" id="search" placeholder="Search">
        <div id="liveSearch"></div>
      </div>
      <button type="submit" class="btn btn-default">Submit</button>
    </form>
  </div>
