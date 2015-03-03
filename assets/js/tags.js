$(document).ready(function() {

	$(function() {
		$("#oznaka").autocomplete({
			source : function(request, response) {
				$.ajax({
					url : "gallery/auto",
					data : {
						term : $("#oznaka").val()
					},
					dataType : "json",
					type : "get",
					success : function(data) {
						response(data);
					}
				});
			},
			minLength : 1
		});
	});

	$(function() {
		var list = new Array();
		$("#dodaj").click(function() {

			$.ajax({
				url : 'gallery/check',
				data : {
					tag : $("#oznaka").val()
				},
				type : "post",
				success : function() {
					if (jQuery.inArray($("#oznaka").val(), list) == -1) {
						list.push($("#oznaka").val());
						$("#tagovi").html("");
						$.each(list, function(key, value) {
							$("#tagovi").append('<div>'+value+'</div> ');
						});
						$("#oznaka").val("");
						$("#inputi").html('');
						$.each(list, function(key, value) {
							$("#inputi").append('<input id="' + value + '" type="hidden" name="mirko' + key + '" value="' + value + '"/>');
						});

					} else {
						$("#oznaka").val("");
					};
				},
				error : function() {
					alert('ups, nesto si zeznio');
				}
			});
		});
		
	});

});
