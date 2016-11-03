<div class="row" id="filter">
  <div class="col-md-4">
    <form action="<?php echo base_url();?>template/filter_partner_data" method="post" id="filter_form">
      <div class="row">
        <div class="col-md-12">
          <select class="btn js-example-basic-single" style="width:220px;background-color: #C5EFF7;" name="site">
            <option value="0" disabled="true" selected="true">Select a Site:</option>
            <option value="NA">All Sites</option>
            <?php echo $sites; ?>
          </select>
        </div>
      </div>
    </form>
  </div>
  <div class="col-md-3">
    <div id="breadcrum" class="alert" style="background-color: #1BA39C;display:none;">
      
    </div>
  </div>
  <div class="col-md-5" id="year-month-filter">
    <div class="filter">
      Year: 
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2010 )" class="alert-link"> 2010 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2011 )" class="alert-link"> 2011 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2012 )" class="alert-link"> 2012 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2013 )" class="alert-link"> 2013 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2014 )" class="alert-link"> 2014 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2015 )" class="alert-link"> 2015 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2016 )" class="alert-link"> 2016 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2017 )" class="alert-link"> 2017 </a>|
      <a href="javascript:void(0)" onclick="date_filter('yearly', 2018 )" class="alert-link"> 2018 </a>
    </div>
    <div class="filter">
      Month: 
      <a href='javascript:void(0)' onclick='date_filter("monthly", 1)' class='alert-link'> Jan </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 2)' class='alert-link'> Feb </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 3)' class='alert-link'> Mar </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 4)' class='alert-link'> Apr </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 5)' class='alert-link'> May </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 6)' class='alert-link'> Jun </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 7)' class='alert-link'> Jul </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 8)' class='alert-link'> Aug </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 9)' class='alert-link'> Sep </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 10)' class='alert-link'> Oct </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 11)' class='alert-link'> Nov </a>|
      <a href='javascript:void(0)' onclick='date_filter("monthly", 12)' class='alert-link'> Dec</a>
    </div>
  </div>
</div>
<script type="text/javascript">
  $().ready(function(){
    $(".js-example-basic-single").select2();
    $("#breadcrum").html("<a href='javascript:void(0)' class='alert-link'><strong>All Sites</strong></a>");
  });
</script>