<div id="counties_map" style="height: 700px; " class="col-md-6">

</div>

<script type="text/javascript">

	$(function () {
    
        // Initiate the chart
        $('#counties_map').highcharts('Map', {
                title: {
                text: "Kenya"
            },
             legend: {
                enabled: true
            },
            
            
            series: [
                {
                    "type": "map",
                    "data": kenya_map,
                    "dataLabels": {
                            enabled: true,
                            color: '#FFFFFF',
                            format: '{point.name}'
                        },
                    "point":{
                        "events":{
                            click: function(){
                                alert(this.name);
                            }
                        }
                    }
                }
            ],

            mapNavigation: {
                enabled: true,
                enableButtons: true
            },
                      
          
          
       
        
        });

    });

</script>