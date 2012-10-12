	function enter_terminal(key){
		var data = $("#terminal").attr('value');
		if (/([a-z0-9])/.test(data)){
			if (((key.keyCode == 13) || (key.keyCode == 10))){
				var data = $("#terminal").attr('value');
				if (data.length > 1) {
					$.ajax({  
						url: "/components/terminal/terminal.php",
						data: "data="+data,
						success: function(otvet_terminal){
									$("#otvet_terminal").html(otvet_terminal);
									$("#otvet_terminal").show();
									$("#terminal").val('');
									$.ajax({  
										url: "/components/terminal/is_root.php",
										success: function(terminal_root){
													$("#terminal_root").html(terminal_root);
													$("#terminal_root").show();
												}  
									});
								}  
					});
				}
			}
		}
		else{
			$("#terminal").val('') ;
		}
	}