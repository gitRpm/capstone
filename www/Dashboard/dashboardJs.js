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
    
    var total = {
        complete: 0,
        incomplete: 0,
        pastDue: 0,
        total: 0,
        completePercentage: function() {
            return Math.round(this.complete/this.total * 100);
        },
        incompletePercentage: function() {
            return Math.round(this.incomplete/this.total * 100);
        },
        pastDuePercentage: function() {
            return Math.round(this.pastDue/this.total * 100);
        }
    }
    
    function getBarData(callback) {
        $.ajax({
            type:'GET',
            async : false,
            data: {data: "barChart"},
            url:'Dashboard/dashboardActions.php',
            success: function(data) {
                callback(data);
            }
        });
    };
    
    function getPieData(callback) {
        $.ajax({
            type:'GET',
            async : false,
            data: {data: "pieChart"},
            url:'Dashboard/dashboardActions.php',
            success: function(data) {
                callback(data);
            }
        });
    };
    
    getBarData(function(array){
        var obj = JSON.parse(array);
        for (var i in obj) {
            user.labels.push(obj[i].username);
            tasks.complete.push(obj[i].completed);// total number of complete needs to be returned from php
            tasks.incomplete.push(obj[i].incomplete);
            tasks.pastDue.push(obj[i].pastDue);
        }
    });
    
    getPieData(function(array){
        var obj = JSON.parse(array);
        total.incomplete = parseInt(obj.incomplete);
        total.complete = parseInt(obj.complete);
        total.pastDue = parseInt(obj.pastDue);
        total.total = parseInt(obj.total);
    });
    
    $('.percentage').each(function(){
        if ($(this).attr('id') == 'complete') {
            $(this).html(total.completePercentage()+"%");
        }
        if ($(this).attr('id') == 'incomplete') {
            $(this).html(total.incompletePercentage()+"%");
        }
        if ($(this).attr('id') == 'pastDue') {
            $(this).html(total.pastDuePercentage()+"%");
        }
    });
    
    console.log(total);
    
    var barData = {
	labels : user.labels,
	datasets : [
		{
			fillColor : "#dff0d8",
			strokeColor : "#d0e9c6",
			data : tasks.complete
		},
		{
			fillColor : "rgba(151,187,205,0.5)",
			strokeColor : "rgba(151,187,205,1)",
			data : tasks.incomplete
		},
                {
			fillColor : "#f2dede",
			strokeColor : "#ebcccc",
			data : tasks.pastDue
		}
	]
    }
    
    var barOptions = {
        scaleShowGridLines : false,
        scaleOverride : true,
        scaleSteps : 25,
        scaleStepWidth : 1,
        scaleStartValue : 0
    }
    
    barChart.Bar(barData, barOptions);
    
    var pie = $("#pieChart").get(0).getContext("2d");
    var pieChart = new Chart(pie);
    
    var pieData = [
        {
            value: total.complete, //complete
            color:"#d0e9c6"
	},
	{
            value : total.incomplete, //incomplete
            color : "rgba(151,187,205,1)"
	},
        {
            value : total.pastDue, //past due
            color : "#ebcccc"
	}
			
    ];
    
    var pieOptions = {
        animationSteps : 50
    }

    pieChart.Pie(pieData, pieOptions);
    
});




