<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="background:#CCC;">
	<thead>
		<tr class="colhead">
			<th>Partner</th>
			<th>Facility</th>
			<th>Tests</th>
			<th>Suppressed</th>
			<th>Non Suppressed</th>
			<th>Rejected</th>
			<th>Adults</th>
			<th>Children</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $outcomes;?>
	</tbody>
</table>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#example').DataTable({
        "order": [[ 2, "desc" ]]
    } );

    $("table").tablecloth({
      theme: "paper",
      striped: true,
      sortable: true,
      condensed: true
    });
  });
</script>