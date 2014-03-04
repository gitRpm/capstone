$(document).ready(function(){
    

    var ctx = $('#barChart').get(0).getContext('2d');
    var barChart = new Chart(ctx);
    
    var user = {
        labels:[]
    };
    
    var tasks = {
        complete:[],
        incomplete:[],
        pastDue:[]
    }
    
    function getData(callback) {
        $.ajax({
            type:'GET',
            async : false,
            data: {data: "users"},
            url:'Dashboard/dashboardActions.php',
            success: function(data) {
                callback(data);
            }
        });
    };
    
    getData(function(array){
        var obj = JSON.parse(array);
        for (var i in obj) {
            user.labels.push(obj[i].username);
            tasks.complete.push(obj[i].complete);// total number of complete needs to be returned from php
            tasks.incomplete.push(obj[i].incomplete);
            tasks.pastDue.push(obj[i].pastDue);
        }
    });
    console.log(tasks.complete);
    console.log(tasks.incomplete);
    console.log(tasks.pastDue);
    var data = {
	labels : user.labels,
	datasets : [
		{
			fillColor : "rgba(220,220,220,0.5)",
			strokeColor : "rgba(220,220,220,1)",
			data : tasks.complete
		},
		{
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,1)",
			data : tasks.incomplete
		},
                {
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,1)",
			data : tasks.pastDue
		}
	]
    }
    var options;
    
    barChart.Bar(data,options);
    
});




