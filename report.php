<?php
  include "header/header-control.php";
?>

<head>
  <title>Report-Hawklot</title>
  <?php include "header/header-head.php"; ?>
</head>


<body>
<?php include "header/header-body.php"; ?>

<form  method="post" id="reportForm" action="report_action.php">

  <div class="form-group">
    <label class="col-md-12"><legend>Report an Issue</legend></label>
  </div>

  <div class="form-group">
    <td class="col-md-6">This form is</td>
  </div>

  <div class="form-group">
    <label class="col-md-6" for="spot_num">Spot Number</label>
    <div class="col-md-6">
    <input id="spot_num" name="spot_num" type="num" placeholder="Number" class="form-control input-md" required>
    </div>
  </div>


  <div class="form-group">
    <label class="col-md-6" for="description">Description of Car (optional)</label>
    <div class="col-md-6">
      <textarea id="description" name="description" class="form-control" rows="4" placeholder="Description"></textarea>
    </div>
  </div>


  <div class="form-group">
    <label class="col-md-6 control-label" for="sumbit_report"></label>
    <div class="col-md-6">
      <button id="sumbit_report" name="sumbit_report" class="btn btn-primary">Submit Report</button>
    </div>
  </div>

</form>
<script>
   $("#reportForm").submit(function(event)
   {
       event.preventDefault();

       var $form = $( this ),
           $submit = $form.find( 'button[name="sumbit_report"]' ),
           spot = $form.find( 'input[name="spot_num"]' ).val(),
           description = $form.find( 'textarea[name="description"]' ).val(),
           url = $form.attr('report_action.php');

       var posting = $.post( url, {
                         spot_num: spot,
                         descr: description
                     });

       posting.done(function( data )
       {
           $( "#Response" ).html(data);

           $submit.text('Your report has been sent, thank you.');

           $submit.attr("disabled", true);
       });
  });
</script>

</body>
