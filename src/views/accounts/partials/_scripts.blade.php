<script>
 $('#flash-overlay-modal').modal();
    $('#accounts_tree').jstree({
			"core" : {
				"themes" : {
					"responsive" : false
				}
			},
			"types" : {
				"default" : {
					"icon" : "fa fa-folder text-primary fa-lg"
				},
				"file" : {
					"icon" : "fa fa-file text-primary fa-lg"
				}
			},
			"plugins" : ["types"]
		})
        .on('select_node.jstree', function (e, data) {
                console.log(data.node.a_attr.href);
                 document.location = data.node.a_attr.href;
        })
        .jstree()
</script