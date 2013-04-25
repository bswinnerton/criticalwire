<?php
  //Set correct title
  $current_title = &$search_title;
  $current_description = &$search_description;
  
  //Header information
  include("../include/header.php");
?>

<div id="row1">
  <div id="cse-search-results"></div>
  <script type="text/javascript">
      var googleSearchIframeName = "cse-search-results";
      var googleSearchFormName = "cse-search-box";
      var googleSearchFrameWidth = 880;
      var googleSearchDomain = "www.google.com";
      var googleSearchPath = "/cse";
    </script>
    <script type="text/javascript" src="http://www.google.com/afsonline/show_afs_search.js"></script>
  </div>

<?php
  include("../include/footer.php");
?>