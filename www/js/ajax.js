var frequency;

$(document).ready(function(){
    // for .markComplete click
    initialize();
    
    $('.sortable').click(function(){
        frequency = $(this).parents('table').attr('id');
        var column = $(this).parents('th').attr('id');
        var order;
        var table = $(this).parents('table');
        // arrow directions
        $('span.glyphicon-chevron-up', table).remove();
        $('span.glyphicon-chevron-down', table).remove();
        // set order param
        if ($(this).hasClass('ASC')){
            $(this).removeClass('ASC');
            $(this).append("<span class='glyphicon glyphicon-chevron-up'></span>");
            order = 'DESC';
        } else {
            $(this).append("<span class='glyphicon glyphicon-chevron-down'></span>");
            $(this).addClass('ASC');
            order = 'ASC'
        }
        // remove arrow from other columns
        $('th span', table).not(this).removeClass('ASC');
        // ajax request
        $.get('taskActions.php',{
                purpose:'sort',
                column:column,
                order:order,
                frequency:frequency,
                dataType: 'html'
        }, function(response) {
            $('tbody', table).html(response);    
            initialize();
        });
    });
    // need to have separate to reload DOM
    function initialize() {
        // dialog box
        $(function () {
            $("#dialogEdit").dialog({
                height: 800,
                width: 700,
                autoOpen: false,
                modal: true
            });
            $("#dialogView").dialog({
                height: 800,
                width: 700,
                autoOpen: false,
                modal: true
            });
        });
        // update status
        $('.markComplete').click(function(){
            var row = $(this).parents('tr');
            var cellStatus = $("td[name='status']", row);
            var cellDateCompleted = $('td.dateCompleted', row);
            var taskId = $(this).parents('tr').attr('id');  
            var statusId = $(cellStatus).attr('id');
            // ajax request
            $.get('taskActions.php',{
                 purpose:'markComplete',
                 taskId:taskId,
                 statusId:statusId
            }, function(data) {
                var json = data,
                obj = JSON.parse(json);
                // replace inner table elements
                $(cellStatus).attr('id', obj.statusId);
                $(cellStatus).removeClass('success');
                $(cellStatus).removeClass('danger');
                $(cellStatus).addClass(obj.className);
                $(cellStatus).html(obj.status);
                $(cellDateCompleted).html(obj.dateCompleted);
            });
        });
        // view a task
        $('.viewTask span').click(function(){
            var taskId = $(this).parents('td').attr('id');
            
            $.get('taskActions.php', {
                purpose:'view',
                taskId:taskId
            }, function(data) {
                var json = data;
                obj = JSON.parse(json);
                $('#viewTaskId').html(obj.taskId);
                $('#viewPriorities').html(obj.priority);
                $('#viewPriorities').removeAttr("class");
                if (obj.priorityId == 1){
                    $('#viewPriorities').addClass("alert alert-danger");
                } else if (obj.priorityId == 2) {
                   $('#viewPriorities').addClass("alert alert-warning"); 
                } else if (obj.priorityId == 3) {
                   $('#viewPriorities').addClass("well well-sm");
                }
                
                $('#viewDescription').html(obj.taskDesc);
                $('#viewStatus').html(obj.status);
                if (obj.className) {
                    $('#viewStatus').removeAttr("class");
                    $('#viewStatus').addClass("alert alert-"+obj.className);
                }
                frequency = (obj.freqId);
                $('#viewFrequency').html(obj.freqDisplay);
                $('#viewAssigned').html(obj.assignedTo);
                $('#viewDateDue').html(obj.dueDate);
                $('#viewDateCreated').html(obj.dateCreated);
                $('#viewDateCompleted').html(obj.dateCompleted);
            });
            $("#dialogView").dialog("open");
        });
        // close view
        $("#dialogFormView").submit(function() {
            $('#dialogView').dialog("close");
            return false;
        });
        
        
        // edit a task
        $('.editTask span').click(function(){
            var taskId = $(this).parents('td').attr('id');
            
            $.get('taskActions.php', {
                purpose:'edit',
                taskId:taskId
            }, function(data) {
                var json = data;
                obj = JSON.parse(json);
                $('[name=formTaskId]').val(obj.taskId);
                $('#formTaskId').html(obj.taskId);
                $('[name=formPriorities]').val(obj.priorityId);
                $('[name=formDescription]').html(obj.taskDesc);
                $('[name=formStatus]').val(obj.statusId);
                frequency = (obj.freqId);
                $('[name=formFrequency]').val(obj.freqId);
                $('[name=formAssigned]').val(obj.assignedToId);
                $('[name=formDateDue]').val(obj.dueDate);
                $('[name=formDateCreated]').val(obj.dateCreated);
                $('[name=formDateCompleted]').val(obj.dateCompleted);
            });
            $("#dialogEdit").dialog("open");
        });
        
        // form  
        $("#dialogFormEdit").submit(function() {
            var taskId = $('[name="formTaskId"]').val();
            var $form = $(this);
            var $inputs = $form.find("input, select, button, textarea");
            var serializedData = $form.serialize();
            $inputs.prop("disabled", true);
            $.post('taskActions.php', {
                purpose:'update',
                data: serializedData
                
            }, function(){
                $.get('taskActions.php', {
                    purpose:'view',
                    taskId:taskId
                }, function(data) {
                    var row = $('tr#'+taskId);
                    var json = data;
                    obj = JSON.parse(json);
                    //console.log(obj);
                    $('span.glyphicon-exclamation-sign', row).removeClass('Low');
                    $('span.glyphicon-exclamation-sign', row).removeClass('Medium');
                    $('span.glyphicon-exclamation-sign', row).removeClass('High');
                    $('span.glyphicon-exclamation-sign', row).addClass(obj.priority);
                    $('td.description', row).html(obj.taskDesc);
                    $('td[name=status]', row).html(obj.status);
                    $('td[name=status]', row).attr('id', obj.statusId);
                    $('td[name=status]', row).removeClass('danger');
                    $('td[name=status]', row).removeClass('success');
                    $('td[name=status]', row).addClass(obj.className);
                    if (obj.status == 'Completed') {
                        $('input.markComplete', row).attr('checked', 'checked');
                    } else {
                        $('td input.markComplete', row).removeAttr('checked');
                    }
                    $('td.assignedTo', row).html(obj.assignedTo);
                    $('td.dueDate', row).html(obj.dueDate);
                    $('td.dateCompleted', row).html(obj.dateCompleted);
                    $('td.dateCreated', row).html(obj.dateCreated);
                    if (frequency != obj.freqId) {
                        $(row).insertBefore('table#'+obj.freqId+' tbody tr:first');
                    }
                });
                $("#dialogEdit").dialog("close");
                $inputs.prop("disabled", false);
            });
            
            return false;
            
        });
        
        $('[name="delete"]').click(function(){
           
            var taskId = $('[name="formTaskId"]').val();
            var row = $('.table tr#'+taskId);
            if (confirm("Are you sure you want to delete task "+taskId+"?")){
                $.post('taskActions.php', {
                    purpose:'delete',
                    taskId: taskId
                }, function(){
                    row.remove();
                });
                $("#dialogEdit").dialog("close");
            }
            return false;
        });
        // datepicker
        $('.datepicker').datepicker({
            format: 'mm/dd/yyyy',
            startDate: '-3d',
            todayHighlight: true,
            buttonImageOnly: true
        });
        
        $(function () {
            $("#dialogEditUser").dialog({
                height: 800,
                width: 700,
                autoOpen: false,
                modal: true
            });
            $("#dialogViewUser").dialog({
                height: 800,
                width: 700,
                autoOpen: false,
                modal: true
            });
        });
        
        // edit a user
        $('.editUser span').click(function(){
            var userId = $(this).parents('td').attr('id');
            $.get('userActions.php', {
                purpose:'edit',
                userId:userId
            }, function(data) {
                var json = data;
                obj = JSON.parse(json);
                $('#formUserId').html(obj.userId);
                $('[name=formUserId]').val(obj.userId);
                $('[name=formPermissions]').val(obj.permission);
                $('[name=formFirstName]').val(obj.firstName);
                $('[name=formLastName]').val(obj.lastName);
                $('[name=formUsername]').val(obj.username);
                $('[name=formPassword]').val(obj.password);
            });
            $("#dialogEditUser").dialog("open");
        });
        
         // form  
        $("#dialogFormEditUser").submit(function() {
            var userId = $('[name="formUserId"]').val();
            var $form = $(this);
            var $inputs = $form.find("input, select, button");
            var serializedData = $form.serialize();
            $inputs.prop("disabled", true);
            $.post('userActions.php', {
                purpose:'update',
                data: serializedData
                
            }, function(){
                $.get('userActions.php', {
                    purpose:'view',
                    userId:userId
                }, function(data) {
                    var row = $('tr#'+userId);
                    var json = data;
                    obj = JSON.parse(json);
                    $('td.permission', row).html(obj.permissionDisplay);
                    $('td.firstname', row).html(obj.firstName);
                    $('td.lastname', row).html(obj.lastName);
                    $('td.username', row).html(obj.username);
                });
                $("#dialogEditUser").dialog("close");
                $inputs.prop("disabled", false);
            });
            
            return false;
            
        });
        
        // view a user
        $('.viewUser span').click(function(){
            var userId = $(this).parents('td').attr('id');
            
            $.get('userActions.php', {
                purpose:'view',
                userId:userId
            }, function(data) {
                var json = data;
                obj = JSON.parse(json);
                $('#viewUserId').html(obj.userId);
                $('#viewPermission').html(obj.permissionDisplay);
                $('#viewFirstName').html(obj.firstName);
                $('#viewLastName').html(obj.lastName);
                $('#viewUsername').html(obj.username);
            });
            $("#dialogViewUser").dialog("open");
        });
        // close view
       $('#closeUserView').click(function(){
          $('#dialogViewUser').dialog("close");
       });
    }
});
