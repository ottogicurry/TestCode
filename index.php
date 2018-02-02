<!DOCTYPE html>
<html lang="en-US">
<head>
<link rel="stylesheet" type="text/css" href="assets/css/main.css">
<script src="assets/js/jquery-3.2.1.min.js"></script>
<script>
function populateTable() {
    // Full disclosure, this was partially stolen to save time
    $.getJSON("http://pythetron.com/rosterbots/api/get_team.php?balance="+($("#balance").val()) , function(data) {
        var tbl_body = "";
        var odd_even = false;
        var tas = 0;
        var classtext = "";
        $.each(data, function() {
            var classtext = (odd_even ? "odd" : "even");
            var tbl_row = "";
            $.each(this, function(k , v) {
                if(k == "starter") {
                    classtext += (v) ? " starter" : " sub";
                } else {
                    if(k == "total_attribute_score") {
                        tas+=v;
                    }
                    tbl_row += "<td>"+v+"</td>";
                }
            })
            tbl_body += "<tr class=\""+classtext+"\">"+tbl_row+"</tr>";
            odd_even = !odd_even;               
        })
        tbl_body += "<tr class=\""+classtext+"\"><td colspan=\"4\" class=\"even starter\" style=\"text-align:center\">Blue denotes starter</td><td>Salary</td><td>"+tas+"</td></tr>";
        $("#robotable tbody").html(tbl_body);
    });
}
</script>
</head>
<body>
<h1>Roster Bots</h1>
<h3>Draft Balance</h3>
<p>
    <input id="balance" type="range" value="5" min="1" max="10" step="1" class="slider" oninput="document.getElementById('rangeshower').value=this.value" />
    <input type="text" id="rangeshower" size="2" disabled />
</p>
<p><button onclick="populateTable();">Generate Roster</button></p>
<table id="robotable">
  <thead>
    <tr>
      <th>Roster Spot</th>
      <th>Name</th>
      <th>Speed</th>
      <th>Strength</th>
      <th>Agility</th>
      <th>Total</th>
    </tr>
  </thead>
  <tbody></tbody>
</table>
<script>
// Updating after the necessary elements load.
document.getElementById('rangeshower').value = document.getElementById('balance').value;
</script>
</body>
</html>