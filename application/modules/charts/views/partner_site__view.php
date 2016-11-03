<table id="example" cellspacing="1" cellpadding="3" class="tablehead table table-striped table-bordered" style="background:#CCC;">
	<thead>
		<tr class="colhead">
			<th>#</th>
			<th>MFL Code</th>
			<th>Name</th>
			<th>County</th>
			<th>Tests</th>
			<th>Suspected Failures</th>
			<th>Repeat VL</th>
			<th>Confirmed Tx</th>
			<th>Rejected</th>
			<th>Adult Tests</th>
			<th>Paeds Tests</th>
			<th>Male</th>
			<th>Female</th>
		</tr>
	</thead>
	<tbody>
		<?php echo $outcomes;?>
	</tbody>
</table>
<script type="text/javascript" charset="utf-8">
  $(document).ready(function() {
  	$('#example').DataTable();

    $("table").tablecloth({
      theme: "paper",
      striped: true,
      sortable: true,
      condensed: true
    });
  });
</script>