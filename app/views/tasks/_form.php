<?= validation_errors() ?>

<div class="field">
	<label for="project_id">Project</label>
	<?= form_dropdown('project_id', $projects, set_value('project_id', $task['project_id']), 'id="project_id", style="width:330px"') ?> 
</div>

<div class="field">
	<label for="task_date">Date</label>
	<?= form_input('date', set_value('date', $task['date']), 'id="task_date" size="10"') ?> 
	<a href="#" onclick="set_to_today('task_date'); return false">« today</a>
</div>

<div class="field">
	<label for="task_start">Start</label>
	<?= form_input('start', set_value('start', $task['start']), 'id="task_start" size="5"') ?> 
	<a href="#" onclick="set_to_now('task_start'); return false">« now</a>
</div>

<div class="field">
	<label for="task_end">End</label>
	<?= form_input('end', set_value('end', $task['end']), 'id="task_end" size="5"') ?> 
	<a href="#" onclick="set_to_now('task_end'); return false">« now</a>
</div>

<div class="field">
	<label for="task_description">Description</label>
	<?= form_input('description', set_value('description', $task['description']), 'id="task_description" size="50"') ?> 
</div>

<div class="field">
	<label for="user_id">User</label>
	<?= form_dropdown('user_id', $users, set_value('user_id', $task['user_id']), 'id="user_id"') ?> 
</div>

<script type="text/javascript">
	function set_to_now(field_id)
	{
		obj = document.getElementById(field_id);
		date = new Date();
		minutes = Math.round(date.getMinutes() / 5) * 5;
		hours = date.getHours();
		if (minutes == 60) {
			minutes = 0;
			if (hours < 23) {
				hours++;
			} else {
				hours = 0;
			}
		}
		minutes = (minutes + "").lpad(0, 2);
		hours = (hours + "").lpad(0, 2);
		obj.value = hours + ":" +  minutes;
		return false;
	}
	
	function set_to_today(field_id)
	{
		obj = document.getElementById(field_id);
		date  = new Date();
		day   = (date.getDate() + "").lpad(0, 2);
		month = ((date.getMonth() + 1) + "").lpad(0, 2);
		year  = date.getFullYear();
		obj.value = day + "/" + month + "/" +  year;
		return false;
	}
	
	//pads left
	String.prototype.lpad = function(padString, length) {
		var str = this;
	    while (str.length < length)
	        str = padString + str;
	    return str;
	}
</script>