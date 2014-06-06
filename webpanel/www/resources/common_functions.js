$(document).ready(function(){
	$('.start_hidden').hide();
});

function editorForm(formData){
	for (var key in formData) {
		field = formData[key];

		if(field.show_element_id != undefined){
			$('#' + field.show_element_id).show();
		}
		
		if(field.hide_element_id != undefined){
			$('#' + field.hide_element_id).hide();
		}
		if(field.setValue != undefined){
			$("[name='" + field.name + "']").val(decodeURIComponent(field.setValue));
		}
	}

}
